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
                <div class="card-header text-center">
                    <h3 class="text-center">{{ $title }}</h3>
                </div>
                <div class="card-body">
                    {{ Form::model($permohonan_ext, ['route' => 'perjalanan_permohonan.konfirmasi.read', 'class' => 'form form-horizontal'] ) }}
                        <div class="form-body">
                            {{ Form::hidden('id_permohonan', $permohonan->id_permohonan) }}
                            <div class="row">
                                @csrf
                                <div class="col-md-5 text-end">
                                    <label>Tahap</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::text('', $permohonan->nm_tahap_aktif, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <label for="is_nd_st_penilai_jadi">Konfirmasi ND Surat Tugas Tim Penilai</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::select('is_nd_st_penilai_jadi', config('bobb.str_boolean.sudah'), NULL, ['class' => 'form-control', 'id' => 'is_nd_st_penilai_jadi', 'placeholder' => ':: Status ::']) }}
                                        @if ($errors->has('is_nd_st_penilai_jadi'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('is_nd_st_penilai_jadi')) }}</div>
                                            <script>(function() { document.getElementById('is_nd_st_penilai_jadi').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <label for="is_nd_survey_jadi">Konfirmasi ND Survey Lapangan</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::select('is_nd_survey_jadi', config('bobb.str_boolean.sudah'), NULL, ['class' => 'form-control', 'id' => 'is_nd_survey_jadi', 'placeholder' => ':: Status ::']) }}
                                        @if ($errors->has('is_nd_survey_jadi'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('is_nd_survey_jadi')) }}</div>
                                            <script>(function() { document.getElementById('is_nd_survey_jadi').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                @include('MonitoringKpknl::perjalanan.components.deadline-form')
                                <div class="col-md-5"></div>
                                <div class="col-md-7 mt-3">
                                    @if ($allow_save)
                                    {!! (new BApp)->submitBtn('Simpan') !!}
                                    @endif
                                    <a href="{{ route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]) }}" class="btn btn-secondary me-1 mb-1">Batal/Kembali</a>
                                </div>
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
@endsection
