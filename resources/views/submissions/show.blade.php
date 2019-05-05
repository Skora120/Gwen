@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$submission->task->name}}</div>
                    <div class="card-body">
                            <p>
                                {{$submission->s_comment}}
                            </p>
                            <p>
                                {{$submission->r_comment}}
                            </p>
                            <p>
                                {{$submission->mark}}
                            </p>
                            <p>
                                {{$submission->file}}
                            </p>
                            <p>
                                @if ($submission->file_extension != 'zip')
                                    <iframe src="{{$submission->path()}}/download" type="application/pdf">
                                        <span>Your browser does not support iframes.</span>
                                    </iframe>
                                @else
                                    <p><a href="{{$submission->path()}}/download">Download Zip file</a></p>
                                @endif
                            </p>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection
