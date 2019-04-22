@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <p>{{$group->name}}</p>

                    <p>{{$group->code}}</p>

                </div>

            </div>
        </div>
    </div>
@endsection
