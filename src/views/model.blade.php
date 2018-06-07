@extends('fastleo::app')

@section('content')

    <div class="row">
        <div class="col-4">
            <h3>{{ isset($model['title']) ? $model['title'] : $model_title }} / Список записей</h3>
        </div>
        <div class="col-4 text-right">
            <form class="form-inline" action="" method="get" id="search" @if(request()->get('search') == null) style="display: none;" @endif>
                    <input type="text" name="search" class="form-control" placeholder="Поиск" value="@if(request()->get('search')){{ request()->get('search') }}@endif">
                    <button type="submit" class="btn btn-success form-control">Найти</button>
                    <a href="/fastleo/app/{{ $model_name }}" class="form-control btn btn-warning">Сброс</a>
            </form>
        </div>
        <div class="col-4 text-right">
            <a href="" onclick="$('#search').toggle(); return false;" class="btn btn-info">Поиск</a>
            <a href="/fastleo/app/{{ $model_name }}/add?{{ request()->getQueryString() }}" class="btn btn-success">Добавить запись</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <br>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th></th>
                    @php $i = 1; @endphp
                    @foreach($model_columns as $c => $t)
                        @if(!isset($f[$c]['visible']) or $f[$c]['visible'] == true)
                            @if(!in_array($t, $exclude_type) and !in_array($c, $exclude_name) and $i < 10)
                                <th>@if(isset($f[$c]['title'])){{ $f[$c]['title'] }}@else{{ str_replace("_", " ", ucfirst($c)) }}@endif</th>
                                @php ++$i; @endphp
                            @endif
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td>
                            @if(isset($row->sort))
                                <a href="/fastleo/app/{{ $model_name }}/up/{{ $row->id }}?{{ request()->getQueryString() }}"><i class="fas fa-arrow-up fa-xs"></i></a>
                            @endif
                            @if(isset($row->menu))
                                <a href="/fastleo/app/{{ $model_name }}/menu/{{ $row->id }}?{{ request()->getQueryString() }}" style="color:{{ $row->menu == 1 ? 'green' : 'red' }}"><i class="far fa-dot-circle fa-xs"></i></a>
                            @endif
                            @if(isset($row->sort))
                                <a href="/fastleo/app/{{ $model_name }}/down/{{ $row->id }}?{{ request()->getQueryString() }}"><i class="fas fa-arrow-down fa-xs"></i></a>
                            @endif
                        </td>
                        @php $i = 1; @endphp
                        @foreach($model_columns as $c => $t)
                            @if(!isset($f[$c]['visible']) or $f[$c]['visible'] == true)
                                @if(!in_array($t, $exclude_type) and !in_array($c, $exclude_name) and $i < 10)
                                    <td>
                                        <a href="/fastleo/app/{{ $model_name }}/edit/{{ $row->id }}?{{ request()->getQueryString() }}">{{ $row->{$c} }}</a>
                                    </td>
                                    @php ++$i; @endphp
                                @endif
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            {{ $rows->appends(request()->all())->links() }}
        </div>
    </div>

@endsection