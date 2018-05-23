@extends('fastleo::app')

@section('content')

    <div class="row">
        <div class="col-6">
            <h3>{{ $title_model }}</h3>
        </div>
        <div class="col-6">
            <a href="/fastleo/app/{{ $name_model }}/add" class="btn btn-success float-right">Create {{ $name_model }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    @php $i = 1; @endphp
                    @foreach($columns_model as $column => $type)
                        @if(!in_array($type, $exclude_type) and !in_array($column, $exclude_name) and $i < 10)
                            <th>{{ ucfirst($column) }}</th>
                            @php ++$i; @endphp
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        @php $i = 1; @endphp
                        @foreach($columns_model as $column => $type)
                            @if(!in_array($type, $exclude_type) and !in_array($column, $exclude_name) and $i < 10)
                                <td>
                                    <a href="/fastleo/app/{{ $name_model }}/edit/{{ $row->id }}">{{ $row->{$column} }}</a>
                                </td>
                                @php ++$i; @endphp
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
            {{ $rows->links() }}
        </div>
    </div>

@endsection