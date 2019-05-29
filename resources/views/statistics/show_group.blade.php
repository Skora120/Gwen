@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Statistics</div>
                    <div class="card-body">
                        <pre>{{print_r($tasksCount)}}</pre>
                        <pre>{{print_r($tasks)}}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
