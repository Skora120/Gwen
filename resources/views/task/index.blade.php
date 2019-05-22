@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Tasks</div>
                    <div class="card-body">
                        @forelse($tasks as $task)
                            <div>
                                <p>Name: <a href="{{$task->path}}">{{$task->name}}</a></p>
                                <p>Description: {{$task->description}}</p>
                            </div>
                            <hr>
                        @empty
                            <p>There aren't any tasks</p>
                        @endforelse

                        {{ $tasks->links() }}

                    </div>
                </div>
                <hr>
            </div>
        </div>


    </div>
@endsection
