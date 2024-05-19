@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ $ad->title }}</h1>
    <p>{{ $ad->description }}</p>
    <p>{{ $ad->price }} руб.</p>
    <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-secondary">Редактировать</a>
    <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Удалить</button>
    </form>

    <h2 class="my-4">Комментарии</h2>
    @foreach ($ad->comments as $comment)
    <div class="card mb-3">
        <div class="card-body">
            <strong>{{ $comment->user->name }}</strong>
            <p>{{ $comment->content }}</p>
            <p><small>Дата: {{ $comment->created_at }}</small></p>
        </div>
    </div>
    @endforeach

    <h2 class="my-4">Добавить комментарий</h2>
    <form action="{{ route('comments.store', $ad->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Комментарий:</label>
            <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
</div>
@endsection
