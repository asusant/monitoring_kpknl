@extends('layouts.be-dashboard')

@section('title')
{{ $title }}
@endsection

@section('extra-css')
<!-- Include Choices CSS -->
<link rel="stylesheet" href="{{ asset('vendors/choices.js/choices.min.css') }}" />
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
                    <h3 class="text-center">Form Kecukupan Tenaga Penilai</h3>
                </div>
                <div class="card-body">
                    {{ Form::model($penilai, ['route' => $route_form, 'class' => 'form form-horizontal'] ) }}
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
                                <div class="col-md-5"></div>
                                <div class="col-md-7">
                                    <div class="alert alert-info">
                                        <h4 class="alert-heading">Ketentuan Pengisian!</h4>
                                        <ol>
                                            <li>Ketua Tim Wajib Diisi</li>
                                            <li>Anggota dipilih selain ketua tim</li>
                                            <li>Total pilihan Ketua & Anggota harus ganjil</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <label for="ketua_tim">Ketua Tim</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::select('ketua_tim', $ref_penilai, NULL, ['class' => 'form-control choices', 'placeholder' => ':: Pilih Ketua ::', 'id' => 'ketua_tim']) }}
                                    </div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <label for="anggota_tim">Anggota Tim</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {{ Form::select('anggota_tim[]', $ref_penilai, NULL, ['class' => 'form-control choices multiple-remove', 'id' => 'anggota_tim', 'multiple' => 'multiple']) }}
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
<!-- Include Choices JavaScript -->
<script src="{{ asset('vendors/choices.js/choices.min.js?v=2') }}"></script>
@endsection
