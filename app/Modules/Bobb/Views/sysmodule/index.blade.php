@extends('layouts.be-dashboard')

@section('title')
Modul
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Modul' }}
@endsection

@section('header-desc')
{!! 'Manajemen Modul Aplikasi <code>can be submenu / menu it self</code>' !!}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_menu_group.read') }}">Grup Menu</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_module_group.read', ['id_menu' => $modul_group->id_menu_group]) }}">Grup Modul</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Modul' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">List Modul (Grup Modul: <code>{{ $modul_group->nm_modul_group }}</code>)</h4>
                <span class="pull-right">
                    <a href="{{ route('sys_module.create', ['id_modul' => $modul_group->id_modul_group]) }}" class="btn btn-outline-primary">Tambah Modul</a>
                </span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td width="5%">#</td>
                                    <td>Nama Modul</td>
                                    <td>Route Prefix</td>
                                    <td>Urutan</td>
                                    <td>Tampil?</td>
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
                                        <td>{{ $r->nm_modul }}</td>
                                        <td><code>{{ $r->route_prefix }}</code></td>
                                        <td>{{ $r->urutan }}</td>
                                        <td>{!! (new Help)->strBoolean($r->is_tampil) !!}</td>
                                        <td>
                                            {!! (new BApp)->btnAkses('sys_module', $r->id_modul, ['validate'], 'btn-sm') !!}
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
