@extends('layouts.app')

@section('content-header')
<h1>
    <a href="{{ url('/remun') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"
                aria-hidden="true"></i> Back</button></a>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><i class="fa fa-money"></i> Remun</li>
    <li class="active"><a href="{{ url('/remun/target') }}"><i class="fa fa-file"></i> Target</a></li>
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
                        <h3 class="box-title">Target</h3>
                    </div>
                    <div class="box-tools">
                        <div class="btn" style="cursor:default">{{ ucfirst($unit->keterangan) }}</div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-header">
                        <form action="" class="col-md-3" method="get">
                            <div class="form-group  {{ $errors->has('periode') ? 'has-error' : ''}}">
                                <label for="periode" class="control-label">{{ 'Ganti Periode' }}</label>
                                <input class="form-control" name="periode" type="month" id="periode"
                                    value="{{ $periode ?? (isset($target_unit->periode) ? $target_unit->periode : date("Y-m"))}}" required>
                                <br>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-calendar   "></i> Ganti
                                </button>
                                {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
                            </div>
                        </form>

                    </div>

                    <form method="POST" action="{{ url('/remun/target') }}" accept-charset="UTF-8" class=""
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-md-3 {{ $errors->has('periode') ? 'has-error' : ''}}">
                                <input class="form-control" name="periode" type="hidden" id="periode"
                                    value="{{ $periode ?? (isset($unit_target->periode) ? $unit_target->periode : date("Y-m"))}}" required>
                                {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        @if (Auth::user()->unit == 999)
                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                    <th>Unit</th>
                                    <th>Target</th>
                                    <th>Realisasi</th>
                                </thead>
                                <tbody>
                                    @foreach($units as $key => $value)
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="target" class="control-label">{{ ucfirst($value->keterangan)
                                                    }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group {{ $errors->has('target') ? 'has-error' : ''}}"
                                                style="width: 100%">
                                                <input class="form-control" name="unit[{{ $value->id }}][target]"
                                                    type="number" id="target" style="width: 100%"
                                                    value="{{ $value->target ?? 0}}" required>
                                                {!! $errors->first('target', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group {{ $errors->has('realisasi') ? 'has-error' : ''}}"
                                                style="width: 100%">
                                                <input class="form-control" name="unit[{{ $value->id }}][realisasi]"
                                                    type="number" id="realisasi" style="width: 100%"
                                                    value="{{ $value->realisasi ?? 0}}" required>
                                                {!! $errors->first('realisasi', '<p class="help-block">:message</p>')
                                                !!}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="row">
                            <div class="form-group col-md-3 {{ $errors->has('realisasi') ? 'has-error' : ''}}">
                                <label for="realisasi" class="control-label">{{ 'Realisasi' }}</label>
                                <input class="form-control" name="realisasi" type="number" id="realisasi"
                                    value="{{ $unit_target->realisasi ?? 0}}" required>
                                {!! $errors->first('realisasi', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        @endif
                        <div class="form-group col-md-1">
                            <label for="sub" class="control-label" style="color: transparent;">a</label>
                            <button class="form-control btn btn-success" type="submit"><i class="fa fa-check"
                                    aria-hidden="true"></i></button>
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