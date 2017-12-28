@inject('perfil', 'App\Services\AuthSrv')
@extends ('menu.plantilla_menu')
@section ('body')
    <style type="text/css">
        .select2-container--open { z-index: 10000; /* form dialog z-index:10002 (computed)*/ };

        .select2-container--default {
            width: 100%;
            /*padding: 0;*/
        }
    </style>
<div class="container box box-info">
    <center>
        <br>
            <div class="easyui-panel" title='{{ $title }}' style="width:70%;height:700px;
                padding:20px 15px 0px 15px">
                {!! Form::open(['url' => URL::route('usuario'),'autocomplete' => 'off','id' => 'formbuscarsuario']) !!}
                    {!! Form::hidden('id_usuario', null, ['id' => 'id_usuario']) !!}
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group col-sm-8">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <div class="form-group">
                                            <label for="">RUT</label>
                                            <div class="form-group">
                                                {!! Form::text('rut', '',
                                                [ 'class' => 'form-control', 'id' => 'rut',
                                                  'placeholder' => 'RUT', 'autofocus' => 'autofocus']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for=""></label>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('activo', 1, null,
                                                    ['class' => 'field', 'id' => 'activo', 'onChange' => 'Procesoactivo()']) !!}
                                                <b>{{ 'Activo' }} </b>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for=""></label>
                                        <div>
                                            {{ Form::button(' Consultar',
                                                [   'id'    => 'consultar', 'type' => 'button',
                                                    'class' => 'btn btn-primary fa fa-search'
                                                ])
                                            }}
                                        </div>
                                    </div>
                                </div>
                                {!! Field::text('nombre', null,
                                [ 'label' => 'Nombres', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>
                            <div class="form-group">
                                <center>
                                    <a href="javascript:;">
                                        @if ($var_icon = 'foto.jpeg') @endif
                                        <div>
                                            <img class="foto-perfil block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("img/$var_icon") !!}'>
                                        </div>
                                    </a>
                                </center>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                {!! Form::open(['url' => URL::route('usuario'),'autocomplete' => 'off','id' => 'formusuario']) !!}

                    {!! Field::select('id_sede', $sedecombo, null,
                        [ 'label' => 'Condominio', 'class' => 'form-control sel']) !!}

                    {!! Field::select('id_perfil', $perfilcombo, null,
                        [ 'label' => 'Perfil', 'class' => 'form-control sel']) !!}

                    <!-- {{--!! Field::select('id_organo', null, null,
                    [   'label' => 'Organos', 'name'  => 'id_poder[]',
                        'class' => 'form-control','multiple']) !!--}} -->

                    <div class="pull-right ver">
                        {{ Form::button(' Agregar',
                            [   'id'    => 'agregar', 'type' => 'button',
                                'class' => 'btn btn-primary fa fa-arrow-down'
                            ])
                        }}
                    </div>
                    <br> <br> <br>
                    <div class="ver">
                        <table id="TablaPerfil" class="display" cellspacing="0" width="100%">
                        </table>
                    </div>
                {!! Form::close() !!}
            </div>
    </center>
    <div id="mm" class="easyui-menu" style="width:165px;">
        <!-- Activar/Inactivar -->
        <div id="p_activo" onclick="javascript:EstatusPerfil(true);" data-options="iconCls:'icon-ok'">Activar perfil</div>

        <div id="p_inactivo" onclick="javascript:EstatusPerfil(false);" data-options="iconCls:'icon-cancel'">Inactivar perfil</div>

        <div id="M_AccesoAvanzado" onclick="formAccesoAvanzado();" data-options="iconCls:'icon-add'">Accesos avanzado</div>

        <div id="Act_Plantilla" onclick="javascript:ActualizarPlantilla();" data-options="iconCls:'icon-reload'">Actualizar con plantilla</div>

        <div id="del_acceso" onclick="javascript:DelAcceso();" data-options="iconCls:'icon-remove'">Eliminar acceso</div>

    </div>
    <div id="tt">
        <a href="{{ URL::route('menu') }}" class="panel-tool-close"></a>
    </div>

    <!-- cuando este listo agregar closable:false -->
    <!-- <div id="w" class="easyui-window" title="Accesos avanzados" -->
    <div id="w" class="easyui-window" title="Accesos avanzados "
        data-options="modal:true,closed:true,collapsible:false,minimizable:false,
        maximizable:false,resizable:false, top:85"
        style="width:50%;height:600px;padding:10px;">

        {!! Form::open(['autocomplete' => 'off','id' => 'formmodulospoderes']) !!}

            {!! Field::select('id_modulo', null, null,
                    [   'label' => 'Módulos', 'name'  => 'id_modulo',
                        'class' => 'form-control combo',
                        'placeholder' => 'Seleccione...']) !!}

            {!! Field::select('id_poder', null, null,
                [   'label' => 'Poderes', 'name'  => 'id_poder[]',
                    'class' => 'form-control combo','multiple']) !!}

            <div class="pull-right">
                {{ Form::button(' Agregar',
                    [   'id'    => 'AgregarAcceso', 'type' => 'button',
                        'class' => 'btn btn-primary fa fa-arrow-down'
                    ])
                }}
            </div>
            <br> <br> <br> <div>
                <table id="TablaAcceso" class="display"  cellspacing="0" width="100%">
                </table>
            </div>
        {!! Form::close() !!}

    </div>
</div>
    <script Language="Javascript">
        var datos = [];
        var d = [];
        datos['rutabuscarusuario'] = "{{ URL::route('buscarusuario') }}";
        datos['rutaestatususuario'] = "{{ URL::route('estatuusuario') }}";
        datos['rutaestatuusuarioperfil'] = "{{ URL::route('estatuusuarioperfil') }}";
        datos['rutaactualizarplantilla'] = "{{ URL::route('actualizarplantilla') }}";
        datos['rutaasignarperfil'] = "{{ URL::route('asignarperfil') }}";
        datos['rutaaccesoavanzado'] = "{{ URL::route('accesoavanzado') }}";
        datos['rutafiltrarpoder'] = "{{ URL::route('filtrarpoder') }}";
        datos['rutaAgregarAcceso'] = "{{ URL::route('agregaracceso') }}";
        datos['rutaEliminarAcceso'] = "{{ URL::route('eliminaracceso') }}";
        d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
        d['id_nivel']= rhtmlspecialchars('{{ $id_nivel }}');
    </script>
    <script src="{{ asset('js/adm/usuario.min.js') }}"></script>
    <script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection