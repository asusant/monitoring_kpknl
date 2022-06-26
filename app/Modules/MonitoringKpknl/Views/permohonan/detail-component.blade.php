<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span class="pull-left">
            <h4 class="card-title">{!! $help->strHighlight($permohonan->no_permohonan, 'primary') !!}</h4>
            <small><span class="bi bi-building"></span> {{ $permohonan->asal_surat }}</small>
        </span>
        <span class="pull-right">
            @if ($permohonan->sts_permohonan != 9)
                <strong>Tahap Aktif: {!! $permohonan->nm_tahap_aktif.' '.$help->strHighlight('<i class="bi bi-hourglass-split"></i> '.$help->timeLeft($now, $permohonan->deadline_tahap_aktif, ($now > $permohonan->deadline_tahap_aktif ? 'yang lalu' : 'lagi')), ($now > $permohonan->deadline_tahap_aktif ? 'danger' : 'warning') ) !!}</strong>
            @else
                {!! $help->strHighlight('Selesai', 'success') !!}
            @endif
        </span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tr>
                    <td width="15%">ND Pemohon</td>
                    <td width="1%">:</td>
                    <td width="34%"><strong>{{ $permohonan->no_surat }}</strong></td>
                    <td width="15%">KL-Eselon 1</td>
                    <td width="1%">:</td>
                    <td width="34%"><strong>{{ $permohonan->kl_eselon_1 }}</strong></td>
                </tr>
                <tr>
                    <td>Tgl. ND Pemohon</td>
                    <td>:</td>
                    <td><strong>{{ $permohonan->tgl_surat }}</strong></td>
                    <td>Satker</td>
                    <td>:</td>
                    <td><strong>{{ $permohonan->satker }}</strong></td>
                </tr>
                <tr>
                    <td>Dalam Rangka</td>
                    <td>:</td>
                    <td><strong>{{ $permohonan->dalam_rangka }}</strong></td>
                    <td>Jenis Aset</td>
                    <td>:</td>
                    <td><strong>{{ $permohonan->jns_aset }}</strong></td>
                </tr>
                <tr>
                    <td>Tindak Lanjut BMN</td>
                    <td>:</td>
                    <td><strong>{{ $permohonan->tindak_lanjut_bmn }}</strong></td>
                    <td>Jenis Objek Penilaian</td>
                    <td>:</td>
                    <td><strong>{{ $permohonan->jns_obj_penilaian }}</strong></td>
                </tr>
                <tr>
                    <td>Indikasi Nilai</td>
                    <td>:</td>
                    <td><strong>{{ $help->formatNumber($permohonan->indikasi_nilai) }}</strong></td>
                    <td>Deskripsi Objek Penilaian</td>
                    <td>:</td>
                    <td><strong>{{ $permohonan->desc_obj_penilaian }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
</div>
