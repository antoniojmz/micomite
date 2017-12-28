@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-success" id="content">
    <div id="divForm">
        <center>
            <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2 id="spanTitulo" class="borderTitulo">Actualizacion de datos</h2>
                </div>
                <div class="col-md-4"></div>
            </div>
        </center>
        <hr>
        {!! Form::open(['id'=>'FormUsuario',
            'autocomplete' => 'off',
            'novalidate' => 'novalidate',
            'files' => true
            ]) !!}
            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
            {!! Form::hidden('user_id', '', [
            'id'            => 'user_id',
            'class'         => 'form-control'])!!}
            <div>
                <center>
                    <h5>
                     <i><span id="spanCondominio"></span></i><br><br>
                    </h5>
                </center>
            </div>
            <div class="caja-foto">
                <center>
                    <a href="javascript:;">
                        @if ($var_icon = 'foto.jpeg') @endif
                        <input type="hidden" id="image" name="image">
                        <div>
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
            <div class="noCambia">
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
                            {!! Form::text('name', '', [
                            'id'            => 'name',
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
                            'maxlength'     => '100'
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
                            {{ Form::label('null', 'Fecha nacimiento:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                {!! Form::text('fecha_nacimiento', '', [
                                'id'            => 'fecha_nacimiento',
                                'class'         => 'form-control vtObs2 vtfecha',
                                'placeholder'   => 'Fecha nacimiento',
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
                            {{ Form::label('null', 'Sexo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                            Femenino&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="sexof" name="sexo" id="sexo" value='f'>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Masculino&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="sexom" name="sexo" id="sexo" value='m'>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="botonera" align="center">
                <div class="pull-rigth">
                    {{ Form::button(' Guardar',
                        [ 'id'=> 'guardar', 'type' => 'button',
                        'class' => 'btn btn-primary fa fa-check-circle'])
                    }}
                </div>
            </div>
        {!! Form::close() !!}
            <br>

        @if ($id_nivel > 2)
            <!--  SI ES PROPIETARIO Y PERTENECE AL COMITE-->
             <div id="divConsulta" class="alert alert-success" style="display:none;">
                  <span id="spanConsulta"></span>
             </div>
        @else
            <!-- SI ES ADMINISTRADOR Y SI ES PARTICIPANTE DEL COMITE -->
            {!! Form::open(['id'=>'FormComite',
            'autocomplete' => 'off'
            ]) !!}
                <center>
                    <div id="divParticipante" class="alert alert-success" style="display:none;">
                        <span id="spanComite"></span>
                        <button name="boton" type="button" id="guardarC" class="btn btn btn-warning" value="1">Eliminar Participación</button>
                    </div>
                </center>
                <center>
                    <div id="modal" align="center" style="display:none;">
                        <div class="pull-rigth">
                           <a href="#myModal" role="button" class="btn btn-large btn btn-success" data-toggle="modal">Asignar participación al comité</a>
                        </div>
                    </div>
                </center>
                <div id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Asignar participación al comité</h4>
                            </div>

                            <div class="modal-body">
                            <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            {{ Form::label('null', 'Cargo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                                        </div>
                                        <div class="col-md-4">
                                            {!! Form::text('cargo', '', [
                                            'id'            => 'cargo',
                                            'class'         => 'form-control vtObs2',
                                            'placeholder'   => 'Cargo',
                                            'style'         => 'width:100%;height:35px',
                                            'maxlength'     => '60'])!!}
                                        </div>
                                    </div>
                            </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button name="boton" type="button" id="guardarC" class="btn btn-primary" value="2">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
        @endif

    </div>
</div>
<script Language="Javascript">
    var d = [];
    d['v_datos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_datos) }}'));
    d['condominio'] = JSON.parse(rhtmlspecialchars('{{ json_encode($condominio) }}'));
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
    d['comite'] = rhtmlspecialchars('{{ $comite }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
    var ruta = "{{ URL::route('mis_datos') }}"
    var rutaF = "{{ URL::route('mis_datosF') }}"
    var rutaE = "{{ URL::route('mis_datosE') }}"
    var rutaC = "{{ URL::route('mis_datosC') }}"
</script>
<script src="{{ asset('js/datos/datos.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>

@endsection
