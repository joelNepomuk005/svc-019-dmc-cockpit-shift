@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row justify-content-left align-items-center vh-100">
            <div class="col-md-6 col-lg-6">
                <div class="bg-white shadow p-5 p-md-5">
                    <div class="">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-5">
                                        <h1 class="h4 mb-3">Passwort zurücksetzen</h1>
                                        <p>
                                            Bitte geben Sie Ihre E-mail Adresse ein, um Ihr Passwort zurückzusetzten.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" id="email" value="{{old('email')}}" required autocomplete="email" autofocus class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                    @enderror
                                    <label for="email">E-Mail-Adresse</label>
                                </div>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    Eine E-mail zum generieren Ihres neues Passwort wurde an Ihre E-mail Adresse verschickt.
                                </div>
                            @endif
                            <div class="row mt-3 pt-3 border-top">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <a href="{{ route('login') }}" class="d-block w-100 btn btn-secondary text-white">Zurück zum Login</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <button type="submit" class="d-block w-100 btn btn-primary text-white">Passwort zurücksetzen</button>
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

