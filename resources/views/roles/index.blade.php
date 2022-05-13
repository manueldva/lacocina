@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Gestionar Roles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
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
                <h3 class="card-title">Listado de Roles</h3>

                <form class="form-inline float-right">
                  <select name="tipo" class="form-control mr-sm-2" id="tipo">
                    <option value=''>Buscar por...</option>
                    <option value='name' @if($buscador == 'name') selected @endif>Descripción</option>
                  </select>
                  <input name="buscarpor" id="buscarpor" value="{{ $dato }}" class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
                     <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i>Buscar</button>
                        &nbsp;&nbsp;
                      @can('roles.create')  
                        <a class="btn btn-outline-primary" href="{{ route('roles.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
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
                  <table class="table table-striped table-valign-middle table-bordered">
                    <thead>
                      <tr>
                        <th><center>Codigo</center></th>
                        <th><center>Descripción</center></th>
                        <th width="280px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($roles as $role)
                        <tr>
                          <td>
                            <center>
                              {{ $role->id }}
                            </center>
                          </td>
                          <td>
                            <center>
                              {{ $role->name }}
                            </center>
                          </td>
                         <td>
                            <center>
                              @can('roles.show')  
                                <a class="btn btn-sm btn-flat btn-outline-info" href="{{ route('roles.show',$role->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Datos"><i class="fas fa-eye"></i> </a>
                              @endcan
                              @can('roles.edit')  
                                <a class="btn btn-sm btn-flat btn-outline-secondary" href="{{ route('roles.edit',$role->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Datos"><i class="fas fa-edit"></i> </a>
                              @endcan
                              @can('roles.destroy')  
                                <a href="#" data-id="{{$role->id}}" class="btn btn-sm btn-flat btn-outline-danger btnDeleteRol" data-toggle="modal" data-target="#deleteRol"  data-toggle="tooltip" data-placement="top" title="Eliminar Registro">
                                  <i class="fas fa-trash-alt"></i>
                                </a>
                              @endcan
                            </center>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

                  <br>
                  <div>
                    <strong>
                      <?php echo  'Mostrando ' . $roles->firstItem() . ' a ' . $roles->lastItem() . ' de ' . $roles->total() . ' registros'; ?> 
                       {{ $roles->appends(Request::only(['tipo','buscarpor']))->links() }}
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
      <!-- Modal -->
      <div class="modal modal-danger fade" id="deleteRol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <!--<h4 class="modal-title text-center" id="myModalLabel">Eliminar confirmación</h4>-->
            </div>
            <form id="frmdeleteRol" action="" method="POST">
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


  $('.btnDeleteRol').on('click', function(){
      var rol = $(this).data('id');
      $('#frmdeleteRol').attr('action', '{{asset('roles')}}/'+rol);
      //$('#deleteEmpleado').modal('show');
    });
    
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