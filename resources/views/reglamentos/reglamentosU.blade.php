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
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table id="tablaReglamentos" class="display" cellspacing="0" width="100%"></table>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('reglamentos') }}"
    var rutaD = "{{ URL::route('reglamentosD') }}"
    var d = [];
    d['v_reglamentos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_reglamentos) }}'));
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
</script>
<script src="{{ asset('js/reglamentos/reglamentosU.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection