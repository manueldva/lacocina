@extends('layouts.app_principal')

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
                    <option value='nombre'>Nombre</option>
                    <option value='apellido'>Apellido</option>
                    <option value='id'>Codigo</option>
                  </select>
                  <input name="buscarpor" id="buscarpor" class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
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
                        <th><center>Estado</center></th>
                        <th width="280px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($clientes as $cliente)
                        <tr>
                          <td>
                            <center>
                              {{ $cliente->codigo }}
                            </center>
                          </td>
                          <td>
                            <center>
                              {{ $cliente->apellido }}
                            </center>
                          </td>
                          <td>
                            <center>
                              {{ $cliente->nombre }}
                            </center>
                          </td>
                          <td>
                            <center>
                              @if($cliente->estado == 1)
                                <img src="{{url('image/on.ico')}}"  width="30" height="30" data-toggle="tooltip" data-placement="top" title="Activo">
                               
                              @else
                                <img src="{{url('image/off.ico')}}"  width="30" height="30" data-toggle="tooltip" data-placement="top" title="Inactivo">
                               
                              @endif
                            </center>
                          </td>
                         <td>
                            <center>
                           

                              <form action="{{ route('clientes.destroy',$cliente->id) }}" method="POST">
                                  <a class="btn btn-sm btn-flat btn-outline-info" href="{{ route('clientes.show',$cliente->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Datos"><i class="fas fa-eye"></i> </a>
                                  <a class="btn btn-sm btn-flat btn-outline-secondary" href="{{ route('clientes.edit',$cliente->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Datos"><i class="fas fa-edit"></i> </a>
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-sm btn-flat btn-outline-danger" onclick="return confirm('¿Esta Seguro de eliminar este registro?')"><i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Eliminar Cliente"></i></button>
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
    </section>
    <!-- /.content -->
@endsection

@section('js')
  <script type="text/javascript">
    
    function searchType(){ 
       var type = $('#tipo').val();
      if (type == 'id'){
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
    
  </script> 

@endsection