@extends('layouts.be-dashboard')

@section('title')
Form User
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Form User' }}
@endsection

@section('header-desc')
{{ 'Form isian data user' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_user.read') }}">User</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Form User' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Form Data User</h4>
                <a href="{{ route('sys_user.read') }}" class="btn btn-outline-secondary me-1 mb-1">Kembali</a>
            </div>
            <div class="card-content">
                <div class="card-body">
                    {{ Form::model($data, ['route' => $form_route, 'class' => 'form form-horizontal'] ) }}
                    @csrf
                    <div class="form-body">
                        {{ Form::hidden('id_user', null) }}
                        <div class="row">
                            <div class="col-md-4">
                                <label for="nm_user">Nama User</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('nm_user', null, ['class' => 'form-control '.($errors->has('nm_user') ? 'is-invalid' : ''), 'placeholder' => 'Bambang', 'id' => 'nm_user']) }}
                                    @if ($errors->has('nm_user'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('nm_user')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="email_user">Email</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::email('email_user', null, ['class' => 'form-control '.($errors->has('email_user') ? 'is-invalid' : ''), 'placeholder' => 'bambang@gmail.com', 'id' => 'email_user']) }}
                                    @if ($errors->has('email_user'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('email_user')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="username_user">Username</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::email('username_user', null, ['class' => 'form-control '.($errors->has('username_user') ? 'is-invalid' : ''), 'placeholder' => 'bambang007', 'id' => 'username_user']) }}
                                    @if ($errors->has('username_user'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('username_user')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="password_user">Password</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::password('password_user', ['class' => 'form-control '.($errors->has('password_user') ? 'is-invalid' : ''), 'placeholder' => '******', 'id' => 'password_user']) }}
                                    @if ($errors->has('password_user'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('password_user')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="identitas_user">No. Identitas (NIP)</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('identitas_user', null, ['class' => 'form-control '.($errors->has('identitas_user') ? 'is-invalid' : ''), 'placeholder' => '198xxxxx', 'id' => 'identitas_user']) }}
                                    @if ($errors->has('identitas_user'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('identitas_user')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="is_aktif">Aktif?</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::select('is_aktif', ['1' => 'Ya', '0' => 'Tidak'], null, ['class' => 'form-select '.($errors->has('is_aktif') ? 'is-invalid' : ''), 'id' => 'urutan']) }}
                                    @if ($errors->has('is_aktif'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('is_aktif')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6"></div>
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
