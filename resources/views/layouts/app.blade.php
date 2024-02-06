<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  {{--  @if (session("due")=="" or session('due')!=session('due'))
      <script>window.location=("{{ url('/reload') }}")</script>
  @elseif (session("tutup")=="" or session('tutup')!=session('tutup'))
      <script>window.location=("{{ url('/refresh') }}")</script>
  @endif  --}}
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Renbut') }}</title>
    {{--  semantic  --}}
    {{-- <link rel="stylesheet" href="{{ asset('semantic/semantic.css') }}"> --}}
    
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/skins/_all-skins.min.css') }}">
        <!-- Icheck -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/iCheck/all.css') }}">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('head')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Rbt</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Renbut</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('images/'. Auth::user()->photo) }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }} </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('images/'. Auth::user()->photo) }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }}  - Administrator
                  <small>Member since {{ substr(Auth::user()->created_at,0,10) }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#"></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#"></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#"></a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('/profil/'.Auth::user()->id.'/edit') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat" 
                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    Sign out
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          {{-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> --}}
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('images/'. Auth::user()->photo) }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }} </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      {{-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> --}}
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        @include('layouts.menu') 
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
<!-- jQuery 3 -->
{{--  <script src="{{ asset('js/jquery.min.js') }}"></script>  --}}
<script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('AdminLTE/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js') }}"></script>
{{-- <!-- <script src="{{ asset('js/app.js') }}"></script> --> --}}
{{-- <script src="{{ asset('semantic/semantic.js') }}"></script> --}}
<!-- ChartJS -->
{{-- <script src="{{ asset('AdminLTE/bower_components/Chart.js/Chart.js') }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--  <script src="{{ asset('AdminLTE/dist/js/pages/dashboard2.js') }}"></script>  --}}
<!-- Select2 -->
<script src="{{ asset('AdminLTE/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('AdminLTE/plugins/iCheck/icheck.min.js') }}"></script>

<script>
    $(document).ready(function(){
      $('.select2').select2()
      $('#dropdown').dropdown();      
      $('.drop').dropdown();      
      $('.list-unstyled li:nth-child(10) a').click();
      @yield('jquery')
    });
</script>
@yield('js')
<!-- Content Header (Page header) -->
  
  <div class="content-wrapper">
    <section class="content-header">
      @yield('content-header')
    </section>
    <div class="col-md-12">
      @if (session('flash_message'))
        <br>
        <a href="#{{ session('scrollto') }}">
          <div class="callout callout-success">
            <h4>Success!</h4>
  
            <p>{{ session('flash_message') }}</p>
          </div>
        </a>
      @endif
      @if (session('error_message'))
        <br>
        <div class="callout callout-danger">
          <h4>Error!</h4>

          <p>{{ session('error_message') }}</p>
        </div>
      @endif
    </div>
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.0.1
    </div>
    <strong>Copyright &copy; 2021 <a href="#">kuli.it</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark" style="max-height: 100%; overflow: auto;">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">

    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
      immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

    {{--  <script>
        $(function(){
            $("#tgl_terima").focusout(function(){
                date = $("#tgl_terima").val();
                cos = $("#customer").val();
                tgl = date.substr(8,2);
                bln = date.substr(5,2);
                thn = date.substr(2,2);
                $("#uqi").val("0"+tgl+"/"+bln+"/UQI/"+cos+"/"+thn);
            });
            $(".radio").click(function(){
                date = $("#tgl_terima").val();
                val = $(This).val();
                tgl = date.substr(8,2);
                bln = date.substr(5,2)+val;
                thn = date.substr(2,2);
                $("#due_laporan").val(bln+"/"+tgl+"/"+thn);
            });
        })
    </script>
      --}}
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
<script>
    $(function () {
        $('#table').DataTable({
        'paging'      : false,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false
        });
        $('#table1').DataTable({
        'paging'      : false,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false
        });
        $('#table3').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : false,
            lengthMenu: [
              [10, 25, 50, -1],
              [10, 25, 50, 'All']
            ]
            });
    });
</script>
</body>
</html>

{{--  window.setInterval(function(){
    var date = new Date();
    $(document).ready(function(){
      $.ajax({
        url:"{{ url('/re') }}",
        type: "get",
        cache:false,
         success:function(msg){
           //alert("wes a"+msg);
         }
      });
    });
}, 1000);    --}}
