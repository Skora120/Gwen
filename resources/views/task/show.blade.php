@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$task->name}}</div>
                    <div class="card-body">
                        <p>
                            {{$task->description}}
                        </p>
                        <p>
                            {{$task->startDate}}
                        </p>
                        <p>
                            {{$task->max_mark}}
                        </p>
                        <p>
                            {{$task->deadline}}
                        </p>
                    </div>
                </div>

                <hr>
                <div class="card">
                    <div class="card-header">Your Submissions</div>
                    <div class="card-body">
                        @forelse($submissions as $userSubmissions)
                            <div>
                            <p>{{$userSubmissions[0]->user->name}}</p>
                            @forelse($userSubmissions as $key => $submission)

                                <p>{{$submission->created_at->diffForHumans()}} <a href="{{url()->current()}}/submissions/{{$submission->id}}">{{$submission->s_comment}}</a></p>

                            @empty
                            </div>
                            <hr>
                            @endforelse
                        @empty
                            <div>
                                <p>You don't have any submissions for this task</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <hr>
                <div class="card">
                    <div class="card-header">Update Task</div>
                    <div class="card-body">
                        <form action="{{$task->path()}}" method="POST">
                            {{method_field('PATCH')}}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" value="{{$task->name}}">
                            </div>
                            <div class="form-group">
                                <textarea name="description" class="form-control">{{$task->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="startDate">Start Time</label>
                                <input type="text" class="form-control" name="startDate" value="{{$task->startDate}}">
                            </div>
                            <div class="form-group">
                                <label for="deadline">End Time</label>
                                <input type="text" class="form-control" name="deadline" value="{{$task->deadline}}">
                            </div>
                            <div class="form-group">
                                <label for="max_mark">Max Mark</label>
                                <input type="number" class="form-control" name="max_mark">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                        <pre>{{$errors}}</pre>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">Submission Form</div>
                    <div class="card-body">
                        <form action="{{$task->path()}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="s_comment">Additional Comment</label>
                                <textarea name="s_comment" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="file">File input</label>
                                <input type="file" class="form-control-file" name="file">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                        <pre>{{$errors}}</pre>
                    </div>
                </div>

                <hr>
            </div>
        </div>


    </div>
@endsection
