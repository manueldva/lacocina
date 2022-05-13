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
            <form method="POST" action="{{ route('roles.store') }}">
              @csrf
              <div class="row">
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
                            <a class="btn btn-outline-success" href="{{ route('roles.index') }}"><i class="fas fa-list"></i> Listado</a>
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
                          <label for="name">Descripción:</label>
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Eje: Admin" value="{{ old('name') }}">
                        </div>
                        @error('name')
                          <div class="alert alert-info" role="alert">
                            {{ $message }}
                          </div>
                        @enderror
                        <!--
                        <div class="form-group">
                          <label for="permission">Listado de Permisos:</label>
                          <br>
                          @foreach($permissions as $permission)
                            <div>  
                              <label>
                                  <input  type="checkbox" name="permissions[]" value="{{ $permission['id'] }}" class="mr-1" />
                                  {{ $permission['description'] }}
                              </label>
                            </div>
                          @endforeach
                        </div>
                      </div>
                      -->
                      <br>
                      @foreach($padre as $pd)
                        <label for="permission">Modulo {{ $pd['father'] }}:</label>
                        <div class="card-header">
                          <!--<div class="row justify-content-center align-items-center">-->
                          <div class="row">
                            @foreach($permissions as $permission)
                              @if($pd['father'] == $permission['father'])
                                <div>  
                                  <label>
                                      <input  type="checkbox" name="permissions[]" value="{{ $permission['id'] }}" class="form-group" />
                                      {{ $permission['description'] }}
                                  </label>
                                </div>
                                &nbsp; &nbsp;&nbsp;&nbsp; 
                              @endif
                            @endforeach
                            <!-- /.col -->
                          </div>
                        </div>
                      @endforeach
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
</script>
@endsection