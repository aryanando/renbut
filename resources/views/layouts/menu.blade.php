<li>
    {{-- <li class="{{ url('/home') == url()->current() ? 'active' : '' }}"> --}}
        <a href="{{ url('/home') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    @if(Auth::user()->unit == 999)
      <li class="treeview {{ Request::is('master/*') ? 'active' : "" }}"">
        <a href="#">
          <i class="fa fa-database"></i> <span>Master</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Request::is('master/satuan') ? 'active' : "" }}"><a href="{{ url('/master/satuan') }}"><i class="fa fa-coffee"></i> Satuan</a></li>
          <li class="{{ Request::is('master/uraian') ? 'active' : "" }}"><a href="{{ url('/master/uraian') }}"><i class="fa fa-coffee"></i> Uraian</a></li>
          <li class="{{ Request::is('master/unit') ? 'active' : "" }}"><a href="{{ url('/master/unit') }}"><i class="fa fa-coffee"></i> Unit</a></li>
          <li class="{{ Request::is('master/pegawai') ? 'active' : "" }}"><a href="{{ url('/master/pegawai') }}"><i class="fa fa-users"></i> Pegawai</a></li>
        </ul>
      </li>
    @endif
    @if(isset(Auth::user()->unit) || Auth::user()->unit == 999)
    <li class="treeview {{ Request::is('transaksi/*') ? 'active' : "" }}">
      <a href="#">
        <i class="fa fa-credit-card"></i> <span>Renbut</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @if(Auth::user()->accessUnit('alkes'))
        <li class="{{ Request::is('transaksi/alkes') ? 'active' : "" }}"><a href="{{ url('/transaksi/alkes') }}"><i class="fa fa-file"></i> Alkes</a></li>
        @endif
        @if(Auth::user()->accessUnit('atk'))
        <li class="{{ Request::is('transaksi/atk') ? 'active' : "" }}"><a href="{{ url('/transaksi/atk') }}"><i class="fa fa-file"></i> ATK</a></li>
        @endif
        @if(Auth::user()->accessUnit('bhp'))
        <li class="{{ Request::is('transaksi/bhp') ? 'active' : "" }}"><a href="{{ url('/transaksi/bhp') }}"><i class="fa fa-file"></i> BHP</a></li>
        @endif
        @if(Auth::user()->accessUnit('bhp_cov_19'))
        <li class="{{ Request::is('transaksi/bhp_cov_19') ? 'active' : "" }}"><a href="{{ url('/transaksi/bhp_cov_19') }}"><i class="fa fa-file"></i> BHP Cov19</a></li>
        @endif
        @if(Auth::user()->accessUnit('cetak'))
        <li class="{{ Request::is('transaksi/cetak') ? 'active' : "" }}"><a href="{{ url('/transaksi/cetak') }}"><i class="fa fa-file"></i> Cetak</a></li>
        @endif
        @if(Auth::user()->accessUnit('obat'))
        <li class="{{ Request::is('transaksi/obat') ? 'active' : "" }}"><a href="{{ url('/transaksi/obat') }}"><i class="fa fa-file"></i> Obat</a></li>
        @endif
        @if(Auth::user()->accessUnit('rumah_tangga'))
        <li class="{{ Request::is('transaksi/rumah_tangga') ? 'active' : "" }}"><a href="{{ url('/transaksi/rumah_tangga') }}"><i class="fa fa-file"></i> Rumah Tangga</a></li>
        @endif
        @if(Auth::user()->accessUnit('sarpras'))
        <li class="{{ Request::is('transaksi/sarpras') ? 'active' : "" }}"><a href="{{ url('/transaksi/sarpras') }}"><i class="fa fa-file"></i> SarPras</a></li>
        @endif
      </ul>
    </li>
      @endif
      
    @if(Auth::user()->unit == 999 || Auth::user()->unit == 800 || Auth::user()->comment == 800)
    <li class="treeview {{ Request::is('gudang/*') ? 'active' : "" }}">
      <a href="#">
        <i class="fa fa-cubes"></i> <span>Gudang</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="{{ Request::is('gudang/alkes') ? 'active' : "" }}">
          <a href="{{ url('gudang/alkes') }}"><i class="fa fa-archive"></i>Alkes</a>
        </li>

        <li class="{{ Request::is('gudang/atk') ? 'active' : "" }}">
          <a href="{{ url('gudang/atk') }}"><i class="fa fa-pencil-square-o"></i>ATK</a>
        </li>

        <li class="{{ Request::is('gudang/bhp') ? 'active' : "" }}">
          <a href="{{ url('gudang/bhp') }}"><i class="fa fa-stethoscope"></i>Bhp</a>
        </li>

        <li class="{{ Request::is('gudang/cetak') ? 'active' : "" }}">
          <a href="{{ url('gudang/cetak') }}"><i class="fa fa-book"></i>Cetak</a>
        </li>

        <li class="{{ Request::is('gudang/obat') ? 'active' : "" }}">
          <a href="{{ url('gudang/obat') }}"><i class="fa fa-medkit"></i>Obat</a>
        </li>

        <li class="{{ Request::is('gudang/rumahtangga') ? 'active' : "" }}">
          <a href="{{ url('gudang/rumahtangga') }}"><i class="fa fa-cart-plus"></i>Rumah Tangga</a>
        </li>

        <li class="{{ Request::is('gudang/sarpras') ? 'active' : "" }}">
          <a href="{{ url('gudang/sarpras') }}"><i class="fa fa-archive"></i>Sarpras</a>
        </li>

        {{--<li class="{{ Request::is('gudang/keluarmasuk/barang') ? 'active' : "" }}">
          <a href="{{ url('gudang/keluarmasuk/barang') }}"><i class="fa fa-file"></i>Transaksi Gudang</a>
        </li>--}}
      </ul>
    </li>
    @endif
      

    @if(isset(Auth::user()->unit) || Auth::user()->unit == 999 || Auth::user()->atas == 2 )
        <!-- <li class="{{ Request::is('remun') ? 'active' : "" }}">
          <a href="{{ url('/remun') }}">
            <i class="fa fa-money"></i> <span>Remun</span>
          </a>
        </li> -->

        <li class="{{ Request::is('remunbaru') ? 'active' : "" }}">
          <a href="{{ url('/remunbaru') }}">
            <i class="fa fa-money"></i> <span>Remun</span>
          </a>
        </li>
    </li>
    
    
    @endif 
    @if(Auth::user()->pegawai_id)
    <li class="{{ Request::is('remun/tiga60') ? 'active' : "" }}">
      <a href="{{ url('/remun/tiga60') }}">
        <i class="fa fa-globe"></i> Penilaian 360
      </a>
    </li>
    @endif

