@extends('layouts.be-dashboard')

@section('title')
Form Grup Modul
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Form Grup Modul' }}
@endsection

@section('header-desc')
{{ 'Form isian data grup modul' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_module_group.read', ['id_menu' => $menu_group->id_menu_group]) }}">Grup Modul</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Form Grup Modul' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Grup Modul (Grup Menu: <code>{{ $menu_group->nm_menu_group }}</code>)</h4>
                <a href="{{ route('sys_module_group.read', ['id_menu' =>  $menu_group->id_menu_group]) }}" class="btn btn-outline-secondary me-1 mb-1">Kembali</a>
            </div>
            <div class="card-content">
                <div class="card-body">
                    {{ Form::model($data, ['route' => $form_route, 'class' => 'form form-horizontal'] ) }}
                    @csrf
                    <div class="form-body">
                        {{ Form::hidden('id_menu_group', $menu_group->id_menu_group) }}
                        {{ Form::hidden('id_modul_group', null) }}
                        <div class="row">
                            <div class="col-md-4">
                                <label for="nm_modul_group">Nama Grup Modul</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('nm_modul_group', null, ['class' => 'form-control '.($errors->has('nm_modul_group') ? 'is-invalid' : ''), 'placeholder' => 'User', 'id' => 'nm_modul_group']) }}
                                    @if ($errors->has('nm_modul_group'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('nm_modul_group')) }}</div>
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
                                <label for="icon_modul_group">Icon</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('icon_modul_group', null, ['class' => 'form-control '.($errors->has('icon_modul_group') ? 'is-invalid' : ''), 'placeholder' => 'bi bi-gear', 'id' => 'icon_modul_group']) }}
                                    @if ($errors->has('icon_modul_group'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('icon_modul_group')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                {!! (new BApp)->submitBtn('Simpan') !!}
                                <a href="{{ route('sys_module_group.read', ['id_menu' =>  $menu_group->id_menu_group]) }}" class="btn btn-secondary me-1 mb-1">Batal</a>
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
