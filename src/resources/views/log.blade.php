@extends('fastleo::app')

@section('content')

    <div class="row">
        <div class="col text-right">
            <a href="/fastleo/log/clear" class="btn btn-warning">Очистить log</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @foreach($logs as $log)
                <small>{{ $log }}</small><br><br>
            @endforeach
        </div>
    </div>

@endsection