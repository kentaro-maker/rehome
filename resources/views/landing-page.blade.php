@extends('layouts.app')

@section('page_title')
<title>{{ config('app.name') }}</title>
@endsection

@section('content')
<div class="featured-section d-flex align-items-center">
    <div class="w-50 d-flex flex-column">
        <h1 class="text-center">{{ config('app.name') }}</h1>
        <p class="section-description text-center">新たな暮らしを見つけよう</p>
        <div class="text-center button-container">
            <a href="#" class="button">暮らしを探す</a>
        </div>
    </div>
    <div class="w-50">
        <img src="{{ cityImage($cities[0]->slug) }}" alt="city" class="w-100">
    </div>
</div>
<div class="introduction-section">
    <div class="container">

        <div class="cities text-center">
            @foreach ($cities as $city)
                <div class="city">
                    <a href="{{ route('city.show', $city->slug) }}"><img src="{{ cityImage($city->slug) }}" alt="city"></a>
                    <a href="{{ route('city.show', $city->slug) }}"><div class="city-name">{{ $city->name }}</div></a>
                    <div class="city-price"></div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center button-container">
            <a href="{{ route('city.index') }}" class="button">View more products</a>
        </div>
    </div> <!-- end container -->
</div>
@endsection
