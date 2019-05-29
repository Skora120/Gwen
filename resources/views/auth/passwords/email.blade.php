@extends('layouts.app_guest')

@section('content')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Zapomniałeś hasła?</h1>
                                    <p class="mb-4">Nic się nie stało!. Podaj swój adres email, a zostanie na niego wysłany link do zresetowania hasła!</p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                       {{ session('status') }}
                                    </div>
                                @endif

                                <form class="user" method="POST" action="{{ route('password.email') }}">
                                @csrf

                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-user" name="email" value="{{ old('email') }}" required placeholder="Wprowadź adres email...">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                             </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Zresetuj hasło
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="/register">Utwórz konto!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="/login">Masz już konto? Zaloguj się!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
