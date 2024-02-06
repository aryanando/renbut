@extends('layouts.app')

@section('content-header')
    <h1>
        Cetak
        <small>Transaksi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-database"></i> Transaksi</li>
        <li class="active"><i class="fa fa-file"></i> Cetak</li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title" style="margin-top:-5px">
                            <form method="post" action="{{ url('/transaksi/cetak/toexcel') }}">
                                {{ csrf_field() }}
                                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</button>
                            </form>
                        </div>
                        <div class="box-tools">
                            <form method="GET" action="{{ url('/transaksi/cetak') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    {{-- <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}"> --}}
                                    <select class="form-control pull-right" style="width: 100%;" name="unit" data-tags="true" required>
                                        @foreach($unit as $key => $item)
                                            <option value="{{ $item->id }}" {{ ($item->id == (request('unit') ?? Auth::user()->unit)) ? 'selected': '' }}>{{ ucfirst($item->keterangan) }}</option>        
                                        @endforeach
                                    </select>
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="POST" action="{{ url('/transaksi/cetak') }}" accept-charset="UTF-8" class="" enctype="multipart/form-data">
                            <div class="box-body">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="form-group col-md-3 {{ $errors->has('periode') ? 'has-error' : ''}}">
                                        <label for="periode" class="control-label">{{ 'Periode' }}</label>
                                        <input class="form-control" name="periode" type="month" id="periode" value="{{ date("Y-m", strtotime(" +1 Month ")) }}" readonly>
                                        {{-- <input class="form-control" name="periode" type="month" id="periode" value="{{ isset($cetak->periode) ? substr($cetak->periode,0,7) : '0001-01'}}" required> --}}
                                        {!! $errors->first('periode', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3 {{ $errors->has('uraian') ? 'has-error' : ''}}">
                                        <label for="uraian" class="control-label">{{ 'Uraian' }}</label>
                                        <input type="hidden" name="uraian" type="text" id="uraian" value="{{ isset($cetak->uraian) ? $cetak->uraian : ''}}" data-tags="true">
                                        <select class="form-control select2" style="width: 100%;" name="uraian_json" type="text" id="uraian_json" value="" data-tags="true" required>
                                            <option disabled selected value>--pilih uraian--</option>
                                            @foreach($uraian as $key => $item)
                                                <option value="{{ $item }}" id="uraian-{{ str_replace(' ','-',$item->keterangan) }}">{{ ucfirst($item->keterangan) }}</option>        
                                            @endforeach
                                        </select>
                                        {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="form-group col-md-2 {{ $errors->has('satuan') ? 'has-error' : ''}}">
                                        <label for="satuan" class="control-label">{{ 'satuan' }}</label>
                                        <input type="hidden" name="satuan" type="text" id="satuan" value="{{ isset($cetak->satuan) ? $cetak->satuan : ''}}" data-tags="true">
                                        <select class="form-control select2" style="width: 100%;" name="satuan_json" type="text" id="satuan_json" value="" data-tags="true" required>
                                            <option disabled selected value>--pilih satuan--</option>
                                            @foreach($satuan as $key => $item)
                                                <option value="{{ $item->keterangan }}">{{ ucfirst($item->keterangan) }}</option>        
                                            @endforeach
                                        </select>
                                        {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="form-group col-md-2 {{ $errors->has('jumlah') ? 'has-error' : ''}}">
                                        <label for="jumlah" class="control-label">{{ 'Jumlah' }}</label>
                                        <input class="form-control" name="jumlah" type="number" id="jumlah" value="{{ isset($cetak->jumlah) ? $cetak->jumlah : ''}}" required>
                                        {!! $errors->first('jumlah', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="form-group col-md-1 {{ $errors->has('stok') ? 'has-error' : ''}}">
                                        <label for="stok" class="control-label">{{ 'Stok' }}</label>
                                        <input class="form-control" name="stok" type="number" id="stok" value="{{ isset($bhp->stok) ? $bhp->stok : ''}}" required>
                                        {!! $errors->first('stok', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="form-group col-md-2 {{ $errors->has('harga') ? 'has-error' : ''}}">
                                        <label for="harga" class="control-label">{{ 'Harga' }}</label>
                                        <input class="form-control" name="harga" type="number" id="harga" value="{{ isset($cetak->harga) ? $cetak->harga : ''}}" required>
                                        {!! $errors->first('harga', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="form-group col-md-2 {{ $errors->has('total') ? 'has-error' : ''}}">
                                        <label for="total" class="control-label">{{ 'Total' }}</label>
                                        <input class="form-control" type="number" id="total" value="{{ isset($cetak->total) ? $cetak->total : ''}}" readonly required>
                                        {!! $errors->first('total', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="sub" class="control-label" style="color: transparent;">a</label>
                                        <button class="form-control btn btn-success" type="submit"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Uraian</th><th>Satuan</th><th style="text-align: right">Jumlah</th><th style="text-align: right">Stok</th><th style="text-align: right">Harga</th><th style="text-align: right">Total</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($cetak as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->uraian }}</td>
                                        <td>{{ $item->satuan }}</td>
                                        <td style="text-align: right">{{ ($item->jumlah == 0)? '-' : number_format($item->jumlah,0,",",".") }}</td>
                                         <td style="text-align: right">{{ ($item->stok == 0)? '-' : number_format($item->stok,0,",",".") }}</td>
                                        <td style="text-align: right">{{ ($item->harga == 0)? '-' : 'Rp ' . number_format($item->harga,0,",",".") }}</td>
                                        <td style="text-align: right">{{ ($item->total == 0)? '-' : 'Rp ' . number_format($item->total,0,",",".") }}</td>
                                        <td>
                                            <a href="javascript:void(0)" title="Edit Cetak" class="edit">
                                                <input type="hidden" class="editval" value="{{ json_encode($item) }}">
                                                <button class="btn btn-primary btn-sm" name="edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            </a>

                                            @if($item->id && $item->unit_id == Auth::user()->unit)
                                            <form method="POST" action="{{ url('/transaksi/cetak' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Cetak" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{-- <div class="pagination-wrapper"> {!! $cetak->appends(['search' => Request::get('search')])->render() !!} </div> --}}
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
{{-- <script> --}}
    {{-- $('#uraian_json').select2({
        tags: true,
    
        insertTag: function(data, tag) {
            var add = { id: "{keterangan: "+tag.text+"}", text: tag.text }
            console.log(add)
            data.push(add)
        }
    }); --}}

    $('#uraian_json').select2('focus');
    $('#uraian_json').change(function(){
        {{-- console.log(($('#uraian_json').val()).substring(0, 1)); --}}
        if (($('#uraian_json').val()).substring(0, 1) != '{'){
            $('#uraian').val($('#uraian_json').val())
            $('#satuan').val('')
            $('#satuan').prop('readonly', false);
            $('#satuan_json').val('').select2().trigger('change').prop("disabled", false);
        } else {
            var uraian = JSON.parse($('#uraian_json').val());
            $('#uraian').val(uraian.keterangan)
            $('#satuan').val(uraian.satuan.charAt(0).toUpperCase() + uraian.satuan.slice(1))
            $('#satuan_json').val(uraian.satuan.charAt(0).toUpperCase() + uraian.satuan.slice(1)).select2().trigger('change').prop("disabled", true);
            $('#harga').val(uraian.harga)
        }

    })
    $('#satuan_json').change(function(){
        $('#satuan').val($('#satuan_json').val())
    })
    $('#jumlah').keyup(function(){
        $('#total').val($('#jumlah').val() * $('#harga').val())
    })
    $('#harga').keyup(function(){
        $('#total').val($('#jumlah').val() * $('#harga').val())
    })

    $('.edit').click(function(){
        var data = JSON.parse($(this).find('.editval').val())
        console.log(data)
        $('#uraian').val(data.uraian)
        $('[id="uraian-' + data.uraian.replaceAll(' ', '-') + '"]').prop("selected", true);
        $('#uraian_json').select2().trigger('change');
        $('#satuan').val(data.satuan)
        $('#satuan_json').val(data.satuan).select2().trigger('change').prop("disabled", true);

        $('#jumlah').val(data.jumlah)
        $('#harga').val(data.harga)
        $('#stok').val(data.stok)
        $('#total').val(data.total)
        $("html, body").animate({ scrollTop: 0 }, "fast");
        $('#jumlah').focus()
    })

{{-- </script> --}}
@endsection
