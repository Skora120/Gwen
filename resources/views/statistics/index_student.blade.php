@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Statistics</div>
                    <div class="card-body">
                        @forelse($submissions as $submission)
                            <p><a href="{{$submission[0]->task->group->subject->path}}">{{ $submission[0]->task->group->subject->name }}</a> <a href="{{$submission[0]->task->path}}">{{$submission[0]->task->name}}</a>
                                {{ round($submission[0]->mark / $submission[0]->task->max_mark, 2) * 100 . '%'}}</p>
                        @empty

                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
