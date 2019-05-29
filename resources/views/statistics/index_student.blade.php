@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Oceny z poszczególnych zdań</h6>
                    </div>
                    <div class="card-body text-center">
                        @forelse($submissions as $submission)
                            <p><a href="{{$submission->task->group->subject->path}}">{{ $submission->task->group->subject->name }}</a></p>
                            <p><a href="{{$submission->task->path}}">{{$submission->task->name}}</a>
                                {{$submission->mark ? $submission->mark : ' Brak'}}/{{$submission->task->max_mark}} - {{ round($submission->mark / $submission->task->max_mark, 2) * 100 . '%'}}</p>
                            <hr>
                        @empty
                            <p>Nie masz żadnych ocen.</p>
                        @endforelse

                        <div class="mx-auto pt-3">
                            {{$submissions->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
