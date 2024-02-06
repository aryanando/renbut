@extends('layouts.app')

@section('content-header')
<h1>
    <a href="{{ url('/remun') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"
                aria-hidden="true"></i> Back</button></a>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><i class="fa fa-money"></i> Remun</li>
    <li class="active"><a href="{{ url('/remun/target') }}"><i class="fa fa-file"></i> Ibadah</a></li>
</ol>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="box-title">
                        <h3 class="box-title">Ibadah</h3>
                    </div>
                    <div class="box-tools">
                        <div class="btn" style="cursor:default">{{ ucfirst($unit_target->keterangan) }}</div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form action="" class="col-md-3" method="get">
                            <div class="form-group  {{ $errors->has('periode') ? 'has-error' : ''}}">
                                <label for="periode" class="control-label">{{ 'Ganti Periode' }}</label>
                                <input class="form-control" name="periode" type="month" id="periode"
                                    value="{{ $periode ?? (isset($target_unit->periode) ? substr($unit_target->periode,0,7) : date("Y-m")) }}"
                                    required>
                                <br>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-calendar   "></i> Ganti
                                </button>
                                {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
                            </div>
                        </form>
                        <div class="col-md-7"></div>
                        <div class="col-md-2">
                            <a href="{{ url('/remun/ibadah/print') }}" class="btn btn-success pull-right"><i
                                    class="fa fa-print"></i> Print</a>
                        </div>
                    </div>
                    <form method="POST" action="{{ url('/remun/ibadah') }}" accept-charset="UTF-8" class=""
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input class="form-control" name="periode" type="hidden" id="periode"
                            value="{{ $periode ?? (isset($unit_target->periode) ? substr($unit_target->periode,0,7) : date("Y-m")) }}" required>

                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Gender</th>
                                        <th>Cuti</th>
                                        <th>Tidak Sholat</th>
                                        <th>Haid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pegawai as $key => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->gender }}</td>
                                        <td>
                                            <input type="hidden" name="pegawai[{{ $loop->iteration-1 }}][id]"
                                                value="{{ $item->id }}">
                                            <div class="form-group {{ $errors->has('cuti') ? 'has-error' : ''}}"
                                                style="width: 100%">
                                                <input class="form-control" style="width: 100%"
                                                    name="pegawai[{{ $loop->iteration-1 }}][cuti]" type="date" id="cuti"
                                                    value="{{ ($item->cuti >= date('y-m-t') ? '' : $item->cuti) }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group {{ $errors->has('absen') ? 'has-error' : ''}}"
                                                style="width: 100%">
                                                <input class="form-control" style="width: 100%; text-align: right"
                                                    max="{{ date('t') * 5 }}" placeholder="0"
                                                    name="pegawai[{{ $loop->iteration-1 }}][absen]" type="number"
                                                    id="absen" value="{{ $item->absen ?? '0' }}" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group {{ $errors->has('absen') ? 'has-error' : ''}}"
                                                style="width: 100%">
                                                <input class="form-control" style="width: 100%; text-align: right"
                                                    max="{{ date('t') * 5 }}" placeholder="0"
                                                    name="pegawai[{{ $loop->iteration-1 }}][haid]" type="number"
                                                    id="haid"
                                                    value="{{ (($item->gender == 'Laki-laki') ? 0: $item->haid) ?? '0' }}"
                                                    {{ ($item->gender == 'Laki-laki') ? 'disabled' : '' }} required>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- <div class="form-group col-md-3 {{ $errors->has('realisasi') ? 'has-error' : ''}}">
                                <label for="realisasi" class="control-label">{{ 'Realisasi' }}</label>
                                <input class="form-control" name="realisasi" type="number" id="realisasi"
                                    value="{{ $target_unit->realisasi ?? 0}}" required>
                                {!! $errors->first('realisasi', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group col-md-1">
                                <label for="sub" class="control-label" style="color: transparent;">a</label>
                                <button class="form-control btn btn-success" type="submit"><i class="fa fa-check"
                                        aria-hidden="true"></i></button>
                            </div> --}}
                        </div>
                        <div class="box-footer">
                            <div class="form-group pull-right col-md-1">
                                <label for="sub" class="control-label" style="color: transparent;">a</label>
                                <button class="form-control btn btn-success" type="submit"><i class="fa fa-check"
                                        aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection