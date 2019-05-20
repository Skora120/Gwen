@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">XDDDDDDDDDDD</div>
                    <div class="card-body">
                        @foreach ($submissions as $submission)
                            <p><a href="{{$submission->path}}">{{ $submission->task->name }}</a></p>
                        @endforeach
                    </div>

                    {{ $submissions->links() }}

                </div>
            </div>
        </div>
    </div>
@endsection
