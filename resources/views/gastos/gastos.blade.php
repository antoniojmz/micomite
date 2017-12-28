@extends ('menu.plantilla_menu')
@section ('body')
<style type="text/css">
#tablaConsultaGastos_filter {
    width: 60px;
    float: left;
    margin-bottom: 10px;
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


	<div class="btn-group btn-group-justified">
			<a href="#" class="btn col-sm-3 boton1" id="divConsulta">
              <i class="glyphicon glyphicon-question-sign"></i><br>
              Consulta de Gastos Comunes
            </a>
            <a href="#" class="btn  col-sm-3 boton2" id="divGastos">
              <i class="glyphicon glyphicon-plus"></i><br>
              Cargar de Gastos Comunes
            </a>
            <a href="#" class="btn col-sm-3 boton3" id="divPagosA">
              <i class="glyphicon glyphicon-cloud"></i><br>
              Carga de Pagos Adicionales
            </a>
            <a href="#" class="btn col-sm-3 boton4" id="divPagosPropietarios">
              <i class="glyphicon glyphicon-question-sign" ></i><br>
              Pagos de los Propietarios
            </a>

            <a href="#" class="btn col-sm-3 boton5" id="spanConceptos">
              <i class="glyphicon glyphicon-cog"></i><br>
               Administrador de Conceptos
            </a>
	</div>

<!-- //CONSULTA DE GASTOS COMUNES --------------------------------------------------- -->

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
	                <!-- {{ Form::button(' Imprimir',
	                [ 'id'=> 'imprimirGasto', 'type' => 'button',
	                'class' => 'btn btn-primary fa fa-plus-circle'])}}
 -->
	                 {{ Form::button(' Cierre del Mes',
	                [ 'id'=> 'cierreMes', 'type' => 'button',
	                'class' => 'btn btn-success fa fa-plus-circle'])}} <br>  <br>
	            </div>
	        	</div><br><br><br><br><br><br>
	   		</div>
       	 </div>
        </div>

</div>
<!-- //VENTANA DE CONFIRMACION DE CIERRE DE MES------------------------------- -->


<div id="modalCierre" class="easyui-window" title="Verifique los Datos del Cierre de Mes" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:750px;height:350px;padding:20px;">
	<div class="col-md-12">

          <table class="table table-user-information">
            <tbody>
             <tr>
                <td>Fecha de Facturación:</td>
                <td><div class="fecha_facturacion_mes"></div></td>
              </tr>
              <tr>
                <td>Mes Facturación:</td>
                <td><div class="mes_facturacion"></div></td>
              </tr>
              <tr>
                <td>Monto Total de Gastos Comunes:</td>
                <td> <div class="mto_gastos_comunes"></div></td>
              </tr>
              <tr>
                <td>Monto Total de Pagos Adicionales:</td>
                <td> <div class="mto_pagos_adicionales"></div></td>
              </tr>
              <tr>
                <td>Monto Total de Fondo de Reserva:</td>
                <td><div class="mto_fondo_reserva"></div></td>
              </tr>
               <tr>
                <td colspan="2" style="color:red; font-style: italic;">Una vez cerrada la facturación del mes no podrán hacer el reverso y ninguna modificación</td>
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
	                		[ 'id'=> 'cancelarCierre', 'type' => 'button',
	                		'class' => 'btn btn-primary fa fa-plus-circle eliminarGasto'])}}

	                        {{ Form::button(' Aceptar',
	                            [ 'id'=> 'confirmarCierre', 'type' => 'button',
	                            'class' => 'btn btn-success fa fa-times-circle'])
	                        }}
	                    </div>

	                </div>
	            </div>
	        </div>
</div>




<!-- //CARGAR GASTOS COMUNES --------------------------------------------------- -->
<div id="divGasto" class="divGastos"  style="display:none;">
	 <center>
            <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2 id="spanTitulo" class="borderTitulo">Registro de Gastos Comunes</h2>
                </div>
                <div class="col-md-4"></div>
            </div>
       </center>
	       <table id="tablaGastos" class="display" cellspacing="0" width="100%"></table>
 		<div id="divTabla">
       		 <div class="col-md-12">
	            <br />
	            <div class="col-md-12 col-md-offset-10">
	                {{ Form::button(' Agregar Gasto Común',
	                [ 'id'=> 'agregarGasto', 'type' => 'button',
	                'class' => 'btn btn-primary fa fa-plus-circle'])}}
	               <br> <br>
	            </div>
	        </div><br><br>
	   </div>
