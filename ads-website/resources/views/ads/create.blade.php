@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Создать объявление</h1>
    
    <form action="{{ route('ads.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
</div>
@endsection
