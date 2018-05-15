<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    var $app, $columns, $model, $name;

    /**
     * ModelController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = $request->segment(count($request->segments()));
        $this->model = 'App\\' . ucfirst($this->name);
        $this->columns = Schema::getColumnListing($this->name . 's');

        dump(DB::connection()->getDoctrineColumn('users')->getType()->getName());

        // Start App
        $this->app = new $this->model();
    }

    /**
     * Rows list
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $rows = $this->app::get();
        return view('fastleo::model', [
            'title_model' => ucfirst($this->name),
            'name_model' => $this->name,
            'rows' => $rows
        ]);
    }

    /**
     * Row add
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('fastleo::model-edit', [
            'title_model' => ucfirst($this->name),
            'name_model' => $this->name,
        ]);
    }

    /**
     * Row edit
     * @param $row_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($row_id)
    {
        $row = $this->app::where('id', $row_id)->first();
        return view('fastleo::model-edit', [
            'title_model' => ucfirst($this->name),
            'name_model' => $this->name,
            'row' => $row
        ]);
    }
}