@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Список объявлений</h1>
    <form action="{{ route('ads.search') }}" method="GET" class="form-inline mb-4">
    <input type="text" name="search" placeholder="Поиск..." class="form-control mr-2">
    <button type="submit" class="btn btn-primary">Искать</button>
</form>

    <a href="{{ route('ads.create') }}" class="btn btn-success mb-4">Создать новое объявление</a>

    <div class="row">
        @foreach($ads as $ad)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $ad->title }}</h5>
                    <p class="card-text">{{ $ad->description }}</p>
                    <p class="card-text">{{ $ad->price }} руб.</p>
                    <a href="{{ route('ads.show', $ad->id) }}" class="btn btn-primary">Подробнее</a>
                    @if(auth()->check() && ($ad->user_id === auth()->id() || auth()->user()->isAdmin()))
                    <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-secondary">Редактировать</a>
                    <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
