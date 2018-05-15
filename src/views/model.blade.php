@extends('fastleo::app')

@section('content')

    <div class="row">
        <div class="col-6">
            <h3>{{ $title_model }} list</h3>
        </div>
        <div class="col-6">
            <a href="{{ route('fastleo') }}/app/{{ $name_model }}/add" class="btn btn-success float-right">Create {{ $name_model }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    @foreach($columns_model as $column)
                        @if(!in_array($column['type'], $exclude_type) and !in_array($column['name'], $exclude_name))
                            <th scope="col">{{ ucfirst($column['name']) }}</th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        @foreach($columns_model as $column)
                            @if(!in_array($column['type'], $exclude_type) and !in_array($column['name'], $exclude_name))
                                <td>
                                    <a href="{{ route('fastleo') }}/app/{{ $name_model }}/edit/{{ $row->id }}">{{ $row->{$column['name']} }}</a>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection