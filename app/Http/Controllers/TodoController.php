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
}