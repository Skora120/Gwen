@extends('layouts.app')

@section('content')

    @if(auth()->user()->isLecturer())
    <div class="row">
        <div class="col-xl-10 col-lg-10 offset-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Przdmioty</h6>
                </div>
                <div class="col-10 col-lg-10 offset-1 text-center mt-2">
                @forelse($subjects as $subject)
                    <div class="card-header"><a href="{{$subject->path}}">{{$subject->name}}</a></div>
                    <div class="card-body">
                        <p>
                            {{$subject->description}}
                        </p>
                    </div>
                @empty
                    <p> Nie masz żadnych przedmiotów</p>
                @endforelse
                   <div class="btn-group btn-group-justified">
                       {{$subjects->links()}}
                   </div>

                    <hr>

                    <div class="card shadow mb-4 mt-5">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Dodaj przedmiot</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{url()->current()}}" method="POST">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="name">Nazwa przedmiotu</label>
                                    <input type="text" class="form-control" name="name">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description">Opis przedmiotu</label>
                                    <textarea rows="7" name="description" class="form-control"></textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-6 offset-3">
                                    <button type="submit" class="btn btn-block btn-primary">Zatwierdź</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else

        <div class="row">
            <div class="col-xl-10 col-lg-10 offset-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Przdmioty</h6>
                    </div>
                    <div class="col-10 col-lg-10 offset-1 text-center mt-2">
                        @forelse($subjects as $subject_user)
                            <div class="card-header"><a href="{{$subject_user->group->subject->path}}">{{$subject_user->group->subject->name}}</a></div>
                            <div class="card-body">
                                <p>
                                    {{$subject_user->group->subject->description}}
                                </p>
                            </div>
                        @empty
                            <p> Nie masz żadnych przedmiotów</p>
                        @endforelse
                        <div class="btn-group btn-group-justified">
                            {{$subjects->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
