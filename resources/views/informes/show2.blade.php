@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cliente - Informes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('informes.index') }}">Informes</a></li>
              <li class="breadcrumb-item active">Informes</li>
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
              <div class="row">
                
              </div>
              <div class="row justify-content-center align-items-center">
                <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="card card-default">
                    <div class="card-header">
                      <center>
                        <h3 class="card-title">Entregas del Dia</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group col-md-5">
                                <label for="fecha">Fecha:</label>
                                <input type="date" class="form-control" id="fecha" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            
                            
                            <a target="_blank" href="#" id="imprimir">
                                <button type="button" class="btn btn btn-primary" id="btnGenerarInforme">Generar Informe</button>
                            </a>
                                                    
                        </div>
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                </div>
              </div>

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



    // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('#cliente_id').select2();
  });

  $('#imprimir').on('click', function(e){
    
      /*var fechadesde = $("#fechadesde").val();
      var fechahasta = $("#fechahasta").val();*/

      var fechaActual = new Date();
      var añoActual = fechaActual.getFullYear();
      var mesActual = fechaActual.getMonth() + 1; // Los meses se cuentan desde 0 (enero) hasta 11 (diciembre)
      var diaActual = fechaActual.getDate();

      // Ajustar el formato de la fecha actual a "YYYY-MM-DD"
      var fechaActualFormateada = añoActual + '-' + (mesActual < 10 ? '0' : '') + mesActual + '-' + (diaActual < 10 ? '0' : '') + diaActual;

      // Obtener las fechas desde el formulario o usar las predeterminadas si están vacías o nulas
      var fecha = $("#fecha").val() || fechaActualFormateada;

      e.preventDefault();
      window.open("{{url('print2')}}/"+ fecha);


  });


  $(document).ready(function() {
        // Agregar evento click al botón "Generar Informe"
        $("#btnGenerarInforme").click(function() {
            // Obtener el valor seleccionado en el campo de selección
            var fecha = $("#fecha").val();
            
            // Validar si se ha seleccionado un cliente antes de generar el informe
            if (!fecha) {
                // Mostrar una alerta con SweetAlert
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Por favor, seleccione una fecha antes de generar el informe.'
                });
                // Detener la ejecución del botón
                return false;
            }
        });
    });
</script>
@endsection