<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema | Iniciar sesión</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link  rel="icon" href="{!! asset('image/navegador.ico') !!}"/>

  <!-- Font Awesome -->

  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
  <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!--<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">-->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!--<link rel="stylesheet" href="../../dist/css/adminlte.min.css">-->
  <!-- Google Font: Source Sans Pro -->
  <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
  <link href="{{ asset('css/googleapis.css') }}" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <!--<a href="#"><b>Sports</b>System</a>-->
    <!--<img class="col-sm-9 img-circle" src="{{asset('image/logo3.png')}}" alt="Photo">-->
    <!--<img class="col-sm-9 img-circle" src="{{asset('image/logo.png')}}" alt="Photo">-->
    <img class="col-sm-9 img-circle" src="{{asset('image/logo.jpeg')}}" alt="Photo">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesión para ingrsar al sistema</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
          <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email o Usuario" name="email" value="{{ old('email') }}"  required autocomplete="email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row justify-content-center align-items-center">

          <!-- /.col -->
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fas fa-sign-in-alt"></i> {{ __('Ingresar') }}</button>
          </div>
          &nbsp; &nbsp; 
          <div class="form-group">
          <a class="btn btn-default btn-block btn-flat" href="{{ url('/') }}"><i class="fas fa-undo"></i> Volver</a>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!--<script src="../../plugins/jquery/jquery.min.js"></script>-->
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!--<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>-->

</body>
</html>

