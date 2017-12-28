@extends ('menu.plantilla_menu')
@section ('body')
<div id="container" class="box box-primary">
	<div id="divAlert1" class="row divAlert1" style="display:none;">
		<div class="popupunder alert alert-danger fade in">
			<button type="button" class="close close-sm" data-dismiss="alert"><i class="glyphicon glyphicon-remove"></i></button>
				<strong><span id="spanTittle"></span></strong>
				<span id="spanMsj"></span>
		</div>
	</div>
	<div  id="divAlert2" class="row divAlert2" style="display:none;">
		<div class="popupunder2 alert alert-danger fade in">
			<button type="button" class="close close-sm" data-dismiss="alert"><i class="glyphicon glyphicon-remove"></i></button>
				<strong><span id="spanTittle2"></span></strong>
				<span id="spanMsj2"></span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-5 divPerfil caja-foto-index">
		<center><h2><ins>Datos Personales</ins></h2></center>
			<div class="row">
				<div class="col-md-4">
	                @if ($var_icon = 'foto.jpeg') @endif
	                <img name="foto-perfil" id="foto-perfil" class="foto-perfil block-center img-thumbnail" width="150" height="150" alt="Image" src='{!! asset("img/$var_icon") !!}'>
	            </div>
				<div class="col-md-8">
					<span class="form-control" style="width:100%;height:35px;"><b>Perfil:</b>&nbsp;&nbsp;<span id="spanPerfil" style="width:100%;height:35px;text-align:center;">Desconocido</span></span>
					<br>
	            </div>
				<div class="col-md-8">
					<span class="form-control" style="width:100%;height:35px;"><u><b>Nombre:</b></u>&nbsp;&nbsp;<span id="spanNombre" style="width:100%;height:35px;text-align:center;">Desconocido</span></span>
					<br>
	            </div>
				<div class="col-md-8">
					<span class="form-control" style="width:100%;height:35px;"><u><b>RUT:</b></u>&nbsp;&nbsp;<span id="spanRut">Desconocido</span></span>
					<br>
	            </div>
	            <div class="col-md-12">
					<span class="form-control" style="width:100%;height:35px;"><u><b>Condominio:</b></u>&nbsp;&nbsp;<span id="spanCondominio">Desconocido</span></span>
	            </div>
			</div>
			<br>
		</div>
		<div class="col-md-7">
			@if ($id_nivel>1)
				<div id="divAlert" class="col-md-10">
					@if ($v_msj>0)
						<div  id="Alert" class="col-md-12 alert-danger">
							<center>
								<a href="{{ URL::route('cartelera')}}" style="width:1000px;color: #8A0808;">
									<b>Ud.tiene  @php echo $v_msj @endphp avisos sin leer.</b>
								</a>
							</center>
						</div>
					@endif
				</div>
				<div class="row" style="width:100%">
					<div id="" class="col-md-2 caja-foto-index"></div>
					<div class="col-md-10 divNoticias">
						<br><center><h2><ins>Publicidad</ins></h2></center>
						<div class="vticker" align="right">
						    <ul>
						        @foreach ($v_publicidad as $publicidad)
						                 <li>
							                @if (strlen($foto1)>3)
												<div class="divContenido" style="width:100%;height:200px;">
													<img name="foto1" id="foto1" width="100%" height="100%" alt="Image" src='{!! $publicidad->urlimage !!}'>
												</div>
											@else
												<div class="divContenido" style="width:100%;height:200px;">
													 <img name="foto1" id="foto1" width="100%" height="100%" alt="Image" src='{!! asset("/img/home_icon1.png") !!}'>
												</div>
										    @endif
						                 </li>
						                 <br>
						        @endforeach
						    </ul>
						</div>
					</div>
				</div>
			@endif
			@if ($id_nivel>2)
				<div id="divEncuesta" class="col-md-10">
					<div id="" class="col-md-2"></div>
					@php 	$v_encuestas @endphp
					@php $array = json_decode($v_encuestas); @endphp
					@if ($array[0]->count>0)
						<div  id="Encues" class="col-md-12">
							<center>
								<a href="{{ URL::route('encuestas')}}" style="width:1000px;color: #125f8a;">
									<b>Ud.tiene  @php echo $array[0]->count @endphp Encuestas sin leer.</b>
								</a>
							</center>
						</div><br>
					@endif
				</div>
			@endif
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-md-5 divCondominio">
			<center><h2><ins>Mi Condominio</ins></h2></center>
			<div class="row">
				<div class="col-md-12">
	 		        <div id='mySwipe' style="width:100%;height:290px;margin:0 auto;" class="swipe">
			        	<div class="swipe-wrap ">
						    @if (strlen($foto1)>3)
								<div class="div-instalaciones" style="width:100%;height:290px;">
									<img name="foto1" id="foto1" width="100%" height="100%" alt="Image" src='{!! asset("$foto1") !!}'>
								</div>
							@else
								<div class="div-instalaciones" style="width:100%;height:290px;">
									 <img name="foto1" id="foto1" width="100%" height="100%" alt="Image" src='{!! asset("/img/home_icon1.png") !!}'>
								</div>
						    @endif
						    @if (strlen($foto2)>3)
								<div class="div-instalaciones" style="width:100%;height:290px;">
									<img name="foto2" id="foto2" width="100%" height="100%" alt="Image" src='{!! asset("$foto2") !!}'>
								</div>
							@else
								<div class="div-instalaciones" style="width:100%;height:290px;">
									<img name="foto2" id="foto2" width="100%" height="100%" alt="Image" src='{!! asset("/img/home_icon1.png") !!}'>
								</div>
						    @endif
							@if (strlen($foto3)>3)
								<div class="div-instalaciones" style="width:100%;height:290px;">
									<img name="foto3" id="foto3" width="100%" height="100%" alt="Image" src='{!! asset("$foto3") !!}'>
								</div>
							@else
								<div class="div-instalaciones" style="width:100%;height:290px;">
									<img name="foto3" id="foto3" width="100%" height="100%" alt="Image" src='{!! asset("/img/home_icon1.png") !!}'>
								</div>
						    @endif
					    </div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-5"></div>
				<div class="col-md-5">
		 			<button class="btn btn-primary fa fa-arrow-left" onclick='mySwipe.prev()'></button>
				    <button class="btn btn-primary fa fa-arrow-right" onclick='mySwipe.next()'></button>
					<br><br>
				</div>
			</div>
		</div>
		<div class="col-md-7"></div>
	</div>
