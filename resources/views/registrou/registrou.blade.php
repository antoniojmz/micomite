@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-primary" id="content">
    <center>
        <div class="col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h2 id="spanTitulo" class="borderTitulo">Registro de usuarios</h2>
            </div>
            <div class="col-md-4"></div>
        </div>
    </center>
    <div id="divTabla">
        <table id="tablaUsuarios" class="display" cellspacing="0" width="100%"></table>
        <div class="col-md-12">
            <br />
            <div class="pull-right">
                {{ Form::button(' Agregar',
                [ 'id'=> 'agregar', 'type' => 'button',
                'class' => 'btn btn-primary fa fa-plus-circle'])}}
            </div>
            <br />
        </div>
    </div>
    <div id="divForm" style="display:none;">
        <center><h2 id="spanTitulo"></h2></center>
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
            <div class="caja-foto">
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
                            {{ Form::label('null', 'Tipo usuario:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                        {!! Field::select('id_tipo', null, [
                            'id'            => 'id_tipo',
                            'label'         => '',
                            'class'         => 'comboclear',
                            'placeholder'         => 'Seleccione...',
                            'style'         => 'width:100%;height:35px'
                            ])!!}
                        </div>
                    </div>
                </div>
            </div>                        
            <div class="siCambia">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'Contraseña:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4 form-group">
                            <input type="password" style="width:100%;height:35px;" class="form-control vtPass" id="password" name="password" placeholder="Contraseña"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'Confirme contraseña:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                              <input type="password" style="width:100%;height:35px;" class="form-control" id="password_confirmation" name="password_confirmation" data-fv-identical="true" data-fv-identical-field="password"
                              data-fv-identical-message="Las contraseñas no coinciden" placeholder="Confirme contraseña"/>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" align="center">
                    <div class="pull-rigth">
                        {{ Form::button(' Volver',
                            [ 'id'=> 'cancelarP', 'type' => 'button',
                            'class' => 'btn btn-primary fa fa-times-circle'])
                        }}
                        {{ Form::button(' Guardar',
                            [ 'id'=> 'guardarP', 'type' => 'button',
                            'class' => 'btn btn-primary fa fa-check-circle'])
                        }}
                    </div>
                </div>
            </div>
            <br/>
            <div class="noCambia" align="center">
                <div class="pull-rigth">
                    {{ Form::button(' Cancelar',
                        [ 'id'=> 'cancelar', 'type' => 'button',
                        'class' => 'btn btn-primary fa fa-times-circle'])
                    }}
                    {{ Form::button(' Guardar',
                        [ 'id'=> 'guardar', 'type' => 'button',
                        'class' => 'btn btn-primary fa fa-check-circle'])
                    }}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
<script Language="Javascript">
    var d = [];
    d['v_usuarios'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_usuarios) }}'));
    d['v_tipo_usuario'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_tipo_usuario) }}'));
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    var ruta = "{{ URL::route('registrou') }}"
    var rutaF = "{{ URL::route('registrouF') }}"
</script>
<script src="{{ asset('js/registrou/registrou.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection