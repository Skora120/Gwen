@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Zadania</div>
                    <div class="card-body">
                        @forelse($tasks as $task)
                            <div>
                                <p>Nazwa: <a href="{{$task->path}}">{{$task->name}}</a></p>
                                <p>Opis: {{substr($task->description,0,140)}}{{strlen($task->description) > 140 ? '...' : ''}}</p>
                            </div>
                            <hr>
                        @empty
                            <p>Nie ma żadnych zadań</p>
                        @endforelse

                        {{ $tasks->links() }}

                    </div>
                </div>
                <hr>
            </div>
        </div>


    </div>
@endsection
