@extends('layouts.app')

@section('content')
    <h1>Добавить комментарий</h1>
    
    <form action="{{ route('comments.store', $ad->id) }}" method="POST">
        @csrf

        <div>
            <label for="content">Комментарий</label>
            <textarea name="content" id="content"></textarea>
        </div>

        <button type="submit">Добавить</button>
    </form>
@endsection
