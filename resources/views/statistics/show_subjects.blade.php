@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Statystyki</h6>
                    </div>
                    <div class="card-body text-center">
                        @if($groups)
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nazwa grupy</th>
                                <th scope="col">Liczba osób</th>
                                <th scope="col">Liczba zadań</th>
                                <th scope="col">Link do grupy</th>
                            </tr>
                            </thead>
                            <tbody>
                              @foreach($groups as $key => $group)
                                <tr>
                                    <th scope="row">{{$key+1 + ($groups->perPage() * ($groups->currentPage() - 1))}}</th>
                                    <td>{{$group->name ? $group->name : "Brak"}}</td>
                                    <td>{{$group->users_count}}</td>
                                    <td>{{$group->tasks_count}}</td>
                                    <td><a href="{{$group->path}}">Przejdz do grupy</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                            <div class="mx-auto pt-3">
                                {{$groups->links()}}
                            </div>
                        @else
                            <p>Ten przedmiot nie posiada żadnej grupy.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>















@endsection
