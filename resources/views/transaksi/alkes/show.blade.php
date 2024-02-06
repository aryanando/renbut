@extends('layouts.app')

@section('content-header')
    <h1>
        <a href="{{ url('/transaksi/alkes') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
        <a href="{{ url('/transaksi/alkes/' . $alkes->id . '/edit') }}" title="Edit Alkes"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
        <form method="POST" action="{{ url('transaksi/alkes' . '/' . $alkes->id) }}" accept-charset="UTF-8" style="display:inline">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger btn-sm" title="Delete Alkes" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
        </form>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-database"></i> Master</li>
        <li><a href="{{ url('/alkes') }}"><i class="fa fa-file"></i> Alkes</a></li>
        <li class="active">{{ $alkes->id }}</li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Alkes {{ $alkes->id }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $alkes->id }}</td>
                                    </tr>
                                    <tr><th> User Id </th><td> {{ $alkes->user_id }} </td></tr><tr><th> Periode </th><td> {{ $alkes->periode }} </td></tr><tr><th> Uraian </th><td> {{ $alkes->uraian }} </td></tr>
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
