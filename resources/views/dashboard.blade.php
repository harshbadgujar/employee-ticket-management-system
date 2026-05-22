<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ Auth::user()->isAdmin() ? __('Admin Dashboard') : __('Employee Dashboard') }}
            </h2>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-600">
                Welcome back, <span class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ Auth::user()->name }}</span> ({{ ucfirst(Auth::user()->role) }})
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Alert / Banner -->
            <div class="relative overflow-hidden bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-xl p-6 md:p-8 text-white">
                <div class="absolute inset-0 bg-cover bg-center opacity-15" style="background-image: url('https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=1000');"></div>
                <div class="relative z-10 max-w-2xl">
                    <h3 class="text-xl md:text-3xl font-bold mb-2">Employee Support Ticket System</h3>
                    <p class="text-indigo-100 text-sm md:text-base leading-relaxed">
                        {{ Auth::user()->isAdmin() 
                            ? 'Monitor system workloads, resolve high priority tickets, and assign support tasks to maintain service level agreements.'
                            : 'Access and manage all tickets assigned to you. Keep statuses updated to ensure swift customer resolution.' }}
                    </p>
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg shadow hover:bg-indigo-50 transition duration-150 ease-in-out text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Create Ticket
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('employees.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 bg-opacity-30 border border-indigo-300 text-white font-semibold rounded-lg hover:bg-opacity-40 transition duration-150 ease-in-out text-sm">
                                Manage Employees
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Open Tickets Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Open Tickets</p>
                        <h4 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $stats['open_tickets'] }}</h4>
                    </div>
                </div>

                <!-- In Progress Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">In Progress</p>
                        <h4 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $stats['in_progress_tickets'] }}</h4>
                    </div>
                </div>

                <!-- Resolved Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-2xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Resolved</p>
                        <h4 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $stats['resolved_tickets'] + $stats['closed_tickets'] }}</h4>
                    </div>
                </div>

                <!-- High Priority Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center hover:shadow-md transition duration-200">
                    <div class="p-3 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-2xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">High Priority</p>
                        <h4 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $stats['high_priority_tickets'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Panel: Recent Tickets (Col span 2) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                {{ Auth::user()->isAdmin() ? 'Recent System Tickets' : 'My Recent Assigned Tickets' }}
                            </h3>
                            <a href="{{ route('tickets.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                View All &rarr;
                            </a>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentTickets as $ticket)
                                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-750 transition flex justify-between items-center">
                                    <div class="flex-1 min-w-0 pr-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full uppercase tracking-wider
                                                {{ $ticket->priority === 'high' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-400' : '' }}
                                                {{ $ticket->priority === 'medium' ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-400' : '' }}
                                                {{ $ticket->priority === 'low' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400' : '' }}
                                            ">
                                                {{ $ticket->priority }}
                                            </span>
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full uppercase tracking-wider
                                                {{ $ticket->status === 'open' ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400' : '' }}
                                                {{ $ticket->status === 'in_progress' ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-400' : '' }}
                                                {{ $ticket->status === 'resolved' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400' : '' }}
                                                {{ $ticket->status === 'closed' ? 'bg-gray-50 text-gray-600 dark:bg-gray-700 dark:text-gray-300' : '' }}
                                            ">
                                                {{ str_replace('_', ' ', $ticket->status) }}
                                            </span>
                                        </div>
                                        <h4 class="text-base font-bold text-gray-800 dark:text-gray-200 mt-2 truncate">
                                            {{ $ticket->title }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">
                                            {{ $ticket->description }}
                                        </p>
                                        <div class="flex items-center space-x-2 text-xs text-gray-400 dark:text-gray-500 mt-2">
                                            <span>#{{ $ticket->id }}</span>
                                            <span>&bull;</span>
                                            <span>Created {{ $ticket->created_at->diffForHumans() }}</span>
                                            @if(Auth::user()->isAdmin() && $ticket->assignedEmployee)
                                                <span>&bull;</span>
                                                <span class="text-indigo-500 dark:text-indigo-400">Assigned to {{ $ticket->assignedEmployee->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-200 dark:border-gray-600 text-sm font-semibold rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                            Manage
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                    No tickets found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Side Stats / Workloads -->
                <div class="space-y-6">
                    @if(Auth::user()->isAdmin())
                        <!-- Admin View: Employee Workloads -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Employee Workloads</h3>
                            </div>
                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($employees as $employee)
                                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-750 transition flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            @if($employee->profile_image)
                                                <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('storage/' . $employee->profile_image) }}" alt="{{ $employee->name }}">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                                    {{ substr($employee->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $employee->name }}</h4>
                                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $employee->email }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-extrabold text-indigo-600 dark:text-indigo-400 block">{{ $employee->total_tickets }} total</span>
                                            <span class="text-xs text-amber-500 block">{{ $employee->open_tickets }} open</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                        No employees found. Seed or add employees.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @else
                        <!-- Employee View: Account Summary Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-6">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">My Workspace</h3>
                            <div class="flex items-center space-x-4">
                                @if(Auth::user()->profile_image)
                                    <img class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500" src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xl border-2 border-indigo-500">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-base font-bold text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-450">{{ Auth::user()->email }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Phone: {{ Auth::user()->phone ?? 'Not set' }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-750/30 rounded-xl p-4 space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">My Resolution Rate:</span>
                                    <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                        @php
                                            $total = $stats['total_tickets'];
                                            $resolved = $stats['resolved_tickets'] + $stats['closed_tickets'];
                                            $rate = $total > 0 ? round(($resolved / $total) * 100) : 0;
                                        @endphp
                                        {{ $rate }}%
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full" style="width: {{ $rate }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
