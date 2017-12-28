@extends ('menu.plantilla_menu') 
@section ('body')
<style type="text/css">

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
            <a href="#" class="btn boton1 col-sm-3" id="divPagosPendientes">
              <i class="glyphicon glyphicon-plus"></i><br>
              Pagos Pendientes Realizados
            </a>
            <a href="#" class="btn boton2 col-sm-3" id="divConsultaPagos">
              <i class="glyphicon glyphicon-plus"></i><br>
              Consulta de Pagos Realizados
            </a>
    </div>

    <div id="divTabla" class="divForm">

                     <div class="col-md-12">
                            <center>
                                <div class="col-md-12">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <h2 class="borderTitulo">Resumen de Saldos</h2>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </center>
                          
                            <br>
                     </div>
                    <div align="col-md-12">
                        <div class="pull-rigth">
                            <div class="col-md-11">
                                  <table id="tablaPagosResumen" class="display table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    </table>
                            </div>
                            <div class="col-md-1"><br><br>
                                {{ Form::button(' Pagar',
                                    [ 'id'=> 'pagarDeuda', 'type' => 'button',
                                    'class' => 'btn btn-success fa fa-plus-circle'])
                                }}
                            </div>
            
                        </div>
                    </div>


                <br>
                     <hr>
                     <div class="col-md-12">
                           <center>
                                <div class="col-md-12">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <h2 class="borderTitulo">Historico de Movimientos</h2>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </center>
                            <table id="tablaPagos" class="display table-striped table-bordered" cellspacing="0" width="100%"></table>
                     </div>
    </div>


    <div id="divForm" class="divForm" style="display:none;" >
        <hr><br><br><br>
        {!! Form::open(['id'=>'FormPagos',
            'autocomplete' => 'off',
            'novalidate' => 'novalidate',
            'files' => true
            ]) !!}
            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
            {!! Form::hidden('id_pago_propietario', '', [
            'id'            => 'id_pago_propietario',
            'class'         => 'form-control'])!!}

             <input type="hidden" name="id_apto" id="id_apto" class="id_apto">
             <input type="hidden" name="id_periodo" id="id_periodo" class="id_periodo">

            <div class="caja-pago" style="display:none;">
                <center>
                    <a href="javascript:;">
                        <div class="prueba">    <br><br><br> <br><br><br> <br><br><br>
                            <img name="foto-pagos" id="foto-pagos" class="block-center img-thumbnail" width="300px" height="300px" alt="Image" src='{!! asset("img/pagos.svg") !!}'>
                        </div>
                    </a>
                </center>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        {{ Form::label('null', 'Propietario:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                          <span class="form-control" id="numero_apto" style="z-index:0;height:35px;color:#808080;">&nbsp;Número de Apartamento</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        {{ Form::label('null', 'Tipo de pago:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('id_tipo_pago', $v_tipo_pago_combos,[
                        'label' => '',
                        'class' => 'comboclear',
                        'style'         => 'width:100%;height:35px',
                        'placeholder'   => 'Selecione...'])
                        !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        {{ Form::label('null', 'Número de verificación:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                            {!! Form::text('codigo_verificacion', '', [
                            'id'            => 'codigo_verificacion',
                            'class'         => 'form-control vtObs',
                            'placeholder'   => 'Número de transferencia, depósito o cheque',
                            'style'         => 'width:100%;height:35px',
                            'maxlength'     => '25'
                            ])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        {{ Form::label('null', 'Fecha de pago:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            {!! Form::text('fecha_pago', '', [
                            'id'            => 'fecha_pago',
                            'class'         => 'form-control vtObs2 vtfecha',
                            'placeholder'   => 'Fecha de pago',
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
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        {{ Form::label('null', 'Monto:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('monto', '', [
                        'id'            => 'monto',
                        'class'         => 'form-control moneda',
                        'placeholder'   => 'Monto',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '50'])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        {{ Form::label('null', 'Observaciones del pago:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::textarea('obs_pago', '', [
                        'id'            => 'obs_pago',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Observaciones',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '290'])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        {{ Form::label('null', 'Comprobante de Pago:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        <div>
                            {!! Form::file('foto', '', [
                            'id'            => 'foto'])!!}
                        </div>
                        <br>
                         <label style="color:red;">Archivo png o jpg no mayor a 4  megabytes (MB)</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="pull-rigth" align="center">
                {{ Form::button(' Volver',
                    [ 'id'=> 'cancelar', 'type' => 'button',
                    'class' => 'btn btn-default fa fa-times-circle'])
                }}
                {{ Form::button(' Guardar',
                    [ 'id'=> 'guardar', 'type' => 'button',
                    'class' => 'btn btn-primary fa fa-check-circle'])
                }}
            </div>
            <br>
        {!! Form::close() !!}
    </div>

    <div id="divConsultaPagos" class="divConsultaPagos" style="display:none;"><center>
                    <div class="col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <h2 class="borderTitulo">Consulta de Pagos Realizados</h2>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </center>
        <table id="tablaPagosPropietarios" class="display" cellspacing="0" width="100%"></table>
    </div>

</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('pagos') }}"
    var d = [];
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
    d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
    d['v_pagos']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_pagos) }}'));
    d['v_pagos_resumen']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_pagos_resumen) }}'));
    d['v_pagos_propietarios']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_pagos_propietarios) }}'));

</script>
<script src="{{ asset('js/pagos/pagosU.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection
