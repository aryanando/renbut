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
                @if(Auth::user()->unit == 999)                    
                <div class="box-header">
                    <form action="" class="col-md-3" method="get">
                        <div class="form-group  {{ $errors->has('periode') ? 'has-error' : ''}}">
                            <label for="periode" class="control-label">{{ 'Ganti Periode' }}</label>
                            <input class="form-control" name="periode" type="month" id="periode"
                                value="{{ isset($target_unit->periode) ? substr($target_unit->periode,0,7) : ($periode ?? date("Y-m"))}}" required>
                            <br>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-calendar   "></i> Ganti
                            </button>
                            {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
                        </div>
                    </form>

                </div>
                @endif
                <!-- /.box-header -->
                <div class="box-body">
                    <h3>Medis</h3>
                    <div class="table-responsive" id="dvData1">
                        <table class="table" style="margin-bottom: 0px">
                            <thead>
                                <tr>
                                    <th colspan="3" bgcolor="#F3F3F3">Remun Periode: <b>{{ date('M-Y') }}</b></th>
                                    <th colspan="{{ Auth::user()->unit == 999 ? 2 : 1 }}" bgcolor="orange"
                                        style="text-align: center">Target Unit</th>
                                    <th bgcolor="orange" style="text-align: center">
                                        <a href="{{ url('/remun/target') }}" title="Edit Target" class="edit">
                                            <button class="btn btn-primary btn-xs" name="edit_t"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        </a>
                                    </th>
                                    <th colspan="3" bgcolor="#16D39D" style="text-align: center">Evaluasi Ibadah</th>
                                    <th bgcolor="#16D39D" style="text-align: center">
                                        <a href="{{ url('/remun/ibadah') }}" title="Edit Ibadah" class="edit">
                                            <button class="btn btn-primary btn-xs" name="edit_i"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        </a>
                                    </th>
                                    <th colspan="{{ Auth::user()->unit == 999 ? 4 : 1 }}" bgcolor="pink">Komponen
                                        DesRater</th>
                                    <th rowspan="2" bgcolor="yellow">Total Kinerja %</th>
                                    @if(Auth::user()->unit == 999)
                                    <th rowspan="2" bgcolor="#FFFFD5">Remunrasi yang di terima</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Unit</th>
                                    @if(Auth::user()->unit == 999)
                                    <th bgcolor="#FFFFD5">Target</th>
                                    @endif
                                    <th>Realisasi</th>
                                    <th bgcolor="orange">%</th>
                                    <th>Tidak Sholat</th>
                                    <th>Haid</th>
                                    <th>Target</th>
                                    <th bgcolor="#16D39D">%</th>
                                    @if(Auth::user()->unit == 999)
                                    <th bgcolor="pink">Atasan</th>
                                    <th bgcolor="pink">Rekan</th>
                                    <th bgcolor="pink">Diri</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 0;
                                @endphp
                                @foreach($remun as $item)
                                @if($item->jenis_remun == 500 || in_array($item->unit_id, [16,21]))
                                <tr bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'white' }}">
                                    <td>{{ ++$i }}</td>
                                    <td style="white-space: nowrap">{{ strtoupper($item->nama) }}</td>
                                    <td>{{ ucfirst($item->keterangan) }}</td>

                                    @if(Auth::user()->unit == 999)
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->target
                                        }}</td>
                                    @endif
                                    <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' :
                                        $item->realisasi }}</td>
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'orange' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' :
                                        $item->target_persentage }}</td>

                                    <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->absen }}
                                    </td>
                                    <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->haid }}
                                    </td>
                                    <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->i_target
                                        }}</td>
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#16D39D' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' :
                                        $item->ibadah_persentage }}</td>

                                    @if(Auth::user()->unit == 999)
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        number_format($item->raterdes_atasan) }}</td>
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        round(number_format($item->raterdes_rekan)*100/150) }}</td>
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        number_format($item->raterdes_diri) }}</td>
                                    @endif
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'pink' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->desrater
                                        }}</td>

                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'yellow' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' :
                                        $item->total_kinerja }}</td>
                                    @if(Auth::user()->unit == 999)
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style='text-align: right;"'>{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        $item->remun }}</td>
                                    @endif
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <h3>Penunjang Medis</h3>
                    <div class="table-responsive" id="dvData2">
                        <table class="table" style="margin-bottom: 0px">
                            <thead>
                                <tr>
                                    <th colspan="3" bgcolor="#F3F3F3">Remun Periode: <b>{{ date('M-Y') }}</b></th>
                                    <th colspan="3" bgcolor="#16D39D" style="text-align: center">Evaluasi Ibadah</th>
                                    <th bgcolor="#16D39D" style="text-align: center">
                                        <a href="{{ url('/remun/ibadah') }}" title="Edit Ibadah" class="edit">
                                            <button class="btn btn-primary btn-xs" name="edit_i"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        </a>
                                    </th>
                                    <th colspan="{{ Auth::user()->unit == 999 ? 4 : 1 }}" bgcolor="pink">Komponen
                                        DesRater</th>
                                    <th rowspan="2" bgcolor="yellow">Total Kinerja %</th>
                                    @if(Auth::user()->unit == 999)
                                    <th rowspan="2" bgcolor="#FFFFD5">Remunrasi yang di terima</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Unit</th>
                                    <th>Tidak Sholat</th>
                                    <th>Haid</th>
                                    <th>Target</th>
                                    <th bgcolor="#16D39D">%</th>
                                    @if(Auth::user()->unit == 999)
                                    <th bgcolor="pink">Atasan</th>
                                    <th bgcolor="pink">Rekan</th>
                                    <th bgcolor="pink">Diri</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 0;
                                @endphp
                                @foreach($remun as $item)
                                @if($item->jenis_remun == 250 && !in_array($item->unit_id, [16,21]))
                                <tr bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'white' }}">
                                    <td>{{ ++$i }}</td>
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
                                        $item->ibadah_persentage }}</td>

                                    @if(Auth::user()->unit == 999)
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        number_format($item->raterdes_atasan) }}</td>
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        number_format($item->raterdes_rekan) }}</td>
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        number_format($item->raterdes_diri) }}</td>
                                    @endif
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'pink' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->desrater
                                        }}</td>

                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'yellow' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' :
                                        $item->total_kinerja }}</td>
                                    @if(Auth::user()->unit == 999)
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style='text-align: right;"'>{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        $item->remun }}</td>
                                    @endif
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <h3>Penunjang Umum</h3>
                    <div class="table-responsive" id="dvData3">
                        <table class="table" style="margin-bottom: 0px">
                            <thead>
                                <tr>
                                    <th colspan="3" bgcolor="#F3F3F3">Remun Periode: <b>{{ date('M-Y') }}</b></th>
                                    <th colspan="3" bgcolor="#16D39D" style="text-align: center">Evaluasi Ibadah</th>
                                    <th bgcolor="#16D39D" style="text-align: center">
                                        <a href="{{ url('/remun/ibadah') }}" title="Edit Ibadah" class="edit">
                                            <button class="btn btn-primary btn-xs" name="edit_i"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        </a>
                                    </th>
                                    <th colspan="{{ Auth::user()->unit == 999 ? 4 : 1 }}" bgcolor="pink">Komponen
                                        DesRater</th>
                                    <th rowspan="2" bgcolor="yellow">Total Kinerja %</th>
                                    @if(Auth::user()->unit == 999)
                                    <th rowspan="2" bgcolor="#FFFFD5">Remunrasi yang di terima</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Unit</th>
                                    <th>Tidak Sholat</th>
                                    <th>Haid</th>
                                    <th>Target</th>
                                    <th bgcolor="#16D39D">%</th>
                                    @if(Auth::user()->unit == 999)
                                    <th bgcolor="pink">Atasan</th>
                                    <th bgcolor="pink">Rekan</th>
                                    <th bgcolor="pink">Diri</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 0;
                                @endphp
                                @foreach($remun as $item)
                                @if(in_array($item->jenis_remun, [100, 150, 200]))
                                <tr bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'white' }}">
                                    <td>{{ ++$i }}</td>
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
                                        $item->ibadah_persentage }}</td>

                                    @if(Auth::user()->unit == 999)
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        number_format($item->raterdes_atasan) }}</td>
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        number_format($item->raterdes_rekan) }}</td>
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        number_format($item->raterdes_diri) }}</td>
                                    @endif
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'pink' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->desrater
                                        }}</td>

                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'yellow' }}"
                                        style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' :
                                        $item->total_kinerja }}</td>
                                    @if(Auth::user()->unit == 999)
                                    <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                        style='text-align: right;"'>{{ $item->cuti >= date('Y-m-t') ? '0' :
                                        $item->remun }}</td>
                                    @endif
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                @if (Auth::user()->unit == 999)
                <h2>Print No Rekening</h2>
                <div class="table-responsive" id="dvData4">
                    <table class="table" style="margin-bottom: 0px">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Unit</th>
                                <th>No Rekening</th>
                                @if(Auth::user()->unit == 999)
                                <th bgcolor="#FFFFD5">Nominal</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 0;
                            @endphp
                            @foreach($remun as $item)
                            <tr bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'white' }}">
                                <td>{{ ++$i }}</td>
                                <td style="white-space: nowrap">{{ strtoupper($item->nama) }}</td>
                                <td>{{ ucfirst($item->keterangan) }}</td>
                                <td>{{ $item->rekening ?? '' }}</td>
                                @if(Auth::user()->unit == 999)
                                <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}"
                                    style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' :
                                    $item->remun }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @foreach ($remun as $item)
                <table>

                </table>
                @endforeach
                <div class="box-footer">
                    <h2>Export Excel</h2>
                    <a class="btn btn-success" id="btnExport1"><i class="fa fa-file-excel-o"></i>Medis</a>
                    <a class="btn btn-success" id="btnExport2"><i class="fa fa-file-excel-o"></i>Penunjang
                        Medis</a>
                    <a class="btn btn-success" id="btnExport3"><i class="fa fa-file-excel-o"></i>Penunjang
                        Umum</a>
                    <a class="btn btn-success" id="btnExport4"><i class="fa fa-file-excel-o"></i>Dengan No Rekening</a>
                </div>
                @endif
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
$("#btnExport1").click(function (e) {
$(this).attr({
'download': "remun500.xls",
'href': 'data:application/csv;charset=utf-8,' + encodeURIComponent( $('#dvData1').html())
})
});
$("#btnExport2").click(function (e) {
$(this).attr({
'download': "remun250.xls",
'href': 'data:application/csv;charset=utf-8,' + encodeURIComponent( $('#dvData2').html())
})
});
$("#btnExport3").click(function (e) {
$(this).attr({
'download': "remun100.xls",
'href': 'data:application/csv;charset=utf-8,' + encodeURIComponent( $('#dvData3').html())
})
});
$("#btnExport4").click(function (e) {
$(this).attr({
'download': "remun_no_rekening.xls",
'href': 'data:application/csv;charset=utf-8,' + encodeURIComponent( $('#dvData4').html())
})
});

@endsection
