@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Gestionar Clientes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Cliente</a></li>
              <li class="breadcrumb-item active">Nuevo</li>
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
            <form action="{{ route('clientes.update',$cliente->id) }}" method="POST">
            @csrf
            @method('PUT')
              <div class="row">
                <div class="col-md-12">
                  <!-- general form elements -->
                    <div class="card card-default">
                      <div class="card-header">
                        <div class="row justify-content-center align-items-center">
                          @if($show == 0)
                          <div class="form-group">
                            <button name="guardar" id="guardar" type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Guardar</button>
                          </div> 
                          &nbsp; &nbsp;
                          @endif 
                          <div class="form-group">
                            <a class="btn btn-outline-success" href="{{ route('clientes.index') }}"><i class="fas fa-list"></i> Listado</a>
                          </div>
                          <!-- /.col -->
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
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
                          <label for="codigotemp">Codigo:</label>
                          <input readonly type="text" class="form-control" id="codigotemp" value="{{ $cliente->codigo }} ">
                        </div>
                        <div class="form-group">
                          <label for="apellido">Apellido:</label>
                          <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ $cliente->apellido }}">
                        </div>
                        @error('apellido')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="nombre">Nombre:</label>
                          <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $cliente->nombre }}">
                        </div>
                        @error('nombre')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="fechanacimiento">Fecha de Nacimiento:</label>
                          <input type="date" class="form-control @error('fechanacimiento') is-invalid @enderror" id="fechanacimiento" name="fechanacimiento" value="{{ $cliente->fechanacimiento }}">
                        </div>
                        @error('fechanacimiento')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="genero">Genero:</label>
                          <select  id="genero" name="genero" class="form-control  @error('genero') is-invalid @enderror">
                            <option value="s" {{ $cliente->genero == 's' ? 'selected' : '' }}>Sin Datos</option>
                            <option value="m" {{ $cliente->genero == 'm' ? 'selected' : '' }}>Masculino</option>
                            <option value="f" {{ $cliente->genero == 'f' ? 'selected' : '' }}>Femenino</option>
                        </select>
                        </div>
                        @error('genero')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
                         <!-- 
                        @if($cliente->foto)
                            <div class="form-group">
                            <p> <strong>Imagen:</strong></p>
                                <img src="{{ $cliente->foto }}" height="200" width="300">
                          </div>
                        @endif
                        <div class="form-group">
                          <input type="file"  class="form-control" id="avatar" name="avatar" accept="image/png, image/jpeg">
                        </div>  
                        -->
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                </div>
                <div class="col-md-6">
                  <!-- general form elements -->
                  <div class="card card-default">
                    <div class="card-header">
                      <center>
                        <h3 class="card-title">Datos de Contacto y Dirección</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">

                        <div class="form-group">
                          <label for="celular">Telefono/Cel:</label>
                          <input type="number" class="form-control @error('celular') is-invalid @enderror" id="celular" name="celular"  value="{{ $cliente->celular }}">
                        </div>
                        @error('celular')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
                        <div class="form-group">
                          <label for="email">Email:</label>
                          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $cliente->email }}">
                        </div>
                        @error('email')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="direccion">Dirección:</label>
                          <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ $cliente->direccion }}">
                        </div>
                        @error('direccion')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
                        <div class="form-group">
                          <label for="fechaalta">Fecha Alta:</label>
                          <input type="date" readonly class="form-control @error('fechaalta') is-invalid @enderror" id="fechaalta" name="fechaalta" value="{{ $cliente->fechaalta }}">
                        </div>
                        @error('fechaalta')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="estado">Estado:</label>
                          <select  id="estado" name="estado" class="form-control  @error('estado') is-invalid @enderror">
                            <option value="1" {{ $cliente->estado == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $cliente->estado == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        </div>
                        @error('estado')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
                        </div>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  <!-- /.card -->
                  </div>
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