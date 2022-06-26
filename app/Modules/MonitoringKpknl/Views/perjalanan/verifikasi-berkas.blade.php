@extends('layouts.be-dashboard')

@section('title')
{{ $title }}
@endsection

@section('extra-css')
<!-- Include DatePicker CSS -->
<link rel="stylesheet" href="{{ asset('vendors/datepicker/css/datepicker.min.css') }}" />
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
        <div class="row">
            <div class="text-right">
                <a href="{{ route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan) ]) }}" class="btn btn-secondary btn-lg mb-3">Kembali</a>
            </div>
            @include('MonitoringKpknl::permohonan.detail-component')
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="pull-left">
                        <h4 class="card-title">Form Verifikasi Kelengkapan Berkas</h4>
                    </span>
                </div>
                <div class="card-body">
                    {{ Form::model($permohonan_ext, ['route' => 'perjalanan_permohonan.verifikasi-kelengkapan.read', 'class' => 'form form-horizontal'] ) }}
                        <div class="form-body">
                            {{ Form::hidden('id_permohonan', $permohonan->id_permohonan) }}
                            <div class="row">
                                @csrf
                                @foreach ($list_verifikasi_boolean as $nm_col => $desc)
                                    <div class="col-md-5 text-end">
                                        <label for="{{ $nm_col }}">{{ $desc }}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::select($nm_col, config('bobb.str_boolean.ada'), NULL, ['class' => 'form-control', 'id' => $nm_col, 'placeholder' => ':: Pilih ::']) }}
                                            @if ($errors->has($nm_col))
                                                <div class="invalid-feedback">{{ implode(' | ', $errors->get($nm_col)) }}</div>
                                                <script>(function() { document.getElementById('{{ $nm_col }}').classList.add('is-invalid')})();</script>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                @endforeach
                                <div class="col-md-5 text-end">
                                    <label for="dok_lainnya">Lainnya</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::textarea('dok_lainnya', NULL, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Dokumen ... (Ada)....']) }}
                                        @if ($errors->has('dok_lainnya'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('dok_lainnya')) }}</div>
                                            <script>(function() { document.getElementById('dok_lainnya').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <label for="sts_permohonan">Status Permohonan</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::select('sts_permohonan', $ref_sts_permohonan, NULL, ['class' => 'form-control', 'placeholder' => ':: Pilih Status Permohonan ::']) }}
                                        @if ($errors->has('sts_permohonan'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('sts_permohonan')) }}</div>
                                            <script>(function() { document.getElementById('sts_permohonan').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <label for="next_tahap">Tahap Selanjutnya</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::text('', $next_tahap->nm_tahap, ['class' => 'form-control', 'disabled' => true]) }}
                                        <small>Deadline: Sekitar {!! $help->strHighlight($help->parseDateTime($next_deadline), 'info') !!} (*deadline berubah menyesuaikan lama input data)</small>
                                    </div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <label for="is_deadline_manual">Ubah Deadline Manual?</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::select('is_deadline_manual', config('bobb.str_boolean.ya_tidak'), NULL, ['class' => 'form-control', 'placeholder' => ':: Ubah Deadline ::', 'id' => 'is_deadline_manual', 'onchange' => 'change_deadline()']) }}
                                        @if ($errors->has('is_deadline_manual'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('is_deadline_manual')) }}</div>
                                            <script>(function() { document.getElementById('is_deadline_manual').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5"></div>
                                <div class="col-md-5 deadline_manual text-end">
                                    <label for="tgl_deadline">Atur Deadline Manual</label>
                                </div>
                                <div class="col-md-3 deadline_manual">
                                    <div class="form-group">
                                        {{ Form::text('tgl_deadline', NULL, ['class' => 'form-control', 'placeholder' => 'Tanggal', 'data-datepicker' => '']) }}
                                        @if ($errors->has('tgl_deadline'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('tgl_deadline')) }}</div>
                                            <script>(function() { document.getElementById('tgl_deadline').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2 deadline_manual">
                                    <div class="form-group">
                                        {{ Form::number('jam_deadline', NULL, ['class' => 'form-control', 'placeholder' => 'Jam (format: HH)']) }}
                                    </div>
                                </div>
                                <div class="col-md-2 deadline_manual"></div>
                                <div class="col-md-5 text-end">
                                    <label for="catatan">Catatan</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::textarea('catatan', NULL, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Perubahan Deadline dikarenakan.....']) }}
                                        @if ($errors->has('catatan'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('catatan')) }}</div>
                                            <script>(function() { document.getElementById('catatan').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                @if ($allow_save)
                                    <div class="col-md-5"></div>
                                    <div class="col-md-7 mt-3">
                                        {!! (new BApp)->submitBtn('Simpan') !!}
                                        <a href="{{ route('perjalanan_permohonan.form-verifikasi-kelengkapan.read', ['id' => $permohonan->id_permohonan]) }}" class="btn btn-secondary me-1 mb-1">Batal</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('extra-js')
<!-- Include DatePicker JS -->
<script src="{{ asset('vendors/datepicker/js/datepicker.min.js') }}"></script>
<script>
    function change_deadline()
    {
        deadline_manual = document.getElementById('is_deadline_manual');
        if(deadline_manual.value == '1')
        {
            for (let el of document.querySelectorAll('.deadline_manual'))
            {
                el.style.display = 'block';
            }
        }
        else
        {
            for (let el of document.querySelectorAll('.deadline_manual'))
            {
                el.style.display = 'none';
            }
        }
    }
    change_deadline();
</script>
@endsection
