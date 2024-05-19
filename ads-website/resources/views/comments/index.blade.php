@extends('layouts.app')

@section('content')
    <h1>Комментарии к объявлению</h1>
    
    @foreach($comments as $comment)
        <div>
            <p>{{ $comment->content }}</p>
            <small>Автор: {{ $comment->user->name }}</small>
        </div>
    @endforeach
@endsection
