<style type="text/css">
	.spanFooter {
		margin-bottom: 30px;
	}

</style>
<div id="content" class="row col-md-12">
	<div id="cuerpo" class="col-md-10">
		<div id="divInicio" class="contenido banner">
			@include ('layouts._banner_principal')
		</div>
		<div id="divLogin" class="col-md-4 col-md-offset-4 contenido" style="display:none;">
			<br><br><br>
			<div id="divLogins" class="divLogins box box-warning" style="height:500px;">
				@if (Session::get('max_request_attemps_exceeded'))
				{{ Lang::get('auth.login_max_attemps_exceeded') }}
				@else
				{!! Form::open(['url' => URL::route('login'),'autocomplete' => 'off']) !!}
				<div class="row">
					<div class="col-md-12">
						<center><strong><h3>Acceso a Clientes</h3></strong></center>
					</div>
				</div>

				<div class="col-md-12">
					<center>
						<img id="avatar" width="80px" height="80px" src="/img/avatar.png">
						<br><br>
					</center>
				</div>

				<div class="col-md-12">
					<div class="group">
						<input type="text" name="username" id="username" maxlength="50" class="responsive-input vtObs2" required>
						<span class="highlight"></span>
						<span class="bar"></span>
						<label>Email o RUT(XXXXXXX-X)</label>
					</div>
				</div>
				<div class="row">
					<div id="divNoexiste" style="display:none;" class="col-md-12 alert alert-danger alert-dismissible">
						<center><span id="spanNoexiste" class="col-md-12"></span></center><br>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						@include ('errors._form_with_error_alert')
					</div>
				</div>
				<div class="row">
					<div  class="col-md-12">
						<center>
							<button type="button" id="btnSiguiente" class="btn btn-primary">Siguiente</button>
						</center>
					</div>
				</div>
			</div>
			<div id="divPass" style="height:500px;display:none;" class="divLogins box box-info">
				<br><br>
				<div class="col-md-12">
					<center>
						<img id="avatar2" width="80px" height="80px" src="/img/avatar.png">
						<br><br>
					</center>
				</div>
				<div class="col-md-12">
					<center><span id="spanName"></span></center>
					<br><br><br>
				</div>
				<div class="col-md-12">
					<div class="group">
						<input type="password" class="responsive-input" name="password" id="password" maxlength="50" required>
						<span class="highlight"></span>
						<span class="bar"></span>
						<label>Contraseña</label>
					</div>
				</div>
				<div class="row"></div>
				<div class="row">
					<center>
						<span><a id="spanNosoy" href="#">
							<b><font color="0881C8" style="font-size:12px;"><u>
								<span id="nombre"></span>
							</u></font></b></a>
						</span><br>
					</center>
				</div>
				<div class="row">
					<center>
						<span><a href="{{ URL::route('recuperar') }}" target="_blank">
							<b><font color="0881C8" style="font-size:12px;"><u>Haz olvidado tu contraseña?</u></font></b></a>
						</span><br>
					</center>
				</div>
				<div class="row">
					<div class="col-md-12">
						@include ('errors._form_with_error_alert')
					</div>
				</div>
				<div class="row">
					<div  class="col-md-12">
						<center><br><button type="submit" class="btn btn-success">Ingresar</button></center>
					</div>
				</div>
			</div>

			{!! Form::close() !!}
			@endif
		</div>
		<div id="divEmpresa" class="contenido" style="display:none;">
			<br><br>
			<div class="box box-purple col-md-8 col-md-offset-2">
				<br>
				<div class="col-md-2">
					<img width="100" height="100" alt="Image" src='{!! asset("img/software.png") !!}'>
					<br><br>
				</div>
				<div class="col-md-10">
					<br>
					<b>Misión:</b> <br>
					Ser la empresa numero uno en sistemas de administración de condominios y edificios otorgando un 100%  de integridad, efectividad, seguridad y transparencia. en un sistema dedicado y enfocado directamente a mejorar la calidad de vida de cada una de nuestros clientes y así nuestra plataforma otorgarle la tranquilidad que tanto se merecen. <br>
				</div>
			</div>
			<div class="box box-purple col-md-8 col-md-offset-2">
				<br>
				<div class="col-md-2">
					<img width="100" height="100" alt="Image" src='{!! asset("img/tranquilidad.jpg") !!}'>
					<br><br>
				</div>
				<div class="col-md-10">
					<br>
					<b>Visión</b><br>
					Integrar a cada una de las personas que vivan en comunidad tanto de edificios y condominios a una nueva generación donde no existan mas estafas ,colusiones , poca trasparencia y nula seguridad dentro de sus condominios e edificios www.micomiteonline.cl brindara una calidad de vida nunca antes vista dentro de sus comunidades enfocandose directamente en los propietarios donde se tomara en cuenta sus opiniones donde dejaran de vivir dentro de un condominio autoritario y pasaran a ser un condominio donde cada opinion cuenta. <br>
				</div>
			</div>
		</div>
		<div id="divContacto" class="contenido" style="display:none;">
			{!! Form::open(['id'=>'FormContacto',
			'autocomplete' => 'off']) !!}
			<br><br><br>
			<div class="box box-warning col-md-8 col-md-offset-2">
				<br>
				<div class="row">
					<div class="col-md-12 col-md-offset-2">
						<div class="col-md-4">
							{!! Field::text('nameC',[
							'label' 		=> '',
							'placeholder'   => 'Nombre',
							'class'         => 'form-control vtObs2',
							'maxlength'		=> Config::get('user.email_max_length'),
							'style'         => 'width:100%;height:35px',
							'autofocus' => 'autofocus'
							])
							!!}
						</div>
						<div class="col-md-4">
							{!! Field::email('emailC',[
							'label' 		=> '',
							'placeholder'   => 'Email',
							'class'         => 'form-control vtObs2',
							'maxlength'		=> Config::get('user.email_max_length'),
							'style'         => 'width:100%;height:35px',
							'autofocus' => 'autofocus'
							])
							!!}
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12 col-md-offset-2">
						<div class="col-md-8">
							<div class="form-group">
								<textarea id="mensaje" rows="10" class="responsive-input vtObs2 input" name="mensaje" placeholder="Comentarios"></textarea>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12 col-md-offset-4">
						<input id="btnSend" type="button" class="btn btn-success" value="Enviar comentario" />
					</div>
				</div>
				<br>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div id="sidebar-collapse" class="sidebar col-md-2">
		<div id="logo" class="logo"></div>
		<ul class="nav col-lg-12">
			<li id="btnInicio" class="active">
				<a href="#"><span class="glyphicon glyphicon-home"></span>Inicio</a>
			</li>
			<li id="btnLogin">
				<a href="#"><span class="glyphicon glyphicon-user"></span>Ingreso de Usuarios</a>
			</li>
			<li id="btnEmpresa">
				<a href="#"><span class="glyphicon glyphicon-th"></span>Sobre Nosotros</a>
			</li>
			<li id="btnContacto">
				<a href="#"><span class="glyphicon glyphicon-envelope"></span>Contáctanos</a>
			</li>
		</ul>
		<center>
			<div class="divFooter logo">
				<span id="spanFooter" class="spanFooter" style="text-align:center;"> <strong>Información</strong><br> micomiteonline@gmail.com <br> +(569) 3192 07 11</span><br>
				<span id="spanFooter" class="spanFooter" style="text-align:center;">&copy;MiComiteOnline.cl</span><br><br><br>
			</div>
		</center>
	</div>
</div>
<script Language="Javascript">
	var ruta = "{{ URL::route('contacto') }}"
	var rutaL = "{{ URL::route('perfil') }}"
</script>
<script src="{{ asset('js/principal/principal.min.js') }}"></script>