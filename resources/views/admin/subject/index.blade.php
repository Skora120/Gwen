@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-xl-8 col-lg-8 offset-lg-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Panel Administratora</h6>
                </div>
                <div class="card-body text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Przedmioty</th>
                            <th scope="col">Imie i nazwisko prowadzacego</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($subjects as $key => $subject)
                            <tr>
                                <th scope="row">{{$key+1 + ($subjects->perPage() * ($subjects->currentPage() - 1))}}</th>
                                <td><a href="{{$subject->path}}">{{$subject->name}}</a></td>
                                <td><a href="/admin/users/{{$subject->user->id}}">{{$subject->user->name}}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mx-auto pt-3">
                        {{ $subjects->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection