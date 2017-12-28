@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-primary">
    <center>
        <br>
        <div class="easyui-panel" title='{{ $title }}' style="width:50%;height:620px;
                padding:20px" >
            {!! Form::open(['url' => URL::route('modulospoderes'),'autocomplete' => 'off','id' => 'formmodulospoderes']) !!}
                {!! Field::select('id_modulo', $moduloscombo, null,
                    [ 'label' => 'Módulos', 'class' => 'form-control']) !!}
                {!! Field::select('id_poder', $poderescombo, null,
                    [   'label' => 'Poderes', 'name'  => 'id_poder[]',
                        'class' => 'form-control','multiple']) !!}
                <div class="pull-right">
                    {{ Form::button(' Agregar',
                        [   'id'    => 'agregar', 'type' => 'button',
                            'class' => 'easyui-linkbutton'
                        ])
                    }}
                </div>
                <br> <br> <br> <div>
                    <table id="tablaModulospoderes" class="display"  cellspacing="0" width="100%"></table>
                </div>
            {!! Form::close() !!}
        </div>
    </center>
    <div id="mm" class="easyui-menu" style="width:165px;">
        <div id="delete" onclick="javascript:eliminar();" data-options="iconCls:'icon-remove'">Eliminar</div>
        <div id="del-sel" onclick="javascript:eliminarseleccion();" data-options="">Eliminar seleccionados</div>
        <div id="sell-all" onclick="javascript:TablaSelAll('tablaModulospoderes','id_modulos_poderes');" data-options="">Seleccionar todo</div>
        <div id="quitarseleccion" onclick="javascript:TablaDesSelAll('tablaModulospoderes');" data-options="">Quitar selección</div>
    </div>
    <div id="tt">
        <a href="{{ URL::route('menu') }}" class="panel-tool-close"></a>
    </div>
</div>    
    <script Language="Javascript">
        var datos = [];
        var d = [];
        datos['rutalistar'] = "{{ URL::route('listarmodulospoderes') }}";
        datos['rutadeletemodulopoder'] = "{{ URL::route('deletemodulospoderes') }}";
        datos['rutaaddmodulopoder'] = "{{ URL::route('addmodulospoderes') }}";
        datos['TablaModulosPoderes'] = JSON.parse(rhtmlspecialchars('{{ json_encode($TablaModulosPoderes) }}'));
        d['id_nivel']= rhtmlspecialchars('{{ $id_nivel }}');
        d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
       
    </script>
    <script src="{{ asset('js/adm/modulospoderes.min.js') }}"></script>
    <script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>

@endsection
