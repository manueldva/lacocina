<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Sistema Gestion') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link  rel="icon" href="{!! asset('image/navegador.ico') !!}"/>
  <!-- Font Awesome -->
 
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
  <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
  <!-- Theme style -->
  <!--<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">-->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
  <!-- Theme style video-->
  <link rel="stylesheet" href="{{ asset('dist/css/video.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/flat/blue.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker-bs3.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
  <link href="{{ asset('css/googleapis.css') }}" rel="stylesheet">
  @yield('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <!--aca-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <!--
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    -->
    </ul>

    <!-- SEARCH FORM -->
    <!--<form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      <li class="nav-item">
        <a class="nav-link" data-toggle="tooltip" data-placement="top" title="Cerrar sesión" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                                 <!--<i class="nav-icon far fa-circle text-danger"></i>-->
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!--<a href="{{ route('home') }}" class="brand-link">-->
    <a href="#" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Gestion') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('showSetting', Auth::user()->id) }}" class="d-block "> {{ Auth::user()->name }}</a>
          <!--<a id="showSetting" href="{{ route('showSetting', Auth::user()->id) }}">Ajustes </a>-->
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @can('home')   
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link 
              @if($segment == 'home')
              active
              @endif
              ">
              <i class="nav-icon fas fa-tachometer-alt  nav-icon"></i>
              <p>
                Tablero
              </p>
            </a>
            
          </li>
          @endcan
          @can('clientes.index')
          <li class="nav-item">
            <a href="{{ route('clientes.index') }}" class="nav-link 
              @if($segment == 'clientes')
              active
              @endif
              ">
              <i class="nav-icon fas fa-user  nav-icon"></i>
              <p>
                Clientes
              </p>
            </a>
            
          </li>
          @endcan
          @if(auth()->user()->can('manageusers.index'))
          <li class="nav-item has-treeview
            @if($segment=='users' || $segment=='roles')
              menu-open
            @endif">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-fingerprint"></i>
              <p>
                Seguridad
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('manageusers.index')
                <li class="nav-item">
                  <a href="{{ route('manageusers.index') }}" class="nav-link  
                    @if($segment=='users')
                    active
                    @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Usuarios</p>
                  </a>
              </li>
              @endcan
              @can('roles.index')
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link
                @if($segment=='roles')
                active
                @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endif
          @can('complementos.index')
          <li class="nav-item has-treeview
          @if(substr($segment, -1)=='c')
              menu-open
            @endif">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Complementos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview
                @if(substr($segment, -1)=='c')
                    menu-open
                  @endif">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                      Personas
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('tipocontactos.index') }}" class="nav-link  
                        @if($segment=='tipocontacto_c')
                        active
                        @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tipo Contactos</p>
                      </a>
                    </li>
                  </ul>
                </li>
              
            </ul>
          </li>
          @endif
          <!--
          <li class="nav-header">Acción</li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="nav-icon far fa-circle text-danger"></i>
                                        {{ __('Cerrar sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>


           
          </li>
          -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('sweetalert::alert')

    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="#"></a></strong>
    Todos los derechos reservados.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0-Beta
    </div>
  </footer>

  <!-- Control Sidebar -->
 <!-- <aside class="control-sidebar control-sidebar-dark">-->
    <!-- Control sidebar content goes here -->
 <!-- </aside>-->
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>-->
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  //$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Morris.js charts -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
<script src="{{ asset('js/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
<!-- daterangepicker -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>-->
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
@yield('js')

</body>
</html>
