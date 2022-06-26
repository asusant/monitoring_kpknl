@extends('layouts.be-dashboard')

@section('title')
Role User
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Role User' }}
@endsection

@section('header-desc')
{{ 'Manajemen role user' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Role User' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">List Data</h4>
                <span class="pull-right">
                    <a href="{{ route('sys_role.create') }}" class="btn btn-outline-primary">Tambah Role</a>
                </span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td width="5%">#</td>
                                    <td>Nama Role</td>
                                    <td>Deskripsi</td>
                                    <td width="15%">Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $n = 1;
                                @endphp
                                @foreach ($data as $r)
                                    <tr>
                                        <td>{{ $n++ }}</td>
                                        <td>{{ $r->nm_role }}</td>
                                        <td>{{ $r->ket_role }}</td>
                                        <td>
                                            {!! (new BApp)->btnAkses('sys_role', $r->id_role, ['validate'], 'btn-sm') !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
