<?php

namespace Camanru\Fastleo;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ModelController extends Controller
{
    var $app, $columns, $model, $name, $schema, $table;

    public $exclude_list_type = ['text', 'longtext'];
    public $exclude_list_name = ['password', 'remember_token', 'admin'];

    public $exclude_row_type = [];
    public $exclude_row_name = ['id', 'remember_token', 'created_at', 'updated_at'];

    /**
     * ModelController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        // Model name
        $this->name = $request->segment(3);

        // Model namespace
        $this->model = 'App\\' . ucfirst($this->name);

        // Table name
        $this->table = $this->name . 's';

        // Table column list
        $this->schema = Schema::getColumnListing($this->table);

        // Table columns
        if (count($this->schema) > 0) {
            foreach (Schema::getColumnListing($this->table) as $k => $column) {
                $this->columns[$k]['name'] = $column;
                $this->columns[$k]['type'] = Schema::getColumnType($this->table, $column);
            }
        } else {
            die('Not exist table ' . $this->table);
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
            'exclude_type' => $this->exclude_list_type,
            'exclude_name' => $this->exclude_list_name,
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
            'exclude_type' => $this->exclude_row_type,
            'exclude_name' => $this->exclude_row_name,
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
    public function edit($model, $row_id)
    {
        $row = $this->app::where('id', $row_id)->first();
        return view('fastleo::model-edit', [
            'exclude_type' => $this->exclude_row_type,
            'exclude_name' => $this->exclude_row_name,
            'columns_model' => $this->columns,
            'title_model' => ucfirst($this->name),
            'name_model' => $this->name,
            'row' => $row
        ]);
    }

    public function save($model, $row_id)
    {

    }

    public function delete($model, $row_id)
    {

    }
}