@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8 col-lg-8 offset-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Panel Administratora</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Imię i nazwisko</th>
                                <th>ID studenta</th>
                                <th>Rodzaj konta</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($users as $key => $user)
                                <tr>
                                    <th scope="row">{{$key+1 + ($users->perPage() * ($users->currentPage() - 1))}}</th>
                                    <td><a href="{{ url()->current() }}/{{$user->id}}">{{ $user->last_name }} {{$user->first_name}}</a></td>
                                    <td><small>{{$user->student_id ? $user->student_id : 'Nie podano'}}</small></td>
                                    <td>
                                        @switch($user->type)
                                            @case(1)
                                            <span>Prowadzący</span>
                                            @break

                                            @case(2)
                                            <span>Administrator</span>
                                            @break

                                            @default
                                            <span>Student</span>
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mx-auto pt-3">
                            {{ $users->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
