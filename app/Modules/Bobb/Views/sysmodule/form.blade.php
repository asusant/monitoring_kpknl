@extends('layouts.be-dashboard')

@section('title')
Form Modul
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Form Modul' }}
@endsection

@section('header-desc')
{{ 'Form isian data modul' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_menu_group.read') }}">Grup Menu</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_module_group.read', ['id_menu' => $modul_group->id_menu_group]) }}">Grup Modul</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Form Modul' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Modul (Grup Modul: <code>{{ $modul_group->nm_modul_group }}</code>)</h4>
                <a href="{{ route('sys_module.read', ['id_modul' =>  $modul_group->id_modul_group]) }}" class="btn btn-outline-secondary me-1 mb-1">Kembali</a>
            </div>
            <div class="card-content">
                <div class="card-body">
                    {{ Form::model($data, ['route' => $form_route, 'class' => 'form form-horizontal'] ) }}
                    @csrf
                    <div class="form-body">
                        {{ Form::hidden('id_modul_group', $modul_group->id_modul_group) }}
                        {{ Form::hidden('id_modul', null) }}
                        <div class="row">
                            <div class="col-md-4">
                                <label for="nm_modul">Nama Modul</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('nm_modul', null, ['class' => 'form-control '.($errors->has('nm_modul') ? 'is-invalid' : ''), 'placeholder' => 'User Management', 'id' => 'nm_modul']) }}
                                    @if ($errors->has('nm_modul'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('nm_modul')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="ket_role">Urutan</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::number('urutan', null, ['class' => 'form-control '.($errors->has('urutan') ? 'is-invalid' : ''), 'placeholder' => '1', 'id' => 'urutan']) }}
                                    @if ($errors->has('urutan'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('urutan')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="route_prefix">Route Prefix</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('route_prefix', null, ['class' => 'form-control '.($errors->has('route_prefix') ? 'is-invalid' : ''), 'placeholder' => 'user_management', 'id' => 'route_prefix']) }}
                                    @if ($errors->has('route_prefix'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('route_prefix')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="is_tampil">Tampil</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::select('is_tampil', ['1' => 'Tampil', '0' => 'Tidak'], null, ['class' => 'form-select '.($errors->has('is_tampil') ? 'is-invalid' : ''), 'id' => 'urutan']) }}
                                    @if ($errors->has('is_tampil'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('is_tampil')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                {!! (new BApp)->submitBtn('Simpan') !!}
                                <a href="{{ route('sys_module.read', ['id_modul' =>  $modul_group->id_modul_group]) }}" class="btn btn-secondary me-1 mb-1">Batal</a>
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
