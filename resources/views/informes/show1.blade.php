@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cliente - Informes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('informes.index') }}">Informes</a></li>
              <li class="breadcrumb-item active">Informes</li>
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
                        <h3 class="card-title">Movimiento del Clientes</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group col-md-5">
                                <label for="fechaDesde">Fecha Desde</label>
                                <input type="date" class="form-control" id="fechadesde" value="{{ \Carbon\Carbon::now()->subDays(7)->format('Y-m-d') }}">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="fechaHasta">Fecha Hasta</label>
                                <input type="date" class="form-control" id="fechahasta" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="fechaHasta">ID del Cliente</label>
                                <input type="number" class="form-control" id="cliente">
                            </div>

                            <a target="_blank" href="#" id="imprimir"> 
                                <button  type="button" class="btn btn btn-primary">  Generar Informe</button>
                            </a>
                        
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
    $('#imprimir').on('click', function(e){
        
        /*var usuario = $("#usuario option:selected").attr("value")
        //alert(usuario);
        if (usuario == '')
        {
            usuario = 'Todos';
        }*/

        /*if(usuario == 'Todos') {
            toastr.error('Debe seleccionar un vendedor para generar el informe');
            return false;
        }*/
        var fechadesde = $("#fechadesde").val();
        var fechahasta = $("#fechahasta").val();
        var cliente = $("#cliente").val();
        e.preventDefault();
        window.open("{{url('print1')}}/"+ cliente + "/" + fechadesde + "/" + fechahasta);


    });
</script>
@endsection