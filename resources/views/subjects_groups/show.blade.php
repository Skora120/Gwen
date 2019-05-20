@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <p>{{$group->name}}</p>

                    <p>{{$group->code}}</p>

                </div>

                <hr>
                <div class="card">
                    <div class="card-header">Tasks</div>
                    <div class="card-body">
                        @forelse($group->tasks as $value)
                            <div>
                                <p>Name: <a href="{{$value->path()}}">{{$value->name}}</a></p>
                                <p>Description: {{$value->description}}</p>
                            </div>
                            <hr>
                            @empty
                                <p>There aren't any tasks</p>
                        @endforelse


                    </div>

                </div>

                <hr>
                <div class="card">
                    <div class="card-header">Create Task</div>
                    <div class="card-body">
                        <form action="{{$group->path()}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Task Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Start Time</label>
                                <input type="text" class="form-control" name="startDate">
                            </div>
                            <div class="form-group">
                                <label for="description">End Time</label>
                                <input type="text" class="form-control" name="deadline">
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
            </div>
        </div>
    </div>
@endsection
