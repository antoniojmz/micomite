@inject('perfil', 'App\Services\AuthSrv')
@extends ('layouts.plantilla_sin_menu2')
@section ('body')
<br><br><br><br>
<div class="container">
   {!! Form::open(['url' => URL::route('cambioacceso'),'autocomplete' => 'off', 'id' => 'cambioacceso']) !!}
   <h4>
      <p class="text-center">
         Bienvenido
         <span>
            {{ Auth::user()->name }}
         </span>
      </p>
   </h4>
   <div class="box box-info">
      
      <center>
        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 id="spanTitulo" class="borderTitulo">Lista de Accesos disponibles</h2>
            </div>
            <div class="col-md-2"></div>
        </div>
      </center>
      <div >
         <br>
         <table id="accesos" class="display" cellspacing="0" width="100%">
         </table>
      </div>
   </div>
   {!! Form::hidden('id_usuario_acceso', null,['id' => 'id_usuario_acceso'])!!}
   {!! Form::close() !!}
</div>
<script Language="Javascript">
   var obj = JSON.parse(rhtmlspecialchars('{{ json_encode($perfil->getUser()) }}'));
</script>
<script src="{{ asset('js/menu/eligeacceso.min.js') }}"></script>
@endsection