</div>
<br>
<script Language="Javascript">
    var d = [];
    d['name']= JSON.parse(rhtmlspecialchars('{{ json_encode($name) }}'));
    d['rut']= JSON.parse(rhtmlspecialchars('{{ json_encode($rut) }}'));
    d['urlimage']= JSON.parse(rhtmlspecialchars('{{ json_encode($urlimage) }}'));
    d['foto1']= JSON.parse(rhtmlspecialchars('{{ json_encode($foto1) }}'));
    d['foto2']= JSON.parse(rhtmlspecialchars('{{ json_encode($foto2) }}'));
    d['foto3']= JSON.parse(rhtmlspecialchars('{{ json_encode($foto3) }}'));
    d['condominio']= JSON.parse(rhtmlspecialchars('{{ json_encode($condominio) }}'));
    d['id_nivel']= rhtmlspecialchars('{{ $id_nivel }}');
    d['des_nivel']= rhtmlspecialchars('{{ $des_nivel }}');
    d['v_msj']= rhtmlspecialchars('{{ $v_msj }}');
    d['id_pantalla']= rhtmlspecialchars('{{ $id_pantalla }}');
    d['v_encuestas']= JSON.parse(rhtmlspecialchars('{{ $v_encuestas }}'));
    d['v_datos_incompletos']= JSON.parse(rhtmlspecialchars('{{ $v_datos_incompletos }}'));
</script>
<script src="{{ asset('js/menu/menu_home.min.js') }}"></script>
<script src="{{ asset('js/menu/menu_msj.min.js') }}"></script>
@endsection