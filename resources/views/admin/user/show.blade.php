@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">XDDDDDDDDDDD</div>
                    <div class="card-body">
                        <pre>{{$user->get()}}</pre>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">XDDDDDDDDDDD</div>
                    <div class="card-body">
                        <form action="{{ url()->current() }}" method="POST">
                            {{method_field('PATCH')}}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="first_name">First name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="{{ $user->first_name  }}">
                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last name</label>
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
                            <button type="submit" class="btn btn-primary">Submit</button>

                            <pre>{{ printf($errors) }}</pre>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
