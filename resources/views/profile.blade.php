@extends('layouts.app')

@section('page_title')
<title>{{ config('app.name') }} | {{ __('Profile') }}</title>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ $user }}
                    <hr>
                    <p>{{ __('Name') }}: {{ $name ?? '' }}</p>
                    <p>{{ __('Gender') }}: {{ $gender ?? '' }}</p>
                    <p>{{ __('Age') }}: {{ $age ?? '' }}</p>
                    <p>{{ __('Birthplace') }}: {{ $birthplace ?? '' }}</p>
                    <p>{{ __('Residence') }}: {{ $residence ?? '' }}</p>
                    <p>{{ __('Occupation') }}: {{ $occupation ?? '' }}</p>
                    <p>{{ __('Communing time') }}: {{ $communing_time ?? '' }}</p>
                    <p>{{ __('Living style') }}: {{ $living_style ?? '' }}</p>
                    <p>{{ __('Annual income') }}: {{ $annual_income ?? '' }}</p>
                    <p>{{ __('Marriage status') }}: {{ $marriage_status ?? '' }}</p>
                    <p>{{ __('Household composition') }}: {{ $household_composition ?? '' }}</p>
                    <p>{{ __('Email') }}: {{ $email ?? '' }}</p>

                    <div>
                        <a class="" href="{{ route('profileEdit') }}">
                            {{ __('Edit Profile') }}
                        </a> ・

                        <a class="" href="{{ route('profileDelete') }}">
                            {{ __('Delete Account') }}
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
