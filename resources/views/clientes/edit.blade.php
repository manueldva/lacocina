@extends('layouts.app_principal')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@if($show == 1) Ver @else Editar @endif Cliente</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Cliente</a></li>
              <li class="breadcrumb-item active">@if($show == 1) Ver @else Editar @endif</li>
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
          <form action="{{ route('clientes.update',$cliente->id) }}" method="POST">
            @csrf
            @method('PUT')
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
                          <label for="apellido">Apellido:</label>
                          <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" placeholder="Eje: Perez" value="{{ $cliente->persona->apellido }}">
                        </div>
                        @error('apellido')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="nombre">Nombre:</label>
                          <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Eje: Juan" value="{{ $cliente->persona->nombre }}">
                        </div>
                        @error('nombre')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <div class="form-group">
                          <label for="documento">Documento:</label>
                          <input type="text" class="form-control @error('documento') is-invalid @enderror" id="documento" name="documento" placeholder="Eje: 15325642" value="{{ $cliente->persona->documento }}">
                        </div>
                        @error('documento')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror

                        <!--
                        <div class="form-group">
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
                          <label for="estado">Estado:</label>
                          <select id="activo" name="activo" class="form-control  @error('activo') is-invalid @enderror">
                              <option value="1" @if ($cliente->activo == 1) selected @endif >Activo</option>
                              <option value="0" @if ($cliente->activo == 0) selected @endif>Inactivo</option>
                          </select>
                        </div>
                        
                      </div>
                      <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                </div>
                
                <div class="col-md-4"> <!-- Oculto por el momento-->
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
                          <div class="form-group">
                            <label for="telefono">Telefono/Celular:</label>
                            <input type="number" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" placeholder="Eje: 3704662448" value="{{ $cliente->persona->telefono }}">
                          </div>
                          @error('telefono')
                            <div class="alert alert-info" role="alert">
                              {{ $message }}
                            </div>
                          @enderror

                          <div class="form-group">
                            <label for="email">Correo:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Eje: santydebil@gmail.com" value="{{ $cliente->persona->email }}">
                          </div>
                          @error('email')
                            <div class="alert alert-info" role="alert">
                              {{ $message }}
                            </div>
                          @enderror

                      
                          <div class="form-group">
                            <label>Otro tipo de contacto:</label>
                            <textarea id= "otrocontacto" name="otrocontacto" class="form-control" rows="1" placeholder="Ingrese algun tipo de contacto">{{ $cliente->persona->otrocontacto }}</textarea>
                          </div>
                          @error('otrocontacto')
                            <div class="alert alert-info" role="alert">
                              {{ $message }}
                            </div>
                          @enderror
                          <div class="form-group">
                            <label>Domicilio:</label>
                            <textarea id= "domicilio" name="domicilio" class="form-control" rows="1" placeholder="Ingrese un domicilio">{{ $cliente->persona->domicilio }}</textarea>
                          </div>
                          @error('domicilio')
                            <div class="alert alert-info" role="alert">
                              {{ $message }}
                            </div>
                          @enderror
  
                        </div>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  <!-- /.card -->
                </div>
                
                <div class="col-md-4"> <!-- Oculto por el momento-->
                  <!-- general form elements -->
                  <div class="card card-default">
                    <div class="card-header">
                      <center>
                        <h3 class="card-title">Datos Viandas</h3>
                      </center>
                      
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                      <div class="form-group">
                          
                          <div class="form-group">
                              <label for="metodopago_id">Metodo de Pago:</label>
                              <select id="metodopago_id" name="metodopago_id" class="form-control @error('metodopago_id') is-invalid @enderror">
                                  <option value="">Seleccionar un Metodo</option>
                                  @foreach($metodopagos as $metodopago)
                                      <option value="{{ $metodopago->id }}" {{ $metodopago->id == $cliente->metodopago_id ? 'selected' : '' }}>
                                          {{ $metodopago->descripcion }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                          @error('metodopago_id')
                              <div class="alert alert-info" role="alert">
                                  {{ $message }}
                              </div>
                          @enderror

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
                                            <input class="form-control form-control-sm" type="number" name="cantidad_{{ $vianda->id }}" id="cantidad_{{ $vianda->id }}" value="{{ old('cantidad_' . $vianda->id, $cantidades[$vianda->id] ?? '') }}" {{ in_array($vianda->id, $viandasSeleccionadas) ? '' : 'disabled' }}>
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
</script>
@endsection