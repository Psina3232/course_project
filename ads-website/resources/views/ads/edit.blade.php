@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Редактировать объявление</h1>
    
    <form action="{{ route('ads.update', $ad->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $ad->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ $ad->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $ad->price }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection