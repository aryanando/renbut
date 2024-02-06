@extends('layouts.app')

@section('content-header')
    <h1>
        <a href="{{ url('gudang/sarpras') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-database"></i> Gudang</li>
        <li><a href="{{ url('/gudang/sarpras') }}"><i class="fa fa-file"></i> Sarpras</a></li>
        <li class="active"><i class="fa fa-file"></i> Edit</li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Uraian {{ $uraian->id }} - Sarpras</h3>
                    </div>
                    <!-- /.box-header -->
                    <form method="POST" action="{{ url('gudang/sarpras/' . $uraian->id) }}" accept-charset="UTF-8" class="" enctype="multipart/form-data">
                        <div class="box-body">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('transaksi.gudang.sarpras.form', ['formMode' => 'edit'])
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
