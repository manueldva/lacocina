@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Configurar Usuario</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Configuraciones</a></li>
              <li class="breadcrumb-item active">Usuario</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12">
            <form action="{{ route('setting',$user->id) }}" method="POST">
            @csrf
            @method('PUT')
              <div class="row">
                <div class="col-md-12">
                  <!-- general form elements -->
                    <div class="card card-default">
                      <div class="card-header">
                        <div class="row justify-content-center align-items-center">
                          <div class="form-group">
                            <button name="guardar" id="guardar" type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Guardar</button>
                          </div> 
                          <!-- /.col -->
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                  <!-- general form elements -->
                  <div class="card card-default">
                    <div class="card-header">
                      <center>
                        <h3 class="card-title">Datos Generales</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">

                        <div class="form-group">
                          <label for="name">Nombre:</label>
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Eje: Juan Perez" value="{{ $user->name }}">
                        </div>
                        @error('name')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
                        <div class="form-group">
                          <label for="username">Usuarname:</label>
                          <input disabled type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Eje: jperez" value="{{ $user->username }}">
                        </div>
                        @error('username')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="email">Email:</label>
                          <input disabled type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Eje: juanperez@gmail.com" value="{{ $user->email }}">
                        </div>
                        @error('email')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
						<div class="form-group">
                          <label for="password">Contraseña:</label>
                          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="">
                        </div>
                        @error('password')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
						<div class="form-group">
                          <label for="password2">Repetir Contraseña:</label>
                          <input type="password" class="form-control @error('password2') is-invalid @enderror" id="password2" name="password2" value="">
                        </div>
                        @error('password2')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
                        
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('js')
<script type="text/javascript">
    $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });
</script>
@endsection