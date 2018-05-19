@extends('fastleo::app')

@section('content')

    <div class="row">
        <div class="col-6">
            <h3>{{ $title_model }} @if(isset($row_id)){{ 'edit' }}@else{{ 'create' }}@endif</h3>
        </div>
        <div class="col-6">
            <a href="/fastleo/app/{{ $name_model }}" class="btn btn-primary float-right">Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="/fastleo/app/{{ $name_model }}/create/@if(isset($row_id)){{ $row_id }}@endif" method="post">
                {{ @csrf_field() }}
                {{ method_field('POST') }}
                @if(count($columns_model) > 0)
                    @foreach($columns_model as $column)
                        @if(!in_array($column['type'], $exclude_type) and !in_array($column['name'], $exclude_name))
                            @if(in_array($column['type'], ['text','longtext']))
                                <div class="form-group">
                                    <label for="{{ $column['name'] }}">{{ ucfirst($column['name']) }}</label>
                                    <textarea name="{{ $column['name'] }}" class="form-control" id="{{ $column['name'] }}" rows="10" placeholder="{{ $column['type'] }}">@if(isset($row->{$column['name']})){{ $row->{$column['name']} }}@endif</textarea>
                                </div>
                            @elseif(in_array($column['name'], ['password']))
                                <div class="form-group">
                                    <label for="{{ $column['name'] }}">{{ ucfirst($column['name']) }}</label>
                                    <input type="text" name="{{ $column['name'] }}" class="form-control" id="{{ $column['name'] }}" placeholder="{{ $column['type'] }}">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="{{ $column['name'] }}">{{ ucfirst($column['name']) }}</label>
                                    <input type="text" name="{{ $column['name'] }}" class="form-control" id="{{ $column['name'] }}" placeholder="{{ $column['type'] }}" value="@if(isset($row->{$column['name']})){{ $row->{$column['name']} }}@endif">
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endif
                <input type="submit" class="btn btn-success" value="Save form">
                <a href="/fastleo/app/{{ $name_model }}" class="btn btn-primary">Back</a>
            </form>
        </div>
    </div>

@endsection