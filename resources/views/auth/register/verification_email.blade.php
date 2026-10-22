@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row justify-content-left align-items-center vh-100">
            <div class="col-md-6 col-lg-6">
                <div class="bg-white shadow p-5 p-md-5">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-5">
                                    <h1 class="h4 mb-3">Registrierung</h1>
                                    <p>
                                       Ihr Benutzerkonto wurde erfolgreich angelegt, Ihr Konto wird in Kürze von uns freigegeben.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <section>
                                        <div class="accordion" id="accordionExample">
                                            <div class="steps">
                                                <progress id="progress" value=100 max=100 ></progress>
                                                <div class="step-item">
                                                    <button class="step-button text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        1
                                                    </button>
                                                </div>
                                                <div class="step-item">
                                                    <button class="step-button text-center collapsed done" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        2
                                                    </button>
                                                </div>
                                                <div class="step-item">
                                                    <button class="step-button text-center collapsed done" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        3
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                </section>
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


@endsection
