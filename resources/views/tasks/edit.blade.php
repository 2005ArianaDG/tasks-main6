@extends('layouts.app')
@section('content')
<h1>Editando tarea ID: {{ $task->id }}</h1>
<hr>
    <a href="{{ route('tasks.index') }}" ><button type="submit" class="btn btn-primary">Volver</button></a>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="/tasks/{{ $task->id }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label class="form-label" for="name">Nombre</label>
        <input class="form-control" type="text" name="name" id="name" value="{{ $task->name }}">
        @error('name')
            <p>{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="form-label" for="priority_id">Prioridad</label>
        <select name="priority_id" id="priority_id" class="form-control">
            @foreach($priorities as $priority)
                <option value="{{ $priority->id }}">{{ $priority->name }}</option>
            @endforeach
        </select>
        @error('priority_id')
            <p>{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="form-label" for="user_id">Asignar a Usuario</label>
        <select name="user_id" id="user_id" class="form-control">
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id')
            <p>{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="form-label" for="description">Descripción</label>
        <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $task->description }}</textarea>
        @error('description')
            <p>{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="form-label" for="tags">Etiquetas</label>
        <select name="tags[]" id="tags" class="form-control" multiple>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ $task->tags->contains($tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
            @endforeach
        </select>
        @error('tags')
            <p>{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection