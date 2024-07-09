<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Task;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {

        $tasks = Task::with('user')->get();

        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }

    public function create(Task $task)
    {

        return view('tasks.create',[
            'task' => $task,
            'priorities' => Priority::all(),
            'users' => User::all(),
            'tags' => Tag::all()
        ]);
    }

    public function show(Task $task)
    {

        return view('tasks.show', [
            'task' => $task
        ]);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'priority_id' => ['required', 'exists:priorities,id'],
        'user_id' => ['required', 'exists:users,id'],
        'tags' => ['nullable', 'array'], // Etiquetas son opcionales y deben ser un arreglo
    ]);

    // Crear la tarea
    $task = Task::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'priority_id' => $data['priority_id'],
        'user_id' => $data['user_id'],
    ]);

    // Asociar etiquetas si se proporcionaron
    if (isset($data['tags'])) {
        $task->tags()->attach($data['tags']);
    }

    return redirect('/tasks')->with('success', 'Tarea creada exitosamente.');
}
    public function delete(Task $task)
    {
        $task->delete();
        return redirect('/tasks');
    }
    public function edit(Task $task)
    {

        return view('tasks.edit', [
            'task' => $task,
            'priorities' => Priority::all(),
            'users' => User::all(),
            'tags' => Tag::all()
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3'],
            'priority_id' => 'required|exists:priorities,id',
            'user_id' => 'required|exists:users,id',
            'tags' => 'array', // Validación para un array de tags
            'tags.*' => 'exists:tags,id' // Validación para cada tag
        ]);
    
        $task->fill($data)->save();
    
        // Actualizar las etiquetas asociadas
        if (isset($data['tags'])) {
            $task->tags()->sync($data['tags']);
        } else {
            // Si no se seleccionaron etiquetas, desasociar todas
            $task->tags()->detach();
        }
    
        return redirect('/tasks/' . $task->id);
    }
    public function complete(Task $task)
    {
        $task->completed = true;
        $task->save();

        return redirect('/tasks');
    }
}

