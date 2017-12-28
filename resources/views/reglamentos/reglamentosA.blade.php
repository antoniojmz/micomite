@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-purple" id="content">
    <center>
        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 id="spanTitulo" class="borderTitulo">Reglamentos internos del condominio</h2>
            </div>
            <div class="col-md-2"></div>
        </div>
    </center>
    <div id="divTabla">
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
        <div class="col-md-12">
            <table id="tablaReglamentos" class="display" cellspacing="0" width="100%"></table>
        </div>
    </div>
    <div id="divForm" style="display:none;">
        <hr>
        {!! Form::open(['id'=>'Formreglamento',
            'autocomplete' => 'off',
            'novalidate' => 'novalidate',
            'files' => true
            ]) !!}
            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
            {!! Form::hidden('id_reglamento', '', [
            'id'            => 'id_reglamento',
            'class'         => 'form-control'])!!}
            <div>
                <center>
                    <h5>
                     <i><span id="spanCondominio"></span></i><br><br>
                    </h5>
                </center>
            </div>
            <div class="noCambia">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'Tipo de Reglamento:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                            {!! Field::select('id_tipo',null,
                                ['label' => '',
                                'class' => 'comboclear',
                                'style'         => 'width:100%;height:35px;',
                                'multiple'   => 'true',
                            ])!!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'Título del Reglamento:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                            {!! Form::text('des_reglamento', '', [
                            'id'            => 'des_reglamento',
                            'class'         => 'form-control vtObs2',
                            'placeholder'   => 'Título del Reglamento',
                            'style'         => 'width:100%;height:35px',
                            'maxlength'     => '50'])!!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'Archivo pdf:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                           <center> <img name="pdf-icon" id="pdf-icon" width="50" height="50" alt="Image" src='{!! asset("img/pdf-flat.png") !!}'></center>
                            {!! Form::file('urlreglamento', '', [
                                'id'            => 'urlreglamento'
                                ])!!}

                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                     <center><h6 style="color:red;">Archivo pdf no mayor a 5  megabytes (MB)</h6></center>
                </div>
                <br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            {{ Form::label('null', 'Activo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                        </div>
                        <div class="col-md-4">
                            {{ Form::checkbox('estatus', 1, true,
                            ['class' => 'field',
                            'id'            => 'estatus']) }}
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="botonera" align="center">
                <div class="pull-rigth">
                    {{ Form::button(' Cancelar',
                        [ 'id'=> 'cancelar', 'type' => 'button',
                        'class' => 'btn btn-default fa fa-times-circle'])
                    }}
                    {{ Form::button(' Guardar',
                        [ 'id'=> 'guardar', 'type' => 'button',
                        'class' => 'btn btn-primary fa fa-check-circle'])
                    }}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('reglamentos') }}"
    var rutaC = "{{ URL::route('reglamentosC') }}"
    var rutaE = "{{ URL::route('reglamentosE') }}"
    var rutaD = "{{ URL::route('reglamentosD') }}"
    var d = [];
    d['v_reglamentos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_reglamentos) }}'));
    d['v_tipo'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_tipo) }}'));
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
</script>
<script src="{{ asset('js/reglamentos/reglamentosA.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection