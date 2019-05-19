@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                        <div class="card-header">XDDDDDDDDDDD</div>
                        <div class="card-body">
                            <p><a href="{{url()->current()}}/users">Users</a></p>
                            <p><a href="{{url()->current()}}/subjects">Subjects</a></p>
                        </div>

                    <pre>{{$subjects->get()}}</pre>
                    <pre>{{$users->get()}}</pre>

                </div>
            </div>
        </div>
    </div>
@endsection
