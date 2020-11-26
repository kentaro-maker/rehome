@extends('layouts.app')

@section('page_title')
<title>{{ config('app.name') }} | {{ __('Register') }}</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</legend>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineCheckbox1" value="{{ $gender ?? '' }}" reuqired autocomplete="gender" autofocus>
                                        <label class="form-check-label" for="inlineCheckbox1">
                                          {{ __('Male') }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineCheckbox2" value="option2">
                                        <label class="form-check-label" for="inlineCheckbox2">
                                          {{ __('Female') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>

                        <div class="form-group row">
                            <label for="bod" class="col-md-4 col-form-label text-md-right">{{ __('BOD') }}</label>
                            <div class="col-md-6 d-flex align-items-center">        
                                <select v-model="year" @input="modifyMonths">
                               
                                </select>年
                                <select :options="months" v-model="month" @input="modifyDates"></select>月
                                <select :options="dates" v-model="date"></select>日
                                <select v-model="selected">
                                    <option disabled value="">選択して下さい</option>
                                    <option v-for="option in options" v-bind:value="option.name" v-bind:key="option.id">
                                        {{ 'option.name' }}
                                    </option>
                                </select>
                                <p>{{ selected }}</p>
                                
                                @error('bod')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="birthplace" class="col-md-4 col-form-label text-md-right">{{ __('Birthplace') }}</label>

                            <div class="col-md-6">
                                <select :options="prefs" v-model="pref" @input="modifyCities">
                     
                                </select>年
                                
                                <select :options="cities" v-model="city"></select>年

                                <input id="birthplace" type="text" class="form-control @error('birthplace') is-invalid @enderror" name="birthplace" value="{{ $birthplace ?? '' }}" required autocomplete="birthplace" autofocus>

                                @error('birthplace')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
