@extends('layouts.app')

@section('content-header')
    <h1>
        Pegawai
        <small>Master</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-database"></i> Master</li>
        <li class="active"><i class="fa fa-file"></i> Pegawai</li>
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
                            <a href="{{ url('/master/pegawai/create') }}" class="btn btn-success btn-sm" title="Add New Pegawai">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add New
                            </a>
                        </div>
                        <div class="box-tools">
                            <form method="GET" action="{{ url('/master/pegawai') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <input type="text" class="form-control pull-right" name="search" placeholder="Search..." value="{{ request('search') }}">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Nama</th><th>Gender</th><th>Unit</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($pegawai as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ strtoupper($item->nama) }}</td><td>{{ $item->gender }}</td><td>{{ ucfirst($item->keterangan) }}</td>
                                        <td>
                                            {{-- <a href="{{ url('/master/pegawai/' . $item->id) }}" title="View Pegawai"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a> --}}
                                            <a href="{{ url('/master/pegawai/' . $item->id . '/edit') }}" title="Edit Pegawai"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/master/pegawai' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Pegawai" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $pegawai->appends(['search' => Request::get('search')])->render() !!} </div>
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
