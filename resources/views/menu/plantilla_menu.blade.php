@inject('perfil', 'App\Services\AuthSrv')
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"  content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="Sistema Virtual Inteligente para Administración de Condominios">
		<title>
			@if(Route::currentRouteNamed('menu'))
				{{ $app_name_project }} | {{ $app_des_project }}
			@else
				{{ $title }} | {{ $app_name_project }}
			@endif
		</title>
		<!-- CSS -->
		<link rel="stylesheet" href="{{ asset('css/font-awesome-4.5.0/css/font-awesome.min.css') }}"/>
		<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet"/>
		<link href="{{ asset('select24/dist/css/select2.min.css') }}" rel="stylesheet"/>
		<!-- pendiente context menu -->
		<link href="{{asset('jQuery-contextMenu-master/dist/jquery.contextMenu.min.css')}}" rel="stylesheet"/>
		<link href="{{ asset('css/menu/menu.min.css') }}" rel="stylesheet" id="css_menu"/>
		<link href="{{ asset('validator/formValidation.min.css') }}" rel="stylesheet"/>
		<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
		<link href="{{ asset('TimePicki-master/css/timepicki.min.css') }}" rel="stylesheet"/>
		<link href="{{ asset('DataTables-1.10.10/media/css/jquery.dataTables.min.css') }}" rel="stylesheet"/>
		<link href="{{ asset('eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"/>
		<!-- daterange picker -->
    	<link href="{{ asset('daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
    	<link href="{{ asset('waitMe-23.09.16/waitMe.min.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('css/login/login.min.css') }}" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="/vendor/jquery-easyui/themes/gray/easyui.min.css"/>
	    <link rel="stylesheet" type="text/css" href="/vendor/jquery-easyui/themes/icon.min.css"/>
	   		<!-- Swipe Carrusel de imagenes -->
	    <link rel="stylesheet" type="text/css" href="/swipe/swipe.min.css"/>


		<!-- JS Scripts -->
	    <script src="{{ asset('js/jquery.min.js') }}"></script>
	    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	    <script src="{{ asset('validator/valtexto.min.js') }}"></script>
	    <script src="{{ asset('validator/formValidation.min.js') }}"></script>
	    <script src="{{ asset('validator/fvbootstrap.min.js') }}"></script>
	    <script src="{{ asset('validator/es_ES.min.js') }}"></script>
	    <script src="{{ asset('js/toastr.min.js') }}"></script>
		<script src="{{ asset('select24/dist/js/select2.full.min.js') }}"></script>
		<script src="{{ asset('select24/dist/js/i18n/es.min.js') }}"></script>
	    <script src="{{ asset('jQuery-contextMenu-master/dist/jquery.contextMenu.min.js') }}"></script>
        <script src="{{ asset('js/menu/funciones_plantilla.min.js') }}"></script>
        <script src="{{ asset('js/menu/jquery.fullscreen.min.js') }}"></script>
		<script src="{{ asset('TimePicki-master/js/timepicki.min.js') }}"></script>
		<script src="{{ asset('DataTables-1.10.10/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('eonasdan-bootstrap-datetimepicker/node_modules/moment/moment.min.js') }}"></script>
        <script src="{{ asset('eonasdan-bootstrap-datetimepicker/node_modules/moment/locale/es.min.js') }}"></script>
	    <script src="{{ asset('eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	    <script src="{{ asset('js/auth/util.min.js') }}"></script>
	    <!-- date-range-picker -->
		<script src="{{ asset('/daterangepicker/moment.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('/daterangepicker/moment-with-locales.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
		<script src="{{ asset('waitMe-23.09.16/waitMe.min.js') }}" type="text/javascript"></script>
		<!-- formato de moneda viejo -->
		<script src="{{ asset('Jquery-Price-Format/jquery.priceformat.min.js') }}"></script>
		<!-- jquery easy-ui -->
		<script type="text/javascript" src="/vendor/jquery-easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="/vendor/jquery-easyui/locale/easyui-lang-es.min.js"></script>
		<!-- Swipe Carrusel de imagenes -->
		<script type="text/javascript" src="/swipe/swipe.min.js"></script>
		<!-- amcharts Graficos -->
<!-- 		<script type="text/javascript" src="/vendor/amcharts/amcharts/amcharts.min.js"></script>
		<script type="text/javascript" src="/vendor/amcharts/amcharts/serial.min.js"></script>
		<script type="text/javascript" src="/vendor/amcharts/amcharts/themes/light.js"></script> -->
		<script src="{{ asset('jquery-easy-ticker-master/jquery.easy-ticker.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('jquery-easy-ticker-master/test/jquery.easing.min.js') }}" type="text/javascript"></script>
		<!-- barra superior de carga -->
		<script src="{{ asset('pace-master/pace.min.js') }}"></script>
		<!-- nuevo formato de moneda -->
		<script src="{{ asset('autoNumeric/autoNumeric.min.js') }}"></script>
		<!-- index para correr el waitme -->
		<script type="text/javascript" src="/js/index/index.min.js"></script>
	</head>
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
    	<div  id="panelPrincipal" class="easyui-layout" style="width:100%;height:100%;border:0px;">
	        <div region="north" split="false" closable="false" title="" style="border:0px;">
	        	<header style="border:0px;background-image: linear-gradient(to bottom, rgb(8,129,200) 100%, rgb(8,129,200) 0px, rgb(142, 140, 140) 100%);border-bottom: 5px solid rgb(243, 237, 235);height:60px;padding-top:1px;">
					<table class="tindex" width="100%" border="0">
						<tr>
							<td class="tdinv" width="70%">
	        					&nbsp;&nbsp;&nbsp;<a href="#"  data-options="iconCls:'icon-large-logo1', plain:true,size:'large'"  class="easyui-linkbutton">&nbsp;<span style="font-size:14px;color:#fff;"><b>Mi comité online</b></span></a>
							</td>
							<td class="tdinv" align="right" width="30%">
					                <a href="{{ URL::route('clave') }}"  data-options="iconCls:'icon-reload',toggle:true"  class="easyui-linkbutton">
						               <span class="spanTop">Cambiar clave</span>
					                </a>
					        </td>
					        <td>&nbsp;</td>
								@if ($perfil->NroAccesos() > 1)
					        <td align="right">
					                <a href="{{ URL::route('cambioacceso') }}"  data-options="iconCls:'icon-large-accesos',toggle:true"  class="easyui-linkbutton">
					               		<span class="spanTop">Accesos</span>
					                </a>
					        </td>
					        <td>&nbsp;</td>
					            @endif
					        <td align="right">
								 <a href="javascript:void(0)" onclick="toggleFullScreen()" data-options="iconCls:'icon-small-maximizar',toggle:true"   class="easyui-linkbutton">
					               	<span class="spanTop">Maximizar</span>
								 </a>
							</td>
							<td>&nbsp;</td>
							<td align="right">
								<a href="{{ URL::route('salir') }}"  data-options="iconCls:'icon-small-salir',toggle:true"   class="easyui-linkbutton">
					               	<span class="spanTop">Salir</span>
								</a>
							</td>
						</tr>
					</table>
	        	</header>
	    	</div>
	        <div id="panel_left" class="DivMenu" align="left" data-options="region:'west',split:true,hideCollapsedContent:false,collapsible:true,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 150,
                collapsedContent: function(){
                    return $('#titlebar');
                }"  title="MENÚ">
			        @include('menu._menu_izq')
	        </div>
	        <div id="container" region="center" title="" class="col-md-12" style="padding:0px;border:0px;width:80%;">
	         	@yield('body')
	        </div>
		</div>
	</body>
</html>