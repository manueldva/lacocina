@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Home - Avisos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Tablero</a></li>
              <li class="breadcrumb-item active">Vencimientos</li>
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
                        <h3 class="card-title">Clientes</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">
                        <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-valign-middle table-bordered">
                                <thead>
                                  <tr>
                                    <th><center>Cliente</center></th>
                                    <th><center>Ultima Entrega</center></th>
                                    <th><center>Avisar</center></th>
                                    <th><center>Telefono</center></th>
                                    <th width="280px"></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($ventasConAviso as $ventaConAviso)
                                    <tr>
                                        <td>
                                            <center>
                                                {{ $ventaConAviso['cliente'] }}
                                            </center>
                                        </td>
    
                                        <td>
                                            <center>
                                                {{ $ventaConAviso['ultima_fecha'] }}
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                Faltando @if($ventaConAviso['aviso'] === 1) 1 entrega @else {{ $ventaConAviso['aviso'] }} entregas @endif
                                            </center>
                                        </td>
                                      
                                      <td>
                                        <center>
                                          {{ $ventaConAviso['telefono'] }}
                                        </center>
                                      </td>
                                      <td>
                                        <center>
                                            <a target="_blank" id="movil" class="btn btn-sm btn-flat btn-outline-success" href="{{ $ventaConAviso['mensajeMovil'] }}" data-toggle="tooltip" data-placement="top" title="WhatsApp Movil"><i class="fab fa-whatsapp"></i></a>
                                            <a target="_blank"  id="noMovil" class="btn btn-sm btn-flat btn-outline-primary" href="{{ $ventaConAviso['mensaje'] }}" data-toggle="tooltip" data-placement="top" title="WhatsApp Web"><i class="fab fa-whatsapp"></i></a>
                                        </center>
                                      </td>
                                      
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>     
                            </div>              
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

    function isMobileDevice() {
        return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
    }

    $(document).ready(function() {
        if (isMobileDevice()) {
            //console.log("Estás en un dispositivo móvil");
            // Ocultar el botón de WhatsApp Web
            $('#noMovil').hide();
        } else {
            //console.log("Estás en una computadora");
            // Ocultar el botón de WhatsApp Móvil
            $('#movil').hide();
        }
    });

</script>
@endsection