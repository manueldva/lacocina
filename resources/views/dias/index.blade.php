@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Listado de Dias</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dias.index') }}">Dias</a></li>
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
              
              <!-- /.card-header -->
              <div class="card-body  p-3">
                <!--<div class="card-body p-0">-->
                  <table class="table table-striped table-valign-middle table-bordered">
                    <thead>
                      <tr>
                        <th><center>Codigo</center></th>
                        <th><center>Descripción</center></th>
                        <th><center>Activo</center></th>
                        <th width="280px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($dias as $dia)
                        <tr>
                          <td>
                            <center>
                              {{ $dia->id }}
                            </center>
                          </td>
                          <td>
                            <center>
                              {{ $dia->descripcion }}
                            </center>
                          </td>
                          <td>
                            <center>
                              @if($dia->activo == 1)
                                <img src="{{url('image/on.ico')}}"  width="30" height="30" data-toggle="tooltip" data-placement="top" title="Activo">
                               
                              @else
                                <img src="{{url('image/off.ico')}}"  width="30" height="30" data-toggle="tooltip" data-placement="top" title="Inactivo">
                               
                              @endif
                            </center>
                          </td>
                         <td>
                            <center>
                              @can('complementos.show')  
                                <a class="btn btn-sm btn-flat btn-outline-info" href="{{ route('dias.show',$dia->id) }}" data-toggle="tooltip" data-placement="top" title="Ver Datos"><i class="fas fa-eye"></i> </a>
                              @endcan
                              @can('complementos.edit')  
                                <a class="btn btn-sm btn-flat btn-outline-secondary" href="{{ route('dias.edit',$dia->id) }}" data-toggle="tooltip" data-placement="top" title="Editar Datos"><i class="fas fa-edit"></i> </a>
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
                      <?php echo  'Mostrando ' . $dias->firstItem() . ' a ' . $dias->lastItem() . ' de ' . $dias->total() . ' registros'; ?> 
                       {{ $dias->appends(Request::only(['tipo','buscarpor']))->links() }}
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
      var d = $(this).data('id');
      $('#frmdelete').attr('action', '{{asset('dias')}}/'+d);
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