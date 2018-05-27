<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ModelController extends Controller
{
    public $app, $columns, $model, $name, $schema, $table;

    public $fastleo_model_name, $fastleo_columns;

    public $exclude_list_type = ['text', 'longtext'];
    public $exclude_list_name = ['sort', 'menu', 'password', 'remember_token', 'admin'];

    public $exclude_row_type = [];
    public $exclude_row_name = ['id', 'password', 'remember_token', 'created_at', 'updated_at'];

    /**
     * ModelController constructor.
     * @param Request $request
     */
    public function __construct()
    {
        // Model name
        $this->name = request()->segment(3);

        // Model namespace
        $this->model = 'App\\' . request()->appmodels[$this->name];

        // Model test
        if (!class_exists($this->model)) {
            return false;
        }

        // Start App
        $this->app = new $this->model();

        // Table name
        $this->table = $this->app->getTable();

        // Table column list
        $this->schema = Schema::getColumnListing($this->table);

        // Exclude visible columns
        $this->exclude_list_name = array_merge($this->exclude_list_name, $this->app->getHidden());
        $this->exclude_row_name = array_merge($this->exclude_row_name, $this->app->getHidden());

        // Fastleo variables
        $this->fastleo_model_name = $this->app->fastleo_model_name ?: $this->name;
        $this->fastleo_columns = $this->app->fastleo_columns ?: [];

        // Table columns
        if (count($this->schema) > 0) {
            foreach ($this->schema as $column) {
                $this->columns[$column] = Schema::getColumnType($this->table, $column);
            }
        } else {
            die('Not exist table ' . $this->table);
        }
    }

    /**
     * Rows list
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $rows = $this->app::paginate(10);
        return view('fastleo::model', [
            'exclude_type' => $this->exclude_list_type,
            'exclude_name' => $this->exclude_list_name,
            'columns_model' => $this->columns,
            'title_model' => ucfirst($this->name),
            'name_model' => $this->name,
            'rows' => $rows,
            'f' => $this->fastleo_columns,
        ]);
    }

    /**
     * Row add
     * @param Request $request
     * @param $model
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request, $model)
    {
        // add
        if ($request->all()) {
            if (isset($this->columns['created_at'])) {
                $request->request->add(['created_at' => \Carbon\Carbon::now()]);
            }
            $id = $this->app->insertGetId($request->except(['_token']));
            header('Location: /fastleo/app/' . $model . '/edit/' . $id);
            die;
        }

        // view
        return view('fastleo::model-edit', [
            'exclude_type' => $this->exclude_row_type,
            'exclude_name' => $this->exclude_row_name,
            'columns_model' => $this->columns,
            'title_model' => ucfirst($this->name),
            'name_model' => $this->name,
            'f' => $this->fastleo_columns,
        ]);
    }

    /**
     * Row edit
     * @param $model
     * @param $row_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $model, $row_id)
    {
        // edit
        if ($request->all()) {
            if (isset($this->columns['updated_at'])) {
                $request->request->add(['updated_at' => \Carbon\Carbon::now()]);
            }
            $this->app->where('id', $row_id)->update($request->except(['_token']));
            header('Location: /fastleo/app/' . $model . '/edit/' . $row_id);
            die;
        }

        // view
        $row = $this->app::where('id', $row_id)->first();
        return view('fastleo::model-edit', [
            'exclude_type' => $this->exclude_row_type,
            'exclude_name' => $this->exclude_row_name,
            'columns_model' => $this->columns,
            'title_model' => ucfirst($this->name),
            'name_model' => $this->name,
            'row_id' => $row_id,
            'row' => $row,
            'f' => $this->fastleo_columns,
        ]);
    }
}