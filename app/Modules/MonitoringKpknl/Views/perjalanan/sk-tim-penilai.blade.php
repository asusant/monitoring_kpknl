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
                    {{ Form::model($permohonan_ext, ['route' => $route_form, 'class' => 'form form-horizontal'] ) }}
                        <div class="form-body">
                            {{ Form::hidden('id_permohonan', $permohonan->id_permohonan) }}
                            <div class="row">
                                @csrf
                                @if (!$only_data)
                                <div class="col-md-5 text-end">
                                    <label>Tahap</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::text('', $permohonan->nm_tahap_aktif, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-5 text-end">
                                    <label for="no_sk_tim_penilai">Nomor Surat Tugas</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::text('no_sk_tim_penilai', NULL, ['class' => 'form-control', 'id' => 'no_sk_tim_penilai', 'placeholder' => 'Nomor ST SK Tim Penilai']) }}
                                        @if ($errors->has('no_sk_tim_penilai'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('no_sk_tim_penilai')) }}</div>
                                            <script>(function() { document.getElementById('no_sk_tim_penilai').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <label for="tgl_sk_tim_penilai">Tanggal Surat Tugas</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::text('tgl_sk_tim_penilai', NULL, ['class' => 'form-control', 'id' => 'tgl_sk_tim_penilai', 'placeholder' => 'Tanggal ST SK Tim Penilai', 'data-datepicker' => '']) }}
                                        @if ($errors->has('tgl_sk_tim_penilai'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('tgl_sk_tim_penilai')) }}</div>
                                            <script>(function() { document.getElementById('tgl_sk_tim_penilai').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <label for="hal_sk_tim_penilai">Perihal Surat Tugas</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::text('hal_sk_tim_penilai', NULL, ['class' => 'form-control', 'id' => 'hal_sk_tim_penilai', 'placeholder' => 'Perihal ST SK Tim Penilai']) }}
                                        @if ($errors->has('hal_sk_tim_penilai'))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get('hal_sk_tim_penilai')) }}</div>
                                            <script>(function() { document.getElementById('hal_sk_tim_penilai').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                                @if (!$only_data)
                                @include('MonitoringKpknl::perjalanan.components.deadline-form')
                                @endif
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
@if ($only_data)
<script src="{{ asset('vendors/datepicker/js/datepicker.min.js') }}"></script>
@endif
@endsection
