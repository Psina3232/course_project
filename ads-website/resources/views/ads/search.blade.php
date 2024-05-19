@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Результаты поиска</h1>
    <form action="{{ route('ads.search') }}" method="GET" class="form-inline mb-4">
        <input type="text" name="query" placeholder="Поиск объявлений" class="form-control mr-2">
        <button type="submit" class="btn btn-primary">Поиск</button>
    </form>

    <div class="row">
        @foreach ($ads as $ad)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $ad->title }}</h5>
                    <p class="card-text">{{ $ad->description }}</p>
                    <a href="{{ route('ads.show', $ad->id) }}" class="btn btn-primary">Подробнее</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
