@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">XDDDDDDDDDDD</div>
                    <div class="card-body">
                        @foreach ($users as $user)
                            <p><a href="{{ url()->current() }}/{{$user->id}}">{{ $user->name }}</a></p>
                        @endforeach
                    </div>

                    {{ $users->links() }}

                </div>
            </div>
        </div>
    </div>
@endsection
