@extends('layouts.app')

@section('content-header')
    <h1>
        Dashboard
        <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-database"></i> Master</a></li>
        <li class="active"><i class="fa fa-file"></i> Satuan</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Import</h3>
                    </div>
                    <!-- /.box-header -->
                    <form method="post" action="{{ url('/transaksi/alkes/import') }}" id="form_import" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('kode') ? 'has-error' : ''}}">
                                <label for="page" class="control-label">Tabel</label>
                                <select class="form-control" id="page">
                                    <option value="{{ url('/transaksi/alkes/import') }}">Alkes</option>
                                    <option value="{{ url('/transaksi/atk/import') }}">Atk</option>
                                    <option value="{{ url('/transaksi/bhp/import') }}">Bhp</option>
                                    <option value="{{ url('/transaksi/bhp_cov_19/import') }}">Bhp_cov_19</option>
                                    <option value="{{ url('/transaksi/cetak/import') }}">Cetak</option>
                                    <option value="{{ url('/transaksi/obat/import') }}">Obat</option>
                                    <option value="{{ url('/transaksi/rumah_tangga/import') }}">Rumah_tangga</option>
                                    <option value="{{ url('/transaksi/sarpras/import') }}">Sarpras</option>
                                </select>
                            </div>
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('kode') ? 'has-error' : ''}}">
                                <label for="file" class="control-label">File excel: </label>
                                <input class="form-control" type="file" name="excel" id="file">
                            </div>
                        </div>
                        <div class="box-footer">
                            {{-- <a href="{{ url('/files/contoh_import_bahan.xlsx') }}">Download file contoh</a> --}}
                            <input class="btn btn-success pull-right" type="submit" value="Submit">
                        </div>
                    </form>
                <!-- /.box-body -->
                </div>
            <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('jquery')

    $('#page').on('change', function() {
        $('#form_import').attr('action', this.value);
        {{-- alert(this.value); --}}
    })

@endsection
