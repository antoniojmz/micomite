@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-purple" id="content">
    <center><h2 id="spanTitulo"></h2></center>
    <div id="divTabla" class="divForm">
        <table id="tablaComite" class="display" cellspacing="0" width="100%"></table>
    </div>
</div>
<div id="myModal2" class="easyui-window" title="Asignar participación al Comité" data-options="modal:true,closed:true,closable:false,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:50%;padding:20px;">
    {!! Form::open(['id'=>'FormComite',
    'autocomplete' => 'off'
    ]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <div class="form-group col-md-12">
                <input type="hidden" name="user_id" id="user_id" value="">
                    <div class="col-md-2">
                        {{ Form::label('null', 'Cargo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-6">
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-5"></div>
            <div class="col-md-7">
                <div class="pull-rigth">
                    <button type="button" class="btn btn-default" id="cerrarC">Cerrar</button>
                    <button name="boton" type="button" id="guardarC" class="btn btn-primary" value="2">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script Language="Javascript">
    var d = [];
    d['v_personas_comites']= JSON.parse(rhtmlspecialchars('{{ $v_personas_comites }}'));
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    var ruta = "{{ URL::route('comite') }}"
</script>
<script src="{{ asset('js/comite/comiteAdmin.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection
