@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row justify-content-left align-items-center vh-100">
            <div class="col-md-6 col-lg-6">
                <div class="bg-white shadow p-5 p-md-5">
                    <div class="">
                        <div class="mb-5">
                            <h1 class="h4 mb-3">{{ __('Verify Your Email Address') }}</h1>
                            <div class="row">
                                <div class="col-12">
                                    @if (session('resent'))
                                        <div class="alert alert-success" role="alert">
                                            {{ __('A fresh verification link has been sent to your email address.') }}
                                        </div>
                                    @endif

                                    <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                                </div>
                                <div class="col-12 mt-3">
                                    <a href="{{ route('login') }}" class="btn btn-primary text-white" type="button">
                                        Zum Login
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
