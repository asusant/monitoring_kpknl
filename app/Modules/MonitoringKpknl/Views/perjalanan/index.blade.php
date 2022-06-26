@extends('layouts.be-dashboard')

@section('title')
{{ $title }}
@endsection

@section('extra-css')
@endsection

@section('header-title')
{{ $title }}
@endsection

@section('header-desc')
{!! $subtitle !!}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $nmB => $url)
        <li class="breadcrumb-item"><a href="{{ $url }}">{{ $nmB }}</a></li>
        @endforeach
        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-2 col-sm-12"></div>
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Detail Data Perjalanan Permohonan</h4>
                        {!! Form::open(['route' => $base_route.'.detail.read', 'class' => 'form form-horizontal']) !!}
                            @csrf
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" name="no_permohonan" value="{{ (old('no_permohonan') ? old('no_permohonan') : session()->get('filter-no-permohonan')) }}" placeholder="Masukkan Nomor Identitas Permohonan Penilaian">
                                <button class="btn btn-primary btn-lg" type="submit">Proses</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-12"></div>
    </div>
</section>
@endsection

@section('extra-js')
@endsection
