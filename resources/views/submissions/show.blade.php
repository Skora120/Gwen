@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-xl-8 col-lg-8 offset-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Odpowiedź {{auth()->user()->name}} na zadanie
                            {{$submission->task->name}}</h6>
                    </div>
                    <div class="card-body text-center">
                        <p>
                            Komentarz wysyłającego: {{$submission->s_comment}}
                        </p>
                        <p>
                            Komentarz oceniającego: {{$submission->r_comment}}
                        </p>
                        <p>
                            Ocena: {{$submission->mark ? $submission->mark : ' Brak'}}
                        </p>
                        <p>
                            Załącznik: <a href="{{$submission->path()}}/download">Pobierz</a>
                        </p>
                        <div>
                            @if ($submission->file_extension != 'zip')
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Podgląd</button>
                            @else
                                <p><a href="{{$submission->path()}}/preview">Pobierz plik zip</a></p>
                            @endif

                            @if(auth()->user()->isAdmin())
                            <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                                    Usuń
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if(!auth()->user()->isStudent())
        <div class="col-12 col-xl-8 col-lg-8 offset-lg-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Oceń zadanie</h6>
                </div>
                <div class="card-body text-center">
                    <form action="{{url()->current()}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{method_field('PATCH')}}
                        <div class="form-group">
                            <label for="r_comment">Dodatkowy komentarz</label>
                            <textarea name="r_comment" class="form-control"></textarea>
                            @if ($errors->has('r_comment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('r_comment') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="mark">Ocena</label>
                            <input type="number" name="mark" class="form-control">
                            @if ($errors->has('number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('number') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Oceń</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Large modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @if($submission->extension == 'zip')
                    <iframe src="{{$submission->path()}}/preview" type="application/pdf" width="100%" style="height: 75vh;">
                        <span>Your browser does not support iframes.</span>
                    </iframe>
                    @endif
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{$submission->path()}}/download"><button type="button" class="btn btn-secondary" onclick="download()">Pobierz</button></a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Zamknij</button>
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
                    Czy aby na pewno chcesz usunąć odpowiedź na zadanie użytkownika '{{ $submission->user->name }}'?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <button type="button" class="btn btn-danger"  onclick="event.preventDefault();
                                                         document.getElementById('delete-subject').submit();">Usuń</button>
                </div>
            </div>
        </div>
    </div>
    <form id="delete-subject" action="{{$submission->path}}" method="POST" style="display: none;">
        @method('DELETE')
        @csrf
    </form>

@endsection
