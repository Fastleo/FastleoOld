<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FilemanagerController extends Controller
{
    public $images = ['png', 'jpg', 'jpeg', 'gif', 'bmp'];

    public $upload = '/uploads';

    public $dir, $folders, $files;

    /**
     * FilemanagerController constructor.
     */
    public function __construct(Request $request)
    {
        // upload folder name
        $this->dir = base_path('public' . $this->upload);
        if ($request->get('folder')) {
            $this->dir = base_path('public' . $this->upload . '/' . $request->get('folder'));
            $this->upload = $this->upload . '/' . $request->get('folder');
        }
    }

    /**
     * Folders list
     * @param array $folders
     * @return array
     */
    public function getFolders($folders = [])
    {
        $scan = scandir($this->dir);
        if (count($scan) > 0) {
            foreach ($scan as $e) {
                if (!in_array($e, ['.', '..']) and is_dir($this->dir . '/' . $e)) {
                    $folders[] = $e;
                }
            }
        }
        return $folders;
    }

    /**
     * Files list
     * @param array $files
     * @return array
     */
    public function getFiles($files = [])
    {
        $scan = scandir($this->dir);
        if (count($scan) > 0) {
            foreach ($scan as $e) {
                if (!in_array($e, ['.', '..']) and is_file($this->dir . '/' . $e)) {
                    $files[] = [
                        'name' => $e,
                        'url' => $this->upload . '/' . $e,
                        'ext' => pathinfo($this->dir . '/' . $e, PATHINFO_EXTENSION),
                    ];
                }
            }
        }
        return $files;
    }

    /**
     * Falimanager index page
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('fastleo::filemanager/index', [
            'folders' => self::getFolders(),
            'files' => self::getFiles(),
            'images' => $this->images,
        ]);
    }

    /**
     * Uploads files
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploads(Request $request)
    {
        $files = $request->file('files');
        if (isset($files) and count($files) > 0) {
            foreach ($files as $file) {
                $file->move($this->dir, $file->getClientOriginalName());
            }
            header('Location: /fastleo/filemanager/?' . request()->getQueryString());
            die;
        }
        return view('fastleo::filemanager/uploads');
    }
}
