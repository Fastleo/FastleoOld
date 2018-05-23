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
                    @foreach($columns_model as $c => $t)
                        @if(!in_array($t, $exclude_type) and !in_array($c, $exclude_name))
                            @if(in_array($t, ['text','longtext']))
                                <div class="form-group">
                                    <label for="{{ $c }}">@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</label>
                                    <textarea name="{{ $c }}" id="{{ $c }}" class="form-control @if(!isset($f[$c]['tinymce']) or $f[$c]['tinymce'] == true){{ 'tinymce' }}@endif">
                                        @if(isset($row->{$c})){!! $row->{$c} !!}@endif
                                    </textarea>
                                </div>
                            @elseif(in_array($c, ['password']))
                                <div class="form-group">
                                    <label for="{{ $c }}">@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</label>
                                    <input type="text" name="{{ $c }}" class="form-control" id="{{ $c }}" placeholder="{{ $t }}" @if(isset($f[$c]['editing']) and $f[$c]['editing'] == false){{ 'disabled' }}@endif>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="{{ $c }}">@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</label>
                                    <div class="input-group">
                                        @if(!isset($f[$c]['media']) or $f[$c]['media'])
                                            <div class="input-group-prepend filemanager" data-fancybox data-type="iframe" data-src="/fastleo/filemanager?field={{ $c }}">
                                                <div class="input-group-text"><i class="fas fa-folder-open"></i></div>
                                            </div>
                                        @endif
                                        <input type="text" name="{{ $c }}" id="{{ $c }}" class="form-control" placeholder="{{ $t }}" value="@if(isset($row->{$c})){{ $row->{$c} }}@endif" @if(isset($f[$c]['editing']) and $f[$c]['editing'] == false){{ 'disabled' }}@endif>
                                    </div>
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