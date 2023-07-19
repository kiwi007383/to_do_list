@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-3">
                <div class="">
                    <a href="{{ route('post#home') }}" class="text-black">
                        <p><i class="fa-solid fa-arrow-left"></i></p>
                    </a>
                </div>
                <h3>{{ $posts[0]['title'] }}</h3>
                <p>{{ $posts[0]['created_at']->format('d-F-y | h:m A') }}</p>
                <div class="d-flex">
                    <div class="btn btn-sm bg-dark text-white me-1 mb-3"><i
                            class="fa-solid fa-money-bill-wave text-primary"></i><small>
                            {{ $posts[0]['price'] }}</small>
                    </div>
                    <div class="btn btn-sm bg-dark text-white me-1 mb-3"><small><i class="fa-solid fa-location-dot"></i>
                            {{ $posts[0]['address'] }}</small>
                    </div>
                    <div class="btn btn-sm bg-dark text-white me-1 mb-3"><small><i class="fa-solid fa-star"
                                style="color: #cee51f;"></i>
                            {{ $posts[0]['rating'] }}</small></div>
                </div>
                <div class="">
                    @if ($posts[0]['image'] == null)
                        <img src="{{ asset('img_not_found.png') }}" class="img-thumbnail w-75">
                    @else
                        <img src="{{ asset('storage/' . $posts[0]['image']) }}" class="img-thumbnail w-75">
                    @endif
                </div>
                <p class="text-muted mt-3">{{ $posts[0]['description'] }}</p>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-4 mb-5">
                    <a href="{{ route('post#edit', $posts[0]['id']) }}">
                        <button class="btn btn-dark">Edit</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
