<?php

namespace App\Modules\Bobb\Controllers;

use App\Bobb\Libs\BApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Bobb\Helpers\Helper as Help;

class BaseController extends Controller
{
    // Model database
    public $model; // {SysUserRole}
    public $title = ''; // Judul Halaman {Role User}
    public $subtitle = ''; // Subtitle Halaman {Manajemen Role untuk user}
    public $breadcrumbs = [
        // {'Dashboard' => route('dashboard.read')} tanpa dashboard & menu aktif
    ];
    public $add_title = ''; // Title tambahan jika diperlukan ex. terdapat referensi {(User: <code>$nm_user</code>)}
    public $base_route = ''; // Base route name untuk CRUD {sys_user_role}
    public $route_params = []; // Jika membutuhkan route param {'id_user' => $id, 'name' => $nm}
    public $table_columns = [ // Untuk view table, key adalah kolom di DB, value adalah nama kolom di tabel
        // {DB_Column} => {Table_Title}
    ];
    public $dt_order = [];
    public $use_validate = false; // Jika memerlukan validasi data
    public $form = [
        // {Nama Kolom}  => { STRING || Object Form Collective dengen format `forward_static_call_array` => [ [Form, formType], [params] ] }
    ]; // Form data
    public $data_method = []; // Custom method untuk get data [ [namaFungsi], [parameter1, parameter2, dst] ] -- PAGINATION HARUS MENYESUAIKAN
    public $add_header_right = ''; // Untuk menambah object di sebelah tombol tambah data
    public $use_pagination = false; // Gunakan Pagination
    public $pagination_limit = 25; // Limit pagination
    public $boolean_column = []; // Menampilkan Ya/Tidak | Aktif/Tidak Aktif, dst.. untuk boolean value
    public $boolean_key = 'ya_tidak'; // Key boolean yg digunakan --> config(bobb.str_boolean)
    public $help =  null;
    public $use_datatable = true;

    public $data = [];

    public function __construct()
    {
        $this->breadcrumbs = [
            'Dashboard' => route('dashboard.read')
        ];

        $this->help = (new Help());

        // Hanya dimasukkan data yang akan digunakan di semua view
        $dt_to_view = ['title', 'subtitle', 'breadcrumbs', 'add_title', 'base_route', 'route_params', 'add_header_right', 'boolean_column', 'boolean_key', 'pagination_limit', 'use_pagination', 'use_datatable'];

        foreach ($dt_to_view as $v)
        {
            $this->data[$v] = $this->{$v};
        }
    }

    /**
     * Index / tampil data
     */
    public function index()
    {
        // default data
        $data = $this->data;
        // tambahan data yang digunakan di view
        $data['table_columns'] = $this->table_columns;
        $data['use_validate'] = $this->use_validate;
        $data['model'] = $this->model;
        // main data
        if(is_array($this->data_method) && sizeof($this->data_method) == 2)
        {
            $data['data'] = call_user_func_array(array($this->model, $this->data_method[0]), $this->data_method[1]);
        }
        else
        {
            $q = $this->model->orderBy($this->dt_order[0], $this->dt_order[1]);
            if($this->use_pagination)
            {
                $data['data'] = $q->paginate($this->pagination_limit);
            }
            else
            {
                $data['data'] = $q->get();
            }
        }
        return view('Bobb::base.index', $data);
    }

    /**
     * Form Create Data
     */
    public function create()
    {
        // default data
        $data = $this->data;
        // tambahan data yang digunakan di view
        $data['model'] = $this->model;
        $data['form'] = $this->form;
        $data['form_route'] = [$data['base_route'].'.store', $data['route_params']];
        $data['data'] = [];
        return view('Bobb::base.form', $data);
    }

    /**
     * Store Data
     */
    public function store(Request $req)
    {
        $this->validate($req, $this->model->validation_data());

        $dt = $this->model;
		foreach ($dt->validation_data() as $col => $rule)
		{
            $dt->{$col} = $req->input($col);
		}
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        BApp::log('Menambah data '.$this->title.'. id='.$dt->{$dt->getPrimaryKey()}.'.', $req->except('_token'));
        return redirect(route($this->base_route.'.read', $this->route_params))->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    /**
     * Form Edit Data
     */
    public function edit($id)
    {
        // default data
        $data = $this->data;
        // tambahan data yang digunakan di view
        $data['model'] = $this->model;
        $data['form'] = $this->form;
        $data['form_route'] = [$data['base_route'].'.update', $data['route_params']];
        $data['data'] = $this->model->findOrFail($id);
        return view('Bobb::base.form', $data);
    }

    /**
     * Update Form
     */
    public function update(Request $req)
    {
        $this->validate($req, $this->model->validation_data($req->input($this->model->getPrimaryKey())));

        $dt = $this->model->findOrFail($req->input($this->model->getPrimaryKey()));
		foreach ($dt->validation_data($req->input($this->model->getPrimaryKey())) as $col => $rule)
		{
			if($req->input($col) != '')
            {
                $dt->{$col} = $req->input($col);
            }
		}
        $dt->updated_by = Auth::user()->id_user;

        BApp::log('Mengubah data '.$this->title.'. id='.$dt->{$this->model->getPrimaryKey()}.'.', $dt->getOriginal(), $req->except('_token'));
        $dt->save();
        return redirect(route($this->base_route.'.read', $this->route_params))->with('alert', ['success', 'Data berhasil diubah!']);
    }

    /**
     * Delete Data
     */
    public function delete($id)
    {
        $dt = $this->model->findOrFail($id);
        BApp::log('Menghapus data '.$this->title.'. id='.$dt->{$this->model->getPrimaryKey()}.'.', $dt->getAttributes());
        $dt->deleted_by = Auth::user()->id_user;
        $dt->save();
        $dt->delete();

        return redirect()->back()->with('alert', ['success', 'Data berhasil dihapus!']);
    }
}
