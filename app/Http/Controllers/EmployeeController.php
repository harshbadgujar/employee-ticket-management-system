<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'employee');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate(5)->withQueryString();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'regex:/^[0-9\-\+\s\(\)]{8,20}$/'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'department' => ['required', 'string', 'in:IT,BD,QA,HR,Finance'],
        ], [
            'phone.regex' => 'Please provide a valid phone number format.',
            'profile_image.max' => 'The profile image must not exceed 2MB.',
        ]);

            // Include department field
            $imagePath = null;
            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('avatars', 'public');
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'department' => $request->department,
                'profile_image' => $imagePath,
                'password' => Hash::make($request->password),
                'role' => 'employee',
            ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee.
     */
    public function show(User $employee)
    {
        if ($employee->role !== 'employee') {
            abort(404);
        }

        // Fetch ticket statistics for this employee
        $ticketsCount = $employee->tickets()->count();
        $openTicketsCount = $employee->tickets()->where('status', 'open')->count();
        $inProgressTicketsCount = $employee->tickets()->where('status', 'in_progress')->count();
        $resolvedTicketsCount = $employee->tickets()->where('status', 'resolved')->count();
        $closedTicketsCount = $employee->tickets()->where('status', 'closed')->count();

        return view('employees.show', compact(
            'employee', 
            'ticketsCount', 
            'openTicketsCount', 
            'inProgressTicketsCount', 
            'resolvedTicketsCount', 
            'closedTicketsCount'
        ));
    }

    /**
     * Show the form for editing the employee.
     */
    public function edit(User $employee)
    {
        if ($employee->role !== 'employee') {
            abort(404);
        }
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the employee.
     */
    public function update(Request $request, User $employee)
    {
        if ($employee->role !== 'employee') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->id)],
            'phone' => ['required', 'string', 'regex:/^[0-9\-\+\s\(\)]{8,20}$/'],
            'department' => ['required', 'string', 'in:IT,BD,QA,HR,Finance'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.regex' => 'Please provide a valid phone number format.',
            'profile_image.max' => 'The profile image must not exceed 2MB.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
        ];

        if ($request->hasFile('profile_image')) {
            // Delete old image if it exists
            if ($employee->profile_image) {
                Storage::disk('public')->delete($employee->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the employee.
     */
    public function destroy(User $employee)
    {
        if ($employee->role !== 'employee') {
            abort(404);
        }

        // Delete profile image if exists
        if ($employee->profile_image) {
            Storage::disk('public')->delete($employee->profile_image);
        }

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
