<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"  content="width=device-width, initial-scale=1, maximum-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>
			@if(Route::currentRouteNamed('home'))
				{{ $app_name_project }} | {{ $app_des_project }}
			@else
				{{ $title }} | {{ $app_name_project  }}
			@endif
		</title>
		<!-- Look and fell (Boostrap) -->
		<!-- <link rel="stylesheet" href="{{ asset('css/font-awesome-4.5.0/css/font-awesome.min.css') }}"> -->
		<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
		<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">


		<link href="{{ asset('select24/dist/css/select2.min.css') }}" rel="stylesheet">


		<link href="{{ asset('bootstrap3-dialog-master/dist/css/bootstrap-dialog.min.css') }}" rel="stylesheet">

		<link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
		<link href="{{ asset('DataTables-1.10.10/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
		<link href="{{ asset('eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
	</head>
	<!-- JS Scripts -->
	    <script src="{{ asset('js/jquery.min.js') }}"></script>
	    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	    <script src="{{ asset('js/auth/util.min.js') }}"></script>
	    <script src="{{ asset('validator/valtexto.min.js') }}"></script>
	    <script src="{{ asset('js/toastr.min.js') }}"></script>


		<script src="{{ asset('select24/dist/js/select2.full.min.js') }}"></script>
		<script src="{{ asset('select24/dist/js/i18n/es.js') }}"></script>

		<script src="{{ asset('bootstrap3-dialog-master/dist/js/bootstrap-dialog.min.js') }}"></script>

		<script src="{{ asset('DataTables-1.10.10/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('eonasdan-bootstrap-datetimepicker/node_modules/moment/moment.min.js') }}"></script>
        <script src="{{ asset('eonasdan-bootstrap-datetimepicker/node_modules/moment/locale/es.js') }}"></script>
	    <script src="{{ asset('eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

	    <link rel="stylesheet" type="text/css" href="/vendor/jquery-easyui/themes/gray/easyui.css">
    <link rel="stylesheet" type="text/css" href="/vendor/jquery-easyui/themes/icon.css">
	<script type="text/javascript" src="/vendor/jquery-easyui/jquery.easyui.min.js"></script>

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
		<div   class="easyui-layout" style="width:100%;height:700px;">
			        <div region="north" split="false" closable="false" title="">
			        <header style="background-image: linear-gradient(to bottom, rgb(47, 145, 230) 0px, rgb(23, 129, 221) 100%);border-bottom: 5px solid #EEE;height:60px;background-image: linear-gradient(to bottom, rgb(70, 101, 173) 0px, rgb(44, 79, 156) 100%);border-bottom: 5px solid rgb(238, 238, 238);height:60px;padding-top:2px;">
							<table width="100%" border="0">
								<tr>
									<td width="85%">
			        					&nbsp;&nbsp;&nbsp;<a href="#"  data-options="iconCls:'icon-large-logo1', plain:true,size:'large'"  class="easyui-linkbutton">&nbsp;<span style="font-size:14px;color:#fff;"><b>Sistema Integral de Recursos Humanos</b></span></a>
									</td>
									<td>hoooola</td>



						
										
										</tr>
										</table>

			        </header>

			        </div>

			<!-- <div region="north" split="false" closable="false" title="">
			        <header style="background-image: linear-gradient(to bottom, rgb(241, 243, 248) 0px, rgb(241, 243, 246) 100%);border-bottom: 5px solid #EEE;height:60px;padding-top:10px;">


			        <div class="collapse navbar-collapse" id="nav-main">
			        	@if (!Auth::guest())
							<ul class="nav navbar-nav navbar-right">
								<li>

								<a href="{{ URL::route('salir') }}"  data-options="iconCls:'icon-small-salir',toggle:true"   class="easyui-linkbutton">Salir</a>
								</li>
							</ul>
						@endif
			        </div>
            </div> -->
        	<div class="ui-layout-center">
        	     @yield('body')
        	</div>
	</body>
</html>