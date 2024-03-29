@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Nuevo Vianda</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('viandas.index') }}">Vianda</a></li>
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
            <form method="POST" action="{{ route('viandas.store') }}">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <!-- general form elements -->
                    <div class="card card-default">
                      <div class="card-header">
                        <div class="row justify-content-center align-items-center">
                          <div class="form-group">
                            <button name="guardar" id="guardar" type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Guardar</button>
                          </div> 
                          &nbsp; &nbsp; 
                          <div class="form-group">
                            <a class="btn btn-outline-success" href="{{ route('viandas.index') }}"><i class="fas fa-list"></i> Listado</a>
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
                          <label for="descripcion">Descripción(*):</label>
                          <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" placeholder="Eje: Clasica" value="{{ old('descripcion') }}">
                        </div>
                        @error('descripcion')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
                        <div class="form-group">
                          <label>Detalle:</label>
                          <textarea id= "detalle" name="detalle" class="form-control" rows="3" placeholder="Ingrese un detalle">{{ old('domicilio') }}</textarea>
                        </div>
                        @error('detalle')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="precio">Precio(*):</label>
                          <input type="number" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio" placeholder="Eje: 700" value="{{ old('precio') }}">
                        </div>
                        @error('precio')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="estado">Activo:</label>
                          <select disabled  id="activo" name="activo" class="form-control  @error('activo') is-invalid @enderror">
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        </div>
                        @error('activo')
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