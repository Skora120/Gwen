@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @forelse($subjects as $subject)
                        <div class="card-header"><a href="{{$subject->path()}}">{{$subject->name}}</a></div>
                        <div class="card-body">
                            <p>
                                {{$subject->description}}
                            </p>
                        </div>
                    @empty
                        <p> Nie masz żadnych przedmiotów</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
@endsection
