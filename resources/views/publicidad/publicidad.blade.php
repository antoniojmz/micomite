@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-warning" id="content">
    <center>
        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 id="spanTitulo" class="borderTitulo"></h2>
            </div>
            <div class="col-md-2"></div>
        </div>
    </center>
    <div class="col-md-12">
       <br>
    </div>

    <div id="divTabla" class="divForm">
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
        <table id="tablaPublicidad" class="display" cellspacing="0" width="100%"></table>
    </div>
    <div id="divForm" style="display:none;" class="divForm">
        <hr>
        {!! Form::open(['id'=>'FormPublicidad',
            'autocomplete' => 'off',
            'novalidate' => 'novalidate',
            'files' => true
            ]) !!}
            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
            {!! Form::hidden('id_publicidad', '', [
            'id'            => 'id_publicidad',
            'class'         => 'form-control'])!!}
            <input type="hidden" name="image" id="image">
            <div class="caja-foto" style="display:none;">
                <center>
                    <a href="javascript:;">
                        <div class="prueba">
                            <img name="foto-publicidad" id="foto-publicidad" class="block-center img-thumbnail" width="200" height="120" alt="Image" src='{!! asset("img/banner_default_blue.png") !!}'>
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
                     <label style="color:red;">Archivo png o jpg no mayor a 4  megabytes (MB)</label>
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
                        {{ Form::label('null', 'Descripción:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('descripcion', '', [
                        'id'            => 'descripcion',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Descripción',
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
                        {{ Form::label('null', 'Comunas:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('id_comunas', $v_comunas,[
                        'label' => '',
                        'class' => 'comboclear',
                        'multiple' => 'true',
                        'style'         => 'width:100%;height:35px'])
                        !!}
                         <input type="checkbox" id="checkbox" > Seleccionar todas las Comunas
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
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('publicidad') }}"
    var rutaF = "{{ URL::route('publicidadF') }}"
    var rutaE = "{{ URL::route('publicidadE') }}"
    var d = [];
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['v_publicidad'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_publicidad) }}'));
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
</script>
<script src="{{ asset('js/publicidad/publicidad.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection