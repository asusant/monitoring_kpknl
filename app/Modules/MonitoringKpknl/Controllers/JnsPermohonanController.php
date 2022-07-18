<?php

namespace App\Modules\MonitoringKpkNl\Controllers;

use App\Modules\Bobb\Controllers\BaseController;
use App\Modules\MonitoringKpkNl\Models\JnsPermohonan;

class JnsPermohonanController extends BaseController
{
    public $title = 'Data jenis Permohonan';
    public $subtitle = 'Manajemen data Jenis Permohonan';
    public $base_route = 'jns_permohonan';
    public $table_columns = [
        // {DB_Column} => {Table_Title}
        'nm_jns_permohonan'     => 'Jenis Permohonan',
        'is_khusus'             => 'Jenis Khusus?',
        'is_aktif'              => 'Aktif?',
    ];
    public $dt_order = ['nm_jns_permohonan', 'ASC'];
    public $add_header_right = '';
    public $use_pagination = false;
    public $pagination_limit = 10;
    public $boolean_column = ['is_aktif','is_khusus'];
    public $boolean_key = 'ya_tidak';

    public function __construct()
    {
        parent::__construct();
        $this->model = new JnsPermohonan();

        // $this->data_method = ['getData', [$this->pagination_limit]];

        $this->form = [
            'nm_jns_permohonan'  => [
                'Jenis Permohonan',
                [
                    ['Form', 'text'],
                    ['nm_jns_permohonan', NULL, ['class' => 'form-control', 'id' => 'nm_jns_permohonan', 'placeholder' => 'KSP']]
                ]
            ],
            'is_khusus'  => [
                'Permohonan Khusus?',
                [
                    ['Form', 'select'],
                    ['is_khusus', config('bobb.str_boolean.ya_tidak'), NULL, ['class' => 'form-control', 'id' => 'is_khusus']]
                ]
            ],
            'is_aktif'  => [
                'Aktif?',
                [
                    ['Form', 'select'],
                    ['is_aktif', config('bobb.str_boolean.ya_tidak'), NULL, ['class' => 'form-control', 'id' => 'is_aktif']]
                ]
            ]
        ];
    }
}
