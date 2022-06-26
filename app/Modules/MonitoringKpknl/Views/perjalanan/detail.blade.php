@extends('layouts.be-dashboard')

@section('title')
{{ $title }}
@endsection

@section('extra-css')
@endsection

@section('header-title')
Histori {{ $title }}
@endsection

@section('header-desc')
Histori {!! $subtitle !!}
@endsection

@section('content-header-right')
<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $nmB => $url)
        <li class="breadcrumb-item"><a href="{{ $url }}">{{ $nmB }}</a></li>
        @endforeach
        <li class="breadcrumb-item active" aria-current="page">Histori {{ $title }}</li>
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
                        <h4 class="card-title">Data Perjalanan Permohonan</h4>
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
        <div class="row">
            @include('MonitoringKpknl::permohonan.detail-component')
            <div class="card">
                <div class="card-body">
                    <h4>Hisory Perjalanan</h4>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tahap</th>
                                        <th>Waktu Mulai</th>
                                        <th>Deadline</th>
                                        <th>Waktu Selesai</th>
                                        <th>Lama Eksekusi</th>
                                        <th>Pelaksana</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (sizeof($perjalanan) > 0)
                                        @php $no = sizeof($perjalanan); @endphp
                                        @foreach ($perjalanan as $r)
                                            <tr>
                                                <td>{{ $no-- }}</td>
                                                <td>{{ $r->nm_tahap }}</td>
                                                <td>{{ $help->parseDateTime($r->wkt_mulai_perjalanan) }}</td>
                                                <td class="{{ ($r->sts_perjalanan == 1 ? 'text-success' : ($now > $r->next_deadline ? 'text-danger' : 'text-warning') ) }}">
                                                    @if ($r->sts_perjalanan != 1)
                                                        {!! $help->strHighlight($help->timeLeft($r->next_deadline, $now, ($now < $r->next_deadline ? 'lagi' : 'yang lalu') ), ($now < $r->next_deadline ? 'warning' : 'danger') ) !!}
                                                    @else
                                                        {{ $help->parseDateTime($r->next_deadline) }}
                                                    @endif
                                                </td>
                                                <td>{{ $help->parseDateTime($r->wkt_selesai_perjalanan) }}</td>
                                                <td>{{ $help->timeLeft($r->wkt_mulai_perjalanan, $r->wkt_selesai_perjalanan, '') }}</td>
                                                <td align="center">
                                                    {{ ($r->nm_user ? $r->nm_user : $r->nm_role) }}
                                                    @if ($r->sts_perjalanan != 1 && $r->id_role_tahap == (new BAuth)->getActiveRole() )
                                                        @switch($r->ext_form_route)
                                                            @case('form')
                                                                @php
                                                                    $route = route($r->ext_form_route, ['id' => $r->id_permohonan]);
                                                                    $btnText = 'Proses';
                                                                @endphp
                                                                @break
                                                            @case('confirm')
                                                                @php
                                                                    $route = route('perjalanan_permohonan.form-konfirmasi.read', ['id' => $r->id_permohonan]);
                                                                    $btnText = 'Proses';
                                                                @endphp
                                                                @break
                                                            @default
                                                                @php
                                                                    $route = route($r->ext_form_route, ['id' => $r->id_permohonan]);
                                                                    $btnText = 'Cetak';
                                                                @endphp
                                                                @break
                                                        @endswitch
                                                        <br>{{ link_to($route, 'Proses', ['class' => 'btn btn-info btn-sm']) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        {!! $help->noDataRow(7) !!}
                                    @endif
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('extra-js')
@endsection
