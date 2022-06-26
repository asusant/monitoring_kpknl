<?php

namespace App\Modules\MonitoringKpkNl\Controllers;

use App\Models\SysRole;
use App\Modules\Bobb\Controllers\BaseController;
use App\Modules\MonitoringKpkNl\Models\TahapMonitoring;
use Symfony\Component\HttpFoundation\Request;

class TahapMonitoringController extends BaseController
{
    public $title = 'Tahapan Monitoring';
    public $subtitle = 'Manajemen data Tahapam Monitoring Permohonan';
    public $base_route = 'tahap_monitoring';
    public $table_columns = [
        // {DB_Column} => {Table_Title}
        'urutan_tahap'      => 'Urutan',
        'nm_tahap'          => 'Tahap',
        'jns_tahap'         => 'Jenis',
        'deadline'          => 'Deadline',
        'role_tahap'        => 'Pelaksana',
        'is_aktif'          => 'Status'
    ];
    public $dt_order = ['urutan_tahap', 'ASC'];
    public $add_header_right = '';
    public $use_pagination = true;
    public $pagination_limit = 25;
    public $boolean_column = ['is_aktif'];
    public $boolean_key = 'aktif';

    public function __construct()
    {
        parent::__construct();
        $this->model = new TahapMonitoring();

        $this->data_method = ['getData', [$this->pagination_limit]];

        $this->form = [
            'nm_tahap'  => [
                'Tahap',
                [
                    ['Form', 'text'],
                    ['nm_tahap', NULL, ['class' => 'form-control', 'id' => 'nm_tahap', 'placeholder' => 'Menerima Permohonan Penilaian dari .....']]
                ]
            ],
            'deadline_hari' => [
                'Deadline (Hari)',
                [
                    ['Form', 'number'],
                    ['deadline_hari', NULL, ['class' => 'form-control', 'id' => 'deadline_hari', 'placeholder' => '1']]
                ]
            ],
            'deadline_jam' => [
                'Deadline (Jam)',
                [
                    ['Form', 'number'],
                    ['deadline_jam', NULL, ['class' => 'form-control', 'id' => 'deadline_jam', 'placeholder' => '14']]
                ]
            ],
            'urutan_tahap' => [
                'Urutan',
                [
                    ['Form', 'number'],
                    ['urutan_tahap', NULL, ['class' => 'form-control', 'id' => 'urutan_tahap', 'placeholder' => '2']]
                ]
            ],
            'jns_tahap' => [
                'Jenis Tahapan',
                [
                    ['Form', 'select'],
                    ['jns_tahap', $this->model->ref_jns_tahap, NULL, ['class' => 'form-control', 'id' => 'jns_tahap', 'placeholder' => ':: Pilih Jenis Tahapan ::']]
                ]
            ],
            'ext_form_route' => [
                'Routing (jika memilih Form/Cetak)',
                [
                    ['Form', 'text'],
                    ['ext_form_route', NULL, ['class' => 'form-control', 'id' => 'ext_form_route', 'placeholder' => 'cetak-dokumen.read']]
                ]
            ],
            'id_role_tahap' => [
                'Pelaksana',
                [
                    ['Form', 'select'],
                    ['id_role_tahap', SysRole::pluck('nm_role', 'id_role')->toArray(), NULL, ['class' => 'form-control', 'id' => 'id_role_tahap', 'placeholder' => ':: Pilih Pelaksana Aktifitas ::']]
                ]
            ],
            'is_aktif'  => [
                'Status',
                [
                    ['Form', 'select'],
                    ['is_aktif', config('bobb.str_boolean.aktif'), NULL, ['class' => 'form-control', 'id' => 'nip_tim_penilaian']]
                ]
            ]
        ];
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
        return view('MonitoringKpknl::tahap_monitoring.index', $data);
    }
}
