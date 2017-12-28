@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-warning" id="content">
<br>
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
            <div class="row">
                <div class="col-md-12">
                    <table id="tablaProveedores" class="display"  cellspacing="0" width="100%"></table>
                </div>
            </div>

        </div>
        <div id="divForm" style="display:none;" class="divForm">
            <hr>
            {!! Form::open(['id'=>'FormProveedores',
            'autocomplete' => 'off',
            'novalidate' => 'novalidate',
            'files' => true
            ]) !!}
            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
            {!! Form::hidden('id_proveedor', '', [
            'id'            => 'id_proveedor',
            'class'         => 'form-control'])!!}
            <input type="hidden" name="image" id="image">
            <div class="caja-foto" style="display:none;">
                <center>
                    <a href="javascript:;">
                        @if ($var_icon = 'edificio.png') @endif
                        <div class="prueba">
                            <img name="foto-perfil" id="foto-perfil" class="foto-perfil block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("img/$var_icon") !!}'>
                        </div>
                    </a>
                    <br>
                    <label style="font-size:11px;">Cargar o cambiar foto de perfil</label>
                    <br>
                    <div>
                        {!! Form::file('foto', '', [
                        'id'            => 'foto'])!!}
                    </div>
                    <label style="color:red;font-size:11px;">Archivo png o jpg no mayor a 2  megabytes (MB)</label>
                    <br>
                    <div>
                        {{ Form::button(' Eliminar',
                        [ 'id'=> 'eliminar', 'type' => 'button',
                        'class' => 'btn btn-default fa fa-times-circle'])}}
                        {{ Form::button(' Cargar',
                        [ 'id'=> 'cargar', 'type' => 'button',
                        'class' => 'btn btn-primary fa fa-check-circle'])}}
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
                            {!! Form::text('paist1', '+56', [
                            'id'            => 'paist1',
                            'class'         => 'form-control vtObs',
                            'style'         => 'width:25%;height:35px',
                            'size'     => '3',
                            'maxlength'     => '3'])!!}

                            {!! Form::text('codigot1', '2', [
                            'id'            => 'codigot1',
                            'class'         => 'form-control vtCedula',
                            'style'         => 'width:25%;height:35px',
                            'size'     => '1',
                            'maxlength'     => '1'])!!}

                            {!! Form::text('numerot1', '', [
                            'id'            => 'numerot1',
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
                        {{ Form::label('null', 'Teléfono:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        <div style="width:100%"  class="input-group">
                            {!! Form::text('paist2', '+56', [
                            'id'            => 'paist2',
                            'class'         => 'form-control vtObs',
                            'style'         => 'width:25%;height:35px',
                            'size'     => '3',
                            'maxlength'     => '3'])!!}

                            {!! Form::text('codigot2', '2', [
                            'id'            => 'codigot2',
                            'class'         => 'form-control vtCedula',
                            'style'         => 'width:25%;height:35px',
                            'size'     => '1',
                            'maxlength'     => '1'])!!}

                            {!! Form::text('numerot2', '', [
                            'id'            => 'numerot2',
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
                        {{ Form::label('null', 'Página web:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('website', '', [
                        'id'            => 'website',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Página web',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '80'])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Categoria:',array('style' => 'text-align:center;line-height:500%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('id_rubro',$v_categorias,
                        ['label' => '',
                        'class' => 'comboclear',
                        'style'         => 'width:100%;height:35px',
                        'placeholder'   => 'Selecione...',
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
                        {{ Form::label('null', 'Historial de servicio:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::textarea('descripcion', '', [
                        'id'            => 'descripcion',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Historial de servicio',
                        'style'         => 'width:100%;height:250px',
                        'maxlength'     => '980'
                        ])!!}
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
                            {!! Form::checkbox('activo', 1, null,['class' => 'field', 'id' => 'activo']) !!}
                        </label>
                    </div>
                </div>
            </div>
            <div class="pull-rigth" align="center">
                {{ Form::button(' Volver',
                [ 'id'=> 'cancelar', 'type' => 'button',
                'class' => 'btn btn-default fa fa-times-circle'])}}
                {{ Form::button(' Guardar',
                [ 'id'=> 'guardar', 'type' => 'button',
                'class' => 'btn btn-primary fa fa-check-circle'])}}
            </div>
            <br>
            {!! Form::close() !!}
        </div>
    <!-- </div> -->
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('proveedores') }}"
    var rutaF = "{{ URL::route('proveedoresF') }}"
    var rutaE = "{{ URL::route('proveedoresE') }}"
    var d = [];
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['v_proveedores'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_proveedores) }}'));
    d['v_categorias'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_categorias) }}'));
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
</script>
<script src="{{ asset('js/proveedores/proveedoresA.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection