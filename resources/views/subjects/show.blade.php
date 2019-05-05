@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$subject->name}}</div>
                    <div class="card-body">
                        <p>
                            {{$subject->description}}
                        </p>
                    </div>
                </div>
                <hr>

                <div class="card">
                    <div class="card-header">Subject Groups</div>
                    <div class="card-body">
                        @forelse($userGroups as $key => $group)
                            {{--<pre>{{print_r($group)}}</pre>--}}
                            <p><a href="{{url()->current() . '/' . $group->id}}">{{$group->name? $group->name: 'Grupa: ' . ($key + 1)}}</a></p>
                        @empty
                            <p>Nie ma żadnych grup zajęciowych</p>
                        @endforelse
                        <p>

                        </p>
                    </div>
                </div>
                <hr>


                <div class="card">
                    <div class="card-body">
                        <form action="{{$subject->path()}}" method="POST">
                            {{method_field('PATCH')}}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" value="{{$subject->name}}">
                            </div>
                            <div class="form-group">
                                <textarea name="description" class="form-control">{{$subject->description}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="card">
                    <div class="card-header">Create subject group</div>
                    <div class="card-body">
                        <form action="{{$subject->path()}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Group Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

                {{--@forelse( as $subject)--}}
                    {{--<div class="card-body">--}}
                        {{--<p>--}}
                        {{--<pre>{{$subject->group->subject}}</pre>--}}
                        {{--</p>--}}
                        {{--<p>--}}
                            {{--<a href="{{$subject->group->subject->path()}}"> {{$subject->group->subject->name}}</a>--}}
                        {{--</p>--}}
                        {{--<hr>--}}
                    {{--</div>--}}
                {{--@empty--}}
                    {{--<p> Nie należysz do żadnej grupy</p>--}}
                {{--@endforelse--}}

            </div>
        </div>


    </div>
@endsection
