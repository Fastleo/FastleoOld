@extends('fastleo::app')

@section('content')

    <div class="row">
        <div class="col-6">
            <h3>{{ $title_model }}</h3>
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
                    <th scope="col">#</th>
                    <th scope="col">Admin</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Auth date</th>
                    <th scope="col">Create date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->admin ? 'yes' : 'no' }}</td>
                        <td><a href="{{--{{ route('fastleo.users.edit', ['user_id' => $user->id]) }}--}}">{{ $row->name }}</a></td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->updated_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection