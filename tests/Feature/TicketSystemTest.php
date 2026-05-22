<?php

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketAssignedMail;

beforeEach(function () {
    // Clear mail fake
    Mail::fake();
});

it('allows admin to view employees list but forbids employees', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_test@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    $employee = User::create([
        'name' => 'Emp User',
        'email' => 'emp_test@example.com',
        'password' => Hash::make('password'),
        'role' => 'employee',
    ]);

    // Admin can access
    $response = $this->actingAs($admin)->get('/employees');
    $response->assertStatus(200);

    // Employee is forbidden
    $response = $this->actingAs($employee)->get('/employees');
    $response->assertStatus(403);
});

it('allows admin to create an employee with profile image and phone validation', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_test2@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(150);

    $response = $this->actingAs($admin)->post('/employees', [
        'name' => 'New Guy',
        'email' => 'newguy@example.com',
        'phone' => '+1234567890',
        'profile_image' => $avatar,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/employees');
    $this->assertDatabaseHas('users', [
        'email' => 'newguy@example.com',
        'phone' => '+1234567890',
        'role' => 'employee',
    ]);
});

it('forbids creating employee with invalid phone number or large image', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_test3@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    // Invalid phone number & huge image
    $hugeAvatar = UploadedFile::fake()->image('huge.jpg')->size(3000); // 3MB

    $response = $this->actingAs($admin)->post('/employees', [
        'name' => 'Bad Guy',
        'email' => 'badguy@example.com',
        'phone' => 'not-a-phone',
        'profile_image' => $hugeAvatar,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors(['phone', 'profile_image']);
});

it('sends an email when admin assigns a ticket to an employee', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_test4@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    $employee = User::create([
        'name' => 'Emp User',
        'email' => 'emp_test_mail@example.com',
        'password' => Hash::make('password'),
        'role' => 'employee',
    ]);

    $response = $this->actingAs($admin)->post('/tickets', [
        'title' => 'Critical Issue',
        'description' => 'Fix the bug immediately',
        'priority' => 'high',
        'assigned_to' => $employee->id,
    ]);

    $response->assertRedirect('/tickets');
    
    // Verify ticket creation
    $this->assertDatabaseHas('tickets', [
        'title' => 'Critical Issue',
        'assigned_to' => $employee->id,
    ]);

    // Verify email was sent
    Mail::assertSent(TicketAssignedMail::class, function ($mail) use ($employee) {
        return $mail->hasTo($employee->email);
    });
});

it('allows employee to only update the status of their assigned tickets', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin_test5@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    $employee = User::create([
        'name' => 'Emp User',
        'email' => 'emp_test_perm@example.com',
        'password' => Hash::make('password'),
        'role' => 'employee',
    ]);

    $otherEmployee = User::create([
        'name' => 'Other Emp',
        'email' => 'other_emp@example.com',
        'password' => Hash::make('password'),
        'role' => 'employee',
    ]);

    $ticket = Ticket::create([
        'title' => 'Bug to fix',
        'description' => 'Fix it',
        'priority' => 'medium',
        'status' => 'open',
        'assigned_to' => $employee->id,
        'created_by' => $admin->id,
    ]);

    // Employee tries to update their assigned ticket status
    $response = $this->actingAs($employee)->put("/tickets/{$ticket->id}", [
        'status' => 'in_progress',
    ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('tickets', [
        'id' => $ticket->id,
        'status' => 'in_progress',
    ]);

    // Employee cannot update title/description
    $response = $this->actingAs($employee)->put("/tickets/{$ticket->id}", [
        'title' => 'Hacked Title',
        'status' => 'resolved',
    ]);
    // It should only update status, keeping original title
    $this->assertDatabaseHas('tickets', [
        'id' => $ticket->id,
        'title' => 'Bug to fix',
        'status' => 'resolved',
    ]);

    // Employee cannot access or update another employee's ticket
    $otherTicket = Ticket::create([
        'title' => 'Other ticket',
        'description' => 'Ignore',
        'priority' => 'low',
        'status' => 'open',
        'assigned_to' => $otherEmployee->id,
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($employee)->get("/tickets/{$otherTicket->id}");
    $response->assertStatus(403);

    $response = $this->actingAs($employee)->put("/tickets/{$otherTicket->id}", [
        'status' => 'resolved',
    ]);
    $response->assertStatus(403);
});