</div>

<div class="divCalculoPrevio" style="display:none;">
	<br><br>
	 <center> <strong><span id="spanTituloGastos">Egresos del Mes</span></strong></center><br><br>
	  <table id="tablaGastosComunes" class="display" cellspacing="0" width="100%"></table>
	<br><br>
	 <center><strong><span id="spanTituloGastos">Detalle de los Gastos Comunes por Apartamento</span></strong></center><br><br>
	  <table id="tablaCalculoGcomunes" class="display" cellspacing="0" width="100%"></table>
	<br><br>
</div>

<div id="divCargar" class="easyui-window" title="Cargar Gasto Comun" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:750px;height:500px;padding:20px;">
    {!! Form::open(['id'=>'FormGasto',
    'autocomplete' => 'off',
    'novalidate' => 'novalidate',
    'files' => true
    ]) !!}
    <input type="hidden" name="id_periodo" id="id_periodo"/>
    <div class="col-md-12">
            <div class="row">
	            <div class="form-group">
	                <div class="col-md-1"></div>
	                <div class="col-md-4">
	                    {{ Form::label('null', 'Tipo de Gasto Comun:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
	                </div>
	                <div class="col-md-6">
	                        {!! Field::select('id_tipo_gasto',null,
		                    ['label' => '',
		                    'class' => 'comboclear',
		                    'placeholder'   => 'Selecione...',
		                    'style'         => 'width:100%;height:35px;z-index:9999',
		                    'placeholder'   => 'Selecione...',
		                    ])!!}
	                </div>
	            </div>
	        </div>
	        <div class="row">
	            <div class="form-group">
	                <div class="col-md-1"></div>
	                <div class="col-md-4">
	                    {{ Form::label('null', 'Concepto detalle:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
	                </div>
	                <div class="col-md-6">
	                        {!! Field::select('id_concepto_detalle_g','',
	                        ['id' => 'id_concepto_detalle_g',
	                        'label' => '',
	                        'class' => 'comboclear',
	                        'placeholder'   => 'Selecione...',
	                        'style'         => 'width:100%;height:35px;'
	                        ])!!}
	                </div>
	            </div>
	        </div>
	        <br>
	        <div class="row">
	        	<div class="form-group">
	        		<div class="col-md-1"></div>
	        		<div class="col-md-4">
	        			{{ Form::label('null', 'Fecha de la factura:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
	        		</div>
	        		<div class="col-md-6">
	        			<div class="input-group">
	        				{!! Form::text('fecha_factura', '', [
	        				'id'            => 'fecha_factura',
	        				'class'         => 'form-control vtObs2 vtfecha',
	        				'placeholder'   => 'Fecha factura',
	        				'style'         => 'width:100%;height:35px',
	        				'maxlength'     => '50',
	        				'data-date-format'=> 'DD/MM/YYYY'
	        				])!!}
	        				<span class="input-group-addon cal">
	        					<span class="glyphicon glyphicon-calendar"></span>
	        				</span>
	        			</div>
	        		</div>
	        	</div>
	        </div>
	        <br>

				<div class="row">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        {{ Form::label('null', 'Monto:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-6">
                        {!! Form::text('monto', '', [
                        'id'            => 'monto',
                        'class'         => 'form-control moneda imputclear',
                        'placeholder'   => 'Monto Total',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '50'])!!}
                    </div>
                </div>
        	</div>
        	<br>

        	 <div class="row">
	            <div class="form-group">
	                <div class="col-md-1"></div>
	                <div class="col-md-4">
	                    {{ Form::label('null', 'Archivo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
	                </div>
	                <div class="col-md-6">
	                       {!! Form::file('urlimage', '', [
                        	'id'            => 'urlimage'])!!}
	                </div>
	            </div>
	        </div>
	        <br>
	        <div class="row">
	            <div class="form-group">
	                <div class="col-md-1"></div>
	                <div class="col-md-4">
	                    {{ Form::label('null', 'Descripción:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
	                </div>
	                <div class="col-md-6">
	                    {!! Form::textarea('descripcion', '', [
	                    'id'            => 'descripcion',
	                    'class'         => 'form-control vtObs2',
	                    'placeholder'   => 'Descripción de la Factura',
	                    'style'         => 'width:100%;height:60px',
	                    'maxlength'     => '295',
	                    'rows'          => '200',
	                    'cols'          => '100'])!!}
	                </div>
	            </div>
	        </div>


	        <br>
	        <div clas="row">
	            <div align="col-md-12">
	                <div class="pull-rigth">
	                    <div class="col-md-4"></div>
	                    <div class="col-md-6">
	                        {{ Form::button(' Cancelar',
	                            [ 'id'=> 'cancelarCargar', 'type' => 'button',
	                            'class' => 'btn btn-primary fa fa-times-circle'])
	                        }}
	                        {{ Form::button(' Guardar',
	                            [ 'id'=> 'guardarCargarPago', 'type' => 'button',
	                            'class' => 'btn btn-primary fa fa-check-circle'])
	                        }}<br><br>
	                    </div>
	                    <div class="col-md-4"></div>
	                </div>
	            </div>
	        </div>
    </div>
    {!! Form::close() !!}
</div>

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
	                       {{ Form::button(' Eliminar Gasto',
	                		[ 'id'=> 'eliminarGasto', 'type' => 'button',
	                		'class' => 'btn btn-success fa fa-plus-circle eliminarGasto'])}}

	                        {{ Form::button(' Cancelar',
	                            [ 'id'=> 'cancelarModalGasto', 'type' => 'button',
	                            'class' => 'btn btn-primary fa fa-times-circle'])
	                        }}


	                    </div>

	                </div>
	            </div>
	        </div>
</div>




<!-- ///////////// CARGAR GASTOS ADICIONALES ///////////////// -->

<div id="divPagosA" class="divPagosA" style="display:none;">
	  <br>
	  <center>
            <strong>
            	<span class="borderTitulo" id="spanTituloGastos">
            		Resumen de Pagos Adicionales del Mes
            	</span>
            </strong>
            <br/><br/>
      </center>

       <div id="divTabla">
           <table id="tablaGastosAdicionales" class="display" cellspacing="0" width="100%"></table>
	        <div class="col-md-12">
	            <br />
	            <div class="col-md-12 col-md-offset-11">
	                {{ Form::button(' Agregar',
	                [ 'id'=> 'agregarGastoA', 'type' => 'button',
	                'class' => 'btn btn-primary fa fa-plus-circle'])}}
	            </div>
	        </div>
	   </div>
</div>

<div id="divPagosAR" class="easyui-window" title="Cargar Pagos Adicionales"  style="display:none;" data-options="modal:true, closed:true, collapsible:false, minimizable:false, maximizable:false, resizable:false, top:85" style="width:750px;height:350px;padding:20px;">
        {!! Form::open(['id'=>'FormPagosA',
        'autocomplete' => 'off',
        'novalidate' => 'novalidate',
        'files' => true
        ]) !!}
        <br><br>
        <div class="col-md-12">
        		<div class="row">
		            <div class="form-group">
		                <div class="col-md-1"></div>
		                <div class="col-md-4">
		                    {{ Form::label('null', 'Propietario:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
		                </div>
		                <div class="col-md-6">
		                    <div class="input-group col-md-12">
		                    	 <input type="hidden" name="id_apartamento" class="id_apartamento">
		                    	 <input type="hidden" name="id_usuario" id="id_usuario">
	                            <span class="form-control spanFechayHora" id="numero_apto" style="z-index:0;height:35px;color:#808080;">&nbsp;Numero de Apartamento</span>
	                            <span class="input-group-addon btn btn-primary fa fa-search" id="btnApartamento" type="button"></span>
	                        </div>
		                </div>
		            </div>
		        </div>
                <div class="row">
		            <div class="form-group">
		                <div class="col-md-1"></div>
		                <div class="col-md-4">
		                    {{ Form::label('null', 'Tipo de Gasto:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
		                </div>
		                <div class="col-md-6">
		                        {!! Field::select('id_tipo_gastoP',null,
			                    ['label' => '',
			                    'class' => 'comboclear',
			                     'style'         => 'width:100%;height:35px;z-index:9999',
			                    'placeholder'   => 'Selecione...',
			                    ])!!}
		                </div>
		            </div>
		        </div>
		        <div class="row">
		            <div class="form-group">
		                <div class="col-md-1"></div>
		                <div class="col-md-4">
		                    {{ Form::label('null', 'Concepto detalle:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
		                </div>
		                <div class="col-md-6">
		                        {!! Field::select('id_concepto_detalle','',
		                        ['id' => 'id_concepto_detalle',
		                        'label' => '',
		                        'class' => 'comboclear',
		                        'placeholder'   => 'Selecione...',
		                        'style'         => 'width:100%;height:35px;'
		                        ])!!}
		                </div>
		            </div>
		        </div>
		        <br>
				<div class="row">
                    <div class="form-group">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            {{ Form::label('null', 'Monto:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('monto', '', [
                            'id'            => 'monto',
                            'class'         => 'form-control moneda imputclear',
                            'placeholder'   => 'Monto Total',
                            'style'         => 'width:100%;height:35px',
                            'maxlength'     => '50'])!!}
                        </div>
                    </div>
            	</div>
            	<br>
		        <div class="row">
		            <div class="form-group">
		                <div class="col-md-1"></div>
		                <div class="col-md-4">
		                    {{ Form::label('null', 'Descripción:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
		                </div>
		                <div class="col-md-6">
		                    {!! Form::textarea('descripcion', '', [
		                    'id'            => 'descripcion',
		                    'class'         => 'form-control vtObs2',
		                    'placeholder'   => 'Descripción de la Factura',
		                    'style'         => 'width:100%;height:60px',
		                    'maxlength'     => '295',
		                    'rows'          => '200',
		                    'cols'          => '100'])!!}
		                </div>
		            </div>
		        </div>
		        <br>
		        <div clas="row">
		            <div align="col-md-12">
		                <div class="pull-rigth">
		                    <div class="col-md-4"></div>
		                    <div class="col-md-6">
		                        {{ Form::button(' Cancelar',
		                            [ 'id'=> 'cerrarPagosAdicionales', 'type' => 'button',
		                            'class' => 'btn btn-primary fa fa-times-circle'])
		                        }}
		                        {{ Form::button(' Guardar',
		                            [ 'id'=> 'guardarPagosAdicionales', 'type' => 'button',
		                            'class' => 'btn btn-primary fa fa-check-circle'])
		                        }}
		                        <br><br>
		                    </div>
		                    <div class="col-md-4"></div>
		                </div>
		            </div>
		        </div>


        </div>
        {!! Form::close() !!}
</div>

<div id="modalApartamentos" class="easyui-window" title="Apartamentos" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:750px;height:520px;padding:20px;">

    <div class="row">
        <div class="col-md-12">
            <table id="tablaApartamentos" class="display" cellspacing="0" width="100%"></table>
        </div>
    </div>
</div>


<!-- //PAGOS DE LOS PROPIETARIOS - -->


<div id="divPagosPropietarios" class="divPagosPropietarios" style="display:none;">
	  <br>
	  <center>
            <strong>
            	<span class="borderTitulo" id="spanTituloGastos">
            		Resumen de Pagos Pendientes por Confirmar
            	</span>
            </strong>
            <br/><br/>
      </center>
	  <div id="divTabla">
           <table id="tablaPagosPropietarios" class="display" cellspacing="0" width="100%"></table>
	   </div>
	   <br><br>

</div>

<!-- //PARAMETRIZAR CONCEPTOS Y CATALOGOS - -->
<div id="modalAsignarFecha" class="easyui-window" title="Asignar Fecha de Facturacion" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:750px;height: 350px; padding:20px;">

	        <div class="row">
	        	<div class="form-group">
	        		<div class="col-md-1"></div>
	        		<div class="col-md-4">
	        			{{ Form::label('null', 'Fecha de la facturación:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
	        		</div>
	        		<div class="col-md-6">
	        			<div class="input-group">
	        				{!! Form::text('fecha_facturacion', '', [
	        				'id'            => 'fecha_facturacion',
	        				'class'         => 'form-control vtObs2 vtfecha',
	        				'placeholder'   => 'Ingrese la fecha de Facturación',
	        				'style'         => 'width:100%;height:35px',
	        				'maxlength'     => '50',
	        				'data-date-format'=> 'DD/MM/YYYY'
	        				])!!}
	        				<span class="input-group-addon cal">
	        					<span class="glyphicon glyphicon-calendar"></span>
	        				</span>
	        			</div>
	        		</div>
	        	</div>
	        </div><br>
	        <div class="row">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        {{ Form::label('null', 'Fondo de Reserva:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-6">
                        {!! Form::text('fondo_reserva', '', [
                        'id'            => 'fondo_reserva',
                        'class'         => 'form-control imputclear',
                        'placeholder'   => 'Porcentaje de Fondo de Reserva',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '50'])!!}
                    </div>
                </div>
        	</div><br>

	        <div clas="row">
	            <div align="col-md-12">
	                <div class="pull-rigth">
	                    <div class="col-md-4"></div>
	                    <div class="col-md-6">
	                        {{ Form::button(' Cancelar',
	                            [ 'id'=> 'cancelarFecha', 'type' => 'button',
	                            'class' => 'btn btn-primary fa fa-times-circle'])
	                        }}
	                        {{ Form::button(' Guardar',
	                            [ 'id'=> 'guardarFecha', 'type' => 'button',
	                            'class' => 'btn btn-primary fa fa-check-circle'])
	                        }}<br><br>
	                    </div>
	                    <div class="col-md-4"></div>
	                </div>
	            </div>
	        </div>

</div>


<div id="divCatalogo" class="divCatalogo" style="display:none;">
    <div class="container2"  style="width:90%;">
        {!! Form::open(['id'=>'FormCatalogo',
        'autocomplete' => 'off'
        ]) !!}
        <br>
            <center>
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <h2 class="borderTitulo">Parametrización de Gastos Comunes</h2>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </center>


            <div class="row">
	            <div class="form-group">
                    <div class="col-md-4"></div>
	                <div class="col-md-2">
	                    {{ Form::label('null', 'Tipo de concepto:',array('style' => 'text-align:center;line-height:500%','class' => 'label-input','id' => '','align' => 'center'))}}
	                </div>
	                <div class="col-md-4">
	                    {!! Field::select('id_tipo_padre',null,
	                    ['label' => '',
	                    'class' => 'comboclear',
	                     'style'         => 'width:100%;height:35px;',
	                    'placeholder'   => 'Selecione...',
	                    ])!!}
	                </div>
                    <div class="col-md-2"></div>

	            </div>
	        </div>
            <div class="row" >
                <div class="col-md-12">
                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Descripción:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('descripcion', '', [
                        'id'            => 'descripcion',
                        'class'         => 'form-control vtObs2 descripcion',
                        'placeholder'   => 'Descripción',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '50'])!!}
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
            <br><br><br>
            <div class="row">
                <div class="col-md-12">
                    <center>
                        {{ Form::button(' Volver',
                            [ 'id'=> 'volverC', 'type' => 'button',
                            'class' => 'btn btn-default fa fa-times-circle'])
                        }}
                        {{ Form::button(' Cargar',
                            [ 'id'=> 'cargarC', 'type' => 'button',
                            'class' => 'btn btn-primary fa fa-times-circle'])
                        }}
                    </center>
                </div>
            </div>
            <div id="divTablaDetalle" class="row">
            	<div class="col-md-12">
            		<div class="col-md-4"></div>
            		<div class="col-md-4">
                		<table id="TablaDetalle" class="display" cellspacing="0" width="100%"></table>
            		</div>
            		<div class="col-md-4"></div>
            	</div>
            </div>
        {!! Form::close() !!}
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
    d['v_gastos_consulta']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_gastos_consulta) }}'));
    d['v_gastos_adicionales']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_gastos_adicionales) }}'));
    d['v_gastos_adicionales_consulta']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_gastos_adicionales_consulta) }}'));
	d['v_apartamentos']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_apartamentos) }}'));
	d['v_apartamentos_cbo']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_apartamentos_cbo) }}'));
	d['v_total_gastos']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_total_gastos) }}'));

	d['periodos_pago']= JSON.parse(rhtmlspecialchars('{{ json_encode($periodos_pago) }}'));
	d['v_pagos_propietarios']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_pagos_propietarios) }}'));
	d['v_anios']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_anios) }}'));
	d['v_calculo_gcomunes']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_calculo_gcomunes) }}'));



</script>
<script src="{{ asset('js/gastos/gastosA.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection