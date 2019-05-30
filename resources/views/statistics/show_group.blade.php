@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statystyki - Oceny z zadań</h6>
                </div>
                <div class="card-body text-center">
                    <p>Ta grupa posiada: {{$tasksCount}} zadania.</p>
                    @forelse($tasks as $task)
                        <hr class="pt-5">
                        <p><a href="{{$task->path}}">Zadanie: {{$task->name}}</a>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Wysyłający</th>
                                <th scope="col">Ocena</th>
                                <th scope="col">Maksymalna ocena</th>
                                <th scope="col">% oceny</th>
                                <th scope="col">Link do zadania</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($task->submissions as $key => $submission)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$submission->user->name}}</td>
                                    <td>{{$submission->mark ? $submission->mark : "Brak"}}</td>
                                    <td>{{$task->max_mark}}</td>
                                    <td>{{ round($submission->mark / $task->max_mark, 2) * 100 . '%'}}</td>
                                    <td><a href="{{$submission->path}}">Przejdz do zadania</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @empty
                        <p>Ta grupa nie za żadnych zadań.</p>
                    @endforelse

                    <div class="mx-auto pt-3">
                        {{$tasks->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
