@extends('layouts.report')

@section('cuerpo')

<h3><center>Fecha: {{ $fecha ?  $fecha  : ''}} </h3>

<div class="row">
	<div class="col-md-12">	

	  <div class="box box-default">
	  	<div class="box-header with-border">


	      <h3 class="box-title">
	      	
	      </h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
			
			<!-- /.col -->
			<div class="col-md-6 pull-right">
			  <!--<div class="box box-default">-->
			    
			    <div class="box-header with-border">
			      

			     
			    </div>
			    <!-- /.box-header -->
			    <div class="box-body">
			    	
					<label>Detalle:</label> 
					<div class="form-group">
					
						<div class="form-group">
							<div class="table-responsive">
								<table id="table_general" class="table table-striped table-hover" data-form="Form">
									<thead>
										<tr>
										
                                            <th><center>Cliente</center></th>
											<th><center>Envio</center></th>
											<th><center>Entregado</center></th>
                                            <th><center>Detalle</center></th>
										</tr>
									</thead>
									<tbody>

										@foreach ($ventas as $venta)
											<tr>
											
											<td><center>{{ $venta->cliente->persona->apellido }}</center></td>
											<td><center>{{ $venta->ventafechas->envio }}</center></td>
											<td><center>{{ $venta->ventafechas->entregado }}</center></td>
											<td><center>{{ $venta->observaciones }}</center></td>
											</tr>
										@endforeach

										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<br>
				<br>
				<hr>
				<div class="col-md-6 pull-right">
					
					<h3>
						<div class="form-group">

                        	<!-- agregar demas variables-->
						</div>
					</h3>
				</div>
			</div>
			<!-- aca agregar el div col-6 -->
			
			</div>
	 	</div>
	    <!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	</div>
</div>



<script>




</script>


@endsection