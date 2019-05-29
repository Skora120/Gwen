@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Zadania</h6>
                    </div>
                    <div class="card-body">
                        @forelse($tasks as $value)
                            <div>
                                <p>Nazwa: <a href="{{$value->path}}">{{$value->name}}</a></p>
                                <p>Opis: {{$value->description}}</p>
                            </div>
                            <hr>
                        @empty
                            <p>Aktualnie nie ma żadnych zdań!</p>
                        @endforelse

                        {{$tasks->links()}}
                    </div>
                </div>

                @if(!auth()->user()->isStudent())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Utwórz zadanie</h6>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <form class="text-center" action="{{$group->path}}" method="POST">
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

                                <button type="submit" class="btn btn-primary">Dodaj</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-12 col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informacje
                        @if(auth()->user()->isAdmin() || (auth()->user()->isLecturer() && empty($users[0])))
                            <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteModal">
                                    Usuń grupę
                                </button>
                        @endif


                        </h6>
                    </div>
                    <div class="card-body">
                        <p>{{$group->name}}</p>
                        <p>Kod dostępu: {{$group->code}}</p>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Użytownicy</h6>
                    </div>
                    <div class="card-body">

                        <ul class="list-group list-group-flush">
                            @forelse($users as $key => $value)
                                <li class="list-group-item"><p>{{$value->user->name}}</p>
                                    @if(!auth()->user()->isStudent())
                                        <small>Id studenta: {{$value->user->student_id ? $value->user->student_id : 'nie podano'}}</small>
                                    @endif
                                    </li>
                            @empty
                                <li class="list-group-item"><p>Grupa nie posiada użytkowników!</p></li>
                            @endforelse
                        </ul>
                        <div class="mx-auto pt-3">
                            {{$users->links()}}
                        </div>
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
                    Czy aby na pewno chcesz usunąć grupę '{{ $group->name }}'?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <button type="button" class="btn btn-danger"  onclick="event.preventDefault();
                                                         document.getElementById('delete-subject').submit();">Usuń</button>
                </div>
            </div>
        </div>
    </div>
    <form id="delete-subject" action="{{$group->path}}" method="POST" style="display: none;">
        @method('DELETE')
        @csrf
    </form>



@endsection
