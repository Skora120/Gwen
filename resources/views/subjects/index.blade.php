@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @forelse($subjects as $subject)
                        <div class="card-header"><a href="{{$subject->path()}}">{{$subject->name}}</a></div>
                        <div class="card-body">
                            <p>
                                {{$subject->description}}
                            </p>
                        </div>
                    @empty
                        <p> Nie masz żadnych przedmiotów</p>
                    @endforelse


                        @forelse(auth()->user()->subjects as $subject)
                            <div class="card-body">
                                <p>
                                    <pre>{{$subject->group->subject}}</pre>
                                </p>
                                <p>
                                <a href="{{$subject->group->subject->path()}}"> {{$subject->group->subject->name}}</a>
                                </p>
                                <hr>
                            </div>
                        @empty
                            <p> Nie masz żadnych przedmiotów</p>
                        @endforelse

                        <div class="card">
                            <div class="card-header">Create subject</div>
                            <div class="card-body">
                                <form action="{{url()->current()}}" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="name">Subject name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
