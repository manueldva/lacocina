@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cargar Venta-Pago</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Cliente</a></li>
              <li class="breadcrumb-item active">Venta</li>
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
          <form action="{{ route('clientes.guardarviandas',$cliente->id) }}" method="POST">
            @csrf
              <div class="row">
                <input type="hidden" name="listado_contactos" id="id_lista_contactos">
                <div class="col-md-12">
                  <!-- general form elements -->
                    <div class="card card-default">
                      <div class="card-header">
                        <div class="row justify-content-center align-items-center">
                          @if($show == 0)
                            <div class="form-group">
                              <button name="guardar" id="guardar" type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Guardar</button>
                            </div>
                            <!--@can('clientes.create')  
                            &nbsp; &nbsp; 
                            <div class="form-group">
                              <a class="btn btn-outline-info" href="{{ route('clientes.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
                            </div>
                            @endcan-->
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
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha"  value="{{ old('fecha', date('Y-m-d')) }}">
                          </div>
                          @error('fecha')
                            <div class="alert alert-info" role="alert">
                              {{ $message }}
                            </div>
                          @enderror

                          <div class="form-group">
                            <label>
                            <input type="checkbox" name="pago" value="1"> Realiza un pago
                            </label>
                            &nbsp;&nbsp;
                            <label>
                            <input type="checkbox" name="envio" value="1"> Con Envio
                            </label>
                          </div>

                          <div class="form-group">
                            <table class="table table-borderless">
                                <tbody>
                                    @foreach($viandas as $vianda)
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="viandas[]" value="{{ $vianda->id }}" {{ in_array($vianda->id, $viandasSeleccionadas) ? 'checked' : '' }} onclick="toggleCantidad(this)"> {{ Str::limit($vianda->descripcion, 10, '') }}
                                                </label>
                                            </td>
                                            <td>
                                              <input class="form-control form-control-sm cantidad-input" type="number" name="cantidad_{{ $vianda->id }}" id="cantidad_{{ $vianda->id }}" min="1" value="{{ old('cantidad_' . $vianda->id, $cantidades[$vianda->id] ?? '') }}" {{ in_array($vianda->id, $viandasSeleccionadas) ? '' : 'disabled' }}>
                                            </td>
                                            <td style="display: none;" class="precio">{{ $vianda->precio }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>

                          <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" id="total" name="total" value="{{ $montoTotal ?? '' }}" disabled>
                          </div>
                          @error('total')
                            <div class="alert alert-info" role="alert">
                              {{ $message }}
                            </div>
                          @enderror

                          <div class="form-group">
                            <label for="totalpagado">Total Pagado</label>
                            <input type="number" class="form-control" id="totalpagado" name="totalpagado" min="0">
                          </div>
                          @error('totalpagado')
                            <div class="alert alert-info" role="alert">
                              {{ $message }}
                            </div>
                          @enderror
                          <br>
                          <hr>
                          <div class="card-body  p-3">
                          <!--<div class="card-body p-0">-->
                          <div class="table-responsive">
                            <table class="table table-striped table-valign-middle table-bordered">
                              <thead>
                                <tr>
                                  <th><center>Fecha</center></th>
                                  <th><center>Tipo Pago</center></th>
                                  <th><center>Concepto</center></th>
                                  <th><center>Total</center></th>
                                  <th><center>TotalPagado</center></th>
  
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($ventasDelDia as $venta)
                                <tr>
                                    <td><center>{{ $venta->fecha }}</center></td>
                                    <td><center>{{ $venta->tipoPago ? $venta->tipoPago->descripcion : 'Sin tipo de pago' }}</center></td>
                                    <td><center>{{ $venta->pago == 1 ? 'Pago' : 'Venta' }}</center></td>
                                    <td><center>{{ $venta->total }}</center></td>
                                    <td><center>{{ $venta->totalpagado }}</center></td>
                                    
                                  </tr>
                                @endforeach
                               
                              </tbody>
                            </table>
                            </div>
                            <br>
                            {{ $ventasDelDia->links() }}
                            <div>
                            
                          <!--</div>-->
                        </div>
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

    function toggleCantidad(checkbox) {
        var cantidadInput = checkbox.parentNode.parentNode.nextElementSibling.querySelector('input[type="number"]');
        cantidadInput.disabled = !checkbox.checked;
        if (checkbox.checked) {
            cantidadInput.value = 1;
        } else {
            cantidadInput.value = '';
        }
    }

    // Array para almacenar las cantidades originales de los checkboxes secundarios
    let cantidadesOriginales = [];

    // Obtener los elementos necesarios
    const cantidadInputs = document.querySelectorAll('.cantidad-input');
    const checkboxes = document.querySelectorAll('input[name="viandas[]"]');
    const totalInput = document.getElementById('total');
    const totalPagadoInput = document.getElementById('totalpagado');

    // Escuchar el evento change en los campos de cantidad
    cantidadInputs.forEach(function(input) {
        input.addEventListener('change', calcularMontoTotal);
    });

    // Escuchar el evento change en los checkboxes
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', calcularMontoTotal);
    });

    // Función para calcular el monto total y actualizar los campos correspondientes
    function calcularMontoTotal() {
        let montoTotal = 0;
        cantidadInputs.forEach(function(input, index) {
            if (input.value !== '' && !isNaN(input.value) && checkboxes[index].checked) {
                const cantidad = parseInt(input.value);
                const precio = parseFloat(input.closest('tr').querySelector('.precio').textContent);
                montoTotal += cantidad * precio;
            }
        });
        totalInput.value = montoTotal.toFixed(2);

        // Habilitar o deshabilitar el botón "Guardar" según el monto total y el estado del checkbox "pago"
        document.getElementById('guardar').disabled = (montoTotal.toFixed(2) === '0.00' && !$('input[name="pago"]').is(':checked'));

        totalPagadoInput.value = ($('input[name="pago"]').is(':checked')) ? 0 : 0;
        totalPagadoInput.min = ($('input[name="pago"]').is(':checked')) ? 1 : 0;
    }

    // Evento change para el checkbox principal
    $('input[name="pago"]').change(function() {
        if ($(this).is(':checked')) {
            // El checkbox está marcado (realiza un pago)
            console.log('El checkbox está marcado');

            // Guardar las cantidades actuales de los checkboxes secundarios antes de desmarcarlos
            cantidadesOriginales = [];
            $('input[name="viandas[]"]').not('#envio').each(function() {
                cantidadesOriginales.push({
                    checked: this.checked,
                    cantidad: this.value
                });
                this.checked = false;
                toggleCantidad(this);
            });
        } else {
            // El checkbox no está marcado (no realiza un pago)
            console.log('El checkbox no está marcado');

            // Si hay cantidades guardadas, restaurar los checkboxes secundarios a sus valores originales
            if (cantidadesOriginales.length > 0) {
                $('input[name="viandas[]"]').not('#envio').each(function(index) {
                    this.checked = cantidadesOriginales[index].checked;
                    toggleCantidad(this);
                });
            }

            // Vaciar el array de cantidades originales
            cantidadesOriginales = [];
        }

        // Recalcular el monto total cuando se marque o desmarque "pago" o un checkbox secundario
        calcularMontoTotal();
    });

    // Evento change para los checkboxes secundarios
    $('input[name="viandas[]"]').not('#envio').change(function() {
        // Desmarcar el checkbox principal si algún checkbox secundario se marca
        $('input[name="pago"]').prop('checked', false);

        // Recalcular el monto total cuando se marque o desmarque un checkbox secundario
        calcularMontoTotal();
    });

    // Calcular el monto total al cargar la página
    calcularMontoTotal();

    

</script>
@endsection