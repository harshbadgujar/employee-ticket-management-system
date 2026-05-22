<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Employee: ') }} <span class="text-indigo-650 dark:text-indigo-400 font-bold">{{ $employee->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Profile Image Section -->
                        <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-100 dark:border-gray-700">
                            <div class="relative w-24 h-24 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center border-2 border-gray-300 dark:border-gray-600 overflow-hidden">
                                @if($employee->profile_image)
                                    <img class="w-full h-full object-cover animate-fade-in" src="{{ asset('storage/' . $employee->profile_image) }}" alt="{{ $employee->name }}'s photo">
                                @else
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold text-4xl">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex-1 text-center sm:text-left space-y-1">
                                <label for="profile_image" class="block text-sm font-bold text-gray-750 dark:text-gray-200">
                                    Change Profile Picture
                                </label>
                                <span class="block text-xs text-gray-500 dark:text-gray-400">
                                    Allowed types: jpeg, png, jpg, gif, webp. Max size: 2MB.
                                </span>
                                <input type="file" name="profile_image" id="profile_image" class="mt-2 text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100 dark:file:bg-indigo-950/40 dark:file:text-indigo-400">
                                @error('profile_image')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-1">
                                <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                @error('name')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-1">
                                <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                @error('email')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="space-y-1">
                                <label for="phone" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone) }}" required placeholder="e.g. +1234567890" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <span class="text-xs text-gray-400">Accepts numbers, spaces, parentheses, hyphens, and + sign (8-20 characters).</span>
                                @error('phone')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Department Dropdown -->
                        <div class="mt-4">
                            <label for="department" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Department</label>
                            <select name="department" id="department" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Select Department</option>
                                <option value="IT" {{ old('department', $employee->department) == 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="BD" {{ old('department', $employee->department) == 'BD' ? 'selected' : '' }}>Business Development</option>
                                <option value="QA" {{ old('department', $employee->department) == 'QA' ? 'selected' : '' }}>QA</option>
                                <option value="HR" {{ old('department', $employee->department) == 'HR' ? 'selected' : '' }}>HR</option>
                                <option value="Finance" {{ old('department', $employee->department) == 'Finance' ? 'selected' : '' }}>Finance</option>
                            </select>
                            @error('department')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Section (Optional) -->
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 space-y-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Change Password (Optional)</h3>
                                <p class="text-xs text-gray-500">Leave these fields blank if you do not want to change the employee password.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Password -->
                                <div class="space-y-1">
                                    <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300">New Password</label>
                                    <input type="password" name="password" id="password" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    @error('password')
                                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password Confirmation -->
                                <div class="space-y-1">
                                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Form Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('employees.index') }}" class="inline-flex items-center px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-655 text-gray-700 dark:text-gray-300 font-semibold text-sm rounded-lg border border-gray-250 dark:border-gray-600 transition">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-lg shadow transition duration-150 ease-in-out">
                                Update Employee
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
