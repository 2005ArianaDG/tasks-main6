@extends('layouts.app')
@section('title', 'Lista de tareas')

@section('content')
    <h1>Lista de tareas</h1>
    <hr>
    <a href="/tasks/create"><button type="submit" class="btn btn-primary">Crear Tarea</button></a>
    <table>
    <table class="table table-striped-columns">
            <tr>
                <th style="width: 22%;">Nombre</th>
                <th style="width: 22%;">Prioridad</th>
                <th style="width: 22%;">Usuario</th>
                <th style="width: 22%;">Etiquetas</th>
                <th style="width: 22%;">Completada</th>
                <th style="width: 22%;">Acciones</th>
            </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr class ="tr">
                <td><a href="/tasks/{{ $task->id }}">{{ $task->name }}</a></td>
                <td>
                    <span class="badge text-bg-warning">{{ $task->priority?->name }}</span>
                </td>
                <td>
                    @if ($task->user)
                        {{ $task->user->name }}
                    @else
                        <span class="text-muted">No asignado</span>
                    @endif
                </td>
                <td>
                    @foreach ($task->tags as $tag)
                        <span class="badge bg-primary">{{ $tag->name }}</span>
                    @endforeach
                </td>
                <td>
                    @if (!$task->completed)
                        Pendiente
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check2-circle" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                    </svg>
                    Completada
                    @endif
                </td>

                <td>
                    @if (!$task->completed)
                        <form action="/tasks/{{ $task->id }}/complete" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Completar</button>
                        </form>
                    @else
                        <span>-</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



@endsection
