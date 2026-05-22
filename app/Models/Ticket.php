<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'status', 'priority', 'assigned_to', 'created_by'])]
class Ticket extends Model
{
    use HasFactory;

    /**
     * Get the employee assigned to this ticket.
     */
    public function assignedEmployee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the creator of this ticket.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
