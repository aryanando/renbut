@extends('layouts.app')

@section('content-header')
    <h1>
        Dashboard
        <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-database"></i> Master</a></li>
        <li class="active"><i class="fa fa-file"></i> Satuan</li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Greed</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        You are logged in! <br>
                    </div>
                    <!-- /.box-body -->
                    @if(Auth::user()->unit == 999)
                    <div class="box-footer">
                        <form method="post" action="{{ url('/toexcel/all') }}">
                            {{ csrf_field() }}
                            <input type="date" name="periode">
                            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Semua Renbut</button>
                        </form>
                    </div>
                    @endif
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
