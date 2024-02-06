@extends('layouts.app')

@section('content-header')
    <h1>
        <a href="{{ url('/remun') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-money"></i> Remun</li>
        <li class="active"><a href="{{ url('/remun/target') }}"><i class="fa fa-file"></i> Rater</a></li>
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
                            <h3 class="box-title">Rater</h3>
                        </div>
                        <div class="box-tools">
                            <div class="btn" style="cursor:default">{{ ucfirst($unit_target->keterangan) }}</div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <form method="POST" action="{{ url('/remun/rater') }}" accept-charset="UTF-8" class="" enctype="multipart/form-data">
                        <div class="box-body">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-3 {{ $errors->has('periode') ? 'has-error' : ''}}">
                                    <label for="periode" class="control-label">{{ 'Periode' }}</label>
                                    <input class="form-control" name="periode" type="month" id="periode" value="{{ isset($target_unit->periode) ? substr($target_unit->periode,0,7) : date("Y-m")}}" required>
                                    {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Reliabity</th>
                                            <th>Assurance</th>
                                            <th>Tangbles</th>
                                            <th>Empaty</th>
                                            <th>Responsivenes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pegawai as $key => $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>
                                                    <input type="hidden" name="pegawai[{{ $loop->iteration-1 }}][id]" value="{{ $item->id }}">
                                                    <div class="form-group {{ $errors->has('reliabity') ? 'has-error' : ''}}" style="width: 100%">
                                                        <input class="form-control" style="width: 100%; text-align: right" placeholder="0" max="10" name="pegawai[{{ $loop->iteration-1 }}][reliabity]" type="number" id="reliabity" value="{{  $item->reliabity ?? '' }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group {{ $errors->has('assurance') ? 'has-error' : ''}}" style="width: 100%">
                                                        <input class="form-control" style="width: 100%; text-align: right" placeholder="0" max="10" name="pegawai[{{ $loop->iteration-1 }}][assurance]" type="number" id="assurance" value="{{  $item->assurance ?? '' }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group {{ $errors->has('tangbles') ? 'has-error' : ''}}" style="width: 100%">
                                                        <input class="form-control" style="width: 100%; text-align: right" placeholder="0" max="10" name="pegawai[{{ $loop->iteration-1 }}][tangbles]" type="number" id="tangbles" value="{{  $item->tangbles ?? '' }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group {{ $errors->has('empaty') ? 'has-error' : ''}}" style="width: 100%">
                                                        <input class="form-control" style="width: 100%; text-align: right" placeholder="0" max="10" name="pegawai[{{ $loop->iteration-1 }}][empaty]" type="number" id="empaty" value="{{  $item->empaty ?? '' }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group {{ $errors->has('responsivenes') ? 'has-error' : ''}}" style="width: 100%">
                                                        <input class="form-control" style="width: 100%; text-align: right" placeholder="0" max="10" name="pegawai[{{ $loop->iteration-1 }}][responsivenes]" type="number" id="responsivenes" value="{{  $item->responsivenes ?? '' }}" required>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer">
                                <div class="form-group pull-right col-md-1">
                                    <label for="sub" class="control-label" style="color: transparent;">a</label>
                                    <button class="form-control btn btn-success" type="submit"><i class="fa fa-check" aria-hidden="true"></i></button>
                                </div>
                            </div>
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
    <!-- /.content -->
@endsection
