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
{!! 'Manajemen Role untuk spesifik user' !!}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.read') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sys_user.read') }}">User</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Role User' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">List Role (User: <code>{{ $user->nm_user }}</code>)</h4>
                <span class="pull-right">
                    <a href="{{ route('sys_user_role.create', ['id_user' => $user->id_user]) }}" class="btn btn-outline-primary">Tambah Role</a>
                </span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td width="5%">#</td>
                                    <td>User</td>
                                    <td>Role</td>
                                    <td width="15%">Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($data) > 0)
                                    @php
                                        $n = 1;
                                    @endphp
                                    @foreach ($data as $r)
                                        <tr>
                                            <td>{{ $n++ }}</td>
                                            <td>{{ $r->nm_user }}</td>
                                            <td><code>{{ $r->nm_role }}</code></td>
                                            <td>
                                                {!! (new BApp)->btnAkses('sys_user_role', $r->id_user_role, ['validate'], 'btn-sm') !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center"><i>Belum ada data.</i></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
