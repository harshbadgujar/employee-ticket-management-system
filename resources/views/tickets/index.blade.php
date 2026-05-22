<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ Auth::user()->isAdmin() ? __('Support Tickets') : __('My Assigned Tickets') }}
            </h2>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Create Support Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Message Banner -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 dark:bg-emerald-950/20 dark:border-emerald-800 dark:text-emerald-400 rounded-xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Search, Priority, & Status Filters Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <form action="{{ route('tickets.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <!-- Search Input -->
                    <div class="space-y-1 md:col-span-2">
                        <label for="search" class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Search Keyword</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search ticket title, description..." class="w-full pl-9 pr-4 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="space-y-1">
                        <label for="status" class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</label>
                        <select name="status" id="status" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">All Statuses</option>
                            <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <!-- Priority Filter -->
                        <!-- Department Filter -->
                        <div class="space-y-1">
                            <label for="department" class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Department</label>
                            <select name="department" id="department" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">All Departments</option>
                                <option value="IT" {{ request('department') === 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="BD" {{ request('department') === 'BD' ? 'selected' : '' }}>Business Development</option>
                                <option value="QA" {{ request('department') === 'QA' ? 'selected' : '' }}>QA</option>
                                <option value="HR" {{ request('department') === 'HR' ? 'selected' : '' }}>HR</option>
                                <option value="Finance" {{ request('department') === 'Finance' ? 'selected' : '' }}>Finance</option>
                            </select>
                        </div>

                    <!-- Actions -->
                    <div class="md:col-span-4 flex justify-end space-x-2 pt-2">
                        @if(request()->anyFilled(['search', 'status', 'priority', 'department']))
                            <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-150 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-655 text-gray-700 dark:text-gray-300 font-semibold text-sm rounded-lg border border-gray-200 dark:border-gray-600 transition">
                                Reset Filters
                            </a>
                        @endif
                        <button type="submit" class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-lg shadow transition duration-150 ease-in-out">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tickets List -->
            <div class="table-container">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ticket Details</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priority</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                @if(Auth::user()->isAdmin())
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status Action</th>
                                @endif
                                @if(Auth::user()->isAdmin())
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Assigned Employee</th>
                                @endif
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-750/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="max-w-md">
                                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate">
                                                {{ $ticket->title }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                                {{ $ticket->description }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                By: <span class="font-semibold text-indigo-500">{{ $ticket->creator->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wider
                                            {{ $ticket->priority === 'high' ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400 border border-rose-100 dark:border-rose-900' : '' }}
                                            {{ $ticket->priority === 'medium' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400 border border-amber-100 dark:border-amber-900' : '' }}
                                            {{ $ticket->priority === 'low' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900' : '' }}
                                        ">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wider
                                            {{ $ticket->status === 'open' ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/30 dark:text-blue-400 border border-blue-100 dark:border-blue-900' : '' }}
                                            {{ $ticket->status === 'in_progress' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400 border border-amber-100 dark:border-amber-900' : '' }}
                                            {{ $ticket->status === 'resolved' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900' : '' }}
                                            {{ $ticket->status === 'closed' ? 'bg-gray-50 text-gray-700 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600' : '' }}
                                        ">
                                            {{ str_replace('_', ' ', $ticket->status) }}
                                        </span>
                                    </td>
@if(Auth::user()->isAdmin())
    <td class="px-6 py-4 whitespace-nowrap">
        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="inline-flex items-center">
            @csrf
            @method('PATCH')
            <select name="status" class="rounded border-gray-300 dark:bg-gray-800 dark:text-gray-200">
                <option value="open" {{ $ticket->status=='open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ $ticket->status=='in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ $ticket->status=='resolved' ? 'selected' : '' }}>Resolved</option>
                <option value="closed" {{ $ticket->status=='closed' ? 'selected' : '' }}>Closed</option>
            </select>
            <button type="submit" class="ml-2 text-sm text-indigo-600 dark:text-indigo-400">Update</button>
        </form>
    </td>
@endif
                                    @if(Auth::user()->isAdmin())
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($ticket->assignedEmployee)
                                                <div class="flex items-center space-x-2">
                                                    @if($ticket->assignedEmployee->profile_image)
                                                        <img class="w-6 h-6 rounded-full object-cover" src="{{ asset('storage/' . $ticket->assignedEmployee->profile_image) }}" alt="">
                                                    @endif
                                                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                        {{ $ticket->assignedEmployee->name }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-xs italic text-gray-400">Unassigned</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('tickets.show', $ticket) }}" class="action-btn action-btn-view" title="View">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                @if(Auth::user()->isAdmin() || $ticket->assigned_to === Auth::id())
                                                    <a href="{{ route('tickets.edit', $ticket) }}" class="action-btn action-btn-edit" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 3v2m0 12l-5-5M16.5 9.5l-3-3m0 0L6 14l1 5 5-1 6.5-6.5-5-5z" />
                                                        </svg>
                                                    </a>
                                                @endif
                                                @if(Auth::user()->isAdmin())
                                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-btn action-btn-delete" title="Delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        No support tickets found matching the specified filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tickets->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
