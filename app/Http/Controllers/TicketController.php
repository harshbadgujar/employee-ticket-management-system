<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Mail\TicketAssignedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    /**
     * Display a listing of the tickets.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Admins can see all tickets, employees can only see their assigned tickets
        if ($user->isAdmin()) {
            $query = Ticket::with(['assignedEmployee', 'creator']);
        } else {
            $query = Ticket::where('assigned_to', $user->id)->with(['assignedEmployee', 'creator']);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Department filter – match assigned employee or ticket creator department
        if ($request->filled('department')) {
            $dept = $request->department;
            $query->where(function($q) use ($dept) {
                $q->whereHas('assignedEmployee', function($q2) use ($dept) {
                    $q2->where('department', $dept);
                })->orWhereHas('creator', function($q2) use ($dept) {
                    $q2->where('department', $dept);
                });
            });
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Apply status filter only when a specific status is chosen (non‑empty and not 'all')
        // This ensures that selecting 'All Statuses' (or leaving the filter empty) will return tickets of any status,
        // including pending, resolved, closed, etc., while still allowing department filtering to work independently.
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }


        $tickets = $query->latest()->paginate(10)->withQueryString();

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $employees = User::where('role', 'employee')->get();
        return view('tickets.create', compact('employees'));
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'string', 'in:low,medium,high'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        // If assigned, verify the user is indeed an employee
        if ($request->filled('assigned_to')) {
            $assignedUser = User::find($request->assigned_to);
            if ($assignedUser->role !== 'employee') {
                return back()->withErrors(['assigned_to' => 'Tickets can only be assigned to employees.'])->withInput();
            }
        }

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open',
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
        ]);

        // Send email notification on assignment
        if ($ticket->assigned_to) {
            try {
                Mail::to($ticket->assignedEmployee->email)->send(new TicketAssignedMail($ticket));
            } catch (\Exception $e) {
                \Log::error("Failed to send ticket assignment email: " . $e->getMessage());
            }
        }

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        Gate::authorize('view', $ticket);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the ticket.
     */
    public function edit(Ticket $ticket)
    {
        Gate::authorize('update', $ticket);

        $employees = User::where('role', 'employee')->get();
        return view('tickets.edit', compact('ticket', 'employees'));
    }

    /**
     * Update the ticket in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        Gate::authorize('update', $ticket);

        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admins can update everything
            $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'priority' => ['required', 'string', 'in:low,medium,high'],
                'status' => ['required', 'string', 'in:open,in_progress,resolved,closed'],
                'assigned_to' => ['nullable', 'exists:users,id'],
            ]);

            // If assigned, verify the user is indeed an employee
            if ($request->filled('assigned_to')) {
                $assignedUser = User::find($request->assigned_to);
                if ($assignedUser->role !== 'employee') {
                    return back()->withErrors(['assigned_to' => 'Tickets can only be assigned to employees.'])->withInput();
                }
            }

            $oldAssigneeId = $ticket->assigned_to;

            $ticket->update([
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'status' => $request->status,
                'assigned_to' => $request->assigned_to,
            ]);

            // Send assignment email if newly assigned or changed assignee
            if ($ticket->assigned_to && $ticket->assigned_to != $oldAssigneeId) {
                try {
                    Mail::to($ticket->assignedEmployee->email)->send(new TicketAssignedMail($ticket));
                } catch (\Exception $e) {
                    \Log::error("Failed to send ticket assignment email: " . $e->getMessage());
                }
            }
        } else {
            // Employees can ONLY update the status
            $request->validate([
                'status' => ['required', 'string', 'in:open,in_progress,resolved,closed'],
            ]);

            $ticket->update([
                'status' => $request->status,
            ]);
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the ticket from storage.
     */
    public function destroy(Ticket $ticket)
    {
        Gate::authorize('delete', $ticket);

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
