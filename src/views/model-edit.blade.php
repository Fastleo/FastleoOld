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
            <form action="" method="post">
                {{ csrf_field() }}
                @if(count($columns_model) > 0)
                    @foreach($columns_model as $column => $type)
                        @if(!in_array($type, $exclude_type) and !in_array($column, $exclude_name))
                            @if(in_array($type, ['text','longtext']))
                                <div class="form-group">
                                    <label for="{{ $column }}">{{ ucfirst($column) }}</label>
                                    <textarea name="{{ $column }}" class="form-control tinymce" id="{{ $column }}" rows="10" placeholder="{{ $type }}">@if(isset($row->{$column})){!! $row->{$column} !!}@endif</textarea>
                                </div>
                            @elseif(in_array($column, ['password']))
                                <div class="form-group">
                                    <label for="{{ $column }}">{{ ucfirst($column) }}</label>
                                    <input type="text" name="{{ $column }}" class="form-control" id="{{ $column }}" placeholder="{{ $type }}">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="{{ $column }}">{{ ucfirst($column) }}</label>
                                    <input type="text" name="{{ $column }}" class="form-control" id="{{ $column }}" placeholder="{{ $type }}" value="@if(isset($row->{$column})){{ $row->{$column} }}@endif">
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