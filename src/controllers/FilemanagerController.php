<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

ini_set('gd.jpeg_ignore_warning', true);

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
     * Resize images
     * @param $path
     * @param $image
     * @param int $desired_width
     */
    private function resize($path, $image, $desired_width = 122)
    {
        switch (pathinfo($this->dir . '/' . $image, PATHINFO_EXTENSION)) {
            case 'png':
                $source_image = imagecreatefrompng($path . '/' . $image);
                break;
            case 'jpeg':
                $source_image = imagecreatefromjpeg($path . '/' . $image);
                break;
            case 'gif':
                $source_image = imagecreatefromgif($path . '/' . $image);
                break;
            default:
                $source_image = imagecreatefromjpeg($path . '/' . $image);
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $desired_height = floor($height * ($desired_width / $width));
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        imagejpeg($virtual_image, $path . '/.thumbs/' . $image);
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
                    $files[] = [
                        'name' => $e,
                        'url' => $this->upload . '/' . $e,
                        'thumbs' => $this->upload . '/.thumbs/' . $e,
                        'ext' => pathinfo($this->dir . '/' . $e, PATHINFO_EXTENSION),
                    ];
                    if (!file_exists($this->dir . '/.thumbs/' . $e)) {
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
                $file->move($this->dir, $file->getClientOriginalName());
                self::resize($this->dir, $file->getClientOriginalName());
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
