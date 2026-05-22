<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('tickets.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Support Ticket: ') }} <span class="text-indigo-650 dark:text-indigo-400 font-bold">#{{ $ticket->id }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Success Message -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 dark:bg-emerald-950/20 dark:border-emerald-800 dark:text-emerald-400 rounded-xl flex items-center shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Ticket Core Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <!-- Status/Priority Header Banner -->
                <div class="px-8 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Status:</span>
                        <span class="text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider border
                            {{ $ticket->status === 'open' ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/30 dark:text-blue-400 border-blue-100 dark:border-blue-900' : '' }}
                            {{ $ticket->status === 'in_progress' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400 border-amber-100 dark:border-amber-900' : '' }}
                            {{ $ticket->status === 'resolved' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900' : '' }}
                            {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600' : '' }}
                        ">
                            {{ str_replace('_', ' ', $ticket->status) }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Priority:</span>
                        <span class="text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider border
                            {{ $ticket->priority === 'high' ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400 border-rose-100 dark:border-rose-900' : '' }}
                            {{ $ticket->priority === 'medium' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400 border-amber-100 dark:border-amber-900' : '' }}
                            {{ $ticket->priority === 'low' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900' : '' }}
                        ">
                            {{ $ticket->priority }}
                        </span>
                    </div>
                </div>

                <!-- Title & Body -->
                <div class="p-8 space-y-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 leading-tight">
                            {{ $ticket->title }}
                        </h3>
                        <span class="block text-xs text-white mt-2">
                            Created {{ $ticket->created_at->format('M d, Y \a\t g:i A') }} ({{ $ticket->created_at->diffForHumans() }})
                        </span>
                    </div>

                    <div class="prose dark:prose-invert max-w-none text-white dark:text-white bg-gray-50 dark:bg-gray-900/60 p-6 rounded-xl border border-gray-100 dark:border-gray-700 whitespace-pre-line text-sm leading-relaxed">
                        {{ $ticket->description }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Section: Meta Data (Span 2) -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h4 class="text-sm font-bold text-gray-800 dark:text-gray-250 uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-gray-750 pb-2">Association details</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            
                            <!-- Creator -->
                            <div class="space-y-1">
                                <span class="block text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold">Created By</span>
                                <div class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $ticket->creator->name }}</div>
                                <div class="text-xs text-gray-500">{{ $ticket->creator->email }}</div>
                                <div class="text-xs text-indigo-500 font-semibold">{{ ucfirst($ticket->creator->role) }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Department: {{ $ticket->creator->department ?? 'N/A' }}</div>
                            </div>

                            <!-- Assignee -->
                            <div class="space-y-1">
                                <span class="block text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold">Assigned Employee</span>
                                @if($ticket->assignedEmployee)
                                    <div class="flex items-center space-x-2 mt-1">
                                        @if($ticket->assignedEmployee->profile_image)
                                            <img class="w-8 h-8 rounded-full object-cover" src="{{ asset('storage/' . $ticket->assignedEmployee->profile_image) }}" alt="">
                                        @endif
                                        <div>
                                            <div class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $ticket->assignedEmployee->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $ticket->assignedEmployee->email }}</div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">Department: {{ $ticket->assignedEmployee->department ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-400 italic mt-1">Unassigned / Waiting for review</div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Right Section: Quick Status Changer / Management -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                        <h4 class="text-sm font-bold text-gray-800 dark:text-gray-250 uppercase tracking-wider border-b border-gray-100 dark:border-gray-750 pb-2">Status Action</h4>
                        
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            
                            @if(Auth::user()->isAdmin())
                                <!-- Hidden inputs to preserve other fields for Admins who use this quick selector -->
                                <input type="hidden" name="title" value="{{ $ticket->title }}">
                                <input type="hidden" name="description" value="{{ $ticket->description }}">
                                <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                                <input type="hidden" name="assigned_to" value="{{ $ticket->assigned_to }}">
                            @endif

                            <div class="space-y-1">
                                <label for="status" class="block text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Change Status</label>
                                <select name="status" id="status" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs">
                                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bottom Navigation Bar -->
            <div class="flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm font-semibold rounded-lg text-gray-750 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    &larr; Back to Tickets List
                </a>
                
                <div class="flex gap-2">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('tickets.edit', $ticket) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                            Edit Details
                        </a>
                        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                                Delete Ticket
                            </button>
                        </form>
                    @elseif($ticket->assigned_to === Auth::id())
                        <a href="{{ route('tickets.edit', $ticket) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                            Edit Status Form
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
