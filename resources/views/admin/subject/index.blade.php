@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">XDDDDDDDDDDD</div>
                    <div class="card-body">
                        @foreach ($subjects as $subject)
                            <p><a href="{{$subject->path}}">{{ $subject->name }}</a></p>
                        @endforeach
                    </div>

                    {{ $subjects->links() }}

                </div>
            </div>
        </div>
    </div>
@endsection
