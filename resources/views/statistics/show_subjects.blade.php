@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Statistics</div>
                    <div class="card-body">
                        @forelse($groups as $group)
                            <p><a href="{{ url()->current() }}/{{$group->id}}">{{$group->name}}</a> | {{$group->users_count}}</p>
                        @empty
                            XD
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
