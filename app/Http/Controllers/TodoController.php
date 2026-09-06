<?php
namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Show all todos belonging to the logged-in user.
     */
    public function index()
    {
        $todos = Todo::where('user_id', auth()->id())
            ->orderByRaw("
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                END
            ")
            ->latest()
            ->get();

        return view('todo', compact('todos'));
    }


    /**
     * Add a new todo for the logged-in user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required',
            'description' => 'nullable',
            'priority' => 'nullable|in:high,medium,low'
        ]);

        Todo::create([
            'user_id' => auth()->id(),
            'task' => $request->task,
            'description' => $request->description,
            'priority' => $request->priority ?? 'medium',
        ]);

        return redirect('/todo')
            ->with('success', 'Task added successfully!');
    }


    /**
     * Show task details.
     */
    public function show($id)
    {
        $todo = Todo::where('user_id', auth()->id())
            ->findOrFail($id);

        return view('todo-show', compact('todo'));
    }


    /**
     * Show edit page.
     */
    public function edit($id)
    {
        $todo = Todo::where('user_id', auth()->id())
            ->findOrFail($id);

        if ($todo->is_completed) {
            return redirect('/todo')
                ->with('error', 'Completed tasks cannot be edited.');
        }

        return view('todo-edit', compact('todo'));
    }


    /**
     * Update task.
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::where('user_id', auth()->id())
            ->findOrFail($id);

        if ($todo->is_completed) {
            return redirect('/todo')
                ->with('error', 'Completed tasks cannot be edited.');
        }

        $request->validate([
            'task' => 'required',
            'description' => 'nullable',
            'priority' => 'required|in:high,medium,low'
        ]);

        $todo->update([
            'task' => $request->task,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);

        return redirect('/todo')
            ->with('success', 'Task updated successfully!');
    }


    /**
     * Complete / uncomplete task.
     */
    public function complete($id)
    {
        $todo = Todo::where('user_id', auth()->id())
            ->findOrFail($id);

        if ($todo->is_completed) {
            $todo->update([
                'is_completed' => false,
                'completed_at' => null,
            ]);
        } else {
            $todo->update([
                'is_completed' => true,
                'completed_at' => now(),
            ]);
        }

        return redirect('/todo');
    }


    /**
     * Delete task.
     */
    public function destroy($id)
    {
        $todo = Todo::where('user_id', auth()->id())
            ->findOrFail($id);

        $todo->delete();

        return redirect('/todo')
            ->with('success', 'Task deleted successfully!');
    }
}

