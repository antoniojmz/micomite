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
    <div id="divTabla" class="divForm">
      <div class="col-md-1"></div>
        <div class="col-md-10">
            <table id="tablaEncuestas"  width="100%" class="display"></table>
            <br />
        </div>
       <div class="col-md-1"></div>
    </div>
    <div id="modalResultados" class="easyui-window" title="Resultados de encuesta" data-options="modal:true,closed:true,closable:false,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="width:80%;padding:20px;">
        <div class="container"  style="width:660px;">
            <div class="row">
                <center>
                    <strong><span id="spanTituloEncuesta"></span></strong><br/>
                </center>
                <center>
                    <span id="spanDescripcionEncuesta"></span><br/>
                </center>
            </div>
            <hr>
            <div id="DivResultado" style="display:none;">
                <div class="row" >
                    <div class="col-md-12">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                                <div id="divResultados"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="DivVotacion" style="display:none;">
                {!! Form::open(['id'=>'FormVotacion',
                    'autocomplete' => 'off'
                    ]) !!}
                    <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
                    {!! Form::hidden('id_encuesta', '', [
                    'id'            => 'id_encuesta',
                    'class'         => 'form-control'])!!}
                    <div id="divVotacion"></div>
                {!! Form::close() !!}
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" align="center">
                        <div class="col-md-3"></div>
                        <div class="col-md-4">
                            {{ Form::button(' Volver',
                                [ 'id'=> 'cancelarR', 'type' => 'button',
                                'class' => 'btn btn-default fa fa-times-circle'])
                            }}
                        </div>
                        <div class="col-md-4 divRespuesta">
                            {{ Form::button(' Votar',
                                [ 'id'=> 'votar', 'type' => 'button',
                                'class' => 'btn btn-primary fa fa-check-circle'])
                            }}
                        </div>
                    </div>
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
    var rutaE = "{{ URL::route('encuestasE') }}"
    var d = [];
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
    d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
    d['v_encuestasA'] = JSON.parse(rhtmlspecialchars('{{ $v_encuestasA }}'));
</script>
<script src="{{ asset('js/encuestas/encuestasU.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection