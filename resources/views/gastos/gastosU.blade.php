@extends ('menu.plantilla_menu')
@section ('body')
<style type="text/css">
#tablaConsultaGastos_filter {
    width: 60px;
    float: left;
    margin-bottom: 10px;
}

.tabla_calculo {

	border-color: red;
	border: 1px;
}

#dataTables_filter label {
	color: red;
}

.subtitulo {
	font: 16px arial, sans-serif;
	font-weight: bold;
	text-align: center;
	color: #088A29;
}
.botonSeleccion {
	color: #fff;
	background-color:#286090;;
	border-color: #204d74;
}

.botonNoSeleccion {
	color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
}
.botonNoSeleccion:hover, .botonNoSeleccion:focus, .botonNoSeleccion:active {
		color: #fff;
}
.botonSeleccion:hover, .botonSeleccion:focus, .botonSeleccion:active {
		color: #fff;
}

.select2-container--open{z-index:10000;};
</style>

<div class="container" id="content">

<!-- //CONSULTA DE GASTOS COMUNES - -->

<div id="divConsulta" class="divConsulta">
	 <center>
            <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2 id="spanTitulo" class="borderTitulo">Consulta de Gastos Comunes</h2>
                </div>
                <div class="col-md-4"></div>
            </div>
       </center><br><br>
       <br><br>

         <div class="col-md-12">
          <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title" >Buscador: </h3>
            </div>
            <div class="panel-body">
            	{!! Form::open(['id'=>'FormConsulta',
		        'autocomplete' => 'off'
		        ]) !!}
            	<div class="col-md-12 container acc-settings">

               	  <div class="col-md-12">
					  <label class="col-md-2 control-label">Seleccione mes y año (*):</label>
					  <div class="col-md-2">
					    {!! Field::select('mes','',
	                        ['id' => 'mes',
	                        'label' => '',
	                        'class' => 'form-control comboclear combobuscar',
	                        'placeholder'   => 'Selecione...',
	                        'style'         => 'width:100%;height:35px;'
	                        ])!!}
					  </div>
					  <div class="col-md-2">
					    {!! Field::select('anios','',
	                        ['id' => 'anios',
	                        'label' => '',
	                        'class' => 'form-control comboclear combobuscar',
	                        'placeholder'   => 'Selecione...',
	                        'style'         => 'width:100%;height:35px;'
	                        ])!!}
					  </div>
					   <label class="col-md-3 control-label">Seleccione el número de Dpto:</label>
					  <div class="col-md-2">
					    {!! Field::select('id_apartamento','',
	                        ['id' => 'id_apartamento',
	                        'label' => '',
	                        'class' => 'form-control comboclear combobuscar',
	                        'placeholder'   => 'Selecione...',
	                        'style'         => 'width:100%;height:35px;'
	                        ])!!}
					  </div>
					  <div class="col-md-1 botones">

					  	 {{ Form::button(' Buscar',
		                [ 'id'=> 'consultaPagos', 'type' => 'button',
		                'class' => 'btn btn-primary fa fa-plus-circle'])}}

					  </div>
					</div>

				</div>
				 {!! Form::close() !!}
            </div><br><br>

            <div class="col-md-12">
            	<span class="subtitulo">Resumen de Facturación del Mes</span>
            </div>
            <table id="tablaResumenGastosComunes"  width="99%" class="display table-striped table-bordered"></table> <br><br>
             <div class="col-md-12">
            	<span class="subtitulo">Calcule sus Gastos Comunes</span>
            </div>
  			<div class="col-md-12">
	          <table class="table table-bordered" width="100%">
	           
	             <tr>
	                <td width="15%"><strong>Total Gastos Comunes:</strong></td>
	            	<td width="15%">{!! Form::text('gasto_comun', '', [
                        'id'            => 'gasto_comun',
                        'class'         => 'form-control imputclear moneda',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '10'])!!}</div>
                    </td>
                    <td width="5%">
                		
                    </td>
	             	<td rowspan="2"><center>Monto del Gasto Comun: <br> <span class="monto_calculado" style="font-size: 26px;"></span></center></td>
	             </tr>   
	             <tr>
	                <td><strong>Ingrese Prorretaje:</strong></td>
	                <td>
		               {!! Form::text('Prorretaje', '', [
                        'id'            => 'prorretaje',
                        'class'         => 'form-control imputclear moneda',
                        'placeholder'   => '%',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '4'])!!}
                    </td>
                    <td>
                		<button id="calcularGastoDetalle"  type="button" class="btn btn-default">
					      <span class="glyphicon glyphicon-transfer"></span>
					    </button>
                    </td>
                    
	              </tr>
	          </table>             
	          </div>

             <br><br>

            <div class="col-md-12">
            	<span class="subtitulo">Gastos Comunes</span>
            </div>
            <table  id="tablaResumenGastosMes"  width="99%" class="display table-striped table-bordered">
            </table><br><br>

    		<div class="col-md-12">
            	<span class="subtitulo">Pagos Adicionales</span>
            </div>
            <table  id="tablaGastosAdicionalesConsulta"  width="99%" class="display table-striped table-bordered">
            </table><br><br>

   			<div class="col-md-12">
            	<span class="subtitulo">Facturación Detallada</span>
            </div>
            <table id="tablaConsultaGastos" width="99%" class="display table-striped table-bordered" cellspacing="0"></table><br><br>
			<div id="divTabla">
       		    <div class="col-md-12">
	            <br />
	            <div class="col-md-10 col-md-offset-9">
	             <!--    {{ Form::button(' Imprimir',
	                [ 'id'=> 'imprimirGasto', 'type' => 'button',
	                'class' => 'btn btn-primary fa fa-plus-circle'])}} -->

	               <br><br>
	            </div>
	        	</div><br><br><br><br><br><br>
	   		</div>
       	 </div>
        </div>

