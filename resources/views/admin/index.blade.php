@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Panel Administratora</h6>
                    </div>
                    <div class="card-body text-center">
                        <p><a href="{{url()->current()}}/users">Uzytkownicy</a></p>
                        <p><a href="{{url()->current()}}/subjects">Przedmioty</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
