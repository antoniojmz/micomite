@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-danger" id="content">
    <center>
        <div class="col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h2 id="spanTitulo" class="borderTitulo">Registro de instalaciones</h2>
            </div>
            <div class="col-md-4"></div>
        </div>
    </center>
    {!! Form::open(['id'=>'Forminstalacion',
    'autocomplete' => 'off'
    ]) !!}
    <div id="divTabla">
     <div class="col-md-12">
            <div class="pull-right">
                {{ Form::button(' Agregar',
                [ 'id'=> 'agregar', 'type' => 'button',
                'class' => 'btn btn-primary fa fa-plus-circle'])}}
            </div>
        </div>
        <div class="col-md-12">
              <br/>
        </div>
        <table id="tablaInstalaciones" class="display" cellspacing="0" width="100%"></table>
    </div>
    <div id="divForm" style="display:none;">
        <hr>
        <center><h3><span id="tituloPantalla"></span></h3></center>
        <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="id_instalacion" id="id_instalacion" value="">
        <hr>
        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Tipo de Instalación:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                        {!! Field::select('id_descripcion','',
                        ['id' => 'id_descripcion',
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
                    {{ Form::label('null', 'Descripción:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                    {!! Form::textarea('descripcion', '', [
                    'id'            => 'descripcion',
                    'class'         => 'form-control vtObs2',
                    'placeholder'   => 'Descripción',
                    'style'         => 'width:100%;height:200px',
                    'maxlength'     => '295',
                    'rows'          => '100',
                    'cols'          => '100'])!!}
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




        <div id="divFotos" class="easyui-window" title="Cargar Fotos" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:60%;height:70%;padding:20px;">
            {!! Form::open(['id'=>'FormFotos',
            'autocomplete' => 'off',
            'novalidate' => 'novalidate',
            'files' => true
            ]) !!}
            <input type="hidden" name="id_instalacion2" id="id_instalacion2" value="">
            <div class="col-md-12">
                <center>
                    <a href="javascript:;">
                        <div class="prueba">
                            <img name="foto-instalacion1" id="foto-instalacion1" class="block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("img/home.png") !!}'>
                        </div>
                    </a>
                    <br>
                    <div>
                            {!! Form::file('foto1', '', [
                                'id'            => 'foto1'])!!}
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
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('instalaciones') }}"
    var rutaF = "{{ URL::route('instalacionesF') }}"
    var rutaE = "{{ URL::route('instalacionesE') }}"
    var d = [];
    d['v_instalaciones_combo']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_instalaciones_combo) }}'));
    d['v_instalaciones']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_instalaciones) }}'));
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
</script>
<script src="{{ asset('js/instalaciones/instalacionesA.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection
