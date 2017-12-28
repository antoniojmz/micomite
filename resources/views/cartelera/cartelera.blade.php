@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-info" id="content">
    <center>
        <div class="col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h2 id="spanTitulo" class="borderTitulo">Cartelera informativa</h2>
            </div>
            <div class="col-md-4"></div>
        </div>
    </center>
    <div id="divTabla">
        <div class="row">
            <div class="col-md-12">
                <br />
                <div class="pull-right">
                    {{ Form::button(' Agregar',
                    [ 'id'=> 'agregar', 'type' => 'button',
                    'class' => 'btn btn-primary fa fa-plus-circle'])}}
                </div>
            </div>
        </div>
        <br />
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table id="tablaCarteleras" class="display table-striped" cellspacing="0" width="100%"></table>
        </div>
        <div class="col-md-1"></div>

    </div>

    <div id="divForm" style="display:none;">
        {!! Form::open(['id'=>'FormCartelera',
        'autocomplete' => 'off'
        ]) !!}
        <center><h3><span id="tituloPantalla"></span></h3></center>
        <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="id_cartelera" id="id_cartelera" value="">
        <hr>

       <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Fecha de Publicación:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                    {!! Form::text('fecha', date('d-m-Y') , [
                    'id'            => 'fecha',
                    'class'         => 'form-control vtFecha',
                    'style'         => 'width:100%;height:35px',
                    'readonly'      => 'true'
                    ])!!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Titulo del Aviso:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                    {!! Form::text('titulo', '', [
                    'id'            => 'titulo',
                    'class'         => 'form-control vtObs2',
                    'placeholder'   => 'Titulo del Aviso',
                    'style'         => 'width:100%;height:35px',
                    'maxlength'     => '100'])!!}
                </div>
            </div>
        </div>


        <div class="row">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Descripcion del Aviso:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div id="divSpan" class="col-md-4" style="display:none;">
                    <span id="SpanDescripcion" class="form-control"></span>
                </div>
                <div id="divTextarea" class="col-md-4">
                    {!! Form::textarea('descripcion', '', [
                    'id'            => 'descripcion',
                    'class'         => 'form-control vtObs2',
                    'placeholder'   => 'Descripcion',
                    'style'         => 'width:100%;height:400px',
                    'maxlength'     => '900',
                    'rows'          => '100',
                    'cols'          => '100'])!!}
                </div>
            </div>
        </div>

        <div id="divPrioridad" class="row" style="display:none;">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    {{ Form::label('null', 'Prioridad:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                            Media&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="sexo" name="prioridad" id="prioridadB" value="1">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Alta&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="sexo" name="prioridad" id="prioridadA" value="2">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div>
        </div>

        <div class="row" id="divActivo" style="display:none;">
            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-2">

                    {{ Form::label('null', 'Activo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                </div>
                <div class="col-md-4">
                   <input type="checkbox" name="estatus" id="estatus" checked="true">
                </div>
            </div>
        </div>

        <br>
        <div clas="row">
            <div align="col-md-12">
                <div class="pull-rigth">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="col-md-4">
                            {{ Form::button(' Volver',
                                [ 'id'=> 'cancelar', 'type' => 'button',
                                'class' => 'btn btn-default fa fa-times-circle'])
                            }}
                        </div>
                        <div id="divGuardar" class="col-md-6">
                            {{ Form::button(' Guardar',
                                [ 'id'=> 'guardar', 'type' => 'button',
                                'class' => 'btn btn-primary fa fa-check-circle'])
                            }}
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('cartelera') }}"
    var rutaA = "{{ URL::route('carteleraA') }}"
    var d = [];
    d['v_carteleras_activas']= JSON.parse(rhtmlspecialchars('{{ $v_carteleras_activas }}'));
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel']= rhtmlspecialchars('{{ $id_nivel }}');
    d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
</script>
<script src="{{ asset('js/cartelera/cartelera.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection