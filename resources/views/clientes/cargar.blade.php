@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cargar Venta</h1>
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
                            @can('clientes.create')  
                            &nbsp; &nbsp; 
                            <div class="form-group">
                              <a class="btn btn-outline-info" href="{{ route('clientes.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
                            </div>
                            @endcan
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
                            <table class="table table-striped table-valign-middle table-bordered">
                              <thead>
                                <tr>
                                  <th><center>Fecha</center></th>
                                  <th><center>Tipo Pago</center></th>
                                  <th><center>Total</center></th>
                                  <th><center>TotalPagado</center></th>
                                  <th width="140px"></th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($ventasDelDia as $venta)
                                <tr>
                                    <td><center>{{ $venta->fecha }}</center></td>
                                    <td><center>{{ $venta->tipoPago ? $venta->tipoPago->descripcion : 'Sin tipo de pago' }}</center></td>
                                    <td><center>{{ $venta->total }}</center></td>
                                    <td><center>{{ $venta->totalpagado }}</center></td>
                                    <td>
                                      <form action="{{ route('clientes.ventas.eliminar', ['cliente' => $cliente->id, 'venta' => $venta->id]) }}" method="POST">
                                          @csrf
                                          @method('POST') <!-- Cambia DELETE por POST -->
                                          <button type="submit" class="btn btn-danger">Eliminar</button>
                                      </form>
                                    </td>
                                  </tr>
                                @endforeach
                               
                              </tbody>
                            </table>
                            
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


    // Obtener los elementos necesarios
    const cantidadInputs = document.querySelectorAll('.cantidad-input');
    const checkboxes = document.querySelectorAll('input[name="viandas[]"]');
    const totalInput = document.getElementById('total');
    
  
    // Escuchar el evento change en los campos de cantidad
    cantidadInputs.forEach(function(input) {
        input.addEventListener('change', calcularMontoTotal);
    });

    // Escuchar el evento change en los checkboxes
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', calcularMontoTotal);
    });

    // Calcular el monto total
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
        
        if (montoTotal.toFixed(2) === '0.00') {
          document.getElementById('guardar').disabled = true;
        } else {
          document.getElementById('guardar').disabled = false;
        }
    }


</script>
@endsection