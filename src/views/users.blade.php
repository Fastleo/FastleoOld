@extends('fastleo::app')

@section('content')

    <div class="row">
        <div class="col-6">
            <h3>Users</h3>
        </div>
        <div class="col-6">
            <a href="{{ route('fastleo.users.create') }}" class="btn btn-success float-right">Create user</a>
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
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->admin ? 'yes' : 'no' }}</td>
                        <td><a href="{{ route('fastleo.users.edit', ['user_id' => $user->id]) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection