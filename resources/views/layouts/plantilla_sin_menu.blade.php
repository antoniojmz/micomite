<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"  content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="Sistema Virtual Inteligente para Administración de Condominios">

		<title>
			@if(Route::currentRouteNamed('home'))
				{{ $app_name_project }} | {{ $app_des_project }}
			@else
				{{ $title }} | {{ $app_name_project  }}
			@endif
		</title>
		<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('validator/formValidation.min.css') }}" rel="stylesheet"/>
    	<link href="{{ asset('waitMe-23.09.16/waitMe.min.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('css/banners.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
	</head>
	<!-- JS Scripts -->
	    <script src="{{ asset('js/jquery.min.js') }}"></script>
	    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('validator/valtexto.min.js') }}"></script>
	    <script src="{{ asset('validator/formValidation.min.js') }}"></script>
	    <script src="{{ asset('validator/fvbootstrap.min.js') }}"></script>
	    <script src="{{ asset('js/auth/util.min.js') }}"></script>
		<script src="{{ asset('bootstrap3-dialog-master/dist/js/bootstrap-dialog.min.js') }}"></script>
	    <script src="{{ asset('validator/es_ES.min.js') }}"></script>
		<script src="{{ asset('waitMe-23.09.16/waitMe.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('pace-master/pace.min.js') }}"></script>
		<script src="{{ asset('js/principal/jquery.immersive-slider.min.js') }}"></script>
	<!-- /JS Scripts -->
	<body>
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
		@include ('layouts._alerts')
		@include ('layouts.principal')
	</body>
</html>