<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'phone' => '+1234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create Employees
        $employee = User::create([
            'name' => 'John Employee',
            'email' => 'employee@example.com',
            'phone' => '+1112223333',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        $alice = User::create([
            'name' => 'Alice Support',
            'email' => 'alice@example.com',
            'phone' => '+4445556666',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        $bob = User::create([
            'name' => 'Bob Support',
            'email' => 'bob@example.com',
            'phone' => '+7778889999',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        // 3. Create Support Tickets
        Ticket::create([
            'title' => 'Critical: Payment Gateway Timeout in Production',
            'description' => 'Users are reporting 504 gateway timeouts when attempting credit card checkouts. This is affecting the stripe integration flow. Urgent attention is needed.',
            'status' => 'open',
            'priority' => 'high',
            'assigned_to' => $employee->id,
            'created_by' => $admin->id,
        ]);

        Ticket::create([
            'title' => 'Feature Request: Add Dark Mode toggler in Profile',
            'description' => 'Users want the ability to switch between dark and light themes in their profile settings. Currently, it defaults to light only.',
            'status' => 'in_progress',
            'priority' => 'medium',
            'assigned_to' => $alice->id,
            'created_by' => $admin->id,
        ]);

        Ticket::create([
            'title' => 'Bug: Profile image is not updating immediately',
            'description' => 'When a user updates their profile picture, the old image is cached in the browser for up to an hour. We should add cache-busting query params to the URL.',
            'status' => 'resolved',
            'priority' => 'low',
            'assigned_to' => $bob->id,
            'created_by' => $admin->id,
        ]);

        Ticket::create([
            'title' => 'SMTP Configuration Issue',
            'description' => 'The emails are currently falling back to the log driver. We should configure the Google SMTP or Mailgun parameters inside the config environment to go live.',
            'status' => 'open',
            'priority' => 'high',
            'assigned_to' => $employee->id,
            'created_by' => $employee->id,
        ]);

        Ticket::create([
            'title' => 'Typo on Landing Page Header',
            'description' => 'In resources/views/welcome.blade.php, on line 125, the word "Empolyees" is misspelled. It should be spelled "Employees".',
            'status' => 'closed',
            'priority' => 'low',
            'assigned_to' => $alice->id,
            'created_by' => $admin->id,
        ]);
    }
}
