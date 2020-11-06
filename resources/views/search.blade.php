@extends('layouts.app')

@section('page_title')
<title>{{ config('app.name') }} | {{ __('Search') }}</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Search') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">完全テレワーク</li>
                    <li class="list-group-item">テレワーク＋週1~2回出勤</li>
                    <li class="list-group-item">テレワーク＋週1~2回出勤</li>
                    <li class="list-group-item">毎日出勤(テレワークなし)</li>
                    <li class="list-group-item">休業中・自宅待機</li>
                    <li class="list-group-item">その他</li>
                </ul>

                <div class="card-body">
                    <a href="{{ route('search.result') }}" class="card-link">{{ __('結果') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
