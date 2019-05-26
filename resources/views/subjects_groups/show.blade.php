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
                                </div>
                                <div class="form-group">
                                    <label for="description">Opis</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">Czas rozpoczęcia</label>
                                    <input type="text" class="form-control" name="startDate">
                                </div>
                                <div class="form-group">
                                    <label for="description">Czas zakończenia</label>
                                    <input type="text" class="form-control" name="deadline">
                                </div>
                                <div class="form-group">
                                    <label for="max_mark">Maksymalna ocena</label>
                                    <input type="number" class="form-control" name="max_mark">
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
                        <h6 class="m-0 font-weight-bold text-primary">Informacje</h6>
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
                                    @if(!auth()->user()->isStudent() and $value->user->student_id != null)
                                        <small>id studenta:{{$value->user->student_id}}</small>
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
@endsection
