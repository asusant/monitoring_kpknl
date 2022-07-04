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
                                                <td>{!! $r->nm_tahap.' <sup><span class="badge bg-primary">'.$r->urutan_tahap.'</span></sup>'.'<br><small><strong>Status: '.$help->strHighlight($r->ref_sts_perjalanan[$r->sts_perjalanan], $r->class_sts_perjalanan[$r->sts_perjalanan]).'</small></strong>'.($r->catatan ? '<br><small><strong>Catatan: '.$r->catatan.'</small></strong>' : '') !!}</td>
                                                <td>{{ $help->parseDateTime($r->wkt_mulai_perjalanan) }}</td>
                                                <td class="{{ $r->class_sts_perjalanan[$r->sts_perjalanan] }}">
                                                    @if ($r->sts_perjalanan == 0)
                                                        {!! $help->strHighlight($help->timeLeft($r->next_deadline, $now, ($now < $r->next_deadline ? 'lagi' : 'yang lalu') ), ($now < $r->next_deadline ? 'warning' : 'danger') ) !!}
                                                    @else
                                                        {{ $help->parseDateTime($r->next_deadline) }}
                                                    @endif
                                                </td>
                                                <td>{{ $help->parseDateTime($r->wkt_selesai_perjalanan) }}</td>
                                                <td>{{ $help->timeLeft($r->wkt_mulai_perjalanan, $r->wkt_selesai_perjalanan, '') }}</td>
                                                <td align="center">
                                                    {{ ($r->nm_user ? $r->nm_user : $r->nm_role) }}
                                                    @if ( in_array($r->sts_perjalanan, $permohonan->ref_sts_stop) && $r->id_role_tahap == (new BAuth)->getActiveRole() && $no != sizeof($perjalanan) )
                                                        @switch($r->jns_tahap)
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
                                                            @case('print')
                                                                @php
                                                                    $route = route('perjalanan_permohonan.form-konfirmasi.read', ['id' => $r->id_permohonan]);
                                                                    $btnText = 'Proses';
                                                                @endphp
                                                                @break
                                                        @endswitch
                                                        <br>{{ link_to($route, $btnText, ['class' => 'btn btn-info btn-sm']) }}
                                                    @endif
                                                    @if ($r->jns_tahap == 'print')
                                                        <a href="{{ route($r->ext_form_route, ['id' => $r->id_permohonan]) }}" class="btn btn-success btn-sm"><i class="bi bi-printer"></i> Cetak</a>
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
