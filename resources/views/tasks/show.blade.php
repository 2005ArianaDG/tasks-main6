@extends('layouts.app')
@section('content')
    <h1>Tarea ID: {{ $task->id }}</h1>
    <hr>
        <a href="{{ route('tasks.index') }}" ><button type="submit" class="btn btn-primary">Volver</button></a>
    <h2>{{ $task->name }}</h2>
    <p>{{ $task->description }}</p>

    <a href="/tasks/{{ $task->id }}/edit">Editar</a>
    <a href="/tasks/{{ $task->id }}/delete">Eliminar</a>
@endsection
