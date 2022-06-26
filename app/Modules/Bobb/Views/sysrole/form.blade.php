@extends('layouts.be-dashboard')

@section('title')
Form Role User
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Form Role User' }}
@endsection

@section('header-desc')
{{ 'Form isian data role user' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_role.read') }}">Role User</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Form Role User' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Role User</h4>
                <a href="{{ route('sys_role.read') }}" class="btn btn-outline-secondary me-1 mb-1">Kembali</a>
            </div>
            <div class="card-content">
                <div class="card-body">
                    {{ Form::model($data, ['route' => $form_route, 'class' => 'form form-horizontal'] ) }}
                    @csrf
                    <div class="form-body">
                        {{ Form::hidden('id_role', null) }}
                        <div class="row">
                            <div class="col-md-4">
                                <label for="nm_role">Nama Role</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('nm_role', null, ['class' => 'form-control '.($errors->has('nm_role') ? 'is-invalid' : ''), 'placeholder' => 'Operator', 'id' => 'nm_role']) }}
                                    @if ($errors->has('nm_role'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('nm_role')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="ket_role">Deskripsi/Keterangan</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('ket_role', null, ['class' => 'form-control '.($errors->has('ket_role') ? 'is-invalid' : ''), 'placeholder' => 'Untuk operator aplikasi', 'id' => 'ket_role']) }}
                                    @if ($errors->has('ket_role'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('ket_role')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                {!! (new BApp)->submitBtn('Simpan') !!}
                                <a href="{{ route('sys_role.read') }}" class="btn btn-secondary me-1 mb-1">Batal</a>
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
