@extends ('menu.plantilla_menu')
@section ('body')
 <div class="container box box-danger" id="content">
    <center>
        <div class="col-md-12">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h2 id="tituloPantalla" class="borderTitulo"></h2>
            </div>
            <div class="col-md-1"></div>
        </div>
    </center>
  <br><hr>
    <div class="row">
      @foreach ($v_instalaciones as $inst)
          <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="well well-sm">
                  <div class="row">
                      <div class="col-sm-6 col-md-4">
                          <?php
                              $var_icon = '/img/home-1.svg';
                              if (strlen($inst->foto1)>3)
                              $var_icon = $inst->foto1;
                          ?>
                          <div data-toggle="modal" data-target="{{ '#myModal'.$inst->id_instalacion }}">
                            <img name="foto-instalacion1" id="foto-instalacion1" class="block-center img-thumbnail caja-instalaciones" width="150" height="10" alt="Image" src='{!! asset("$var_icon") !!}'>
                          </div>
                      </div>
                      <div class="col-sm-6 col-md-8">
                          <h2><b>{{ $inst->des_sede }}</b></h2>
                          <h4><b><ins>{{ $inst->des_descripcion }}</ins></b></h4>
                          <h4><b>{{ $inst->descripcion }}</b></h4>   
                      </div>
                  </div>
              </div>
          </div>
          <div id="{{ 'myModal'.$inst->id_instalacion}}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">×</button>
                   <h2 class="modal-title">{{ $inst->des_descripcion }}</h2>
                </div>
                <div class="modal-body">
                      <img name="foto-instalacion1" id="foto-instalacion1" class="block-center" width="570px" height="380px" alt="Image" src='{!! asset("$var_icon") !!}'>
                      <hr>
                      {{ $inst->descripcion }}
                </div>
           </div>
          </div>
        </div>
        @endforeach
    </div>
</div>
<script Language="Javascript">
    var ruta = "{{ URL::route('instalaciones') }}"
    var d = []; 
    d['v_instalaciones']= JSON.parse(rhtmlspecialchars('{{ json_encode($v_instalaciones) }}'));
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
    d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
    $('#tituloPantalla').text('INSTALACIONES DEL ' + d.v_instalaciones[0].des_sede);
</script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection