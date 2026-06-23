<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Fetch dashboard statistics
        $stats = [
            'total' => $user->tasks()->count(),
            'pending' => $user->tasks()->pending()->count(),
            'completed' => $user->tasks()->completed()->count(),
            'overdue' => $user->tasks()->overdue()->count(),
        ];

        // Start tasks query
        $query = $user->tasks();

        // Apply filters
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status', 'pending'), // default to pending for better focus
            'priority' => $request->get('priority'),
            'due_date' => $request->get('due_date'),
        ];
        
        $query->filter($filters);

        // Apply sorting
        $sortBy = $request->get('sort_by', 'due_date');
        $sortOrder = $request->get('sort_order', 'asc');

        if ($sortBy === 'priority') {
            $query->orderByRaw("CASE WHEN priority = 'high' THEN 1 WHEN priority = 'medium' THEN 2 WHEN priority = 'low' THEN 3 ELSE 4 END " . ($sortOrder === 'desc' ? 'DESC' : 'ASC'));
        } elseif (in_array($sortBy, ['title', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else { // default to due_date sorting
            // Nulls last on ascending, nulls first on descending
            $nullOrder = $sortOrder === 'asc' ? 'ASC' : 'DESC';
            $query->orderByRaw("CASE WHEN due_date IS NULL THEN 1 ELSE 0 END " . $nullOrder)
                  ->orderBy('due_date', $sortOrder);
        }

        // Paginate tasks
        $tasks = $query->paginate(10)->withQueryString();

        return view('dashboard', compact('tasks', 'stats', 'filters', 'sortBy', 'sortOrder'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->user()->tasks()->create($request->validated());

        return redirect()->route('dashboard')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Display the specified task details as JSON (for editing/viewing in modal).
     */
    public function show(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        return response()->json($task);
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $data = $request->validated();

        if ($data['status'] === 'completed' && $task->status !== 'completed') {
            $data['completed_at'] = now();
        } elseif ($data['status'] === 'pending' && $task->status !== 'pending') {
            $data['completed_at'] = null;
        }

        $task->update($data);

        return redirect()->route('dashboard')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $task->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Tarefa excluída com sucesso!');
    }

    /**
     * Toggle the task status between pending and completed.
     */
    public function toggleComplete(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        if ($task->isCompleted()) {
            $task->update([
                'status' => 'pending',
                'completed_at' => null,
            ]);
            $message = 'Tarefa marcada como pendente.';
        } else {
            $task->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
            $message = 'Tarefa marcada como concluída.';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $task->status,
                'completed_at' => $task->completed_at ? $task->completed_at->format('Y-m-d H:i:s') : null
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
