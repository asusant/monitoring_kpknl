@extends('layouts.be-dashboard')

@section('title')
User
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'User' }}
@endsection

@section('header-desc')
{{ 'Manajemen user' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'User' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">List Data Users</h4>
                <span class="pull-right">
                    <a href="{{ route('sys_user.create') }}" class="btn btn-outline-primary">Tambah User</a>
                </span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td width="5%">#</td>
                                    <td>Nama User</td>
                                    <td>Email</td>
                                    <td>Username</td>
                                    <td>Identitas</td>
                                    <td>Aktif?</td>
                                    <td>Ekstra</td>
                                    <td width="15%">Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $k => $r)
                                    <tr>
                                        <td>{{ $k + $data->firstItem() }}</td>
                                        <td>{{ $r->nm_user }}</td>
                                        <td>{{ $r->email_user }}</td>
                                        <td>{{ $r->username_user }}</td>
                                        <td>{{ $r->identitas_user }}</td>
                                        <td>{!! (new Help)->strBoolean($r->is_aktif) !!}</td>
                                        <td>
                                            @if (config('bobb.akses.a_validate') && config('bobb.akses.a_validate') == 1)
                                                <a href="{{ route('sys_user_role.read', ['id_user' => $r->id_user]) }}" class="btn btn-dark btn-sm">Role</a>
                                            @endif
                                        </td>
                                        <td>
                                            {!! (new BApp)->btnAkses('sys_user', $r->id_user, ['validate'], 'btn-sm') !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $data->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
