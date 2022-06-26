@extends('layouts.be-dashboard')

@section('title')
Form Grup Menu
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Form Grup Menu' }}
@endsection

@section('header-desc')
{{ 'Form isian data grup menu' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_menu_group.read') }}">Grup Menu</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Form Grup Menu' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Grup Menu</h4>
                <a href="{{ route('sys_menu_group.read') }}" class="btn btn-outline-secondary me-1 mb-1">Kembali</a>
            </div>
            <div class="card-content">
                <div class="card-body">
                    {{ Form::model($data, ['route' => $form_route, 'class' => 'form form-horizontal'] ) }}
                    @csrf
                    <div class="form-body">
                        {{ Form::hidden('id_menu_group', null) }}
                        <div class="row">
                            <div class="col-md-4">
                                <label for="nm_role">Nama Grup Menu</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('nm_menu_group', null, ['class' => 'form-control '.($errors->has('nm_menu_group') ? 'is-invalid' : ''), 'placeholder' => 'Data Referensi', 'id' => 'nm_menu_group']) }}
                                    @if ($errors->has('nm_menu_group'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('nm_menu_group')) }}</div>
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
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                {!! (new BApp)->submitBtn('Simpan') !!}
                                <a href="{{ route('sys_menu_group.read') }}" class="btn btn-secondary me-1 mb-1">Batal</a>
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
