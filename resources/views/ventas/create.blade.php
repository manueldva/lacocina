@extends('layouts.app_principal')


@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Nueva Venta</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Venta</a></li>
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
            <form method="POST" action="{{ route('ventas.store') }}">
              @csrf
              <div class="row">
                <input type="hidden" name="listado_contactos" id="id_lista_contactos">
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
                        <h3 class="card-title">Datos de la venta</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">

                      <div class="form-group">
                          <label for="cliente_id">Cliente</label>
                          <select class="form-control" name="cliente_id" id="cliente_id">
                              <option value="0">Seleccione un cliente</option>
                              @foreach ($clientes as $cliente)
                                  <option value="{{ $cliente->id }}" data-total="{{ $cliente->totalPrecioViandas() }}" data-metodopago="{{ $cliente->metodopago_id }}">{{ $cliente->Apellido }} {{ $cliente->Nombre }}</option>
                              @endforeach
                          </select>

                        </div>
                        @error('cliente_id')
                            <div class="alert alert-info" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <label for="metodopago_id">Metodo de pago:</label>
                            <select id="metodopago_id" name="metodopago_id" class="form-control @error('metodopago_id') is-invalid @enderror">
                                <option value="">Seleccionar</option>
                                @foreach($metodopagos as $metodopago)
                                    <option value="{{ $metodopago->id }}">
                                        {{ $metodopago->descripcion }} ({{ $metodopago->dias }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('metodopago_id')
                            <div class="alert alert-info" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <label for="tipopago_id">Tipo de Pago:</label>
                            <select id="tipopago_id" name="tipopago_id" class="form-control @error('tipopago_id') is-invalid @enderror">
                                <option value="">Seleccionar</option>
                                @foreach($tipopagos as $tipopago)
                                    <option value="{{ $tipopago->id }}">
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
                          <label for="fecha">Fecha(*)</label>
                          <input type="date" class="form-control" id="fecha" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                      </div>
                      @error('fecha')
                          <div class="alert alert-info" role="alert">
                              {{ $message }}
                          </div>
                      @enderror

                      <div class="form-group">
                        <label for="total">Total:</label>
                        <input type="number" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{ old('total') }}">
                      </div>
                      @error('total')
                        <div class="alert alert-info" role="alert">
                          {{ $message }}
                        </div>
                      @enderror

                      <div class="form-group">
                        
                        <input type="checkbox" name="estado" id="estado"  checked data-bootstrap-switch data-off-color="danger" data-on-color="success"  data-on-text="Activo" data-off-text="Cerrado">
                        <input type="checkbox" name="pago" id="pago" data-bootstrap-switch data-off-color="danger" data-on-color="success"  data-on-text="Pago" data-off-text="No pago">
                      </div>
                        
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
               
        
                <div class="col-md-4" > <!-- Oculto por el momento-->
                  <!-- general form elements -->
                  <div class="card card-default">
                    <div class="card-header">
                      <center>
                        <h3 class="card-title">Detalle Viandas</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                      <div class="form-group">
                        <div class="form-group">
                          <table class="table table-borderless">
                              <tbody>
                                  @foreach($viandas as $vianda)
                                      <tr>
                                          <td>
                                              <label>
                                                  <input type="checkbox" name="viandas[]" value="{{ $vianda->id }}">  {{ Str::limit($vianda->descripcion, 10, '') }}
                                      
                                              </label>
                                          </td>
                                          <td>
                                            <input class="form-control form-control-sm cantidad-input" type="number" name="cantidad_{{ $vianda->id }}" id="cantidad_{{ $vianda->id }}" min="1" disabled>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                        </div>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  <!-- /.card -->
                  </div>
                </div>

                <div class="col-md-4" > <!-- Oculto por el momento-->
                  <!-- general form elements -->
                  <div class="card card-default">
                    <div class="card-header">
                      <center>
                        <h3 class="card-title">Datos Viandas</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                      <div class="form-group">

                        
                        
                        
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

        // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('#cliente_id').select2();
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    function toggleCantidad(checkbox) {
        var cantidadInput = checkbox.parentNode.parentNode.nextElementSibling.querySelector('input[type="number"]');
        cantidadInput.disabled = !checkbox.checked;
        if (checkbox.checked) {
            cantidadInput.value = 1;
        } else {
            cantidadInput.value = '';
        }
    }



    $(document).ready(function() {
        $('#cliente_id').change(function() {
            var selectedOption = $(this).find(':selected');
            var metodopago = selectedOption.data('metodopago');
            var total = selectedOption.data('total');
            var clienteId = selectedOption.val();


            // Restablecer estado de checkboxes y campos de cantidad
            $('input[name="viandas[]"]').prop('checked', false);
            $('input[name^="cantidad_"]').prop('disabled', true).val('');

            // Seleccionar la opción correspondiente en el select "metodopago_id" y cargar el total que corresponde al cliente
            $('#metodopago_id').val(metodopago);
            $('#total').val(total);

            
            $.ajax({
                url: '/ajax/get-cliente-info/' + clienteId,
                type: 'GET',
                success: function(response) {
                    var viandasCantidad = response.viandasSeleccionadas;

                    // Cargamos las cantidades correspondientes en los campos de cantidad
                    for (var viandaId in viandasCantidad) {

                         // Marcamos el checkbox correspondiente
                         var checkbox = $('input[name="viandas[]"][value="' + viandaId + '"]');
                        checkbox.prop('checked', true);
                        toggleCantidad(checkbox[0]);

                        var cantidad = viandasCantidad[viandaId];
                        $('#cantidad_' + viandaId).val(cantidad);
                        
                        
                        //$('input[name="viandas[]"][value="' + viandaId + '"]').prop('checked', true);
                       
                    }
                }
            });

        });
    });

    // Ejecutar el cambio de estado de los checkboxes al cargar la página
    $('input[name="viandas[]"]').on('change', function() {
        toggleCantidad(this);
    });
   
    $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });


    
</script>
@endsection