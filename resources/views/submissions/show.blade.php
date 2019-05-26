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
                            Ocena: {{$submission->mark}}
                        </p>
                        <p>
                            Załącznik: <a href="{{$submission->path()}}/download">plik</a>
                        </p>
                        <div>
                            <p>Podgląd</p>
                            @if ($submission->file_extension != 'zip')
                                <iframe src="{{$submission->path()}}/download" type="application/pdf">
                                    <span>Your browser does not support iframes.</span>
                                </iframe>
                            @else
                                <p><a href="{{$submission->path()}}/download">Download Zip file</a></p>
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
@endsection
