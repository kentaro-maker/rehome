@extends('layouts.app')

@section('page_title')
<title>{{ config('app.name') }} | {{ __('Profile') }}</title>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Profile') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profileEdit') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $name ?? '' }}" required autocomplete="name" autofocus>

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
                            <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>
                            <div class="col-md-6">
                                <select id="age" name="age" class="form-control @error('age') is-invalid @enderror" id="age" required autocomplete="age" autofocus>
                                    <option selected>Choose...</option>
                                    @for ($i = 0; $i < 101; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>

                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthplace" class="col-md-4 col-form-label text-md-right">{{ __('Birthplace') }}</label>

                            <div class="col-md-6">
                                <input id="birthplace" type="text" class="form-control @error('birthplace') is-invalid @enderror" name="birthplace" value="{{ $birthplace ?? '' }}" required autocomplete="birthplace" autofocus>

                                @error('birthplace')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="residence" class="col-md-4 col-form-label text-md-right">{{ __('Residence') }}</label>

                            <div class="col-md-6">
                                <input id="residence" type="text" class="form-control @error('residence') is-invalid @enderror" name="residence" value="{{ $residence ?? '' }}" required autocomplete="residence" autofocus>

                                @error('residence')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="occupation" class="col-md-4 col-form-label text-md-right">{{ __('Occupation') }}</label>

                            <div class="col-md-6">
                                <input id="occupation" type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" value="{{ $occupation ?? '' }}" required autocomplete="occupation" autofocus>

                                @error('occupation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="communing_time" class="col-md-4 col-form-label text-md-right">{{ __('Communing time') }}</label>

                            <div class="col-md-6">
                                <input id="communing_time" type="text" class="form-control @error('communing_time') is-invalid @enderror" name="communing_time" value="{{ $communing_time ?? '' }}" required autocomplete="communing_time" autofocus>

                                @error('communing_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="living_style" class="col-md-4 col-form-label text-md-right">{{ __('Living style') }}</label>

                            <div class="col-md-6">
                                <input id="living_style" type="text" class="form-control @error('living_style') is-invalid @enderror" name="living_style" value="{{ $living_style ?? '' }}" required autocomplete="living_style" autofocus>

                                @error('living_style')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="annual_income" class="col-md-4 col-form-label text-md-right">{{ __('Annual income') }}</label>
                            <div class="col-md-6">
                                <select id="annual_income" name="annual_income" class="form-control @error('annual_income') is-invalid @enderror" id="age" required autocomplete="annual_income" autofocus>
                                  <option selected>Choose...</option>
                                  @for ($i = 1; $i < 100; $i++)
                                  <option value="{{ $i }}">{{ $i }}00万円</option>
                                  @endfor
                                </select>

                                @error('annual_income')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                          <label for="marriage_status" class="col-md-4 col-form-label text-md-right">{{ __('Marriage status') }}</label>

                          <div class="col-md-6">
                            <input id="marriage_status" type="text" class="form-control @error('marriage_status') is-invalid @enderror" name="marriage_status" value="{{ $marriage_status ?? '' }}" required autocomplete="marriage_status" autofocus>

                            @error('marriage_status')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="household_composition" class="col-md-4 col-form-label text-md-right">{{ __('Household composition') }}</label>

                            <div class="col-md-6">
                                <input id="household_composition" type="text" class="form-control @error('household_composition') is-invalid @enderror" name="household_composition" value="{{ $household_composition ?? '' }}" required autocomplete="household_composition" autofocus>

                                @error('household_composition')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? '' }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Done') }}
                                </button>

                                <a class="" href="{{ route('profile') }}">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
