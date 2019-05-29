@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{$subject->name}}

                            @if(auth()->user()->isAdmin() || (auth()->user()->isLecturer() && empty($userGroups[0])))
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteModal">
                                Usuń
                            </button>
                            @endif

                            @if(auth()->user()->isAdmin() || (auth()->user()->isLecturer() && !empty($userGroups[0])))
                                <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary float-right mr-1" data-toggle="modal" data-target=".bd-example-modal-lg">
                                        Dodaj zadanie
                                    </button>
                                @endif

                        </h6>
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
                        <h6 class="m-0 font-weight-bold text-primary">Utwórz grupę</h6>
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


    <!-- Large modal add task to multiple groups -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tworzenie jednego zadania dla wielu grup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mt-3">
                    <div class="col-10 offset-1">
                        <form class="text-center" action="{{$subject->path}}/task" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Nazwa zadania</label>
                                <input type="text" class="form-control" name="name">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">Opis</label>
                                <textarea class="form-control" name="description"></textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">Czas rozpoczęcia</label>
                                <input type="text" class="form-control" name="startDate" placeholder="YYYY-MM-DD HH:MM:SS">
                                @if ($errors->has('startDate'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('startDate') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">Czas zakończenia</label>
                                <input type="text" class="form-control" name="deadline" placeholder="YYYY-MM-DD HH:MM:SS">
                                @if ($errors->has('deadline'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('deadline') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="max_mark">Maksymalna ocena</label>
                                <input type="number" class="form-control" name="max_mark">
                                @if ($errors->has('max_mark'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('max_mark') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="max_mark">Wybierz grupy:</label>
                                <hr>
                                @foreach($userGroups as $key => $group)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$group->id}}" name="groups[]">
                                    <label class="form-check-label" for="defaultCheck1">
                                        #{{$key + 1}} - {{$group->name ? $group->name : ' bez nazwy'}}
                                    </label>
                                </div>
                                @endforeach
                                @if ($errors->has('groups'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('groups') }}</strong>
                                        </span>
                                @endif

                                <hr>
                            </div>

                            <button type="submit" class="btn btn-primary">Utworz zadanie</button>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center mt-3">
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Czy aby na pewno chcesz usunąć '{{ $subject->name }}'?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <button type="button" class="btn btn-danger"  onclick="event.preventDefault();
                                                         document.getElementById('delete-subject').submit();">Usuń</button>
                </div>
            </div>
        </div>
    </div>
    <form id="delete-subject" action="{{$subject->path}}" method="POST" style="display: none;">
        @method('DELETE')
        @csrf
    </form>

@endsection
