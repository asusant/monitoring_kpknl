<?php

return [
    'map_privileges'    => array(
        'read' 		=> ['index','view','read'],
        'create' 	=> ['create','insert','store'],
		'update'	=> ['edit','update'],
		'delete'	=> ['delete','hapus'],
        'validate'	=> ['validate']
    ),
    'ref_bulan'	=> array(
        1=>'Januari',
        2=>'Februari',
        3=>'Maret',
        4=>'April',
        5=>'Mei',
        6=>'Juni',
        7=>'Juli',
        8=>'Agustus',
        9=>'September',
        10=>'Oktober',
        11=>'November',
        12=>'Desember'
    ),
    'ref_bulan_singkat'	=> array(
            1=>'Jan',
            2=>'Feb',
            3=>'Mar',
            4=>'Apr',
            5=>'Mei',
            6=>'Jun',
            7=>'Jul',
            8=>'Ags',
            9=>'Sep',
            10=>'Okt',
            11=>'Nov',
            12=>'Des'
    ),
    'hari'	        => array('Sun'=>'Minggu','Mon'=>'Senin','Tue'=>'Selasa','Wed'=>'Rabu','Thu'=>'Kamis','Fri'=>'Jumat','Sat'=>'Sabtu'),
    'hari_2'	    => array('1'=>'Senin','2'=>'Selasa','3'=>'Rabu','4'=>'Kamis','5'=>'Jumat','6'=>'Sabtu','7'=>'Minggu'),
    'tahun'         => 2021,
    'sts_valid' => [
        0   => 'Ajuan',
        1   => 'Valid',
        2   => 'Ditolak'
    ],
    'class_valid'   => [
        0   => 'warning',
        1   => 'success',
        2   => 'danger'
    ],
    'str_boolean'   => [
        'ya_tidak'  => [
            0   => 'Tidak',
            1   => 'Ya'
        ],
        'aktif'     => [
            0   => 'Tidak Aktif',
            1   => 'Aktif'
        ],
        'sudah'     => [
            0   => 'Belum',
            1   => 'Sudah'
        ],
        'valid'     => [
            0   => 'Tidak Valid',
            1   => 'Valid'
        ]
    ],
    'class_boolean' => [
        0   => 'danger',
        1   => 'success'
    ],
];
