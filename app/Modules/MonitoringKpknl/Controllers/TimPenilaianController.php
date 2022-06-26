<?php

namespace App\Modules\MonitoringKpkNl\Controllers;

use App\Models\SysUser;
use App\Modules\Bobb\Controllers\BaseController;
use App\Modules\MonitoringKpkNl\Models\TimPenilaian;
use Illuminate\Support\Facades\DB;

class TimPenilaianController extends BaseController
{
    public $title = 'Data Tim Penilai';
    public $subtitle = 'Manajemen data Tim Penilai Permohonan';
    public $base_route = 'tim_penilaian';
    public $table_columns = [
        // {DB_Column} => {Table_Title}
        'urutan_tim_penilaian'  => 'Urutan',
        'nm_tim_penilaian'      => 'Nama',
        'nip_tim_penilaian'     => 'NIP',
        'user_tim_penilaian'    => 'User',
        'is_aktif'              => 'Status'
    ];
    public $dt_order = ['urutan_tim_penilaian', 'ASC'];
    public $add_header_right = '';
    public $use_pagination = true;
    public $pagination_limit = 10;
    public $boolean_column = ['is_aktif'];
    public $boolean_key = 'aktif';

    public function __construct()
    {
        parent::__construct();
        $this->model = new TimPenilaian();

        $this->data_method = ['getData', [$this->pagination_limit]];

        $this->form = [
            'nm_tim_penilaian'  => [
                'Nama',
                [
                    ['Form', 'text'],
                    ['nm_tim_penilaian', NULL, ['class' => 'form-control', 'id' => 'nm_tim_penilaian', 'placeholder' => 'John Doe']]
                ]
            ],
            'nip_tim_penilaian' => [
                'NIP',
                [
                    ['Form', 'text'],
                    ['nip_tim_penilaian', NULL, ['class' => 'form-control', 'id' => 'nip_tim_penilaian', 'placeholder' => '1992338xxxx']]
                ]
            ],
            'urutan_tim_penilaian' => [
                'Urutan',
                [
                    ['Form', 'number'],
                    ['urutan_tim_penilaian', NULL, ['class' => 'form-control', 'id' => 'urutan_tim_penilaian', 'placeholder' => '2']]
                ]
            ],
            'id_user_tim_penilaian' => [
                'User',
                [
                    ['Form', 'select'],
                    ['id_user_tim_penilaian', SysUser::where('is_aktif', 1)->get([DB::raw('CONCAT(nm_user, " (", email_user, ")") as nm_user'), 'id_user'])->pluck('nm_user', 'id_user')->toArray(), NULL, ['class' => 'form-control choices', 'id' => 'nip_tim_penilaian', 'placeholder' => ':: Pilih User ::']]
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
}
