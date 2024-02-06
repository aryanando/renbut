@extends('layouts.app')

@section('content-header')
    <h1>
        <a href="{{ url('/transaksi/alkes') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-database"></i> Master</li>
        <li><a href="{{ url('/alkes') }}"><i class="fa fa-file"></i> Alkes</a></li>
        <li class="active"><i class="fa fa-file"></i> Create</li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Alkes</h3>
                    </div>
                    <!-- /.box-header -->
                    <form method="POST" action="{{ url('/transaksi/alkes') }}" accept-charset="UTF-8" class="" enctype="multipart/form-data">
                        <div class="box-body">
                            {{ csrf_field() }}

                            @include ('transaksi.alkes.form', ['formMode' => 'create'])
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

@section('head')
    <style>
        .select2-container.select2-container-disabled .select2-choice {
            background-color: #ddd;
            border-color: #a8a8a8;
        }
    </style>
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
{{-- </script> --}}
@endsection