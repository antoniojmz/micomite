@extends ('menu.plantilla_menu')
@section ('body')
<div class="container box box-danger" id="content">
        <center>
            <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2 id="spanTitulo" class="borderTitulo">Integrantes de Seguridad</h2>
                </div>
                <div class="col-md-4"></div>
            </div>
        </center>
        <br>
    <div class="row">
    @foreach ($v_seguridad as $seg)
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-5">
                        <?php
                            $var_icon = '/img/foto.jpeg';
                            if (strlen($seg->urlimage)>3)
                            $var_icon = $seg->urlimage;
                        ?>
                        <div><center>
                            <img name="foto-perfil" id="foto-perfil" class="foto-perfil block-center img-thumbnail" width="120" height="120" alt="Image" src='{!! asset("$var_icon") !!}'> 
                             <div class="row lead">
                                  <div class="star-rating">
                                      <?php
                                      $estrellas = $seg->votacion;
                                      for ($i = 0; $i < 5; $i++) {

                                        if($i < $estrellas){
                                          echo "<a href='#'>&#9733;</a>";
                                        }else{
                                          echo "<a href='#' style='color: #95a5a6;display: inline-block; font-size: 23px;' >&#9733;</a>";
                                        }
                                      }
                                      ?>
                                    </div>
                            </div></center>
                        </div>

                    </div>
                    <div class="col-md-7 descripcion">
                        <b>{{ $seg->nombres }}</b></br>
                        <cite title="Cargo"> <small><i class="glyphicon glyphicon-user">
                            </i>&nbsp;&nbsp;{{ $seg->cargo }}</small></cite>
                        <p>
                          <i class="glyphicon glyphicon-time"></i>
                          {{ $seg->des_turno }} <br/>
                          <i class="glyphicon glyphicon-calendar"></i>
                            <?php
                              $resultado = str_replace("1", "Lunes", $seg->dias_semana);
                               $resultado = str_replace("2", "Martes", $resultado);
                               $resultado = str_replace("3", "Miercoles", $resultado);
                               $resultado = str_replace("4", "Jueves", $resultado);
                               $resultado = str_replace("5", "Viernes", $resultado);
                               $resultado = str_replace("6", "Sabado", $resultado);
                               $resultado = str_replace("7", "Domingo", $resultado);
                              echo $resultado;
                            ?><br/>
                            <i class="glyphicon glyphicon-envelope"></i>
                               {{ $seg->email }}
                            <br/>
                            <i class="glyphicon glyphicon-phone-alt"></i>
                            Teléfonos:{{ $seg->telefonoresidencial }}<br/>
                            <i class="glyphicon glyphicon-earphone"></i>
                            {{ $seg->movil }}<br/>
                        </p>
                        <!-- Split button -->
                        <div class="votacion"><br>
                          <div class="col-md-3"></div>
                          <div class="col-md-11">
                            <button id="evaluar" value="{{$seg->id_seguridad}}" data-toggle="modal"  data-target="{{ '#myModal'.$seg->id_seguridad }}" type="button" class="btn btn-success parametro">Evaluar</button>
                            <button id="evaluaciones" value="{{$seg->id_seguridad}}" type="button" class="btn btn-info evaluaciones">Comentarios</button>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


       <div id="{{ 'myModal'.$seg->id_seguridad }}" class="modal fade cerrar" tabindex="-1" role="dialog">
              {!! Form::open(['id'=>'FormVotacion',
              'autocomplete' => 'off'
              ]) !!}

                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                         <h2 class="modal-title">{{ $seg->nombres }} </h2>
                         <input type="hidden" name="id_seguridad" class="id_seguridad"/>
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
                                      'placeholder'   => 'Ingrese sus comentarios',
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
<div id="myModalComentarios" class="easyui-window" title="Consulta de Evaluaciones" data-options="modal:true,closed:true,closable:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,top:85" style="height:500px;width:900px;padding:20px;">
  <div><center><h3><ins><b><span id="tituloSeguridad"></span></b></ins></h3></center></div>
  <div>
   <div class="modal-body">
    <div class="section">
    <div id="divComentarios" class="container col-md-12">
    </div>
  </div>
</div>
</div>
<script Language="Javascript">
var d = [];
d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
d['id_nivel'] = rhtmlspecialchars('{{ $id_nivel }}');
var rutaV = "{{ URL::route('seguridadVotar') }}"
var rutaC = "{{ URL::route('seguridadV') }}"
</script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
<script src="{{ asset('js/seguridad/seguridadU.min.js') }}"></script>
<link href="{{ asset('css/seguridad/seguridad.min.css') }}" rel="stylesheet">
@endsection