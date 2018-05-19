<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilemanagerController extends Controller
{
    public $images = ['png', 'jpg', 'jpeg', 'gif', 'bmp'];

    public $upload = '/uploads';

    public $dir, $folders, $files;

    public function __construct()
    {
        // Текущая папка
        $this->dir = base_path('public' . $this->upload);

        // список папок и файлов
        $scan = scandir($this->dir);

        // делим на файлы и папки
        foreach ($scan as $e) {
            if (!in_array($e, ['.', '..'])) {
                if (is_dir($this->dir . '/' . $e)) {
                    $this->folders[] = $e;
                } else {
                    $this->files[] = [
                        'name' => $e,
                        'url' => $this->upload . '/' . $e,
                        'ext' => pathinfo($this->dir . '/' . $e, PATHINFO_EXTENSION),
                    ];
                }
            }
        }
    }

    public function index()
    {
        return view('fastleo::filemanager.index', [
            'folders' => $this->folders,
            'files' => $this->files,
            'images' => $this->images,
        ]);
    }

    public function uploads(Request $request)
    {
        $files = $request->file('files');
        if (isset($files) and count($files) > 0) {
            foreach ($files as $file) {
                $file->move($this->dir, $file->getClientOriginalName());
            }
        }
        return view('fastleo::filemanager.uploads');
    }
}
