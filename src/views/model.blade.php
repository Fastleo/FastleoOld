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
                    @foreach($columns_model as $c => $t)
                        @if(!isset($f[$c]['visible']) or $f[$c]['visible'] == true)
                            @if(!in_array($t, $exclude_type) and !in_array($c, $exclude_name) and $i < 10)
                                <th>@if(isset($f[$c]['name'])){{ $f[$c]['name'] }}@else{{ ucfirst($c) }}@endif</th>
                                @php ++$i; @endphp
                            @endif
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        @php $i = 1; @endphp
                        @foreach($columns_model as $c => $t)
                            @if(!isset($f[$c]['visible']) or $f[$c]['visible'] == true)
                                @if(!in_array($t, $exclude_type) and !in_array($c, $exclude_name) and $i < 10)
                                    <td>
                                        <a href="/fastleo/app/{{ $name_model }}/edit/{{ $row->id }}">{{ $row->{$c} }}</a>
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
            {{ $rows->links() }}
        </div>
    </div>

@endsection