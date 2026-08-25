<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();

        return view('todo', compact('todos'));
    }

    public function store(Request $request)
    {
        Todo::create([
            'task' => $request->task
        ]);

        return redirect('/todo');
    }

    public function edit($id)
    {
        $todo = Todo::findOrFail($id);

        return view('todo-edit', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);

        $todo->update([
            'task' => $request->task
        ]);

        return redirect('/todo');
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);

        $todo->delete();

        return redirect('/todo');
    }
}