@extends('layouts.be-dashboard')

@section('title')
Grup Menu
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Grup Menu' }}
@endsection

@section('header-desc')
{!! 'Manajemen Grup Menu <code>group_menu / text only</code>' !!}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Grup Menu' }}</li>
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
                    <a href="{{ route('sys_menu_group.create') }}" class="btn btn-outline-primary">Tambah Grup Menu</a>
                </span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td width="5%">#</td>
                                    <td>Nama Grup Menu</td>
                                    <td>Urutan</td>
                                    <td>Extra</td>
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
                                        <td>{{ $r->nm_menu_group }}</td>
                                        <td>{{ $r->urutan }}</td>
                                        <td>
                                            @if (config('bobb.akses.a_validate') && config('bobb.akses.a_validate') == 1)
                                                <a href="{{ route('sys_module_group.read', ['id_menu' => $r->id_menu_group]) }}" class="btn btn-info btn-sm">Grup Modul</a>
                                            @endif
                                        </td>
                                        <td>
                                            {!! (new BApp)->btnAkses('sys_menu_group', $r->id_menu_group, ['validate'], 'btn-sm') !!}
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
