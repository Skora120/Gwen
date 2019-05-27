@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{$subject->name}}</h6>
                    </div>
                    <div class="card-body text-center pb-5">
                        <p>{{$subject->description}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Area Chart -->
            <div class="col-12 col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Grupy zajęciowe</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($userGroups as $key => $group)
                                <li class="list-group-item display-4"><p><a href="{{$group->path()}}">#{{$key + 1}}  {{$group->name? $group->name: 'Grupa: ' . ($key + 1)}}</a></p></li>

                            @empty
                                <li class="list-group-item display-4"><small></small><p>Ten przedmiot nie ma żadnych grup zajęciowych</p></li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mx-auto">
                       @if(isset($userGroups[0]->perPage))
                        {{$userGroups->links()}}
                        @endif
                    </div>
                </div>
            </div>
            @if(auth()->user()->isLecturer())
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Utwórz do grupy</h6>
                    </div>
                    <div class="card-body col-10 offset-1">
                        <form action="{{$subject->path()}}" method="POST" class="text-center">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Nazwa grupy<small>(opcjonalne)</small></label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <button type="submit" class="btn btn-primary">Utwórz</button>
                        </form>
                    </div>
                </div>
            </div>


                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edytuj przedmiot</h6>
                        </div>
                        <div class="card-body col-10 offset-1">
                            <form class="text-center" action="{{$subject->path()}}" method="POST">
                                {{method_field('PATCH')}}
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="name">Nazwa przedmiotu</label>
                                    <input type="text" class="form-control" name="name" value="{{$subject->name}}">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">Opisu</label>
                                    <textarea name="description" class="form-control">{{$subject->description}}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">Zapisz</button>
                            </form>
                        </div>
                    </div>
                </div>


            @endif
        </div>
    </div>
@endsection
