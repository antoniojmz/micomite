@inject('reportes', 'App\Services\AuthSrv')
@extends ('menu.plantilla_menu')
@section ('body')
<center>
        <br>
        <div class="easyui-panel" title='{{ $title }}' style="width:50%;height:620px;
                padding:20px" data-options="tools:'#tt'">
        {!! Form::open(['url' => URL::route('aplicaciones'),'autocomplete' => 'off']) !!}
        <table id="reportes" class="display" cellspacing="0" width="100%">
        </table>
        <hr>
        {!! Form::hidden('id_reporte', null,['id' => 'id_reporte'])!!}
          <!-- Fecha -->
          @include ('consultas_reportes._fechareportes')
          <!-- /fecha -->
            <div class="pull-right">
              {{ Form::button('Aceptar',
                  [   'id'  => 'Aceptar',
                    'class' => ' btn btn-primary fa fa-search-plus',
                    'type'  => "submit"
                  ])
              }}
            </div>
         {!! Form::close() !!}
        </div>
    </center>
    <div id="tt">
        <a href="{{ URL::route('menu') }}" class="panel-tool-close"></a>
    </div>
    <script Language="Javascript">
      var obj = JSON.parse(rhtmlspecialchars('{{ json_encode($reportes->Reportes()) }}'));
    </script>
  <script src="{{ asset('js/menu/aplicaciones.js') }}"></script>
@endsection
