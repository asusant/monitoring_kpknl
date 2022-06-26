@extends('layouts.be-dashboard')

@section('title')
Dashboard
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ 'Sample Header Menu' }}
@endsection

@section('header-desc')
{{ 'Deksipsi sample header menu' }}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ 'Sample Modul' }}</li>
    </ol>
</nav>
@endsection

@section('content')
@endsection
