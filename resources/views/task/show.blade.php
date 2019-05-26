@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{$task->name}}</h6>
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

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Odpowiedzi na zadania</h6>
                    </div>
                    <div class="card-body">
                        @if(!auth()->user()->isStudent())
                            <form action="{{$task->path}}" method="POST">
                                {{method_field('PATCH')}}
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="name">Nazwa</label>
                                    <input type="text" class="form-control" name="name" value="{{$task->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Opis</label>
                                    <textarea name="description" class="form-control" rows="6">{{$task->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="startDate">Czas rozpoczęcia</label>
                                    <input type="text" class="form-control" name="startDate" value="{{$task->startDate}}">
                                </div>
                                <div class="form-group">
                                    <label for="deadline">Czas zakończenia</label>
                                    <input type="text" class="form-control" name="deadline" value="{{$task->deadline}}">
                                </div>
                                <div class="form-group">
                                    <label for="max_mark">Maksymalna Ocena</label>
                                    <input type="number" class="form-control" name="max_mark" value="{{$task->max_mark}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        @else
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
                        @endif
                    </div>
                </div>
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
@endsection
