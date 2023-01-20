@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Nuevo Cliente</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Cliente</a></li>
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
            <form method="POST" action="{{ route('clientes.store') }}">
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
                            <a class="btn btn-outline-success" href="{{ route('clientes.index') }}"><i class="fas fa-list"></i> Listado</a>
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
                        <h3 class="card-title">Datos Generales</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">
                        <div class="form-group">
                          <label for="apellido">Apellido(*)</label>
                          <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" placeholder="Eje: Perez" value="{{ old('apellido') }}">
                        </div>
                        @error('apellido')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="nombre">Nombre(*)</label>
                          <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Eje: Juan" value="{{ old('nombre') }}">
                        </div>
                        @error('nombre')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="documento">Documento:</label>
                          <input type="text" class="form-control @error('documento') is-invalid @enderror" id="documento" name="documento" placeholder="Eje: 16451235" value="{{ old('documento') }}">
                        </div>
                        @error('documento')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <!--<div class="form-group">
                          <label for="fechanacimiento">Fecha de Nacimiento:</label>
                          <input type="date" class="form-control @error('fechanacimiento') is-invalid @enderror" id="fechanacimiento" name="fechanacimiento" value="{{ old('fechanacimiento') ? old('fechanacimiento') : date('Y-m-d')  }}">
                        </div>
                        @error('fechanacimiento')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror   

                        -->

                        <div class="form-group">
                          <label>Domicilio:</label>
                          <textarea id= "domicilio" name="domicilio" class="form-control" rows="2" placeholder="Ingrese un domicilio">{{ old('domicilio') }}</textarea>
                        </div>
                        @error('domicilio')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="estado">Estado:</label>
                          <select disabled id="activo" name="activo" class="form-control  @error('activo') is-invalid @enderror">
                              <option value="1" selected>Activo</option>
                              <option value="0">Inactivo</option>
                          </select>
                        </div>
                        
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
               
        
                <div class="col-md-4" style="display:none"> <!-- Oculto por el momento-->
                  <!-- general form elements -->
                  <div class="card card-default">
                    <div class="card-header">
                      <center>
                        <h3 class="card-title">Datos de Contacto</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                      <div class="form-group">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover" data-form="Form">
                            <thead>
                              <tr>
                                <td> 
                                    <label for="tipocontacto_id">Tipo Contacto:</label>
                                    <select  id="tipocontacto_id" name="tipocontacto_id" class="form-control  @error('tipocontacto_id') is-invalid @enderror">
                                        <option value="" >Seleccionar</option>
                                        @foreach($tipocontactos as $tipo)
                                          <option value="{{ $tipo->id }}" >{{ $tipo->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td> 
                                  <label for="labelvalor">Valor:</label>
                                  <input type="text" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" placeholder="Eje: 3704334054" value="{{ old('valor') }}">
                                </td>
                                <td> 
                                  <label for="labelvalor">&nbsp;&nbsp;</label>
                                  <div class="form-group">
                                    <a class="btn btn-outline-info" id="agregarcontacto" name="agregarcontacto"><i class="fas fa-plus"></i> </a>
                                  </div>
                                  
                                </td>
                              </tr>	
                              
                            </thead>
                          </table>
                          <div class="form-group">
                            <div class="table-responsive">
                              <table   id="table_contactos" class="table table-striped table-hover" data-form="Form">
                                <thead>
                                  <tr>
                                  <!--<th width="10px"> ID</th>-->
                                    <th style="display:none;"> Codigo contacto</th>
                                    <th> Tipo Contacto</th>
                                    <th> Valor</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
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
    $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });


    $("#agregarcontacto").click(function() {

      
      if($('#tipocontacto_id').val() == ''  || $("#valor").val() == '') {

        toastr.error('No se puede agregar este contacto. Faltan datos');
        return false;
      }
    
      //variables para guardar en la grilla
      var valor = $('#valor').val();
      //var descripcion = $("#descripcionarticulo").val();
      var tipocontacto =$('select[name="tipocontacto_id"] option:selected').text();
      var tipocontacto_id = $('#tipocontacto_id').val();
      //var cantidad = parseInt($('#cantidadarticulo').val());

      //cargo la grilla
      $('#table_contactos tbody').prepend(
        '<tr>' + 
        '<td style="display:none;">' + tipocontacto_id + '</td>' +
        '<td>' + tipocontacto + '</td>' +
        '<td>' + valor + '</td>' +
        "<td><a class='btn btn-sm btn-flat btn-outline-danger' onclick ='deletecontacto_row($(this))'><i class='fas fa-trash-alt'></i> </a></td>" +
        '</td>' +
        '</tr>');

        $("#tipocontacto_id").val('');
        $("#valor").val('');

      toastr.success('Contacto agregado a la lista');


    });
</script>
@endsection