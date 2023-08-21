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
                        <h3 class="card-title">Movimiento del Clientes</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group col-md-5">
                                <label for="fechaDesde">Fecha Desde</label>
                                <input type="date" class="form-control" id="fechadesde" value="{{ \Carbon\Carbon::now()->subDays(7)->format('Y-m-d') }}">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="fechaHasta">Fecha Hasta</label>
                                <input type="date" class="form-control" id="fechahasta" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <div class="form-group  col-md-5">
                              <label for="cliente_id">ID del Cliente</label>
                              <select class="form-control" name="cliente_id" id="cliente_id">
                                  <option value="">Seleccione un cliente</option>
                                  @foreach ($clientes as $cliente)
                                      <option value="{{ $cliente->id }}">{{ $cliente->Apellido }} {{ $cliente->Nombre }}</option>
                                  @endforeach
                              </select>

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
      var fechadesde = $("#fechadesde").val() || "2023-01-01";
      var fechahasta = $("#fechahasta").val() || fechaActualFormateada;

      var cliente = $("#cliente_id").val();
      e.preventDefault();
      window.open("{{url('print1')}}/"+ cliente + "/" + fechadesde + "/" + fechahasta + "/" + 0);


  });


  $(document).ready(function() {
        // Agregar evento click al botón "Generar Informe"
        $("#btnGenerarInforme").click(function() {
            // Obtener el valor seleccionado en el campo de selección
            var cliente = $("#cliente_id").val();
            
            // Validar si se ha seleccionado un cliente antes de generar el informe
            if (!cliente) {
                // Mostrar una alerta con SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Por favor, seleccione un cliente antes de generar el informe.'
                });
                // Detener la ejecución del botón
                return false;
            }
        });
    });
</script>
@endsection