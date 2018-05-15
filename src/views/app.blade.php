<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fastleo Admin Panel</title>
</head>
<body>
<nav class="navbar navbar-light navbar-dark bg-dark flex-md-nowrap">
    <a class="navbar-brand" href="#">Fastleo Admin Panel</a>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4 bg-light">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link {{ Request::is('fastleo/info') ? 'active' : '' }}" href="{{ route('fastleo.info') }}"><i class="fas fa-home"></i> Information</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::is('fastleo/pages') ? 'active' : '' }}" href="{{ route('fastleo.pages') }}"><i class="far fa-newspaper"></i> Static pages</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::is('fastleo/users') ? 'active' : '' }}" href="{{ route('fastleo.users') }}"><i class="fas fa-users"></i> Users and roles</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::is('fastleo/config') ? 'active' : '' }}" href="{{ route('fastleo.config') }}"><i class="fas fa-cogs"></i> Configuration</a></li>
                @if(count(request()->attributes->get('models')) > 0)
                    @foreach(request()->attributes->get('models') as $model)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('fastleo') }}/app/{{ strtolower($model) }}">
                                <i class="fas fa-cogs"></i> {{ $model }}s
                            </a>
                        </li>
                    @endforeach
                @endif
                <li class="nav-item"><a class="nav-link" href="/" target="_blank"><i class="fas fa-globe"></i> Go to site</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('fastleo.logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        <div class="col-lg-10 col-md-9 col-sm-8 ">
            @yield('content')
        </div>
    </div>
</div>
<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css">
<script src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>