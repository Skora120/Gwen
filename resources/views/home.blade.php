@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ostatnie zadania</h6>
                </div>
                @if(empty($w_tasks))
                    <div class="card-body text-center">
                        <h5 class="card-title">Nie posiadasz zadnych zadań</h5>
                    </div>
                @endif

                @for ($i = 0; $i < 2; $i++)
                    @if(!empty($w_tasks[$i]))
                        <div class="card-body text-center">
                            <h5 class="card-title">{{$w_tasks[$i]->name}}</h5>
                            <p class="card-text">{{substr($w_tasks[$i]->description,0,140)}}{{strlen($w_tasks[$i]->description) > 140 ? '...' : ''}}</p>
                            <a href="{{$w_tasks[$i]->path}}" class="btn btn-primary">Przejdź do zadania</a>
                        </div>
                        <hr>
                    @endif
                @endfor
            </div>
        </div>
    </div>

    <div class="row">
        {{--Potencially Activities--}}
        {{--<div class="col-xl-6 col-lg-6">--}}
            {{--<div class="card shadow mb-4">--}}
                {{--<div class="card-header py-3">--}}
                    {{--<h6 class="m-0 font-weight-bold text-primary">Ostatnie aktywności</h6>--}}
                {{--</div>--}}
                {{--<div class="card-body">--}}
                    {{--<ul class="list-group list-group-flush">--}}
                        {{--<li class="list-group-item"><small>26min temu...</small><p>Cras justo odio</p></li>--}}
                        {{--<li class="list-group-item"><small>1h 25minut temu...</small><p>Dapibus ac facilisis in</p></li>--}}
                        {{--<li class="list-group-item"><small>2h 25minut temu...</small><p>Morbi leo risus</p></li>--}}
                        {{--<li class="list-group-item"><small>2h 45minut temu...</small><p>Porta ac consectetur ac</p></li>--}}
                        {{--<li class="list-group-item"><small>3h 5minut temu...</small><p>Vestibulum at eros</p></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        @if(auth()->user()->isStudent())
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dołącz do grupy</h6>
                </div>
                <div class="card-body col-6 offset-3">
                    <form action="{{route('subject-join')}}" method="POST" class="text-center">
                    {{csrf_field()}}
                    <div class="form-group">
                    <label for="code">Kod dołączenia</label>
                    <input type="text" class="form-control" name="code">
                    </div>
                    <button type="submit" class="btn btn-primary">Dołącz</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>


</div>
@endsection