</div>
<!-- //VENTANA DE CONFIRMACION DE CIERRE DE MES  -->
<div id="modalGasto" class="easyui-window" title="Detalle del Gasto Común" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:750px;height:400px;padding:20px;">
	<div class="col-md-12">

          <table class="table table-user-information">
            <tbody>
             <tr>
                <td>Fecha de Carga:</td>
                <td><div class="fecha_carga"></div></td>
              </tr>
              <tr>
                <td>Tipo de Gasto Comun:</td>
                <td> <div class="tipo_gasto"></div></td>
              </tr>
              <tr>
                <td>Concepto detalle:</td>
                <td> <div class="concepto_detalle"></div></td>
              </tr>
              <tr>
                <td>Fecha de la factura:</td>
                <td><div class="fecha_factura"></div></td>
              </tr>
              <tr>
                <td>Monto:</td>
                <td><div class="monto"></div></td>
              </tr>
              <tr>
                <td>Descripción:</td>
                <td><div class="descripcion"></div></td>
              </tr>
              <tr>
                <td>Factura:</td>
                <td><button id="descargarImagen"  type="button" class="btn btn-default">
				      <span class="glyphicon glyphicon-save"></span>
				    </button>
    			</td>
              </tr>
            </tbody>
          </table>
	</div>
	  <div clas="row">
	            <div align="col-md-12">
	                <div class="pull-rigth">
	                    <div class="col-md-5"></div>
	                    <div class="col-md-5">
	                        {{ Form::button(' Cancelar',
	                            [ 'id'=> 'cancelarModalGasto', 'type' => 'button',
	                            'class' => 'btn btn-primary fa fa-times-circle'])
	                        }}


	                    </div>

	                </div>
	            </div>
	        </div>
</div>


</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('gastos_comunes') }}"
    var rutaB = "{{ URL::route('gastos_comunesB') }}"
    var rutaC = "{{ URL::route('gastos_comunesC') }}"
    var rutaComboD = "{{ URL::route('gastos_comunesA') }}"
    var rutaP = "{{ URL::route('gastos_comunesP') }}"
	var rutaPA = "{{ URL::route('gastos_comunesPA') }}"
    var rutaEliminarPA = "{{ URL::route('gastos_comunesPAB') }}"
    var rutaEliminarP = "{{ URL::route('gastos_comunesPB') }}"
    var rutaCierre = "{{ URL::route('gastos_comunesCM') }}"
	var rutaConfirmarP = "{{ URL::route('gastos_comunesCP') }}"
	var rutaRechazarP = "{{ URL::route('gastos_comunesRP') }}"
	var rutaCGC = "{{ URL::route('gastos_comunesCGC') }}"
    var d = [];
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
    d['v_tipo_padre'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_tipo_padre) }}'));
    d['v_gastos']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_gastos) }}'));
    d['v_gastos_adicionales']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_gastos_adicionales) }}'));
	d['v_apartamentos']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_apartamentos) }}'));
	d['v_apartamentos_cbo']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_apartamentos_cbo) }}'));
	d['v_total_gastos']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_total_gastos) }}'));

	d['periodos_pago']= JSON.parse(rhtmlspecialchars('{{ json_encode($periodos_pago) }}'));
	d['v_pagos_propietarios']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_pagos_propietarios) }}'));
	d['v_anios']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_anios) }}'));
	d['v_calculo_gcomunes']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_calculo_gcomunes) }}'));
</script>
<script src="{{ asset('js/gastos/gastosU.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script> 
@endsection