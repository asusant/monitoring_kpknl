@extends('layouts.be-dashboard')

@section('title')
Pengaturan Aplikasi
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Pengaturan Aplikasi' }}
@endsection

@section('header-desc')
{{ 'Mengatur variabel-variabel terkait aplikasi' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Pengaturan Aplikasi' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">List Data</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="{{ route('app_setting.update') }}" method="POST">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    @foreach ($data as $row)
                                    <div class="col-md-4">
                                        <label><code>{{ $row->key }}</code></label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control" name="{{ 'content['.$row->id_app_setting.']' }}" placeholder="{{ 'Isi Setting' }}" value="{{ $row->content }}">
                                    </div>
                                    @endforeach
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        {!! (new BApp)->submitBtn('Update') !!}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Data</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('app_setting.create') }}">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Key</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">
                                                <input type="text" class="form-control @if ($errors->has('key')) is-invalid @endif" placeholder="app_logo" name="key" value="{{ old('key') }}">
                                                <div class="form-control-icon">
                                                    <i class="bi bi-key"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Content</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">
                                                <input type="text" class="form-control @if ($errors->has('content')) is-invalid @endif" placeholder="images/logo.png" name="content" value="{{ old('content') }}">
                                                <div class="form-control-icon">
                                                    <i class="bi bi-card-text"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        {!! (new BApp)->submitBtn('Tambah') !!}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
