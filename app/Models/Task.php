<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if task is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if task is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'pending' && $this->due_date && $this->due_date->isPast();
    }

    /**
     * Scope: Pending tasks.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Completed tasks.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->toDateString());
    }

    /**
     * Scope: Filter tasks by various criteria.
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['status'] ?? null, function ($query, $status) {
            if ($status === 'completed') {
                $query->completed();
            } elseif ($status === 'pending') {
                $query->pending();
            } elseif ($status === 'overdue') {
                $query->overdue();
            }
        });

        $query->when($filters['priority'] ?? null, function ($query, $priority) {
            if (in_array($priority, ['low', 'medium', 'high'])) {
                $query->where('priority', $priority);
            }
        });

        $query->when($filters['due_date'] ?? null, function ($query, $dueDate) {
            if ($dueDate === 'today') {
                $query->whereDate('due_date', now()->toDateString());
            } elseif ($dueDate === 'tomorrow') {
                $query->whereDate('due_date', now()->addDay()->toDateString());
            } elseif ($dueDate === 'this_week') {
                $query->whereBetween('due_date', [
                    now()->startOfWeek()->toDateString(),
                    now()->endOfWeek()->toDateString()
                ]);
            } elseif ($dueDate === 'overdue') {
                $query->overdue();
            }
        });
    }
}
