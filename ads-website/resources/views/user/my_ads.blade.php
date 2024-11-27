@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Профиль {{ Auth::user()->name }}</h1>

        <h2>Мои объявления</h2>
        @foreach ($ads as $ad)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $ad->title }}</h5>
                    <p class="card-text">{{ $ad->description }}</p>
                    <a href="{{ route('ads.show', $ad->id) }}" class="btn btn-primary">Смотреть</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
