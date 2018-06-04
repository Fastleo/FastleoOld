<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ModelController extends Controller
{
    public $app, $columns, $model, $name, $schema, $table;

    public $fastleo_model, $fastleo_columns;

    public $exclude_list_type = ['text', 'longtext'];
    public $exclude_list_name = ['sort', 'menu', 'password', 'remember_token', 'admin'];

    public $exclude_row_type = [];
    public $exclude_row_name = ['id', 'sort', 'menu', 'password', 'remember_token', 'created_at', 'updated_at'];

    /**
     * ModelController constructor.
     * @param Request $request
     */
    public function __construct()
    {
        // Model name
        $this->name = request()->segment(3);

        // Model namespace
        $this->model = 'App\\' . request()->appmodels[$this->name]['name'];

        // Model exist
        if (!class_exists($this->model)) {
            return false;
        }

        // Start App
        $this->app = $this->getModel();

        // Table name
        $this->table = $this->getTable();

        // Table column list
        $this->schema = $this->getColumns();

        // Exclude visible columns
        $this->exclude_list_name = array_merge($this->exclude_list_name, $this->app->getHidden());
        $this->exclude_row_name = array_merge($this->exclude_row_name, $this->app->getHidden());

        // Fastleo variables
        $this->fastleo_model = $this->app->fastleo_model ?: [];
        $this->fastleo_columns = $this->app->fastleo_columns ?: [];

        // Table columns
        if (count($this->schema) > 0) {
            foreach ($this->schema as $column) {
                $this->columns[$column] = $this->getColumnType($column);
            }
        } else {
            die('Not exist table ' . $this->table);
        }
    }

    /**
     * @return mixed
     */
    private function getModel()
    {
        return app($this->model);
    }

    /**
     * @return mixed
     */
    private function getTable()
    {
        return $this->app->getTable();
    }

    /**
     * @return mixed
     */
    private function getColumns()
    {
        return Schema::getColumnListing($this->table);
    }

    /**
     * @param $column
     * @return mixed
     */
    private function getColumnType($column)
    {
        return Schema::getColumnType($this->table, $column);
    }

    /**
     * @return array
     */
    private function parsColumns()
    {
        foreach ($this->fastleo_columns as $k => $v) {
            // value = key
            $this->fastleo_columns[$k]['key'] = true;
            
            if (isset($v['data']) and is_string($v['data'])) {
                // data parsing
                $prs = explode(isset($this->fastleo_columns[$k]['delimiter']) ? $this->fastleo_columns[$k]['delimiter'] : ":", $v['data']);

                // create array
                if (count($prs) == 5) {
                    // Model:column_key:column_value:where:value
                    $this->fastleo_columns[$k]['data'] = app($prs[0])->where($prs[3], $prs[4])->orderBy('id')->pluck($prs[2], $prs[1])->toArray();
                } elseif (count($prs) == 4) {
                    // Model:column_value:where:value
                    $this->fastleo_columns[$k]['data'] = app($prs[0])->where($prs[2], $prs[3])->orderBy('id')->pluck($prs[1])->toArray();
                    // value = value
                    $this->fastleo_columns[$k]['key'] = null;
                } elseif (count($prs) == 3) {
                    // Model:column_key:column_value
                    $this->fastleo_columns[$k]['data'] = app($prs[0])->whereNotNull('id')->orderBy('id')->pluck($prs[2], $prs[1])->toArray();
                } else {
                    // error
                    $this->fastleo_columns[$k]['data'] = [];
                }
            }
        }

        return $this->fastleo_columns;
    }

    /**
     * Rows list
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $rows = $this->app::paginate(16);
        return view('fastleo::model', [
            'exclude_type' => $this->exclude_list_type,
            'exclude_name' => $this->exclude_list_name,
            'model_columns' => $this->columns,
            'model_title' => ucfirst($this->name),
            'model_name' => $this->name,
            'model' => $this->fastleo_model,
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
            foreach ($request->all() as $k => $v) {
                if (is_array($v)) {
                    $request->request->add([$k => implode(",", $v)]);
                }
            }
            $id = $this->app->insertGetId($request->except(['_token']));
            header('Location: /fastleo/app/' . $model . '/edit/' . $id);
            die;
        }

        // view
        return view('fastleo::model-edit', [
            'exclude_type' => $this->exclude_row_type,
            'exclude_name' => $this->exclude_row_name,
            'model_columns' => $this->columns,
            'model_title' => ucfirst($this->name),
            'model_name' => $this->name,
            'model' => $this->fastleo_model,
            'f' => $this->parsColumns(),
        ]);
    }

    /**
     * Row edit
     * @param Request $request
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
            foreach ($request->all() as $k => $v) {
                if (is_array($v)) {
                    $request->request->add([$k => implode(",", $v)]);
                }
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
            'model_columns' => $this->columns,
            'model_title' => ucfirst($this->name),
            'model_name' => $this->name,
            'model' => $this->fastleo_model,
            'row_id' => $row_id,
            'row' => $row,
            'f' => $this->parsColumns(),
        ]);
    }

    /**
     * Включение и отключение меню
     * @param Request $request
     * @param $model
     * @param $row_id
     */
    public function menu(Request $request, $model, $row_id)
    {
        $menu = 1;
        $row = $this->app::where('id', $row_id)->first();
        if ($row->menu == 1) {
            $menu = 0;
        }
        $this->app::where('id', $row_id)->update([
            'menu' => $menu
        ]);
        //return $menu;
        header('Location: /fastleo/app/' . $model . '?' . request()->getQueryString());
        die;
    }
}