@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
            <div class="card">
                <div class="card-header">Joint to group</div>
                <div class="card-body">
                    <form action="{{route('subject-join')}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="code">Group Code</label>
                            <input type="text" class="form-control" name="code">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
