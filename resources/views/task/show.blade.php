@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{$task->name}}
                        @if(auth()->user()->isAdmin() || (auth()->user()->isLecturer() && empty($submissions[0])))
                            <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteModal">
                                    Usuń zadanie
                                </button>
                            @endif

                        </h6>
                    </div>
                    <div class="card-body">
                        <p>
                            Opis: {{$task->description}}
                        </p>
                        <p>
                            Czas rozpoczęcia: {{$task->startDate}}
                        </p>
                        <p>
                            Czas zakończenia: {{$task->deadline}}
                        </p>
                        <p>
                            Maksymalna Ocena: {{$task->max_mark}}
                        </p>
                    </div>
                </div>

                @if(!auth()->user()->isStudent())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edytuj zadanie</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{$task->path}}" method="POST">
                            {{method_field('PATCH')}}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Nazwa</label>
                                <input type="text" class="form-control" name="name" value="{{$task->name}}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">Opis</label>
                                <textarea name="description" class="form-control" rows="6">{{$task->description}}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="startDate">Czas rozpoczęcia</label>
                                <input type="text" class="form-control" name="startDate" value="{{$task->startDate}}">
                                @if ($errors->has('startDate'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $errors->first('startDate') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="deadline">Czas zakończenia</label>
                                <input type="text" class="form-control" name="deadline" value="{{$task->deadline}}">
                                @if ($errors->has('deadline'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $errors->first('deadline') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="max_mark">Maksymalna Ocena</label>
                                <input type="number" class="form-control" name="max_mark" value="{{$task->max_mark}}">
                                @if ($errors->has('max_mark'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $errors->first('max_mark') }}</strong>
                                </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

                @else
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Dodaj odpowiedź na zadanie</h6>
                    </div>
                    <div class="card-body">
                        @if($task->startDate < date(now()) && $task->deadline > date(now()))
                        <form action="{{$task->path()}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="s_comment">Dodatkowy komentarz</label>
                                <textarea name="s_comment" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="file">Załącznik <small>(pdf,zip,cpp)</small></label>
                                <input type="file" class="form-control-file" name="file">
                            </div>
                            <button type="submit" class="btn btn-primary">Wyślij</button>
                        </form>
                        @else
                            <p>Do tego zadanie nie można dodać odpowiedzi, ponieważ zadanie się nie rozpoczeło / zakończyło się.</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <div class="col-12 col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Odpowiedzi na zadania</h6>
                    </div>
                    <div class="card-body">
                        @forelse($submissions as $userSubmissions)
                            <div>
                                <p>{{$userSubmissions->user->name}} <small>{{$userSubmissions->created_at->diffForHumans()}}</small></p>
                                <p>{{$userSubmissions->s_comment}}</p>
                                <p>Ocena: {{$userSubmissions->mark? $userSubmissions->mark: 'Brak'}}</p>
                                <a href="{{url()->current()}}/submissions/{{$userSubmissions->id}}">Przejdź do odpowiedzi</a>

                            </div>
                            <hr>
                        @empty
                            <div>
                                <p>Aktualnie nie ma odpowiedzi na to zadanie</p>
                            </div>
                        @endforelse

                        {{$submissions->links()}}
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
                    Czy aby na pewno chcesz usunąć zadanie '{{ $task->name }}'?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <button type="button" class="btn btn-danger"  onclick="event.preventDefault();
                                                         document.getElementById('delete-subject').submit();">Usuń</button>
                </div>
            </div>
        </div>
    </div>
    <form id="delete-subject" action="{{$task->path}}" method="POST" style="display: none;">
        @method('DELETE')
        @csrf
    </form>

@endsection
