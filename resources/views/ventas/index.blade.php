@extends('layouts.app_principal')
@section('css')
    <!-- Estilos CSS específicos para esta página -->
    <style>
        /* Aquí puedes agregar tus estilos personalizados */
        .fecha-column {
            width: 150px;
        }

        /* Asegúrate de agregar este estilo en una etiqueta <style> o en un archivo .css */
      .custom-modal-dialog {
        max-width: 800px; /* Ajusta el ancho deseado */
        width: 90%; /* También puedes usar porcentajes para mayor flexibilidad */
      }
    </style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Listado de Ventas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
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
                  @can('ventas.create') 
                    &nbsp;&nbsp;
                    <a class="btn btn-outline-info" href="{{ route('ventas.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
                    @endcan
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
                <div class="table-responsive">
                  <table class="table table-striped table-valign-middle table-bordered">
                    <thead>
                      <tr>
                        <th><center>Fecha</center></th>
                        <th><center>Cliente</center></th>
                        <th><center>Total a Entregar</center></th>
                        <th><center>Entregado</center></th>
                        <th><center>Estado</center></th>
                        <th width="280px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($ventas as $venta)
                        <tr>
                          <td>
                            <center>
                              {{ $venta->fecha }}
                            </center>
                          </td>
                          <td>
                            <center>
                              {{ $venta->cliente->persona->apellido }} {{ $venta->cliente->persona->nombre }}
                            </center>
                          </td>
                          <td>
                            <center>
                              {{ $venta->aEntregar }}
                            </center>
                          </td>
                          <td>
                            <center>
                              {{ $venta->entregado }}
                            </center>
                          </td>
                          
                          <td>
                            <center>
                              @if($venta->estado == 1)
                                <img src="{{url('image/on.ico')}}"  width="30" height="30" data-toggle="tooltip" data-placement="top" title="Activo">
                               
                              @else
                                <img src="{{url('image/off.ico')}}"  width="30" height="30" data-toggle="tooltip" data-placement="top" title="Inactivo">
                               
                              @endif
                            </center>
                          </td>
                         <td>
                            <center>
                           

                              <form action="{{ route('ventas.destroy',$venta->id) }}" method="POST">
                                  @can('ventas.show') 
                                    <a class="btn btn-sm btn-flat btn-outline-info btnDetalles" href="#" data-id="{{$venta->id}}" data-toggle="modal" data-target="#modalDetalles" data-toggle="tooltip" data-placement="top" title="Ver Detalles"><i class="fas fa-list"></i></a>
                                     
                                    <a class="btn btn-sm btn-flat btn-outline-info" href="{{ route('ventas.show',$venta->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Datos"><i class="fas fa-eye"></i> </a>                                  
                                  @endcan
                                  @can('ventas.edit')  
                                    <!--<a class="btn btn-sm btn-flat btn-outline-info" href="{{ route('clientes.show',$venta->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Datos"><i class="fas fa-eye"></i> </a>-->
                                    <a class="btn btn-sm btn-flat btn-outline-secondary" href="{{ route('ventas.edit',$venta->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Datos"><i class="fas fa-edit"></i> </a>
                                  @endcan
                                  @can('ventas.destroy')  
                                    <a  href="#" data-id="{{$venta->id}}" class="btn btn-sm btn-flat btn-outline-danger btnDelete  @if($venta->estado == 0) disabled @endif" data-toggle="modal" data-target="#delete"  data-toggle="tooltip" data-placement="top" title="Eliminar Registro">
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
                  </div>
                  <br>
                  <div>
                    <strong>
                      <?php echo  'Mostrando ' . $ventas->firstItem() . ' a ' . $ventas->lastItem() . ' de ' . $ventas->total() . ' registros'; ?> 
                       {{ $ventas->appends(Request::only(['tipo','buscarpor']))->links() }}
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
     <!-- Modal para mostrar los detalles de la venta -->
<div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="modalDetallesLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable custom-modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="modalDetallesLabel">Detalles de Venta</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <table class="table table-striped table-valign-middle table-bordered">
                <thead>
                    <tr>
                        <th><center>Fecha</center></th>
                        <th><center>Detalle</center></th>
                        <th><center>Envio</center></th>
                        <th><center>Entregado</center></th>
                    </tr>
                </thead>
                <tbody id="detallesVentaBody">
                    <!-- Aquí se cargarán los detalles de la venta mediante JavaScript -->
                </tbody>
            </table>
            <div class="pagination-container">
                <ul class="pagination"></ul>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
      var v = $(this).data('id');
      $('#frmdelete').attr('action', '{{asset('ventas')}}/'+v);
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
    

   

    $('.btnDetalles').on('click', function() {
        var ventaId = $(this).data('id');
        cargarDetallesVenta(ventaId);
    });

    function cargarDetallesVenta(ventaId) {
        var detallesVentaBody = $('#detallesVentaBody');
        detallesVentaBody.empty(); // Limpiar contenido actual de la tabla

        $.ajax({
            url: '{{ url('detallesVenta') }}/' + ventaId,
            type: 'GET',
            success: function(data) {
                // Construir el contenido de la tabla con los detalles de la venta
                var detallesVentaBody = $('#detallesVentaBody');
                detallesVentaBody.empty(); // Limpiar contenido actual de la tabla

                data.fechas.forEach(function(fecha) {
                    //var rowClass = fecha.entregado === 1 ? 'background-color: #e6f7ff;' : 'background-color: #f1f1f1;';
                    var envioIcon = fecha.envio === 1 ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>';
                    var entregadoIcon = fecha.entregado === 1 ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>';
                    var row = '<tr>';
                    row += '<td><center>' + fecha.fecha + '</center></td>';
                    row += '<td><center>' + fecha.detallesTexto + '</center></td>';
                    row += '<td><center>' + envioIcon + '</center></td>';
                    row += '<td><center>' + entregadoIcon + '</center></td>';
                    row += '</tr>';
                    detallesVentaBody.append(row);
                });
            },
            error: function() {
                console.error('Error al cargar los detalles de la venta');
            }
        });
    }


  </script> 

@endsection