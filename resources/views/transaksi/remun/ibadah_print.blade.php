@extends('layouts.app')

@section('content-header')
<h1>
    Remun
    <small>Transaksi</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><i class="fa fa-money"></i> Remun</li>
</ol>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                {{-- <div class="box-header">
                    <h3></h3>
                </div> --}}
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form action="" class="col-md-3" method="get">
                            <div class="form-group {{ $errors->has('periode') ? 'has-error' : ''}}">
                                <label for="periode" class="control-label">{{ 'Ganti Periode' }}</label>
                                <input class="form-control" name="periode" type="month" id="periode"
                                    value="{{ isset($target_unit->periode) ? substr($target_unit->periode,0,7) : date("
                                    Y-m")}}" required>
                                <br>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-calendar   "></i> Ganti
                                </button>
                                {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
                            </div>
                        </form>
                        @if (Auth::user()->unit == 999)
                        <div class="col-md-7"></div>
                        <div class="col-md-2">
                            <a class="btn btn-success pull-right" id="btnExport"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                        </div>
                        @endif
                    </div>
                    <div class="table-responsive" id="dvData">
                        <table class="table" style="margin-bottom: 0px">
                            <thead>
                                <tr>
                                    <th colspan="3" bgcolor="#F3F3F3">Remun Periode: <b>{{ date('M-Y', strtotime($date))
                                            }}</b></th>
                                    <th colspan="3" bgcolor="#16D39D" style="text-align: center">Evaluasi Ibadah</th>
                                    <th bgcolor="#16D39D" style="text-align: center">
                                        <a href="{{ url('/remun/ibadah') }}" title="Edit Ibadah" class="edit">
                                            <button class="btn btn-primary btn-xs" name="edit_i"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Unit</th>
                                    <th>Absen</th>
                                    <th>Haid</th>
                                    <th>Target</th>
                                    <th bgcolor="#16D39D">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($remun as $item)
                                <tr bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'white' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="white-space: nowrap">{{ strtoupper($item->nama) }}</td>
                                    <td>{{ ucfirst($item->keterangan) }}</td>

                                    <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->absen }}
                                    </td>
                                    <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->haid }}
                                    </td>
                                    <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->i_target
                                        }}</td>
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#16D39D' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' :
                                        round($item->i_persen) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

@section('jquery')
$("#btnExport").click(function (e) {
console.log('asd');
$(this).attr({
'download': "download.xls",
'href': 'data:application/csv;charset=utf-8,' + encodeURIComponent( $('#dvData').html())
})
});
@endsection