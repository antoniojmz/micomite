@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-danger" id="content">
    <center>
        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 id="spanTitulo" class="borderTitulo"></h2>
            </div>
            <div class="col-md-2"></div>
        </div>
    </center>
    <div id="divTabla" class="divForm">
        <div class="col-md-12">
            <br />
            <div class="pull-right">
                {{ Form::button(' Agregar',
                [ 'id'=> 'agregar', 'type' => 'button',
                'class' => 'btn btn-primary fa fa-plus-circle'])}}
            </div>
        </div>
        <div class="col-md-12">
            <br/>
        </div>

        <div class="row">
            <div class="col-md-12" style="text-align: right;color:blue;">
                <span id="spanTurnos" ><a href="#" style="color:#0881C8;"><strong>Cargar turnos</strong></a></span>
            </div>
        </div>
        <table id="tablaSeguridad" class="display" cellspacing="0" width="100%"></table>

    </div>
    <div id="divForm" style="display:none;" class="divForm">
        <hr>
        {!! Form::open(['id'=>'FormSeguridad',
            'autocomplete' => 'off',
            'novalidate' => 'novalidate',
            'files' => true
            ]) !!}
            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
            {!! Form::hidden('id_seguridad', '', [
            'id'            => 'id_seguridad',
            'class'         => 'form-control'])!!}
            <input type="hidden" name="image" id="image">
            <div class="caja-foto" style="display:none;">
                <center>
                    <a href="javascript:;">
                        @if ($var_icon = 'foto.jpeg') @endif
                        <div class="prueba">
                            <img name="foto-perfil" id="foto-perfil" class="foto-perfil block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("img/$var_icon") !!}'>
                        </div>
                    </a>
                    <br>
                    <label>Cargar o cambiar foto de perfil</label>
                    <br>
                    <div>
                            {!! Form::file('foto', '', [
                                'id'            => 'foto'])!!}
                    </div>
                    <br>
                     <label style="color:red;">Archivo png o jpg no mayor a 2  megabytes (MB)</label>
                    <br>
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
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'RUT:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('rut', '', [
                        'id'            => 'rut',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'RUT',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '50'])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Nombres:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('nombres', '', [
                        'id'            => 'nombres',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Nombres',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '50'])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Correo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('email', '', [
                        'id'            => 'email',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Correo',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '50'
                        ])!!}
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
                        'maxlength'     => '50'
                        ])!!}
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
                            'style'         => 'width:25%;height:35px',
                            'size'     => '3',
                            'maxlength'     => '3'])!!}

                            {!! Form::text('codigot', '2', [
                            'id'            => 'codigot',
                            'class'         => 'form-control vtCedula',
                            'style'         => 'width:25%;height:35px',
                            'size'     => '1',
                            'maxlength'     => '1'])!!}

                            {!! Form::text('numerot', '', [
                            'id'            => 'numerot',
                            'class'         => 'form-control vtCedula',
                            'placeholder'   => 'Teléfono',
                            'style'         => 'width:50%;height:35px',
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
                        {{ Form::label('null', 'Movil:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        <div style="width:100%"  class="input-group">
                            {!! Form::text('paism', '+56', [
                            'id'            => 'paism',
                            'class'         => 'form-control vtObs',
                            'style'         => 'width:25%;height:35px',
                            'size'     => '3',
                            'maxlength'     => '3'])!!}

                            {!! Form::text('codigom', '9', [
                            'id'            => 'codigom',
                            'class'         => 'form-control vtCedula',
                            'style'         => 'width:25%;height:35px',
                            'size'     => '1',
                            'maxlength'     => '1'])!!}

                            {!! Form::text('numerom', '', [
                            'id'            => 'numerom',
                            'class'         => 'form-control vtCedula',
                            'placeholder'   => 'Movil',
                            'style'         => 'width:50%;height:35px',
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
                        {{ Form::label('null', 'Cargo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('cargo', '', [
                        'id'            => 'cargo',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Cargo',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '50'
                        ])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Sueldo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('sueldo', '', [
                        'id'            => 'sueldo',
                        'class'         => 'form-control vtObs2 moneda',
                        'placeholder'   => 'Sueldo',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '50'
                        ])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Turno:',array('style' => 'text-align:center;line-height:500%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('id_turno',null,
                        ['label' => '',
                        'class' => 'comboclear',
                        'style'         => 'width:100%;height:35px',
                        'placeholder'   => 'Selecione...'
                        ])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Dias:',array('style' => 'text-align:center;line-height:500%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('id_dias',null,
                        ['label' => '',
                        'class' => 'comboclear',
                        'multiple' => 'multiple',
                        'style'         => 'width:100%;height:35px'
                        ])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Tipo de seguridad:',array('style' => 'text-align:center;line-height:500%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('id_tipo_seguridad',null,
                        ['label' => '',
                        'class' => 'comboclear',
                         'style'         => 'width:100%;height:35px',
                        'placeholder'   => 'Selecione...',
                        ])!!}
                    </div>
                </div>
            </div>
            <div id="divSegExterna" style="display:none;">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'RUT de la empresa:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                            {!! Form::text('rutE', '', [
                            'id'            => 'rutE',
                            'class'         => 'form-control vtObs2',
                            'placeholder'   => 'RUT',
                            'style'         => 'width:100%;height:35px',
                            'maxlength'     => '50'])!!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'Nombre de la empresa:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                            {!! Form::hidden('id_empresa', '', [
                            'id'            => 'id_empresa',
                            'value'           =>'1'
                            ])!!}
                        <div class="col-md-4">
                            {!! Form::text('des_empresa', '', [
                            'id'            => 'des_empresa',
                            'class'         => 'form-control vtObs2',
                            'placeholder'   => 'Nombre de la empresa',
                            'style'         => 'width:100%;height:35px',
                            'readonly'         => 'true',
                            'maxlength'     => '50'])!!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                          {{ Form::label('null','Activo:',array('style' => 'text-align:center;line-height:500%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4 checkbox">
                        <label>
                            {!! Form::checkbox('activo', 1, null,
                                ['class' => 'field', 'id' => 'activo']) !!}
                        </label>
                    </div>
                </div>
            </div>
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
    <div id="modalTurnos" class="easyui-window" title="Registro de turnos" data-options="modal:true,closed:true,closable:false,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:80%;height:500px;padding:20px;">
        <div class="container"  style="width:90%;">
            {!! Form::open(['id'=>'FormTurno',
            'autocomplete' => 'off',
            'novalidate' => 'novalidate',
            'files' => true
            ]) !!}
                <center>
                    <strong><span id="spanTituloEncuesta"></span></strong><br/><br/>
                </center>
                <div class="row" >
                    <div class="col-md-12">
                        <div class="col-md-2">
                            {{ Form::label('null', 'Hora inicio:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                            {!! Form::text('horaI', '', [
                            'id'            => 'horaI',
                            'class'         => 'form-control',
                            'placeholder'   => 'Hora de inicio',
                            'style'         => 'width:100%;height:35px',
                            'maxlength'     => '50'])!!}
                        </div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'Hora fin:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                            {!! Form::text('horaF', '', [
                            'id'            => 'horaF',
                            'class'         => 'form-control',
                            'placeholder'   => 'Hora fin',
                            'style'         => 'width:100%;height:35px',
                            'maxlength'     => '50'])!!}
                        </div>
                    </div>
                </div>
                <br><br><br>
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            {{ Form::button(' Volver',
                                [ 'id'=> 'cancelarT', 'type' => 'button',
                                'class' => 'btn btn-default fa fa-times-circle'])
                            }}
                            {{ Form::button(' Cargar',
                                [ 'id'=> 'cargarT', 'type' => 'button',
                                'class' => 'btn btn-primary fa fa-check-circle'])
                            }}
                        </center>
                    </div>
                </div>
                <div id="divTablaTurnos" class="row">
                    <table id="tablaTurnos" class="display" cellspacing="0" width="40%"></table>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('seguridad') }}"
    var rutaF = "{{ URL::route('seguridadF') }}"
    var rutaE = "{{ URL::route('seguridadE') }}"
    var rutaC = "{{ URL::route('seguridadC') }}"
    var rutaT = "{{ URL::route('seguridadT') }}"
    var d = [];
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['v_turnos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_turnos) }}'));
    d['v_seguridad'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_seguridad) }}'));
    d['v_dias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_dias) }}'));
    d['v_tipo_seguridad'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_tipo_seguridad) }}'));
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
</script>
<script src="{{ asset('js/seguridad/seguridadA.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection
