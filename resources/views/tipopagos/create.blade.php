@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Nuevo T. Pago</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('tipopagos.index') }}">T. Pagos</a></li>
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
            <form method="POST" action="{{ route('tipopagos.store') }}">
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
                            <a class="btn btn-outline-success" href="{{ route('tipopagos.index') }}"><i class="fas fa-list"></i> Listado</a>
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
                          <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" placeholder="Eje: Celular" value="{{ old('descripcion') }}">
                        </div>
                        @error('descripcion')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="recargo">Recargo:</label>
                          <select  id="recargo" name="recargo" class="form-control  @error('recargo') is-invalid @enderror">
                            <option value="0" selected>No</option>
                            <option value="1">Si</option>
                        </select>
                        </div>
                        @error('recargo')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror


                        <div class="form-group">
                          <label for="porcentajerecargo">% Recargo:</label>
                          <input type="number" class="form-control @error('porcentajerecargo') is-invalid @enderror" id="porcentajerecargo" name="porcentajerecargo" placeholder="Eje: 10" value="{{ old('porcentajerecargo') }}">
                        </div>
                        @error('porcentajerecargo')
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

		
    function habilitarMotivoEstado(){
			var estado = $("#recargo").val();
			if(estado == 1 ) {
				$("#porcentajerecargo").prop( "disabled", false );
        $("#porcentajerecargo").focus();
			} else {
				$("#porcentajerecargo").prop( "disabled", true );
        $("#porcentajerecargo").val('');
			}
		}

    habilitarMotivoEstado();

		$('#recargo').on('change', function(e){
      habilitarMotivoEstado();
		});


</script>
@endsection