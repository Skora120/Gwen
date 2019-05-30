@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statystyki</h6>
                </div>
                <div class="card-body text-center">
                    @if(!empty($subjects[0]))
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nazwa przedmiotu</th>
                                <th scope="col">Liczba grup</th>
                                <th scope="col">Strona przedmiotu</th>
                                <th scope="col">Statystyki przedmiotu</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $key => $subject)
                                <tr>
                                    <th scope="row">{{$key+1 + ($subjects->perPage() * ($subjects->currentPage() - 1))}}</th>
                                    <td>{{$subject->name}}</td>
                                    <td>{{$subject->subject_groups_count}}</td>
                                    <td><a href="{{$subject->path}}">Przejdz do przedmiotu</a></td>
                                    <td><a href="{{url()->current()}}/subjects/{{$subject->slug}}">Statystyki przedmiotu</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="mx-auto pt-3">
                            {{$subjects->links()}}
                        </div>
                    @else
                        <p>Nie posiadasz żadnych przedmiotów.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
