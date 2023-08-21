@extends('layouts.report')

@section('cuerpo')

<h3><center>Cliente: {{ $cliente ?  $cliente->persona->apellido  : ''}} {{ $cliente ?  $cliente->persona->nombre  : ''}}</h3>
@if($tipo == 0)
	<h3><center>Desde el  @if($fechadesde) {{ $fechadesde}} @endif Hasta el @if($fechahasta) {{ $fechahasta}} @endif</center></h3>
@endif
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
											
                                            <th><center>Fecha</center></th>
                                            <th><center>Tipo Pago</center></th>
											<th><center>Cantidad</center></th>
											@if($tipo == 0 )
                                            	<th><center>Concepto</center></th>
											@endif
                                            <th><center>Total</center></th>
                                            <th><center>TotalPagado</center></th>
										</tr>
									</thead>
									<tbody>

										@foreach ($ventas as $venta)
											<tr>
											
											<td><center>{{ $venta->fecha }}</center></td>
											<td><center>{{ $venta->tipoPago ? $venta->tipoPago->descripcion : 'Sin tipo de pago' }}</center></td>
											<td><center>{{ $venta->pago == 1 ?  '-' : $venta->cantidadviandas }}</center></td>
											@if($tipo == 0 )
												<td><center>{{ $venta->pago == 1 ? 'Pagado' : 'Sin Pagar' }}</center></td>
											@endif
											<td><center>{{  $venta->pago == 1 ?  '-' : $venta->total }}</center></td>
											<td><center>{{ $venta->totalpagado }}</center></td>
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

                        	<!--@if ($cliente->monto_adeudado > 0)
								<label>Debe en el rango de fecha seleccionado: ${{ $cliente->monto_adeudado }}  </b> </label>
							@else
								<label>@if ($cliente->monto_adeudado !=  0) A favor en el rango de fecha seleccionado: @endif ${{ abs($cliente->monto_adeudado) }}  </b> </label>
							@endif
							
							<br>
							<br>-->
							@if ($cantidadgeneral > 0)
								<label>Deuda Actual: ${{ $cantidadgeneral }}  </b> </label>
							@else
								<label>@if ($cantidadgeneral !=  0) Saldo a favor:  {{ abs($cantidadgeneral) }}  @else Esta al dia @endif  </b> </label>
							@endif

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

</center>

<script>




</script>


@endsection