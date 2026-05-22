<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Employee Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600 relative"></div>
                <div class="px-8 pb-8 relative">
                    <div class="flex flex-col sm:flex-row items-center sm:items-end justify-between -mt-16 mb-6">
                        <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 text-center sm:text-left">
                            <div class="w-32 h-32 rounded-full bg-white dark:bg-gray-800 p-1.5 shadow-md flex items-center justify-center overflow-hidden">
    @if($employee->profile_image)
        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $employee->profile_image) }}" alt="{{ $employee->name }}'s photo">
    @else
        <span class="text-indigo-600 dark:text-indigo-400 font-bold text-4xl">
            {{ strtoupper(substr($employee->name, 0, 1)) }}
        </span>
    @endif
</div>
                            <div class="mb-2">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $employee->name }}</h3>
                                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ ucfirst($employee->role) }}</p>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Department: {{ $employee->department ?? 'Not Specified' }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 mt-4 sm:mt-0">
                            <a href="{{ route('employees.edit', $employee) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm rounded-lg shadow-sm transition">
                                Edit Account
                            </a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-lg shadow-sm transition">
                                    Delete Account
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Details Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <div>
                            <span class="block text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Email Address</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200 block mt-1">{{ $employee->email }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Phone Number</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200 block mt-1">{{ $employee->phone ?? 'Not Specified' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Date Joined</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200 block mt-1">{{ $employee->created_at->format('F d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats & Workload Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 space-y-8">
                <div>
                    <h4 class="text-lg font-bold text-gray-800 dark:text-gray-100">Ticket Metrics & Workload</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-450 mt-1">Overview of the employee's active support tasks and completion records.</p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-900/40 rounded-xl p-4 text-center">
                        <span class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 block">{{ $ticketsCount }}</span>
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 block mt-1">Total Assigned</span>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-950/20 rounded-xl p-4 text-center">
                        <span class="text-2xl font-extrabold text-blue-600 dark:text-blue-400 block">{{ $openTicketsCount }}</span>
                        <span class="text-xs font-bold text-blue-500 dark:text-blue-450 block mt-1">Open Tickets</span>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-950/20 rounded-xl p-4 text-center">
                        <span class="text-2xl font-extrabold text-amber-600 dark:text-amber-400 block">{{ $inProgressTicketsCount }}</span>
                        <span class="text-xs font-bold text-amber-500 dark:text-amber-450 block mt-1">In Progress</span>
                    </div>
                    <div class="bg-emerald-50 dark:bg-emerald-950/20 rounded-xl p-4 text-center">
                        <span class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 block">{{ $resolvedTicketsCount }}</span>
                        <span class="text-xs font-bold text-emerald-500 dark:text-emerald-450 block mt-1">Resolved</span>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-4 text-center col-span-2 md:col-span-1">
                        <span class="text-2xl font-extrabold text-gray-700 dark:text-gray-300 block">{{ $closedTicketsCount }}</span>
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 block mt-1">Closed</span>
                    </div>
                </div>

                <!-- Workload Progress -->
                <div class="space-y-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center text-sm font-bold text-gray-700 dark:text-gray-300">
                        <span>Resolution Progress Rate</span>
                        <span class="text-indigo-600 dark:text-indigo-400">
                            @php
                                $total = $ticketsCount;
                                $resolved = $resolvedTicketsCount + $closedTicketsCount;
                                $rate = $total > 0 ? round(($resolved / $total) * 100) : 0;
                            @endphp
                            {{ $rate }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 h-3 rounded-full overflow-hidden shadow-inner">
                        <div class="bg-gradient-to-r from-indigo-500 to-emerald-500 h-full rounded-full" style="width: {{ $rate }}%"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
