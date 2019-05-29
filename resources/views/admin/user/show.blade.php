@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edytuj użytkownika</h6>
                </div>
                <div class="card-body">
                    <form action="{{ url()->current() }}" method="POST">
                        {{method_field('PATCH')}}
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="first_name">Imie</label>
                            <input type="text" class="form-control" name="first_name" placeholder="{{ $user->first_name  }}">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="last_name">Nazwisko</label>
                            <input type="text" class="form-control" name="last_name" placeholder="{{ $user->last_name }}">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Adres email</label>
                            <input type="email" class="form-control" name="email" placeholder="{{ $user->email }}">

                        </div>
                        <div class="form-group">
                            <label for="email_confirmation">Potwierdź adres email</label>
                            <input type="email" class="form-control" name="email_confirmation" placeholder="">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Hasło</label>
                            <input type="password" class="form-control" name="password" autocomplete="new-password">

                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Potwierdzenie hasła</label>
                            <input type="password" class="form-control" name="password_confirmation">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                            @endif
                        </div>
                        @if ($user->isStudent())
                            <div class="form-group">
                                <label for="student_id">Identyfikator studenta</label>
                                <input type="text" class="form-control" name="student_id" placeholder="{{ $user->student_id }}">
                                @if ($errors->has('student_id'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $errors->first('student_id') }}</strong>
                                        </span>
                                @endif
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="user_type">Rodzaj użytkownika</label>
                            <select class="form-control" name="type">
                                <option value="0" {{ $user->type == 0 ? 'selected' : '' }}>Student</option>
                                <option value="1" {{ $user->type == 1 ? 'selected' : '' }}>Prowadzący</option>
                                <option value="2" {{ $user->type == 2 ? 'selected' : '' }}>Administrator</option>
                            </select>

                        </div>
                        <button type="submit" class="btn btn-primary">Zatwierdź</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($user->isStudent())
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Odpowiedzi na zadania</h6>
                </div>
                <div class="card-body">
                    @forelse($submissions as $submission)
                        <p><a href="{{$submission->task->group->subject->path}}">{{ $submission->task->group->subject->name }}</a></p>
                        <p><a href="{{$submission->task->path}}">{{$submission->task->name}}</a></p>
                        <hr>
                    @empty
                        <p>Nie posiada żadnych odpowiedzi na zadania.</p>
                    @endforelse

                    <div class="mx-auto pt-3">
                        {{$submissions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
