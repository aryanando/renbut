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
                        <div class="table-responsive" id="dvData">
                            <table class="table" style="margin-bottom: 0px">
                                <thead>
                                    <tr>
                                        <th colspan="3" bgcolor="#F3F3F3">Remun Periode: <b>{{ date('M-Y') }}</b></th>
                                        <th colspan="{{ Auth::user()->unit == 999 ? 2 : 1 }}" bgcolor="orange" style="text-align: center">Target Unit</th>
                                        <th bgcolor="orange" style="text-align: center">
                                            <a href="{{ url('/remun/target') }}" title="Edit Target" class="edit">
                                                <button class="btn btn-primary btn-xs" name="edit_t" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            </a>
                                        </th>
                                        <th colspan="3" bgcolor="#16D39D" style="text-align: center">Evaluasi Ibadah</th>
                                        <th bgcolor="#16D39D" style="text-align: center">
                                            <a href="{{ url('/remun/ibadah') }}" title="Edit Ibadah" class="edit">
                                                <button class="btn btn-primary btn-xs" name="edit_i" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            </a>
                                        </th>
                                        <th colspan="5" bgcolor="aqua" style="text-align: center">Komponen Rater</th>
                                        <th bgcolor="aqua" style="text-align: center">
                                            <a href="{{ url('/remun/rater') }}" title="Edit Rater" class="edit">
                                                <button class="btn btn-primary btn-xs" name="edit_r" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            </a>
                                        </th>
                                        <th colspan="3" bgcolor="pink" style="text-align: center">Komponen D.E.S</th>
                                        <th bgcolor="pink" style="text-align: center">
                                            <a href="{{ url('/remun/des') }}" title="Edit D.E.S" class="edit">
                                                <button class="btn btn-primary btn-xs" name="edit_des" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            </a>
                                        </th>
                                        <th rowspan="2" bgcolor="yellow">Total Kinerja %</th>
                                        @if(Auth::user()->unit == 999)
                                            <th rowspan="2" bgcolor="#FFFFD5">Remunrasi yang di terima</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>#</th><th>Nama</th><th>Unit</th>
                                        @if(Auth::user()->unit == 999)
                                            <th bgcolor="#FFFFD5">Target</th>
                                        @endif
                                        <th>Realisasi</th><th bgcolor="orange">%</th>
                                        <th>Absen</th><th>Haid</th><th>Target</th><th bgcolor="#16D39D">%</th>
                                        <th>Realiability</th><th>Assurance</th><th>Tangibility</th><th>Empaty</th><th>Responsivenes</th><th bgcolor="aqua">%</th>
                                        <th>Disiplin</th><th>Etika</th><th>Skill</th><th bgcolor="pink">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($remun as $item)
                                    <tr bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'white' }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="white-space: nowrap">{{ strtoupper($item->nama) }}</td>
                                        <td>{{ ucfirst($item->keterangan) }}</td>

                                        @if(Auth::user()->unit == 999)
                                            <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}" style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->target }}</td>
                                        @endif
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->realisasi }}</td>
                                        <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'orange' }}" style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->target_persentage }}</td>

                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->absen }}</td>
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->haid }}</td>
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->i_target }}</td>
                                        <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#16D39D' }}" style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->ibadah_persentage }}</td>
                                        
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->reliabity }}</td>
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->assurance }}</td>
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->tangbles }}</td>
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->empaty }}</td>
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->responsivenes }}</td>
                                        <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'aqua' }}" style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->rater_persentage }}</td>
                                        
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->disiplin }}</td>
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->etika }}</td>
                                        <td style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->skill }}</td>
                                        <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'pink' }}" style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->des_persentage }}</td>

                                        <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : 'yellow' }}" style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '' : $item->total_kinerja }}</td>
                                        @if(Auth::user()->unit == 999)
                                            <td bgcolor="{{ $item->cuti >= date('Y-m-t') ? 'yellow' : '#FFFFD5' }}" style="text-align: right">{{ $item->cuti >= date('Y-m-t') ? '0' : number_format($item->remun) }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    @if (Auth::user()->unit == 999)
                        <div class="box-footer">
                            <a class="btn btn-success" id="btnExport"><i class="fa fa-file-excel-o"></i> Export Excel</a>
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
    $("#btnExport").click(function (e) {
        console.log('asd');
        $(this).attr({
            'download': "download.xls",
                'href': 'data:application/csv;charset=utf-8,' + encodeURIComponent( $('#dvData').html())
        })
    });
@endsection