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
                            @if(in_array($t, ['text','longtext']) or (isset($f[$c]['type']) and in_array($f[$c]['type'], ['text','longtext'])))
                                <div class="form-group">
                                    <label for="{{ $c }}">@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</label>
                                    <textarea name="{{ $c }}" id="{{ $c }}" class="form-control @if(isset($f[$c]['tinymce']) and $f[$c]['tinymce'] == true){{ 'tinymce' }}@endif" @if(isset($f[$c]['editing']) and $f[$c]['editing'] == false){{ 'disabled' }}@endif>@if(isset($row->{$c})){!! trim($row->{$c}) !!}@endif</textarea>
                                    @if(isset($f[$c]['description']) and $f[$c]['description'] != '')
                                        <small id="emailHelp" class="form-text text-muted">{{ $f[$c]['description'] }}</small>
                                    @endif
                                </div>
                            @elseif(isset($f[$c]['type']) and in_array($f[$c]['type'], ['integer', 'int', 'tinyint', 'float', 'double', 'decimal']))
                                <div class="form-group">
                                    <label for="{{ $c }}">@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</label>
                                    <div class="input-group">
                                        <input type="number" name="{{ $c }}" id="{{ $c }}" class="form-control" placeholder="{{ $t }}" value="@if(isset($row->{$c})){{ $row->{$c} }}@endif" @if(isset($f[$c]['editing']) and $f[$c]['editing'] == false){{ 'disabled' }}@endif>
                                        @if(isset($f[$c]['description']) and $f[$c]['description'] != '')
                                            <small id="emailHelp" class="form-text text-muted">{{ $f[$c]['description'] }}</small>
                                        @endif
                                    </div>
                                </div>
                            @elseif(isset($f[$c]['type']) and in_array($f[$c]['type'], ['checkbox', 'boolean']))
                                <div class="form-group form-check">
                                    <input type="hidden" name="{{ $c }}" value="0">
                                    <input type="checkbox" name="{{ $c }}" class="form-check-input" id="{{ $c }}" placeholder="{{ $t }}" value="1" @if(isset($f[$c]['editing']) and $f[$c]['editing'] == false){{ 'disabled' }}@endif @if(isset($row->{$c}) and $row->{$c} == 1){{ 'checked' }}@endif>
                                    <label class="form-check-label" for="{{ $c }}">@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</label>
                                </div>
                            @elseif(isset($f[$c]['type']) and in_array($f[$c]['type'], ['array', 'multiarray']))
                                <div class="form-group">
                                    <label for="{{ $c }}">@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</label>
                                    <select class="form-control select2" id="{{ $c }}" @if($f[$c]['type'] == 'multiarray'){{ 'multiple' }}@endif @if(isset($f[$c]['editing']) and $f[$c]['editing'] == false){{ 'disabled' }}@endif>
                                        @if($f[$c]['data'])
                                            @foreach($f[$c]['data'] as $v)
                                                <option value="{{ $v }}" @if(isset($row->{$c}) and $row->{$c} == $v){{ 'selected' }}@endif>{{ $v }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if(isset($f[$c]['description']) and $f[$c]['description'] != '')
                                        <small id="emailHelp" class="form-text text-muted">{{ $f[$c]['description'] }}</small>
                                    @endif
                                </div>
                            @elseif(isset($f[$c]['type']) and in_array($f[$c]['type'], ['select', 'multiselect']))
                                <div class="form-group">
                                    <label for="{{ $c }}">@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</label>
                                    <select class="form-control select2" id="{{ $c }}" @if($f[$c]['type'] == 'multiselect'){{ 'multiple' }}@endif @if(isset($f[$c]['editing']) and $f[$c]['editing'] == false){{ 'disabled' }}@endif>
                                        <option value=""></option>
                                        @if($f[$c]['data'] and is_string($f[$c]['data']))
                                            @php
                                                $parsing = explode(":", $f[$c]['data']);
                                                $model = 'App\\'.$parsing[0];
                                                $app = $model::get();
                                            @endphp
                                            @if(count($parsing) == 3)
                                                @foreach($app as $v)
                                                    @if(isset($v->{$parsing[1]}) and isset($v->{$parsing[2]}))
                                                        <option value="{{ $v->{$parsing[1]} }}" @if(isset($row->{$c}) and $row->{$c} == $v->{$parsing[1]}){{ 'selected' }}@endif>{{ $v->{$parsing[2]} }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                    @if(isset($f[$c]['description']) and $f[$c]['description'] != '')
                                        <small id="emailHelp" class="form-text text-muted">{{ $f[$c]['description'] }}</small>
                                    @endif
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="{{ $c }}">@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</label>
                                    <div class="input-group">
                                        @if(isset($f[$c]['media']) and $f[$c]['media'] == true)
                                            <div class="input-group-prepend filemanager" data-fancybox data-type="iframe" data-src="/fastleo/filemanager?field={{ $c }}">
                                                <div class="input-group-text"><i class="fas fa-folder-open"></i></div>
                                            </div>
                                        @endif
                                        <input type="text" name="{{ $c }}" id="{{ $c }}" class="form-control" placeholder="{{ $t }}" value="@if(isset($row->{$c})){{ $row->{$c} }}@endif" @if(isset($f[$c]['editing']) and $f[$c]['editing'] == false){{ 'disabled' }}@endif>
                                    </div>
                                    @if(isset($f[$c]['description']) and $f[$c]['description'] != '')
                                        <small id="emailHelp" class="form-text text-muted">{{ $f[$c]['description'] }}</small>
                                    @endif
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