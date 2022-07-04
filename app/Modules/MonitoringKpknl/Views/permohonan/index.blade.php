@extends('layouts.be-dashboard')

@section('title')
{{ $title }}
@endsection

@section('extra-css')
@if (isset($use_datatable) && $use_datatable)
<link rel="stylesheet" href="{{ asset('vendors/simple-datatables/style.css') }}">
@endif
@endsection

@section('header-title')
{{ $title }}
@endsection

@section('header-desc')
{!! $subtitle !!}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $nmB => $url)
        <li class="breadcrumb-item"><a href="{{ $url }}">{{ $nmB }}</a></li>
        @endforeach
        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">List {{ $title }} {!! $add_title !!}</h4>
                <span class="pull-right">
                    {!! $add_header_right !!}
                    @if (config('bobb.akses')['a_create'] == 1)
                    <a href="{{ route($base_route.'.create', $route_params) }}" class="btn btn-outline-primary">Input Permohonan Baru</a>
                    @endif
                </span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover datatable">
                            <thead>
                                <tr>
                                    <th>No. Permohonan</th>
                                    <th>Surat</th>
                                    <th>Objek</th>
                                    <th>Penilaian</th>
                                    <th>Tahapan Sebelumnya</th>
                                    <th>Tahapan Berlangsung</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($data) > 0)
                                    @php $now = date('Y-m-d H:i:s'); @endphp
                                    @foreach ($data as $r)
                                        <tr class="{{ ( $now > $r->deadline_tahap_aktif && $r->sts_permohonan != 9 ? 'bg-danger text-white' : '' ) }}">
                                            <td>{{ link_to(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($r->no_permohonan) ]), $r->no_permohonan, ['class' => 'text-nowrap']) }}<br>Status: {!! $help->strHighlight($model->ref_sts_permohonan[$r->sts_permohonan], $model->class_sts_permohonan[$r->sts_permohonan]) !!}</td>
                                            {{-- <td>Asal: {!! $help->strHighlight($r->asal_surat, 'primary') !!}<br>No: {!! $help->strHighlight($r->no_surat, 'info') !!}<br>Tgl: {!! $help->strHighlight($help->parseDate($r->tgl_surat), 'warning') !!}</td> --}}
                                            <td>Asal: <strong>{{ $r->asal_surat }}</strong><br>No: <strong>{{ $r->no_surat }}</strong><br>Tgl: <strong>{{ $help->parseDate($r->tgl_surat) }}</strong></td>
                                            {{-- <td>Pemilik: {!! $help->strHighlight($r->pemilik_obj_penilaian, 'primary') !!}<br>Jenis: {!! $help->strHighlight($r->jns_obj_penilaian, 'info') !!}<br>Indikasi Nilai: {!! $help->strHighlight("Rp ".$help->formatNumber($r->indikasi_nilai), 'success') !!}</td> --}}
                                            <td>Pemilik: {!! $help->strHighlight($r->pemilik_obj_penilaian, 'primary') !!}<br>Jenis: <strong>{{ $r->jns_obj_penilaian }}</strong><br>Indikasi Nilai: {!! $help->strHighlight("Rp ".$help->formatNumber($r->indikasi_nilai), 'success') !!}</td>
                                            <td>
                                                Ketua Tim: <strong>{{ $r->ketua_tim }}</strong><br>
                                                Jadwal Survey: <strong>{{ $help->parseDate($r->jadwal_survey) }}</strong>
                                            </td>
                                            <td><span class="bi bi-bookmark-fill"></span> {{ $r->nm_tahapan_sebelum }}<br>{!! $help->strHighlight('<i class="bi bi-check-all"></i> '.$help->parseDateTime($r->proses_tahap_sebelum), 'success') !!}</td>
                                            <td>
                                                @if ($r->sts_permohonan != '9')
                                                    <span class="bi bi-stopwatch-fill"></span> {{ $r->nm_tahapan_aktif }}<br>{!! $help->strHighlight('<i class="bi bi-hourglass-split"></i> '.$help->timeLeft($now, $r->deadline_tahap_aktif), ( $now > $r->deadline_tahap_aktif ? 'danger' : 'warning' )) !!}
                                                @else
                                                    {!! $help->strHighlight('<span class="bi bi-check-all"></span> Selesai', 'success') !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($max_tahap > $r->id_tahap_aktif)
                                                    {{-- Cek boleh akses? --}}
                                                    {{ link_to(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($r->no_permohonan) ]), 'Perjalanan', ['class' => 'btn btn-info btn-sm']) }}
                                                @endif
                                                @if ($r->id_tahap_aktif <= 2 && !in_array($r->sts_permohonan, [4,9]))
                                                    {!! (new BApp)->btnAkses($base_route, $r->{$model->getPrimaryKey()}, (!$use_validate ? ['validate'] : []), 'btn-sm') !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center"><i>Belum ada data.</i></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        @if ($use_pagination)
                            {{ $data->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('extra-js')
@if (isset($use_datatable) && $use_datatable)
<script src="{{ asset('vendors/simple-datatables/simple-datatables.js') }}"></script>
<script>
    // Simple Datatable
    var tables = [].slice.call(document.querySelectorAll('.datatable'))
    var dataTableList = tables.map(function (el) {
        return new simpleDatatables.DataTable(el);
    });
</script>
@endif
@endsection
