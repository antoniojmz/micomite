@extends ('menu.plantilla_menu')
@section ('body')
<div class="container" id="content">
        <center>
            <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2 id="spanTitulo" class="borderTitulo">Proveedores</h2>
                </div>
                <div class="col-md-4"></div>
            </div>
        </center>
        <br>

 <ul id="filters" class="clearfix">
   <?php
   $cadena = " <li id='liprincipal'><span id='inicio' class='filter active' data-filter='";
   $va = "";
   foreach ($v_categorias_activas as $ca) {
    $va .= ".".$ca->id.", ";
  }
  $va = substr($va, 0, -2);
  $cadena2 ="'></span></li>";
  echo $cadena."".$va."".$cadena2;
  ?>
  @foreach ($v_categorias_activas as $cat)
  <li><span class="filter" data-filter="{{ '.'.$cat->id }}">{{ $cat->text }}</span></li>
  @endforeach
</ul>
<div id="principal" >
     <img name="proveedores" id="foto-proveedores" width="65%" alt="Image" src='/img/imagen_proveedores.png'>
</div>
<div id="portfoliolist">
<br>
  @foreach ($v_proveedores as $prov)
  <div class="portfolio {{ $prov->id_categoria }}" data-cat="{{ $prov->id_categoria }}" >
    <div class="portfolio-wrapper" >
      <?php
      $var_icon = '/img/edificio.png';
      if (strlen($prov->urlimage)>3)
        $var_icon = $prov->urlimage;
      ?>
      <center>
        <div >
          <img name="foto-perfil" id="foto-perfil" class="foto-perfil block-center img-thumbnail"  alt="Image" src='{!! asset("$var_icon") !!}'>
        </div>
      </center>
      <div class="label">
        <div class="label-text">
          <a class="text-title">{{ $prov->nombres }}</a>
          <span class="text-category">
            <div class="row lead">
             <div class="star-rating">
              <?php
              $estrellas = $prov->votacion;
              for ($i = 0; $i < 5; $i++) {

                if($i < $estrellas){
                  echo "<a href='#'>&#9733;</a>";
                }else{
                  echo "<a href='#' style='color: #95a5a6;display: inline-block; font-size: 23px;' >&#9733;</a>";
                }
              }
              ?>
            </div>
          </div>
        </span>
      </div>
      <div class="label-bg"></div>
    </div>
    <div class="votacion">
      <br>
      <br>
      <br>
      <div class="col-md-3"></div>
      <div class="col-md-11">
        <button type="button" class="btn btn-primary" data-toggle="modal"  data-target="{{ '#myModal'.$prov->id_proveedor }}">Información</button>
        <button id="evaluaciones" value="{{$prov->id_proveedor}}" type="button" class="btn btn-success evaluaciones">Comentarios</button>
      </div>
    </div>
  </div>

</div>

<div id="{{ 'myModal'.$prov->id_proveedor }}" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h2 class="modal-title">{{ $prov->nombres }} </h2>
      </div>
      <div class="modal-body">
       <div class="row">
        <div class="col-md-2 col-lg-4 " align="center"> <img name="foto-perfil" id="foto-perfil" class="foto-perfil block-center img-thumbnail" alt="Image" src='{!! asset("$var_icon") !!}'> </div>
        <div class=" col-md-8">
          <table class="table table-user-information">
            <tbody>
              <tr>
                <td>Categoria:</td>
                <td>{{ $prov->des_categoria }} </td>
              </tr>
              <tr>
                <td>Dirección:</td>
                <td>{{ $prov->direccion }}</td>
              </tr>
              <tr>
                <td>Email</td>
                <td><a href="mailto:info@support.com">{{ $prov->email }}</a></td>
              </tr>
              <tr>
                <td>Teléfonos</td>
                <td>{{ $prov->telefono1 }}<br>
                  {{ $prov->telefono2 }}<br>
                  {{ $prov->movil }}
                </td>
              </tr>
              <tr>
                <td>Descripción:</td>
                <td>{{ $prov->descripcion }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div id="{{ 'myModal2'.$prov->id_proveedor }}" class="modal fade cerrar" tabindex="-1" role="dialog">
  {!! Form::open(['id'=>'FormVotacion',
  'autocomplete' => 'off'
  ]) !!}

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h2 class="modal-title">{{ $prov->nombres }} </h2>
        <input type="hidden" name="id_proveedor" class="id_proveedor"/>
      </div>
      <div class="modal-body">
       <div class="row">
        <div class="form-group">
          <div class="col-md-2"></div>
          <div class="col-md-2">
            {{ Form::label('null', 'Votación:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
          </div>
          <div class="col-md-6">
            <div id="stars" class="starrr"></div>
            <input type="hidden" name="estrellas" class="estrellas"/>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-md-2"></div>
          <div class="col-md-2">
            {{ Form::label('null', 'Comentarios:',array('style' => 'text-align:center;line-height:300%','class' => 'label-input','id' => '','align' => 'center'))}}
          </div>
          <div class="col-md-6">
            {!! Form::textarea('comentariost', '', [
            'id'            => 'comentariost',
            'class'         => 'form-control comentario',
            'placeholder'   => 'Ingrese sus comentarios de la empresa',
            'style'         => 'width:100%;height:100px',
            'maxlength'     => '980',
            'rows'          => '20',
            'cols'          => '80'
            ])!!}
            <input type="hidden" name="comentarios" class="comentarios"/>
          </div>
        </div>
      </div>
      <br>
      <br>
      <br>
      <div class="pull-rigth" align="center">
       {{ Form::button(' Volver',
       [ 'id'=> 'cancelar', 'type' => 'button','data-dismiss'=>'modal',
       'class' => 'btn btn-primary fa fa-times-circle'])
     }}

     {{ Form::button(' Guardar',
     [ 'id'=> 'guardarV', 'type' => 'button',
     'class' => 'btn btn-primary fa fa-check-circle'])
   }}
 </div>
</div>

</div>
</div>
{!! Form::close() !!}
</div>
@endforeach
</div>
</div>
<div id="myModalComentarios" class="easyui-window" title="Evaluaciones del Proveedor" data-options="modal:true,closed:true,closable:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="height:500px;width:900px;padding:20px;">
  <div><center><h3><ins><b><span id="tituloProveedor"></span></b></ins></h3></center></div>
  <div>
   <div class="modal-body">
    <div class="section">
    <div id="divComentarios" class="container">
    </div>
  </div>
</div>
</div>
<script Language="Javascript">
  var d = [];
  d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
  d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
  d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
  d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
  var rutaV = "{{ URL::route('proveedoresVotar') }}"
  var rutaC = "{{ URL::route('proveedoresC') }}"
</script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
<script src="{{ asset('js/simple-portfolio-page/js/jquery.mixitup.min.js') }}"></script>
<script src="{{ asset('js/proveedores/proveedoresU.min.js') }}"></script>
<link href="{{ asset('css/proveedores/proveedores.min.css') }}" rel="stylesheet">
@endsection
