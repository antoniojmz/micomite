@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-info" id="content">
    <center>
        <div class="col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h2 id="spanTitulo" class="borderTitulo"></h2>
            </div>
            <div class="col-md-4"></div>
        </div>
    </center>
    <div id="divTabla" class="divForm col-md-12">
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
        <table id="tablaEncuestas"></table>
    </div>
    <div id="divForm" style="display:none;" class="divForm">
        <hr>
        {!! Form::open(['id'=>'FormEncuestas',
            'autocomplete' => 'off'
            ]) !!}
            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
            {!! Form::hidden('id_encuesta', '', [
            'id'            => 'id_encuesta',
            'class'         => 'form-control'])!!}

            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Título de encuesta:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('titulo', '', [
                        'id'            => 'titulo',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Título de encuesta',
                        'style'         => 'width:100%;',
                        'maxlength'     => '300'
                        ])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Descripción de encuesta:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::textarea('descripcion', '', [
                        'id'            => 'descripcion',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Descripcion de encuesta',
                        'style'         => 'width:600px;height:400px',
                        'maxlength'     => '910'
                        ])!!}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" align="center">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            {{ Form::button(' Volver',
                                [ 'id'=> 'cancelar', 'type' => 'button',
                                'class' => 'btn btn-default fa fa-times-circle'])
                            }}
                        </div>
                        <div id="divGuardar" class="col-md-2" style="display:none;">
                            {{ Form::button(' Guardar',
                                [ 'id'=> 'guardar', 'type' => 'button',
                                'class' => 'btn btn-primary fa fa-check-circle'])
                            }}
                        </div>
                    </div>
                    <div id="divCargar" class="col-md-3" style="display:none;">
                        {{ Form::button(' Cargar opciones',
                            [ 'id'=> 'cargar', 'type' => 'button',
                            'class' => 'btn btn-primary fa fa-plus-circle'])
                        }}
                    </div>
                </div>
            </div>
            <br>
        {!! Form::close() !!}
    </div>
    <div id="modalOpciones" class="easyui-window" title="Cargar opciones de encuesta" data-options="modal:true,closed:true,closable:false,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:700px;height:520px;padding:20px;">
        <div class="container" style="width:660px;">
            {!! Form::open(['id'=>'FormOpciones',
            'autocomplete' => 'off'
            ]) !!}
            {!! Form::hidden('id_encuesta2', '', [
            'id'            => 'id_encuesta2',
            'class'         => 'form-control'])!!}
            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'Opción:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('opcion', '', [
                            'id'            => 'opcion',
                            'class'         => 'form-control vtObs2',
                            'placeholder'   => 'Opción',
                            'style'         => 'width:100%;height:35px',
                            'maxlength'     => '50'])!!}
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            {{ Form::button(' Volver',
                                [ 'id'=> 'cancelarO', 'type' => 'button',
                                'class' => 'btn btn-default fa fa-times-circle'])
                            }}
                            {{ Form::button(' Guardar',
                                [ 'id'=> 'guardarO', 'type' => 'button',
                                'class' => 'btn btn-primary fa fa-check-circle'])
                            }}
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div id="divTabla">
                        <table id="tablaOpcion"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalResultados" class="easyui-window" title="Resultados de encuesta" data-options="modal:true,closed:true,closable:false,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:60%;padding:20px;">
        <div class="container" style="width:60%;">
            <div class="row">
                    <center>
                        <strong><span id="spanTituloEncuesta"></span></strong><br/><br/>
                    </center>
            </div>
            <div class="row" >
                <div class="col-md-12">
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                        <!-- <center> -->
                            <div id="divResultados"></div>
                        <!-- </center> -->
                    </div>
                </div>
            </div>
            <br><br><br>
            <div class="row">
                <div class="col-md-12">
                    <center>

                        {{ Form::button(' Volver',
                            [ 'id'=> 'cancelarR', 'type' => 'button',
                            'class' => 'btn btn-default fa fa-times-circle'])
                        }}
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('encuestas') }}"
    var rutaO = "{{ URL::route('encuestasO') }}"
    var rutaP = "{{ URL::route('encuestasP') }}"
    var rutaD = "{{ URL::route('encuestasD') }}"
    var rutaR = "{{ URL::route('encuestasR') }}"
    var d = [];
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['v_encuestas'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_encuestas) }}'));
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
</script>
<script src="{{ asset('js/encuestas/encuestasA.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection