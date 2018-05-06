@extends('fastleo::app')

@section('content')

    <div class="row">
        <div class="col-6">
            <h3>User Create/Edit</h3>
        </div>
        <div class="col-6">
            <a href="{{ route('fastleo.users') }}" class="btn btn-success float-right">Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{ route('fastleo.users.save', [$user]) }}" method="post">
                {{ @csrf_field() }}
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" value="@if(isset($user->email)){{ $user->email }}@endif">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="First and Last name" value="@if(isset($user->name)){{ $user->name }}@endif">
                </div>
                <div class="form-group form-check">
                    <input type="hidden" name="admin" value="0">
                    <input type="checkbox" name="admin" class="form-check-input" id="admin" @if(isset($user->admin) and $user->admin == 1){{ 'checked' }}@endif value="1">
                    <label class="form-check-label" for="admin">administrator role</label>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Password">
                    <small id="passwordHelp" class="form-text text-muted">Leave the field blank if you do not want to change the password</small>
                </div>
                <div class="form-group">
                    <label for="repeat-password">Repeat password</label>
                    <input type="password" name="repeat-password" class="form-control" id="repeat-password" placeholder="Repeat password">
                </div>
                <button type="submit" class="btn btn-primary">Save form</button>
            </form>
        </div>
    </div>

@endsection