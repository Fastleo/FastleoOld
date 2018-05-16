@extends('fastleo::app')

@section('content')

    <div class="row">
        <div class="col-6">
            <h3>{{ $title_model }} create/edit</h3>
        </div>
        <div class="col-6">
            <a href="{{ route('fastleo') }}/app/{{ $name_model }}" class="btn btn-success float-right">Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="" method="post">
                {{ @csrf_field() }}
                @if(count($columns_model) > 0)
                    @foreach($columns_model as $column)
                        @if(!in_array($column['type'], $exclude_type) and !in_array($column['name'], $exclude_name))
                            @if(in_array($column['type'], ['text','longtext']))
                                <div class="form-group">
                                    <label for="{{ $column['name'] }}">{{ ucfirst($column['name']) }}</label>
                                    <textarea name="{{ $column['name'] }}" class="form-control" id="{{ $column['name'] }}" placeholder="{{ $column['type'] }}">@if(isset($row->{$column['name']})){{ $row->{$column['name']} }}@endif</textarea>
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
                <button type="submit" class="btn btn-primary">Save form</button>
            </form>
        </div>
    </div>

@endsection