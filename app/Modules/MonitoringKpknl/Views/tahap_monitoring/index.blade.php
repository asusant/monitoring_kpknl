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
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">List {{ $title }} {!! $add_title !!}</h4>
                <span class="pull-right">
                    {!! $add_header_right !!}
                    @if (config('bobb.akses')['a_create'] == 1)
                    <a href="{{ route($base_route.'.create', $route_params) }}" class="btn btn-outline-primary">Tambah {{ $title }}</a>
                    @endif
                </span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    @foreach ($table_columns as $tb_col)
                                        <th>{{ $tb_col }}</th>
                                    @endforeach
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($data) > 0)
                                    @foreach ($data as $r)
                                        <tr>
                                            @foreach ($table_columns as $db_col => $tb_col)
                                                <td>
                                                    @if (in_array($db_col, $boolean_column))
                                                        {!! (new Help)->strBoolean($r->{$db_col}, '', $boolean_key) !!}
                                                    @elseif ($db_col == 'jns_tahap')
                                                        <code>{{ $model->ref_jns_tahap[$r->{$db_col}] }}</code>
                                                    @elseif ($db_col == 'ext_form_route')
                                                        <code>{{ $r->{$db_col} }}</code>
                                                    @else
                                                        {{ $r->{$db_col} }}
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                {!! (new BApp)->btnAkses($base_route, $r->{$model->getPrimaryKey()}, (!$use_validate ? ['validate'] : []), 'btn-sm') !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="{{ (sizeof($table_columns) + 1) }}" class="text-center"><i>Belum ada data.</i></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        @if ($use_pagination)
                            {{ $data->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
