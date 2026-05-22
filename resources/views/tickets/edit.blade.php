<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('tickets.show', $ticket) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Support Ticket: ') }} <span class="text-indigo-650 dark:text-indigo-400 font-bold">#{{ $ticket->id }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @if(Auth::user()->isAdmin())
                            <!-- Admin fields -->
                            <!-- Title -->
                            <div class="space-y-1">
                                <label for="title" class="block text-sm font-bold text-gray-755 dark:text-gray-300">Ticket Subject / Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $ticket->title) }}" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                @error('title')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="space-y-1">
                                <label for="description" class="block text-sm font-bold text-gray-755 dark:text-gray-300">Detailed Description</label>
                                <textarea name="description" id="description" rows="5" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('description', $ticket->description) }}</textarea>
                                @error('description')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Priority -->
                                <div class="space-y-1">
                                    <label for="priority" class="block text-sm font-bold text-gray-755 dark:text-gray-300">Severity / Priority</label>
                                    <select name="priority" id="priority" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="low" {{ old('priority', $ticket->priority) === 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority', $ticket->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority', $ticket->priority) === 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('priority')
                                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="space-y-1">
                                    <label for="status" class="block text-sm font-bold text-gray-755 dark:text-gray-300">Ticket Status</label>
                                    <select name="status" id="status" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="open" {{ old('status', $ticket->status) === 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in_progress" {{ old('status', $ticket->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ old('status', $ticket->status) === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="closed" {{ old('status', $ticket->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('status')
                                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Assignment -->
                                <div class="space-y-1">
                                    <label for="assigned_to" class="block text-sm font-bold text-gray-755 dark:text-gray-300">Assign to Employee</label>
                                    <select name="assigned_to" id="assigned_to" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">Leave Unassigned</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ old('assigned_to', $ticket->assigned_to) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <!-- Employee view: Read-only details + Status selector -->
                            <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-xl space-y-4 mb-6 border border-gray-100 dark:border-gray-700">
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Ticket Title</h4>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-1">{{ $ticket->title }}</p>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Description</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-1 whitespace-pre-line">{{ $ticket->description }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Priority</h4>
                                        <p class="text-sm font-bold mt-1 uppercase text-indigo-550 dark:text-indigo-400">{{ $ticket->priority }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Created By</h4>
                                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-1">{{ $ticket->creator->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Changer -->
                            <div class="space-y-1">
                                <label for="status" class="block text-sm font-bold text-gray-755 dark:text-gray-300">Update Ticket Status</label>
                                <select name="status" id="status" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <option value="open" {{ old('status', $ticket->status) === 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ old('status', $ticket->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ old('status', $ticket->status) === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ old('status', $ticket->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Form Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-655 text-gray-700 dark:text-gray-300 font-semibold text-sm rounded-lg border border-gray-250 dark:border-gray-600 transition">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-lg shadow transition duration-150 ease-in-out">
                                Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
