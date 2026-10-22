@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row justify-content-left align-items-center vh-100">
            <div class="col-md-6 col-lg-6">
                <div class="bg-white shadow p-5 p-md-5">
                    <div class="">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-5">
                                        <h1 class="h4 mb-3">Neues Passwort erstellen</h1>
                                        <p>
                                            Bitte geben Sie Ihr neues Passwort ein.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                    <input type="email" name="email" id="email" required autocomplete="email"  value="{{ $email ?? old('email') }}" autofocus class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                    <label for="email">Benutzername (E-Mail-Adresse)</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password" id="password" value="" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                        @enderror
                                        <label for="password">Passwort</label>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" name="password_confirmation" id="password-confirm" value="" required autocomplete="new-password" class="form-control @error('password') is-invalid @enderror">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                            @enderror
                                            <label for="password">{{ __('Passwort bestätigen') }}</label>
                                        </div>
                                    </div>
                                </div>

                            <div class="row mt-3 pt-3 border-top">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <button type="submit" class="d-block w-100 btn btn-primary text-white">Neues Passwort erstellen</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


