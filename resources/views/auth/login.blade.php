@extends ('layouts.plantilla_sin_menu')
@section ('body')
<div style="padding-top:60px;"></div>	
<div class="content-login"><br><br><br><br>
	<div class="col-md-12">
		 <ul id="carousel">
		  <li><img width="800" height="338" alt="" src="/images/CD01.jpg" /></li>
		  <li><img width="800" height="338" alt="" src="/images/CD03.jpg" /></li>
		</ul> 
	</div>

	<div class="col-md-12">
		<br /><br/>
		<div class="col-md-4">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
		</div>
		<div class="col-md-4">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
		</div>
		<div class="col-md-4">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
		</div>
	</div>
</div>
<div class="col-md-12 borde-login">
	@if (Session::get('max_request_attemps_exceeded'))
		{{ Lang::get('auth.login_max_attemps_exceeded') }}
	@else
		{!! Form::open(['url' => URL::route('login'),'autocomplete' => 'off']) !!}
		<br><br><br><br>
		<center>
			<div class="icons"></div>
		</center>
		<br>
		<div class="col-md-12">
			<center><strong>Acceso a Clientes</strong></center>
		</div>
		<br><br>
		<div class="col-md-12">
			<strong>Email o RUT(XXXXXXX-X)</strong>
		</div>
		<div class="col-md-12">
			{!! Field::text('username',[
				'label' 		=> '',
				'placeholder'   => 'Ingrese su email o RUT',
				'class'         => 'form-control vtObs2',
				'maxlength'		=> Config::get('user.email_max_length'),
				'style'         => 'width:100%;height:35px',
				'autofocus' => 'autofocus',
				])
			!!}
		</div>
		<br /><br /><br /><br /><br />
		<div class="col-md-12">
			<strong>Contraseña</strong>
		</div>
		<div class="col-md-12">
			{!! Field::password('password',[
					'label' 		=> '',
					'placeholder'   => 'Ingrese su contraseña',
					'maxlength'		=> Config::get('user.password_max_length'),
					'style'         => 'width:100%;height:35px',
					])
			!!}
		</div>
		<div class="col-md-12">
				<center><button type="submit" class="btn btn-success">Ingresar</button></center>
		</div>	
		<hr><br/><br/><br/><br/><br/>
		<div class="p-lg text-center">
            <span style="font-size:12px;font-weigth:bold;font-family:helvetica">
            	<span>&copy;</span>
            	<span ng-bind="app.year"></span>
            	<span>-</span>
             	<span>2017 - <a href="https://www.strattonhouse.cl/"><b><font color="0881C8"><u>Mi Comite</u></font></b></a></span>
          	</span>
      	</div>
      	@include ('errors._form_with_error_alert')
        {!! Form::close() !!}
  	@endif
</div>	
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/infinitecarousel/jquery.infinitecarousel3.min.js') }}"></script>
<script src="{{ asset('js/login/login.min.js') }}"></script>
@endsection