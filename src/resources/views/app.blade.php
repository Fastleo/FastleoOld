<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fastleo Admin Panel</title>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.1.0/css/all.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
    <link rel="stylesheet" href="/css/fastleo.admin.css">
</head>
<body>
<nav class="navbar navbar-light navbar-dark bg-dark flex-md-nowrap fastleo-nav">
    <a class="navbar-brand" href="/fastleo/info">Fastleo Admin Panel</a>
    <div class="pull-right">
        <a href="#" class="filemanager" data-fancybox data-type="iframe" data-src="/fastleo/filemanager">Файловый менеджер</a> /
        <a href="/" target="_blank">Перейти на сайт</a> /
        <a href="/fastleo/logout">Выйти</a>
    </div>
</nav>
<div class="container-fluid fastleo-container">
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4 bg-light fastleo-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/fastleo/info" class="nav-link"><i class="fas fa-home"></i> Информация</a>
                </li>
                @if(isset(request()->appmodels) and count(request()->appmodels) > 0)
                    @foreach(request()->appmodels as $model)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('fastleo/app/'. strtolower($model['name'])) ? 'active' : '' }}" href="/fastleo/app/{{ strtolower($model['name']) }}">
                                @if(isset($model['icon']) and $model['icon'] != '')
                                    <i class="{{ $model['icon'] }}"></i>
                                @else
                                    <i class="fas fa-box-open"></i>
                                @endif
                                {{ $model['title'] }}
                            </a>
                        </li>
                    @endforeach
                @endif
                <li class="nav-item">
                    <br>
                    <a href="https://softonline.org" target="_blank">
                        <small>Softonline</small>
                    </a>
                    <br>
                    <a href="https://github.com/Camanru/Fastleo" target="_blank">
                        <small>Github</small>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-10 col-md-9 col-sm-8 fastleo-content">
            @yield('content')
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.0/tinymce.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>

<script>
    function filemanager(field, value) {
        $('#' + field).val(value);
    }

    tinymce.init({
        selector: 'textarea.tinymce',
        theme: 'modern',
        plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help code',
        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor removeformat | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | link image media | code',
        image_advtab: true,
        relative_urls: false,
        height: 300,
        file_browser_callback: function (field_name, url, type, win) {
            tinyMCE.activeEditor.windowManager.open({
                url: "/fastleo/filemanager",
                width: 1020,
                height: 600,
            }, {
                window: win,
                input: field_name
            });
        }
    });
    $(document).ready(function () {
        $('.filemanager').fancybox({
            iframe: {
                css: {
                    width: '1020px',
                    height: '640px',
                }
            }
        });
        $('.select2').select2();

        $('#import').click(function () {
            $('input[name=import]').trigger('click');
            return false;
        });

        $('input[name=import]').on('change', function () {
            if (confirm('Вы уверены, что хотите импортировать данные из файла ' + $(this).val())) {
                $('#form').submit();
            } else {
                window.location.reload();
                return false;
            }
        });
    });
</script>
</body>
</html>