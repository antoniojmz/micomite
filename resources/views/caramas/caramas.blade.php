@extends ('menu.plantilla_menu')
@section ('body')
<div id="content" class="box box-danger">
 	<h1 align="center">!Lo sentimos. Por ahora este módulo no esta en funcionamiento aún!</h1>
</div>
<script Language="Javascript">
    var d = []; 
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}'); 
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}'); 
    d['id_nivel']= rhtmlspecialchars('{{ $id_nivel }}');
</script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection
