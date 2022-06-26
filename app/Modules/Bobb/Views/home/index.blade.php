@extends('layouts.be-dashboard')

@section('title')
Dashboard
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Dashboard' }}
@endsection

@section('header-desc')
{{-- {{ cache('sys_setting')['sys_desc'] }} --}}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">{{ 'Dashboard' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="alert alert-success">
    <h4 class="alert-heading">Selamat datang di {{ cache('sys_setting')['sys_name'] }}</h4>
    <p>
        {{ cache('sys_setting')['sys_desc'] }}
    </p>
    @if (session()->get('bobb_active_role') == config('lembur.level.koor'))
        <p>
            Unit: <strong>{{ cache('ref_unit_simpeg')[(new BAuth)->getUnitSimpeg()] }}</strong>
        </p>
    @endif
    @if ( in_array(session()->get('bobb_active_role'), [config('lembur.level.ppk'), config('lembur.level.staff_ppk')]))
        <p>
            Unit: <strong>{{ cache('ref_unit_sikeu')[(new BAuth)->getUnitSikeu()] }}</strong>
        </p>
    @endif
</div>

@endsection
