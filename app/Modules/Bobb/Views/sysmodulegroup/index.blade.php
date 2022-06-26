@extends('layouts.be-dashboard')

@section('title')
Grup Modul
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Grup Modul' }}
@endsection

@section('header-desc')
{!! 'Manajemen Grup Modul <code>can be menu / group menu</code>' !!}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_menu_group.read') }}">Grup Menu</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Grup Modul' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">List Grup Modul (Grup Menu: <code>{{ $menu_group->nm_menu_group }}</code>)</h4>
                <span class="pull-right">
                    <a href="{{ route('sys_module_group.create', ['id_menu' => $menu_group->id_menu_group]) }}" class="btn btn-outline-primary">Tambah Grup Modul</a>
                </span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td width="5%">#</td>
                                    <td>Nama Grup Modul</td>
                                    <td>Urutan</td>
                                    <td>Icon</td>
                                    <td>Ekstra</td>
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
                                        <td>{{ $r->nm_modul_group }}</td>
                                        <td>{{ $r->urutan }}</td>
                                        <td>{{ $r->icon_modul_group }}</td>
                                        <td>
                                            <a href="{{ route('sys_module.read', ['id_modul' => $r->id_modul_group]) }}" class="btn btn-info btn-sm">Modul</a>
                                        </td>
                                        <td>
                                            {!! (new BApp)->btnAkses('sys_module_group', $r->id_modul_group, ['validate'], 'btn-sm') !!}
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
