@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-info" id="content">
            {!! Form::open(['id'=>'FormCondominio',
            'autocomplete' => 'off'
            ]) !!}
    <center>
        <div class="col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h2 id="tituloPantalla" class="borderTitulo"></h2>
            </div>
            <div class="col-md-4"></div>
        </div>
    </center>
    <div id="divTabla">
       <div class="col-md-12">
            <div class="pull-right">
                {{ Form::button(' Agregar',
                [ 'id'=> 'agregar', 'type' => 'button',
                'class' => 'btn btn-primary fa fa-plus-circle'])}}
            </div>
        </div>
       <div class="col-md-12">
           <br>
        </div>
        <table id="tablaSedes" class="display" cellspacing="0" width="100%"></table>
    </div>
    <div id="divForm" style="display:none;">
        <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="id_sede" id="id_sede" value="">
        <hr>
        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Condominio:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                    {!! Form::text('des_sede', '', [
                    'id'            => 'des_sede',
                    'class'         => 'form-control vtObs2',
                    'placeholder'   => 'Nombre del condominio',
                    'style'         => 'width:100%;height:35px',
                    'maxlength'     => '200'])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Ciudad:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                        {!! Field::select('id_ciudad',$v_ciudad,
                        ['id' => 'id_ciudad',
                        'label' => '',
                        'class' => 'comboclear',
                        'style'         => 'width:100%;height:35px;'
                        ])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Comuna:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                    {!! Field::select('id_comuna', $v_comunas,[
                    'label' => '',
                    'class' => 'comboclear',
                    'style'         => 'width:100%;height:35px'])
                    !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Teléfono:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                    <div style="width:100%"  class="input-group">
                        {!! Form::text('paist', '+56', [
                        'id'            => 'paist',
                        'class'         => 'form-control vtObs',
                        'style'         => 'width:15%;height:35px',
                        'size'     => '3',
                        'maxlength'     => '3'])!!}

                        {!! Form::text('codigot', '2', [
                        'id'            => 'codigot',
                        'class'         => 'form-control vtCedula',
                        'style'         => 'width:10%;height:35px',
                        'size'     => '1',
                        'maxlength'     => '1'])!!}

                        {!! Form::text('numerot', '', [
                        'id'            => 'numerot',
                        'class'         => 'form-control vtCedula',
                        'placeholder'   => 'Teléfono',
                        'style'         => 'width:60%;height:35px',
                        'size'     => '10',
                        'maxlength'     => '10'])!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Dirección:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                    {!! Form::text('direccion', '', [
                    'id'            => 'direccion',
                    'class'         => 'form-control vtObs2',
                    'placeholder'   => 'Dirección',
                    'style'         => 'width:100%;height:35px',
                    'maxlength'     => '180'])!!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Observaciones:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                    {!! Form::textarea('obs', '', [
                    'id'            => 'obs',
                    'class'         => 'form-control vtObs2',
                    'placeholder'   => 'Observaciones',
                    'style'         => 'width:100%;height:35px',
                    'maxlength'     => '295',
                    'rows'          => '100',
                    'cols'          => '100'])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">

                    {{ Form::label('null', 'Activo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                   <input type="checkbox" name="activo_sede" id="activo_sede" checked="true">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">

                     {{ Form::label('null', 'Fecha de la facturación:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
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
        </div>
          <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                      {{ Form::label('null', 'Fondo de Reserva:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                            {!! Form::text('fondo_reserva', '', [
                        'id'            => 'fondo_reserva',
                        'class'         => 'form-control imputclear',
                        'placeholder'   => '%',
                        'style'         => 'width:30%;height:35px',
                        'maxlength'     => '3'])!!}
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div clas="row">
            <div align="col-md-12">
                <div class="pull-rigth">
                    <div class="col-md-4"></div>
                    <div class="col-md-3">
                        {{ Form::button(' Cancelar',
                            [ 'id'=> 'cancelar', 'type' => 'button',
                            'class' => 'btn btn-default fa fa-times-circle'])
                        }}
                        {{ Form::button(' Guardar',
                            [ 'id'=> 'guardar', 'type' => 'button',
                            'class' => 'btn btn-primary fa fa-check-circle'])
                        }}
                    </div>
                    <div class="divCam col-md-2" style="display:none;">
                        {{ Form::button(' Cargar Fotos',
                            [ 'id'=> 'guardarF', 'type' => 'button',
                            'class' => 'btn btn-primary fa fa-plus-circle'])
                        }}
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}




        <div id="divFotos" class="easyui-window" title="Cargar Fotos" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:60%;height:60%;padding:20px;">
            {!! Form::open(['id'=>'FormFotos',
            'autocomplete' => 'off',
            'novalidate' => 'novalidate',
            'files' => true
            ]) !!}
            <input type="hidden" name="id_sede2" id="id_sede2" value="">
            <div class="col-md-12">
                <div class="col-md-4">
                    <center>
                        <a href="javascript:;">
                            <div class="prueba">
                                <img name="foto-condominio1" id="foto-condominio1" class="block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("img/home.png") !!}'>
                            </div>
                        </a>
                        <br>
                        <div>
                                {!! Form::file('foto1', '', [
                                    'id'            => 'foto1'])!!}
                        </div>
                    </center>
                </div>
                <div class="col-md-4">
                    <center>
                        <a href="javascript:;">
                            <div class="prueba">
                                <img name="foto-condominio2" id="foto-condominio2" class="block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("img/home.png") !!}'>
                            </div>
                        </a>
                        <br>
                        <div>
                                {!! Form::file('foto2', '', [
                                    'id'            => 'foto2'])!!}
                        </div>
                        <br>
                         <label style="color:red;">Archivos png o jpg no mayor a 4  megabytes (MB)</label>
                        <br><br><br>
                        <div>
                            {{ Form::button(' Eliminar',
                                [ 'id'=> 'eliminar', 'type' => 'button',
                                'class' => 'btn btn-default fa fa-times-circle'])
                            }}
                            {{ Form::button(' Cargar',
                                [ 'id'=> 'cargar', 'type' => 'button',
                                'class' => 'btn btn-primary fa fa-check-circle'])
                            }}
                        </div>
                    </center>
                </div>
                <div class="col-md-4">
                    <center>
                        <a href="javascript:;">
                            <div class="prueba">
                                <img name="foto-condominio3" id="foto-condominio3" class="block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("img/home.png") !!}'>
                            </div>
                        </a>
                        <br>
                        <div>
                                {!! Form::file('foto3', '', [
                                    'id'            => 'foto3'])!!}
                        </div>
                    </center>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('condominio') }}"
    var rutaF = "{{ URL::route('condominioF') }}"
    var rutaE = "{{ URL::route('condominioE') }}"
    var d = [];
    d['title']= JSON.parse(rhtmlspecialchars('{{ json_encode($title) }}'));
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['v_sedes']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_sedes) }}'));
</script>
<script src="{{ asset('js/condominio/condominio.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection
