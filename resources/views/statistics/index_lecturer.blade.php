@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Statistics</div>
                    <div class="card-body">
                        @forelse($subjects as $subject)
                            <p><a href="/statistics/subjects/{{$subject->slug}}">{{$subject->name}}</a></p>
                        @empty
                            XD
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
