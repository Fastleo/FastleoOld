<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

ini_set('gd.jpeg_ignore_warning', true);

class FilemanagerController extends Controller
{
    public $images = ['png', 'jpg', 'jpeg', 'gif'];

    public $upload = '/uploads';

    public $dir, $folders, $files;

    /**
     * FilemanagerController constructor.
     */
    public function __construct(Request $request)
    {

        // upload folder name
        $this->dir = base_path('public' . $this->upload);

        // Create uploads dir
        if (!is_dir($this->dir)) {
            File::makeDirectory($this->dir, $mode = 0777, true, true);
        }

        // Change dir
        if ($request->get('folder')) {
            $this->dir = base_path('public' . $this->upload . '/' . $request->get('folder'));
            $this->upload = $this->upload . '/' . $request->get('folder');
        }

        // create thumbs folder
        if (!is_dir($this->dir . '/.thumbs')) {
            File::makeDirectory($this->dir . '/.thumbs', $mode = 0777, true, true);
        }
    }

    /**
     * @param $path
     * @param $image
     * @param int $desired_width
     * @return bool
     */
    private function resize($path, $image, $desired_width = 122)
    {
        $ext = pathinfo($this->dir . '/' . $image, PATHINFO_EXTENSION);

        switch ($ext) {
            case 'png':
                $source_image = @imagecreatefrompng($path . '/' . $image);
                break;
            case 'jpg':
                $source_image = @imagecreatefromjpeg($path . '/' . $image);
                break;
            case 'jpeg':
                $source_image = @imagecreatefromjpeg($path . '/' . $image);
                break;
            case 'gif':
                $source_image = @imagecreatefromgif($path . '/' . $image);
                break;
        }

        if (!$source_image) {
            return false;
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $desired_height = floor($height * ($desired_width / $width));
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        switch ($ext) {
            case 'png':
                imagepng($virtual_image, $path . '/.thumbs/' . $image);
                break;
            case 'jpg':
                imagejpeg($virtual_image, $path . '/.thumbs/' . $image);
                break;
            case 'jpeg':
                imagejpeg($virtual_image, $path . '/.thumbs/' . $image);
                break;
            case 'gif':
                imagegif($virtual_image, $path . '/.thumbs/' . $image);
                break;
        }

        return true;
    }

    /**
     * Folders list
     * @param array $folders
     * @return array
     */
    protected function getFolders($folders = [])
    {
        $scan = scandir($this->dir);
        if (count($scan) > 0) {
            foreach ($scan as $e) {
                if (!in_array($e, ['.', '..', '.thumbs']) and is_dir($this->dir . '/' . $e)) {
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
    protected function getFiles($files = [])
    {
        $scan = scandir($this->dir);
        if (count($scan) > 0) {
            foreach ($scan as $e) {
                if (!in_array($e, ['.', '..', '.thumbs']) and is_file($this->dir . '/' . $e)) {
                    $ext = pathinfo($this->dir . '/' . $e, PATHINFO_EXTENSION);
                    $files[] = [
                        'name' => $e,
                        'url' => $this->upload . '/' . $e,
                        'thumbs' => (file_exists($this->dir . '/.thumbs/' . $e)) ? $this->upload . '/.thumbs/' . $e : '',
                        'ext' => $ext,
                    ];
                    if (!file_exists($this->dir . '/.thumbs/' . $e) and in_array($ext, ['jpg', 'jpeg', 'png', 'gif',])) {
                        self::resize($this->dir, $e);
                    }
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
                $name = str_replace([' '], ['_'], $file->getClientOriginalName());
                $file->move($this->dir, $name);
                $ext = pathinfo($this->dir . '/' . $name, PATHINFO_EXTENSION);
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif',])) {
                    self::resize($this->dir, $name);
                }
            }
            header('Location: /fastleo/filemanager?' . request()->getQueryString());
            die;
        }
        return view('fastleo::filemanager/uploads');
    }

    public function create()
    {
        return view('fastleo::filemanager/create');
    }
}
