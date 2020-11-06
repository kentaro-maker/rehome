@extends('layouts.app')

@section('page_title')
<title>{{ config('app.name') }} | {{ __('Search') }}</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Search result') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>

                <ul class="list-group list-group-flush">
                    @foreach ($cities as $city)
                        <li class="list-group-item">
                            <p>{{ $city->name }}</p>
                            <a href="{{ route('search.result.detail' , $city->id) }}">詳細</a>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
</div>
@endsection
