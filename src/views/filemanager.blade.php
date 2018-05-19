<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fastleo Filemanager</title>
    <script src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css">
    <link rel="stylesheet" href="/css/fastleo.filemanager.css">
</head>
<body>
<nav class="navbar navbar-light navbar-dark bg-dark flex-md-nowrap">
    <a class="navbar-brand" href="/fastleo/filemanager">Fastleo Filemanager</a>
    <div class="pull-right">
        <a href="/fastleo/filemanager/uploads?folder={{ request()->input('folder') }}">Загрузить файл</a> /
        <a href="/fastleo/filemanager/create?folder={{ request()->input('folder') }}">Создать папку</a>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            @yield('content')
        </div>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>