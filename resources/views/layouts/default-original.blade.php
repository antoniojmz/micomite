<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>
			@if(Route::currentRouteNamed('home'))
				{{ $app_name_project }} | {{ $app_des_project }}
			@else
				{{ $title }} | {{ $app_name_project  }}
			@endif
		</title>
		<!-- Look and fell (Boostrap) -->
		<link rel="stylesheet" href="{{ asset('css/font-awesome-4.5.0/css/font-awesome.min.css') }}">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
		<link href="{{ asset('select24/select2.min.css') }}" rel="stylesheet">
		<link href="{{ asset('bootstrap3-dialog-master/dist/css/bootstrap-dialog.min.css') }}" rel="stylesheet">

		<!-- /Look and fell (Boostrap) -->
		<!-- ie happens -->
		    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		    <!--[if lt IE 9]>
		      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		    <![endif]-->
		<!-- /ie happens -->
	</head>
	<!-- JS Scripts -->
	    <script src="{{ asset('js/jquery.min.js') }}"></script>
	    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	    <script src="{{ asset('js/auth/util.min.js') }}"></script>
	    <script src="{{ asset('validator/valtexto.js') }}"></script>
	    <script src="{{ asset('js/toastr.min.js') }}"></script>
		<script src="{{ asset('select24/select2.min.js') }}"></script>
		<script src="{{ asset('bootstrap3-dialog-master/dist/js/bootstrap-dialog.min.js') }}"></script>
	<!-- /JS Scripts -->
	<body>
		<!-- Menu nav -->
		@if (Session::has('resultado'))
			<script Language="Javascript">
				var v_titulo 	= '{{ Session::get('resultado.titulo') }}';
				var v_mensaje 	= '{{ Session::get('resultado.mensaje') }}';
				var v_tipo 		= '{{ Session::get('resultado.tipo') }}';
				toastr.options = { "closeButton": true, "timeOut": "2000", "extendedTimeOut": "1500" };
				var a = "toastr."+v_tipo+"('" + v_mensaje + "','" + v_titulo + "');";
				eval(a);
			</script>
		@endif
		<!-- Menu nav -->
		<!-- Menu nav -->
			@include ('layouts/_navbar')
		<!-- /Menu nav -->
		<div class="content">
			<!-- alerts -->
				@include ('layouts/_alerts')
			<!-- /alerts -->
		@if (!Auth::guest())
			@if (!Auth::user()->preguntasecreta)
				<!-- Crear una nueva plantilla y redireccionar al blade -->
				<!-- {{ Redirect::route('actualizarps') }} -->
				<script type="text/javascript">
					// window.location="{{ URL::to('/cuenta/actualizar_pregunta_secreta') }}";
					// window.location="{{ URL::to('/cuenta/actualizar_pregunta_secreta') }}";
					window.location="{{route('actualizarps')}}";
				</script>
			@else
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			@endif
		@endif
		<!-- Body -->
		@if (View::hasSection('body'))
			<div class="content-body">
				@yield ('body')
			</div>
		@endif
		<!-- /Body -->
		</div>
	</body>
</html>