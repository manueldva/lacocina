@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@if($show == 1) Ver @else Editar @endif Calle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('calles.index') }}">Calles</a></li>
              <li class="breadcrumb-item active">Editar</li>
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
            <form action="{{ route('calles.update',$calle->id) }}" method="POST">
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
                            @can('complementos.create')  
                            &nbsp; &nbsp; 
                            <div class="form-group">
                              <a class="btn btn-outline-info" href="{{ route('calles.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
                            </div>
                            @endcan
                          @endif
                          &nbsp; &nbsp; 
                          <div class="form-group">
                            <a class="btn btn-outline-success" href="{{ route('calles.index') }}"><i class="fas fa-list"></i> Listado</a>
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
                          <label for="descripcion">Descripción:</label>
                          <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" value="{{ $calle->descripcion }}">
                        </div>
                        @error('descripcion')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="estado">Activo:</label>
                          <select  id="activo" name="activo" class="form-control  @error('activo') is-invalid @enderror">
                            <option value="1" {{ $calle->activo == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $calle->activo == '0' ? 'selected' : '' }}>Inactivo</option>
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