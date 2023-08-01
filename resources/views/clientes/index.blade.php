@extends('layouts.app_principal')
@section('css')
    <!-- Estilos CSS específicos para esta página -->
    <style>
        /* Aquí puedes agregar tus estilos personalizados */
        .fecha-column {
            width: 100px;
        }
    </style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Listado de Clientes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
              <li class="breadcrumb-item active">Listado</li>
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
       <div class="row  justify-content-center align-items-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <!-- <h3 class="card-title">Listado de Clientes</h3>-->

                <form class="form-inline float-right">
                  <select name="tipo" class="form-control mr-sm-2" id="tipo">
                    <option value=''>Buscar por...</option>
                    <option value='nombre' @if($buscador == 'nombre') selected @endif>Nombre</option>
                    <option value='apellido' @if($buscador == 'apellido') selected @endif>Apellido</option>
                    <option value='documento' @if($buscador == 'documento') selected @endif>Documento</option>
                  </select>
                  &nbsp;&nbsp;
                  <input name="buscarpor" id="buscarpor"  value="{{ $dato }}" class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
                  &nbsp;&nbsp;
                  <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i>Buscar</button>
                  &nbsp;&nbsp;
                  <a class="btn btn-outline-info" href="{{ route('clientes.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
                </form>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 200px;">
                                        <!--
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                    &nbsp;&nbsp;
                  -->
                    
                   
                   
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body  p-3">
                <!--<div class="card-body p-0">-->
                  <table class="table table-striped table-valign-middle table-bordered">
                    <thead>
                      <tr>
                        <th><center>Codigo</center></th>
                        <th><center>Apellido</center></th>
                        <th><center>Nombre</center></th>
                        <th><center>Deuda</center></th>
                        <th><center>Estado</center></th>
                        <th width="280px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($clientes as $cliente)
                        <tr>
                          <td>
                            <center>
                              {{ $cliente->id }}
                            </center>
                          </td>
                          <td>
                            <center>
                              {{ $cliente->persona->apellido }}
                            </center>
                          </td>
                          <td>
                            <center>
                              {{ $cliente->persona->nombre }}
                            </center>
                          </td>
                          <td><center>
                          @if ($cliente->monto_adeudado > 0)
                            <span class="text-danger">Debe: ${{ $cliente->monto_adeudado }}</span>
                          @else
                            <span class="text-success">@if ($cliente->monto_adeudado !=  0) A Favor: @endif ${{ abs($cliente->monto_adeudado) }}</span>
                          @endif
                          </center>
                          </td>
                          <td>
                            <center>
                              @if($cliente->activo == 1)
                                <img src="{{url('image/on.ico')}}"  width="30" height="30" data-toggle="tooltip" data-placement="top" title="Activo">
                               
                              @else
                                <img src="{{url('image/off.ico')}}"  width="30" height="30" data-toggle="tooltip" data-placement="top" title="Inactivo">
                               
                              @endif
                            </center>
                          </td>
                         <td>
                            <center>
                           

                              <form action="{{ route('clientes.destroy',$cliente->id) }}" method="POST">
                                  <a class="btn btn-sm btn-flat btn-outline-dark" href="#" data-toggle="modal" data-target="#modalVentas" data-cliente-id="{{ $cliente->id }}" data-placement="top" title="Detalle ventas"><i class="fas fa-list"></i> </a>
                                  <a class="btn btn-sm btn-flat btn-outline-primary" href="{{ route('clientes.cargarviandas',$cliente->id) }}" data-toggle="tooltip" data-placement="top" title="Cargar Venta"><i class="fas fa-address-card"></i> </a>
                                  <!--<a class="btn btn-sm btn-flat btn-outline-info" href="{{ route('clientes.show',$cliente->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Datos"><i class="fas fa-eye"></i> </a>-->
                                  <a class="btn btn-sm btn-flat btn-outline-secondary" href="{{ route('clientes.edit',$cliente->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Datos"><i class="fas fa-edit"></i> </a>
                                  @can('complementos.destroy')  
                                    <a href="#" data-id="{{$cliente->id}}" class="btn btn-sm btn-flat btn-outline-danger btnDelete" data-toggle="modal" data-target="#delete"  data-toggle="tooltip" data-placement="top" title="Eliminar Registro">
                                      <i class="fas fa-trash-alt"></i>
                                    </a>
                                  @endcan
                              </form>
                            </center>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

                  <br>
                  <div>
                    <strong>
                      <?php echo  'Mostrando ' . $clientes->firstItem() . ' a ' . $clientes->lastItem() . ' de ' . $clientes->total() . ' registros'; ?> 
                       {{ $clientes->appends(Request::only(['tipo','buscarpor']))->links() }}
                    </strong>  
                <!--</div>-->
              </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
      <!-- Modal para mostrar las ventas del cliente -->
      <div class="modal fade" id="modalVentas" tabindex="-1" role="dialog" aria-labelledby="modalVentasLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modalVentasLabel">Ventas de <span id="clienteNombre"></span></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      
                  </div>
                  <div class="modal-body">
                              <!-- Filtros de fecha -->
                      <div class="form-row">
                          <div class="form-group col-md-5">
                              <label for="fechaDesde">Fecha Desde</label>
                              <input type="date" class="form-control" id="fechaDesde" value="{{ \Carbon\Carbon::now()->subDays(7)->format('Y-m-d') }}">
                          </div>
                          <div class="form-group col-md-5">
                              <label for="fechaHasta">Fecha Hasta</label>
                              <input type="date" class="form-control" id="fechaHasta" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                          </div>
                          <div class="form-group col-md-2">
                           <!-- Agregar botón para aplicar el filtro de fechas -->
                            <label for="fechaHasta">&nbsp</label>
                            <br>
                            <button type="button" class="btn btn-primary" id="btnFiltrarVentas">Filtrar</button>
                          </div>
                      </div>
                      
                      <div class="table-responsive">
                          <table class="table table-striped table-valign-middle table-bordered">
                              <thead>
                                  <tr>
                                      <th class="fecha-column"><center>Fecha</center></th>
                                      <th><center>Tipo Pago</center></th>
                                      <th><center>Cantidad</center></th>
                                      <th><center>Concepto</center></th>
                                      <th><center>Total</center></th>
                                      <th><center>Pagado</center></th>
                                  </tr>
                              </thead>
                              <tbody id="ventasDelClienteBody">
                                  <!-- Aquí se cargarán las ventas del cliente mediante JavaScript -->
                              </tbody>
                          </table>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  </div>
                  <!-- Agregar el contenedor de paginación -->
                  <div class="modal-footer justify-content-center">
                      <ul class="pagination"></ul>
                  </div>
              </div>
          </div>
      </div>
      <!-- Modal -->
      <div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <!--<h4 class="modal-title text-center" id="myModalLabel">Eliminar confirmación</h4>-->
            </div>
            <form id="frmdelete" action="" method="POST">
                {{method_field('delete')}}
                {{csrf_field()}}
              <div class="modal-body">
              <p class="text-center">
                <h5>
                  <center>
                    ¿Estás seguro de que quieres eliminar esto?
                  </center>
                </h5>
              </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">No, cancelar</button>
                <button type="submit" class="btn btn-warning">Sí, eliminar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
  <script type="text/javascript">
    
    $('.btnDelete').on('click', function(){
      var c = $(this).data('id');
      $('#frmdelete').attr('action', '{{asset('clientes')}}/'+c);
      //$('#deleteEmpleado').modal('show');
    });

    function searchType(){ 
       var type = $('#tipo').val();
      if (type == 'documento'){
        $('#buscarpor').attr('type','number');
        $('#buscarpor').focus();
      } else
      {
        $('#buscarpor').attr('type','text');
        $('#buscarpor').focus();
      }
    }

    searchType(); 

    $('#tipo').change(function(e) {
      searchType(); 
      $('#buscarpor').val('');
      $('#buscarpor').focus();
    });
    

   // Actualizar la función cargarVentas para aceptar las fechas como parámetros
   function cargarVentas(page, clienteId, fechaDesde, fechaHasta) {
        var ventasDelClienteBody = $('#ventasDelClienteBody');
        ventasDelClienteBody.empty(); // Limpiar contenido actual de la tabla

        // Actualizar el título del modal con el apellido y nombre del cliente
        $('#clienteNombre').text('');

        $.ajax({
            url: '{{ url('ventasDelCliente') }}/' + clienteId + '?page=' + page,
            type: 'GET',
            data: {
                fechaDesde: fechaDesde,
                fechaHasta: fechaHasta
            },
            success: function(data) {
                // Construir el contenido de la tabla con las ventas del cliente
                var ventasDelClienteBody = $('#ventasDelClienteBody');
                ventasDelClienteBody.empty(); // Limpiar contenido actual de la tabla

                // Actualizar el título del modal con el apellido y nombre del cliente
                $('#clienteNombre').text(data.cliente.persona.apellido + ' ' + data.cliente.persona.nombre);

                data.ventas.forEach(function(venta) {
                    var row = '<tr>';
                    row += '<td><center>' + venta.fecha + '</center></td>';
                    row += '<td><center>' + (venta.tipo_pago ? venta.tipo_pago.descripcion : 'Sin tipo de pago') + '</center></td>';
                    row += '<td><center>' + venta.cantidadviandas + '</center></td>';
                    row += '<td><center>' + (venta.pago == 1 ? 'Pago' : 'Venta') + '</center></td>';
                    row += '<td><center>' + venta.total + '</center></td>';
                    row += '<td><center>' + venta.totalpagado + '</center></td>';
                    row += '</tr>';
                    ventasDelClienteBody.append(row);
                });

                // Actualizar los enlaces de paginación manualmente
                var pagination = '';
                for (var i = 1; i <= data.lastPage; i++) {
                    pagination += '<li class="page-item ' + (i === data.currentPage ? 'active' : '') + '">';
                    pagination += '<a class="page-link" href="#" data-page="' + i + '">' + i + '</a>';
                    pagination += '</li>';
                }
                $('.pagination').html(pagination);
            },
            error: function() {
                console.error('Error al cargar las ventas del cliente');
            }
        });
    }

    // Cuando el modal se muestre, cargar las ventas del cliente seleccionado
    $('#modalVentas').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        clienteId = button.data('cliente-id');

        // Obtener las fechas seleccionadas al mostrar el modal
        var fechaDesde = $('#fechaDesde').val();
        var fechaHasta = $('#fechaHasta').val();

        // Cargar las ventas del cliente con las fechas filtradas
        cargarVentas(1, clienteId, fechaDesde, fechaHasta);

        // Manejar clic en los enlaces de paginación dentro del modal
        $('#modalVentas').on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).data('page');
            cargarVentas(page, clienteId, fechaDesde, fechaHasta); // Cargar las ventas de la página seleccionada
        });
    });

    // Agregar evento al botón "Filtrar" dentro del modal
    $('#modalVentas').on('click', '#btnFiltrarVentas', function() {
        // Obtener las fechas seleccionadas
        var fechaDesde = $('#fechaDesde').val();
        var fechaHasta = $('#fechaHasta').val();

        // Cargar las ventas con el filtro de fechas
        cargarVentas(1, clienteId, fechaDesde, fechaHasta);
    });

     // Establecer las fechas seleccionadas al cerrar el modal
    $('#modalVentas').on('hide.bs.modal', function(event) {
        // Obtener la fecha actual y la fecha de una semana atrás
        var fechaActual = obtenerFechaActual();
        var fechaUnaSemanaAtras = new Date();
        fechaUnaSemanaAtras.setDate(fechaUnaSemanaAtras.getDate() - 7);
        var fechaUnaSemanaAtrasStr = fechaUnaSemanaAtras.toISOString().slice(0, 10);

        // Establecer los valores de fecha en los campos "Fecha Desde" y "Fecha Hasta" del modal
        $('#fechaDesde').val(fechaUnaSemanaAtrasStr);
        $('#fechaHasta').val(fechaActual);
    });

    function obtenerFechaActual() {
        var fecha = new Date();
        var anio = fecha.getFullYear();
        var mes = ('0' + (fecha.getMonth() + 1)).slice(-2);
        var dia = ('0' + fecha.getDate()).slice(-2);
        return anio + '-' + mes + '-' + dia;
    }

   
  </script> 

@endsection