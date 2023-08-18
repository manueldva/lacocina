@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@if($show == 1) Ver @else Editar @endif Venta</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Venta</a></li>
              <li class="breadcrumb-item active">@if($show == 1) Ver @else Editar @endif</li>
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
          <form action="{{ route('ventas.update',$venta->id) }}" method="POST">
            @csrf
            @method('PUT')
              <div class="row">
                <input type="hidden" name="listado_contactos" id="id_lista_contactos">
                <div class="col-md-12">
                  <!-- general form elements -->
                    <div class="card card-default">
                      <div class="card-header">
                        <div class="row justify-content-center align-items-center">
                          @if($show == 0)
                            @if($venta->estado == 1 || $venta->total == 0)
                              <div class="form-group">
                                <button name="guardar" id="guardar" type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Guardar</button>
                              </div>
                            @endif
                            @can('ventas.create')  
                            &nbsp; &nbsp; 
                            <div class="form-group">
                              <a class="btn btn-outline-info" href="{{ route('ventas.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
                            </div>
                            @endcan
                            &nbsp; &nbsp; 
                          @endif
                          <div class="form-group">
                            <a class="btn btn-outline-success" href="{{ route('ventas.index') }}"><i class="fas fa-list"></i> Listado</a>
                          </div>
                          <!-- /.col -->
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <!-- general form elements -->
                  <div class="card card-default">
                    <div class="card-header">
                      <center>
                        <h3 class="card-title">Datos de la Venta</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">
                        <div class="form-group">
                            <label for="cliente">cliente(*):</label>
                            <input type="text" class="form-control" id="cliente" name="cliente" value="{{ $venta->cliente->persona->apellido }} {{ $venta->cliente->persona->nombre }}" disabled>
                        </div>
                        <div class="form-group">
                          <label for="metodopago_id">Metodo Pago(*):</label>
                          <input type="text" class="form-control" id="metodopago_id" name="metodopago_id" value="{{ $venta->metodopago->descripcion }}" disabled>
                      </div>
                          <div class="form-group">
                              <label for="tipopago_id">Tipo de Pago:</label>
                              <select id="tipopago_id" name="tipopago_id" class="form-control @error('tipopago_id') is-invalid @enderror">
                                  <option value="">Seleccionar</option>
                                  @foreach($tipopagos as $tipopago)
                                      <option value="{{ $tipopago->id }}" @if ($venta->tipopago_id == $tipopago->id) selected @endif>
                                          {{ $tipopago->descripcion }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                          @error('tipopago_id')
                              <div class="alert alert-info" role="alert">
                                  {{ $message }}
                              </div>
                          @enderror
                          

                        <div class="form-group">
                            <label for="fecha">Fecha(*):</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $venta->fecha }}" disabled>
                        </div>
                        @error('fecha')
                            <div class="alert alert-info" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                          <label for="total">Total:</label>
                          <input type="number" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{ $venta->total }}">
                        </div>
                        @error('total')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          @if($ventafechas->isEmpty())
                            <input type="checkbox" name="estado" id="estado"  @if ($venta->estado == 1 ) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success"  data-on-text="Activo" data-off-text="Cerrado">
                            &nbsp; 
                          @endif
                            <input type="checkbox" name="pago" id="pago" @if ($venta->pago == 1 ) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success"  data-on-text="Pago" data-off-text="No pago">
                        </div>
                          

                      </div>
                      <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                </div>
                
                <div class="col-md-8"> <!-- Oculto por el momento-->
                  <!-- general form elements -->
                  <div class="card card-default">
                    <div class="card-header">
                      <center>
                        <h3 class="card-title">Detalle de la Venta</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                      <div class="form-group">
                        <div class="table-responsive">
                          <table class="table table-striped table-valign-middle table-bordered">
                            <thead>
                              <tr>
                                <th><center>Vianda</center></th>
                                <th><center>Precio</center></th>
                                <th><center>Cantidad</center></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($ventadetalles as $ventad)
                                <tr>
                                  <td>
                                    <center>
                                      {{ $ventad->vianda->descripcion }}
                                    </center>
                                  </td>
                                  
                                  <td>
                                    <center>
                                      {{ $ventad->precio }}
                                    </center>
                                  </td>
                                  <td>
                                    <center>
                                      {{ $ventad->cantidad }}
                                    </center>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>

                        <div class="table-responsive">
                          <table class="table table-striped table-valign-middle table-bordered">
                            <thead>
                              <tr>
                                <th><center>Fecha</center></th>
                                <th><center>Envio</center></th>
                                <th><center>Entregado</center></th>
                                <th><center>Cancelar</center></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($ventafechas as $ventaf)
                                <tr>
                                  <td>
                                    <center>
                                      {{ $ventaf->fecha }}
                                    </center>
                                  </td>
                                  
                                  <td>
                                      <center>
                                        <input @if($show == 1 ) disabled @endif type="checkbox" class="envio-checkbox" data-ventaf-id="{{ $ventaf->id }}" @if($ventaf->envio == 1) checked @endif data-on-switch-change="envioEntregado"  data-on-text="Si" data-off-text="No">
                                      </center>
                                  </td>
                                  <td>
                                    <center>
                                      <input @if($show == 1 ) disabled @endif type="checkbox" class="entregado-checkbox" data-ventaf-id="{{ $ventaf->id }}" @if($ventaf->entregado == 1) checked @endif data-on-switch-change="actualizarEntregado"  data-on-text="Si" data-off-text="No">
                                  </center>
                                  </td>
                                  <td>
                                    <center>
                                      <input @if($show == 1 ) disabled @endif type="checkbox" class="cancelar-checkbox" data-ventaf-id="{{ $ventaf->id }}"  data-on-switch-change="cancelarEntregado"  data-on-text="Si" data-off-text="No">
                                    </center>
                                </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                          </div>
                          @if($totalRegistrosRestantes > 0)
                            <center><h5>Quedan {{ $totalRegistrosRestantes }} registros para procesar y el {{ $ultimaFecha }} es la ultima entrega</h5></center>
                          @endif
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
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  });


    
  $(document).ready(function() {
      $(".entregado-checkbox").bootstrapSwitch();
      $(".envio-checkbox").bootstrapSwitch();
      $(".cancelar-checkbox").bootstrapSwitch();

      $("body").on("switchChange.bootstrapSwitch", ".entregado-checkbox, .cancelar-checkbox", function(event, state) {
          var checkbox = $(this);
          var ventafId = checkbox.data("ventaf-id");
          var entregado = $(".entregado-checkbox[data-ventaf-id='" + ventafId + "']").bootstrapSwitch("state") ? 1 : 0;
          var envio = $(".envio-checkbox[data-ventaf-id='" + ventafId + "']").bootstrapSwitch("state") ? 1 : 0;
          var cancelar = $(".cancelar-checkbox[data-ventaf-id='" + ventafId + "']").bootstrapSwitch("state") ? 1 : 0;

          var mensaje = cancelar ? "El registro ha sido cancelado y la fecha actualizada" : "El registro desaparecerá de este listado";
    

          // Realizar una solicitud AJAX para actualizar el registro en el servidor
          $.ajax({
              type: "POST",
              url: "{{ route('venta.actualizar_entregado') }}",
              data: {
                  ventaf_id: ventafId,
                  entregado: entregado,
                  envio: envio,
                  cancelar: cancelar,
                  _token: "{{ csrf_token() }}"
              },
              success: function(response) {
                  // Mostrar mensaje SweetAlert
                  Swal.fire({
                      icon: 'success',
                      title: 'Registro Actualizado',
                      text: mensaje,
                      showConfirmButton: true
                  }).then(function() {
                      // Recargar la página
                      location.reload();
                  });
              },
              error: function(xhr, status, error) {
                  console.error(error);
              }
          });
      });
  });

  $(document).ready(function() {
    var checkboxPago = $("#pago");
    var selectTipoPago = $("#tipopago_id");

    checkboxPago.on("switchChange.bootstrapSwitch", function(event, state) {
        if (state) {
            if (selectTipoPago.val() === "") {
                checkboxPago.bootstrapSwitch("state", false);
            } 
        }
    });

    selectTipoPago.on("change", function() {
        if (selectTipoPago.val() === "") {
            checkboxPago.bootstrapSwitch("state", false);
        } else {
            checkboxPago.bootstrapSwitch("state", true);
        }
    });
  });


</script>
@endsection