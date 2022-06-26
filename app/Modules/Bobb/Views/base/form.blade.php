@extends('layouts.be-dashboard')

@section('title')
{{ $title }}
@endsection

@section('extra-css')
<!-- Include Choices CSS -->
<link rel="stylesheet" href="{{ asset('vendors/choices.js/choices.min.css') }}" />
<!-- Include DatePicker CSS -->
<link rel="stylesheet" href="{{ asset('vendors/datepicker/css/datepicker.min.css') }}" />
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
        <li class="breadcrumb-item"><a href="{{ route($base_route.'.read', $route_params) }}">{{ $title }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form {{ $title }}</li>
    </ol>
</nav>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Form {{ $title }} {!! $add_title !!}</h4>
                <span class="pull-right">
                    <a href="{{ route($base_route.'.read', $route_params) }}" class="btn btn-outline-secondary me-1 mb-1">Kembali</a>
                </span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    {{ Form::model($data, ['route' => $form_route, 'class' => 'form form-horizontal'] ) }}
                    <div class="form-body">
                        {{ Form::hidden($model->getPrimaryKey(), null) }}
                        <div class="row">
                            @foreach ($form as $c => $f)
                                <div class="col-md-3 text-end">
                                    <label for="{{ $f[0] }}">{{ $f[0] }}</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        @if (is_array($f[1]))
                                        {!! forward_static_call_array($f[1][0], $f[1][1]) !!}
                                        @else
                                        {!! $f[1] !!}
                                        @endif
                                        @if ($errors->has($c))
                                            <div class="invalid-feedback">{{ implode(' | ', $errors->get($c)) }}</div>
                                            <script>(function() { document.getElementById('{{ $c }}').classList.add('is-invalid')})();</script>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                {!! (new BApp)->submitBtn('Simpan') !!}
                                <a href="{{ route($base_route.'.read', $route_params) }}" class="btn btn-secondary me-1 mb-1">Batal</a>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
@include('components.partial.nominal')
@endsection
@section('extra-js')
<!-- Include Choices JavaScript -->
<script src="{{ asset('vendors/choices.js/choices.min.js') }}"></script>
<!-- Include DatePicker JS -->
<script src="{{ asset('vendors/datepicker/js/datepicker.min.js') }}"></script>
@endsection
