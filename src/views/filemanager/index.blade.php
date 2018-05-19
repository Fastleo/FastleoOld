@extends('fastleo::filemanager')

@section('content')

    <div class="row">

        @if(request()->input('folder'))
            @php $getfolder = explode('/', request()->input('folder')); @endphp
            @php array_pop($getfolder); @endphp
            @php $getfolder = implode('/', $getfolder); @endphp
            <a href="?folder={{ $getfolder }}">
                <div class="block" style="background-image: url('/ico/folder.png');">
                    <span class="filename">..</span>
                </div>
            </a>
        @endif

        @if(isset($folders) and count($folders) > 0)
            @foreach($folders as $folder)
                <a href="?folder=@if(request()->input('folder')){{ request()->input('folder') . '/' }}@endif{{ $folder }}">
                    <div class="block" style="background-image: url('/ico/folder.png');">
                        <span class="filename">{{ $folder }}</span>
                    </div>
                </a>
            @endforeach
        @endif

        @if(isset($files) and count($files) > 0)
            @foreach($files as $file)
                @php (in_array($file['ext'], $images)) ? $background = $file['url'] : $background = '/ico/'.$file['ext'].'.jpg'; @endphp
                <a href="?folder&file">
                    <div class="block image" style="background-image: url('{{ $background }}');" data-url="{{ $file['url'] }}">
                        <span class="filename">{{ str_limit($file['name'], 10, '..') }}.{{ $file['ext'] }}</span>
                    </div>
                </a>
            @endforeach
        @endif
    </div>

    <script type="text/javascript" language="javascript">
        $(document).ready(function () {
            $('div.image').on('click', function () {
                var args = top.tinymce.activeEditor.windowManager.getParams();
                win = (args.window);
                input = (args.input);
                win.document.getElementById(input).value = $(this).attr('data-url');
                top.tinymce.activeEditor.windowManager.close();
            });
        });
    </script>

@endsection