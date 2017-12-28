@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-purple">
    <center>
        <br>
        {!! Form::open(['url' => URL::route('plantillanivel'),'autocomplete' => 'off','id' => 'formPlantillaPerfil']) !!}
            <div class="easyui-panel" title='{{ $title }}' style="width:50%;height:650px;
                padding:20px 15px 0px 15px">
                {!! Field::select('id_perfil', $nivelcombo, 2,
                    [ 'label' => 'Perfil', 'class' => 'form-control']) !!}
                {!! Field::select('id_modulo', $moduloscombo, null,
                    [ 'label' => 'Módulos', 'class' => 'form-control']) !!}
                {!! Field::select('id_poder', null, null,
                    [   'label' => 'Poderes', 'name'  => 'id_poder[]',
                        'class' => 'form-control','multiple']) !!}
                <div class="pull-right row-fluid">
                    {{ Form::button(' Agregar',
                        [   'id'    => 'agregar', 'type' => 'button',
                            'class' => 'btn btn-primary fa fa-arrow-down'
                        ])
                    }}
                </div>
                <br> <br> <br>
                <table id="TablaPerfilModulosPoderes" class="display" cellspacing="0" width="100%">
                </table>
            </div>
        {!! Form::close() !!}
    </center>
    <div id="mm" class="easyui-menu" style="width:165px;">
        <div id="delete" onclick="javascript:eliminar();" data-options="iconCls:'icon-remove'">Eliminar</div>
        <div id="del-sel" onclick="javascript:eliminarseleccion();" data-options="">Eliminar seleccionados</div>
        <div id="sell-all" onclick="javascript:TablaSelAll('TablaPerfilModulosPoderes','id_plantilla_nivel');" data-options="">Seleccionar todo</div>
        <div id="quitarseleccion" onclick="javascript:TablaDesSelAll('TablaPerfilModulosPoderes');" data-options="">Quitar selección</div>
    </div>
    <div id="tt">
        <a href="{{ URL::route('menu') }}" class="panel-tool-close"></a>
    </div>
</div>    
    <script Language="Javascript">
        var datos = [];
        var d = [];
        datos['TablaPerfilModulosPoderes'] = JSON.parse(rhtmlspecialchars('{{ json_encode($TablaPerfilModulosPoderes) }}'));
        datos['filtrarpoder'] = "{{ URL::route('filtrarpoder') }}";
        datos['rutaDeletePlantillaNivel'] = "{{ URL::route('deleteplantillaperfil') }}";
        datos['rutaAddPlantillaNivel'] = "{{ URL::route('addplantillaperfil') }}";
        d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
        d['id_nivel']= rhtmlspecialchars('{{ $id_nivel }}');
    </script>
    <script src="{{ asset('js/adm/plantillanivel.min.js') }}"></script>
    <script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection