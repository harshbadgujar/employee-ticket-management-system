<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the system dashboard with relevant stats.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // General Stats for Admin
            $stats = [
                'total_tickets' => Ticket::count(),
                'open_tickets' => Ticket::where('status', 'open')->count(),
                'in_progress_tickets' => Ticket::where('status', 'in_progress')->count(),
                'resolved_tickets' => Ticket::where('status', 'resolved')->count(),
                'closed_tickets' => Ticket::where('status', 'closed')->count(),
                'high_priority_tickets' => Ticket::where('priority', 'high')->count(),
            ];

            // Employees list with ticket counts
            $employees = User::where('role', 'employee')
                ->withCount([
                    'tickets as total_tickets',
                    'tickets as open_tickets' => function ($query) {
                        $query->where('status', 'open');
                    },
                    'tickets as resolved_tickets' => function ($query) {
                        $query->where('status', 'resolved');
                    }
                ])
                ->latest()
                ->take(5)
                ->get();

            // Recent Tickets
            $recentTickets = Ticket::with('assignedEmployee')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard', compact('stats', 'employees', 'recentTickets'));
        } else {
            // Stats specifically for this Employee
            $stats = [
                'total_tickets' => Ticket::where('assigned_to', $user->id)->count(),
                'open_tickets' => Ticket::where('assigned_to', $user->id)->where('status', 'open')->count(),
                'in_progress_tickets' => Ticket::where('assigned_to', $user->id)->where('status', 'in_progress')->count(),
                'resolved_tickets' => Ticket::where('assigned_to', $user->id)->where('status', 'resolved')->count(),
                'closed_tickets' => Ticket::where('assigned_to', $user->id)->where('status', 'closed')->count(),
                'high_priority_tickets' => Ticket::where('assigned_to', $user->id)->where('priority', 'high')->count(),
            ];

            // Recent Tickets assigned to them
            $recentTickets = Ticket::where('assigned_to', $user->id)
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard', compact('stats', 'recentTickets'));
        }
    }
}
