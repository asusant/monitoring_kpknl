@extends('layouts.be-dashboard')

@section('title')
Form Role User
@endsection

@section('extra-css')
<!-- Include Choices CSS -->
<link rel="stylesheet" href="{{ asset('vendors/choices.js/choices.min.css') }}" />
@endsection

@section('header-title')
{{ 'Form Role User' }}
@endsection

@section('header-desc')
{{ 'Form isian data Role User' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_user.read') }}">User</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_user_role.read', ['id_user' => $user->id_user]) }}">Grup Modul</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Form Role User' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Role User (User: <code>{{ $user->nm_user }}</code>)</h4>
                <a href="{{ route('sys_user_role.read', ['id_user' =>  $user->id_user]) }}" class="btn btn-outline-secondary me-1 mb-1">Kembali</a>
            </div>
            <div class="card-content">
                <div class="card-body">
                    {{ Form::model($data, ['route' => $form_route, 'class' => 'form form-horizontal'] ) }}
                    @csrf
                    <div class="form-body">
                        {{ Form::hidden('id_user', $user->id_user) }}
                        {{ Form::hidden('id_user_role', null) }}
                        <div class="row">
                            <div class="col-md-4">
                                <label>User</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::text('', $user->nm_user.' ('.$user->identitas_user.')', ['class' => 'form-control', 'disabled' => 'true']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="id_role">Role</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::select('id_role', $ref_role, null, ['class' => 'form-select choices '.($errors->has('id_role') ? 'is-invalid' : ''), 'id' => 'urutan']) }}
                                    @if ($errors->has('id_role'))
                                        <div class="invalid-feedback">{{ implode(' | ', $errors->get('id_role')) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                {!! (new BApp)->submitBtn('Simpan') !!}
                                <a href="{{ route('sys_user_role.read', ['id_user' =>  $user->id_user]) }}" class="btn btn-secondary me-1 mb-1">Batal</a>
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
<script src="{{ asset('vendors/choices.js/choices.min.js') }}"></script>
@endsection
