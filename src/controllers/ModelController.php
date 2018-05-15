<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ModelController extends Controller
{
    var $app, $columns, $model, $name, $schema, $table;

    public $exclude_type = ['text', 'longtext'];
    public $exclude_name = ['password', 'remember_token', 'admin'];

    /**
     * ModelController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = $request->segment(3);
        $this->model = 'App\\' . ucfirst($this->name);
        $this->table = $this->name . 's';
        $this->schema = Schema::getColumnListing($this->table);

        // Table columns
        if(count($this->schema) > 0) {
            foreach (Schema::getColumnListing($this->table) as $k => $column) {
                $this->columns[$k]['name'] = $column;
                $this->columns[$k]['type'] = Schema::getColumnType($this->table, $column);
            }
        } else {
            dd('Not exist table ' . $this->table);
        }

        // Start App
        $this->app = new $this->model();
    }

    /**
     * Rows list
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $rows = $this->app::limit(20)->get();
        return view('fastleo::model', [
            'exclude_type' => $this->exclude_type,
            'exclude_name' => $this->exclude_name,
            'columns_model' => $this->columns,
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
            'columns_model' => $this->columns,
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
            'columns_model' => $this->columns,
            'title_model' => ucfirst($this->name),
            'name_model' => $this->name,
            'row' => $row
        ]);
    }
}