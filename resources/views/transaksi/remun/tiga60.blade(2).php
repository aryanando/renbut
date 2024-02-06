@extends('layouts.app')

@section('content-header')
{{-- penilaian kinerja --}}
<h1>
    <a href="{{ url('/remun') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"
                aria-hidden="true"></i> Back</button></a>
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
                        <h3 class="box-title">Penilaian 360</h3>
                    </div>
                    <div class="box-tools">
                    @if(isset(Auth::user()->unit) == 999) 
                        <a href="{{ url('/remun/tiga60/gendef') }}" title="Back"><button class="btn btn-success btn-sm">
                         Generate</button></a>
                    @endif
                        <div class="btn" style="cursor:default">{{ ucfirst($unit_target->keterangan) }}</div>
                    </div>
                </div>
                <!-- /.box-header -->
                <form method="POST" action="{{ url('/remun/tiga60') }}" accept-charset="UTF-8" class=""
                    enctype="multipart/form-data">
                    <div class="box-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-md-3 {{ $errors->has('periode') ? 'has-error' : ''}}">
                                <label for="periode" class="control-label">{{ 'Periode' }}</label>
                                <input class="form-control" name="periode" type="month" id="periode"
                                    value="{{ date("Y-m") }}" readonly required>
                                {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th rowspan="3">#</th>
                                        <th rowspan="3">
                                            <center>Indikator</center>
                                        </th>
                                        @if($rekan['atasan'])
                                        <th colspan="5">
                                            <center>Atasan</center>
                                        </th>
                                        @endif
                                        @if($rekan['rekan1'])
                                        <th colspan="5">
                                            <center>Rekan Kerja 1</center>
                                        </th>
                                        @endif
                                        @if($rekan['rekan2'])
                                        <th colspan="5">
                                            <center>Rekan Kerja 2</center>
                                        </th>
                                        @endif
                                        @if($rekan['diri'])
                                        <th colspan="5">
                                            <center>Diri Sendiri</center>
                                        </th>
                                        @endif
                                        @if($rekan['bawahan'])
                                        @foreach ($rekan['bawahan'] as $key => $item)
                                        <th colspan="5">
                                            <center></center>
                                        </th>
                                        @endforeach
                                        @endif
                                    </tr>
                                    <tr>
                                        @php
                                        $kolom = [
                                        "atasan",
                                        "rekan1",
                                        "rekan2",
                                        "diri"
                                        ];
                                        @endphp
                                        @foreach ($kolom as $item)
                                        @if ($rekan[$item])
                                        <th colspan="5">
                                            <center>{{ $rekan[$item]->nama ?? '{ nama }' }}</center>
                                        </th>
                                        @endif
                                        @endforeach
                                        @if($rekan['bawahan'])
                                        @foreach ($rekan['bawahan'] as $key => $item)
                                        <th colspan="5">
                                            <center>{{ $item->nama ?? '{ nama }' }}</center>
                                        </th>
                                        @endforeach
                                        @endif
                                        @if($rekan['karu'])
                                        @foreach ($rekan['karu'] as $key => $item)
                                        <th colspan="5">
                                            <center>{{ $item->nama ?? '{ nama }' }}</center>
                                        </th>
                                        @endforeach
                                        @endif
                                    </tr>
                                    <tr>
                                        @foreach ($kolom as $item)
                                        @if ($rekan[$item])
                                        <th>
                                            <center>1</center>
                                        </th>
                                        <th>
                                            <center>2</center>
                                        </th>
                                        <th>
                                            <center>3</center>
                                        </th>
                                        <th>
                                            <center>4</center>
                                        </th>
                                        <th>
                                            <center>5</center>
                                        </th>
                                        @endif
                                        @endforeach
                                        @if($rekan['bawahan'])
                                        @foreach ($rekan['bawahan'] as $key => $item)
                                        <th>
                                            <center>1</center>
                                        </th>
                                        <th>
                                            <center>2</center>
                                        </th>
                                        <th>
                                            <center>3</center>
                                        </th>
                                        <th>
                                            <center>4</center>
                                        </th>
                                        <th>
                                            <center>5</center>
                                        </th>
                                        @endforeach
                                        @endif
                                        @if($rekan['karu'])
                                        @foreach ($rekan['karu'] as $key => $item)
                                        <th>
                                            <center>1</center>
                                        </th>
                                        <th>
                                            <center>2</center>
                                        </th>
                                        <th>
                                            <center>3</center>
                                        </th>
                                        <th>
                                            <center>4</center>
                                        </th>
                                        <th>
                                            <center>5</center>
                                        </th>
                                        @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $komponen = [
                                    "reliability" => [
                                    "Mampu bekerja sesuai dengan SOP"
                                    ],
                                    "assurance" => [
                                    "Mampu bekerja dengan baik sesuai bidang keilmuan",
                                    "Mampu menjadi agen perubahan dan memotivasi lingkungan sekitar",
                                    ],
                                    "tangibility" => [
                                    "Mampu berpenampilan menarik sesuai buku etika sikap tampang",
                                    ],
                                    "empathy" => [
                                    "Memiliki kepedulian terhadap pelanggan",
                                    "Memiliki kepedulian terhadap rekan kerja",
                                    ],
                                    "responsiveness" => [
                                    "Cepat dan tanggap terhadap kebutuhan dan komplain pelanggan",
                                    "Kecepatan mengelola kebutuhan unit terkait",
                                    ],
                                    "disiplin" => [
                                    "Tepat waktu dalam melaksanakan jam dinas",
                                    "Tepat waktu dalam menyelesaikan tugas",
                                    "Mematuhi regulasi rumah sakit",
                                    ],
                                    "etika" => [
                                    "Memiliki nilai moral yang baik sesuai buku etika sikap tampang",
                                    ],
                                    "skill" => [
                                    "Mampu bekerja sama dengan tim unit",
                                    "Mampu bekerja sama dengan unit lain",
                                    "Memiliki kemauan untuk terus belajar dibidangnya",
                                    ],
                                    ];
                                    @endphp
                                    @foreach($komponen as $key => $item)
                                    <th>{{ $loop->iteration }}</th>
                                    <th>{{ ucfirst($key) }}</th>
                                    {{-- @foreach ($kolom as $kol)
                                    @for ($i = 0; $i < 5; $i++) <td>
                                        </td>
                                        @endfor
                                        @endforeach --}}
                                        @foreach ($item as $k => $komp)
                                        <tr>
                                            <td></td>
                                            <td style="white-space: pre;">{{ $k+1 }}. {{ $komp }}</td>
                                            {{-- <input type="hidden" name="$kol[0]" value="{{ 0 }}"> --}}
                                            @foreach ($kolom as $kol)
                                            @if ($rekan[$kol] && !is_array($rekan[$kol]))
                                            @for ($i = 0; $i < 5; $i++) 
                                            @php
                                                switch ($i) {
                                                    case '0':
                                                        // $color = '#f54242';
                                                        $color = '#ffffff';
                                                        break;
                                                    case '1':
                                                        // $color = '#f59042';
                                                        $color = '#ffffff';
                                                        break;
                                                    case '2':
                                                        // $color = '#f5f242';
                                                        $color = '#ffffff';
                                                        break;
                                                    case '3':
                                                        // $color = '#69f542';
                                                        $color = '#ffffff';
                                                        break;
                                                    case '4':
                                                        $color = '#42f5d1';
                                                        break;
                                                    
                                                    default:
                                                        $color = '#f54242';
                                                        break;
                                                }
                                            @endphp

                                            <td style="background-color:{{ $color }}">
                                                <center class="form-group">
                                                    <input class="iradio_flat-green" style="text-align: right"
                                                        placeholder="0" max="10" name="{{ $kol }}[{{ $key }}][{{ $k }}]"
                                                        type="radio" value="{{ $i+1 }}" @if(($isi[$rekan[$kol]->id][$key][$k] ?? 2) == $i+1) checked @endif
                                                        required>
                                                </center>
                                                </td>
                                                @endfor
                                                @endif
                                                @endforeach
                                                {{-- bawahan --}}
                                                @if($rekan['bawahan'])
                                                @foreach ($rekan['bawahan'] as $kb => $b)
                                                @for ($i = 0; $i < 5; $i++) 
                                                @php
                                                    switch ($i) {
                                                        case '0':
                                                            // $color = '#f54242';
                                                            $color = '#ffffff';
                                                            break;
                                                        case '1':
                                                            // $color = '#f59042';
                                                            $color = '#ffffff';
                                                            break;
                                                        case '2':
                                                            // $color = '#f5f242';
                                                            $color = '#ffffff';
                                                            break;
                                                        case '3':
                                                            // $color = '#69f542';
                                                            $color = '#ffffff';
                                                            break;
                                                        case '4':
                                                            $color = '#42f5d1';
                                                            break;
                                                        
                                                        default:
                                                            $color = '#f54242';
                                                            break;
                                                    }
                                                @endphp

                                                <td style="background-color:{{ $color }}">
                                                    <center class="form-group">
                                                        <input class="iradio_flat-green" style="text-align: right"
                                                            placeholder="0" max="10" name="bawahan[{{ $kb }}][{{ $key }}][{{ $k }}]"
                                                            type="radio" value="{{ $i+1 }}" @if(($isi[$b->id][$key][$k] ?? 2) == $i+1) checked="checked" @endif
                                                            required>
                                                    </center>
                                                    </td>
                                                    @endfor
                                                    @endforeach
                                                    @endif

                                                {{-- karu --}}
                                                @if($rekan['karu'])
                                                @foreach ($rekan['karu'] as $kr => $r)
                                                @for ($i = 0; $i < 5; $i++) 
                                                @php
                                                    switch ($i) {
                                                        case '0':
                                                            // $color = '#f54242';
                                                            $color = '#ffffff';
                                                            break;
                                                        case '1':
                                                            // $color = '#f59042';
                                                            $color = '#ffffff';
                                                            break;
                                                        case '2':
                                                            // $color = '#f5f242';
                                                            $color = '#ffffff';
                                                            break;
                                                        case '3':
                                                            // $color = '#69f542';
                                                            $color = '#ffffff';
                                                            break;
                                                        case '4':
                                                            $color = '#42f5d1';
                                                            break;
                                                        
                                                        default:
                                                            $color = '#f54242';
                                                            break;
                                                    }
                                                @endphp

                                                <td style="background-color:{{ $color }}">
                                                    <center class="form-group">
                                                        <input class="iradio_flat-green" style="text-align: right"
                                                            placeholder="0" max="10" name="karu[{{ $kr }}][{{ $key }}][{{ $k }}]"
                                                            type="radio" value="{{ $i+1 }}" @if(($isi[$r->id][$key][$k] ?? 2) == $i+1) checked="checked" @endif
                                                            required>
                                                    </center>
                                                    </td>
                                                    @endfor
                                                    @endforeach
                                                    @endif
                                            
                                        </tr>
                                        @endforeach
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="form-group col-md-2">
                                <label for="evaluasi" class="control-label">Masa Kerja</label>
                                    <!-- {{ $hitungan = \Carbon\Carbon::parse($pegawai->tmt_kerja)->diffInMonths() }} -->
                                <input type=text disabled value="{{floor($hitungan/12)}} Tahun {{floor($hitungan%12)}} Bulan" class="form-control"> 
                                <!-- {{ $hitungan = \Carbon\Carbon::parse($pegawai->tmt_kerja)->diffInYears() }} -->
                            </div>
                            <div class="form-group col-md-2">
                                <label for="evaluasi" class="control-label">Tidak Sholat:</label>
                                <input type="number" name="absen" class="form-control" maxlength=3 max=150 value="{{ $ibadah->absen ?? '' }}" required>
                            </div>
                            @if(Auth::user()->pegawai->gender == 'Perempuan')                                
                                <div class="form-group col-md-1">
                                    <label for="evaluasi" class="control-label">Haid:</label>
                                    <input type="number" name="haid" class="form-control" maxlength=3 max=150 value="{{ $ibadah->haid ?? '' }}" required>
                                </div>
                            @endif
                            <div class="form-group pull-right col-md-1">
                                <label for="sub" class="control-label" style="color: transparent;">a</label>
                                <button class="form-control btn btn-success" type="submit"><i class="fa fa-check"
                                        aria-hidden="true"></i></button>
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

@section('jquery')
//Flat red color scheme for iCheck
{{-- $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
  checkboxClass: 'icheckbox_flat-green',
  radioClass   : 'iradio_flat-green'
}) --}}

@endsection
