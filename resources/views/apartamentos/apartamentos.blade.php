@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-danger" id="content">
    <center>
        <div class="col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h2 id="tituloPantalla" class="borderTitulo"></h2>
            </div>
            <div class="col-md-4"></div>
        </div>
    </center>
    <div id="divTabla" class="divForm">
        <table id="tablaApartamentos" class="display" cellspacing="0" width="100%"></table>
    </div>
    <div id="divForm" class="divForm" style="display:none;">
        <div id="divMostrar" class="divMostrar" style="display:none;">
            <table id="tablaUsuarioApartamentos" class="display" cellspacing="0" width="100%"></table>
            <br />
            <div class="col-md-12 col-md-offset-5">
                {{ Form::button(' Volver',
                [ 'id'=> 'volverA', 'type' => 'button',
                'class' => 'btn btn-default fa fa-times-circle'])}}
            </div>
        </div>
        <div id="divMostrar" class="divMostrar">
            <div class="caja-foto">
                <center>
                    <a href="javascript:;">
                        @if ($var_icon = 'foto.jpeg') @endif
                        <input type="hidden" id="image" name="image">
                        <div>
                            <img name="foto-perfil" id="foto-perfil" class="foto-perfil block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("img/$var_icon") !!}'>
                        </div>
                    </a>
                    <br>
                </center>
            </div>
            {!! Form::open(['id'=>'FormApartamento',
            'autocomplete' => 'off'
            ]) !!}
            <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="id_apartamento" id="id_apartamento" value="">
            <input type="hidden" name="user_id" id="user_id" value="">
            <hr>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Propietario:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        <span id="name" class="form-control"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Tipo:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        Casa&nbsp;&nbsp;&nbsp;
                        <input type="radio" class="tipoc" name="tipo" id="tipo" value='1'>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Apartamento&nbsp;&nbsp;&nbsp;
                        <input type="radio" class="tipof" name="tipo" id="tipo" value='2'>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Número de casa / apto:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('numero', '', [
                        'id'            => 'numero',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Número de la casa o apartamento',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '200'])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Nombre casa / apto:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('nombre', '', [
                        'id'            => 'nombre',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Nombre de la casa o apartamento',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '200'])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Porcentaje:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('porcentaje', '', [
                        'id'            => 'porcentaje',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'porcentaje de la casa o apartamento',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '200'])!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{ Form::label('null', 'Observaciones:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
                    </div>
                    <div class="col-md-4">
                        {!! Form::textarea('obs', '', [
                        'id'            => 'obs',
                        'class'         => 'form-control vtObs2',
                        'placeholder'   => 'Observaciones',
                        'style'         => 'width:100%;height:35px',
                        'maxlength'     => '200'])!!}
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
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('apartamentos') }}"
    var rutaU = "{{ URL::route('apartamentosU') }}"
    var rutaD = "{{ URL::route('apartamentosD') }}"
    var d = [];
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['id_nivel']= rhtmlspecialchars('{{ $id_nivel }}');
    d['v_usuariosAptos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_usuariosAptos) }}'));
</script>
<script src="{{ asset('js/apartamentos/apartamentos.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection
