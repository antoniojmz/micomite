<?php
use App\Exceptions\CustomException;
Route::group(['middleware' => ['web']], function () {
	Route::get('/', ['uses' => 'WebController@getHome', 'as' => 'home']);
	Route::get('recuperar', ['uses' => 'RecuperarController@getRecuperar', 'as' => 'recuperar']);
	Route::post('recuperar',['uses' => 'RecuperarController@postRecuperar', 'as' => 'recuperar']);
	Route::post('contacto',['uses' => 'RecuperarController@postContacto', 'as' => 'contacto']);
	Route::post('perfil',['uses' => 'RecuperarController@postPerfil', 'as' => 'perfil']);

	// try{
	Route::group(['namespace' => 'Auth', 'prefix' => 'auto_servicio'], function (){
		//Menu
		Route::get('menu', ['uses'  => 'AuthController@getMenu', 'as'    => 'menu']);

		// Cambio de acceso
		Route::get('elige_acceso', ['uses'  => 'AuthController@getCambioAcceso', 'as'    => 'cambioacceso']);
		Route::post('elige_acceso', ['uses'  => 'AuthController@postCambioAcceso', 'as'    => 'cambioacceso']);

		// Login
		Route::get('login', ['uses'  => 'AuthController@getLogin', 'as'    => 'login']);
		Route::post('login', ['uses'  => 'AuthController@postLogin', 'as'  => 'login']);

		// Buscar
		Route::get('buscar', ['uses'  => 'AuthController@getBuscar', 'as'    => 'buscar']);
		Route::post('buscar', ['uses'  => 'AuthController@postBuscar', 'as'  => 'buscar']);

		// Logout
		Route::get('logout',  ['uses' => 'AuthController@getLogout', 'as'  => 'logout']);
		Route::get('salir',  ['uses' => 'AuthController@getSalir', 'as'  => 'salir']);

	});

		/////////////////////////////////////////////////////////////////////////
	    /////////////////////////////////////////////////////////////////////////
	    ////OPCIONES DEL MENU IZQUIERDO
	    /////////////////////////////////////////////////////////////////////////
	    /////////////////////////////////////////////////////////////////////////

	//Administracion
	Route::group(['namespace' => 'Administracion', 'prefix' => 'auto_servicio'], function (){
		//////////////////////////////////Usuario////////////////////////////////
		Route::get('usuario', ['uses'  => 'UsuarioController@getUsuario', 'as'    => 'usuario']);
		Route::post('buscarusuario', ['uses'  => 'UsuarioController@postBuscarUsuariosPerfiles',
			'as' => 'buscarusuario']);
		Route::post('estatuusuario', ['uses'  => 'UsuarioController@postEstatusUsuario',
			'as' => 'estatuusuario']);
		Route::post('estatuusuarioperfil', ['uses'  => 'UsuarioController@postEstatusUsuarioPerfil',
			'as' => 'estatuusuarioperfil']);
		Route::post('actualizarplantilla', ['uses' => 'UsuarioController@postActualizarPlantilla', 'as' => 'actualizarplantilla']);
		Route::post('asignarperfil', ['uses' => 'UsuarioController@postAsignarPerfil', 'as' => 'asignarperfil']);
		Route::post('accesoavanzado', ['uses' => 'UsuarioController@postAccesoAvanzado', 'as' => 'accesoavanzado']);
		Route::post('agregaracceso', ['uses' => 'UsuarioController@postAgregarAcceso', 'as' => 'agregaracceso']);
		Route::post('eliminaracceso', ['uses' => 'UsuarioController@postEliminarAcceso', 'as' => 'eliminaracceso']);
		//////////////////////////////////Usuario////////////////////////////////

		//////////////////////////////////Modulos poderes////////////////////////////////
		Route::get('modulos_poderes',
				[	'uses'	=> 'ModulosPoderesController@getModulosPoderes',
					'as'	=> 'modulospoderes'	]);

        Route::post('modulos_poderes',
        	[	'uses'	=> 'ModulosPoderesController@postModulosPoderes',
        		'as'	=> 'modulospoderes'	]);

        Route::post('listar_modulos_poderes', ['uses'  => 'ModulosPoderesController@postListarModulosPoderes', 'as' => 'listarmodulospoderes']);
        Route::post('delete_modulos_poderes', ['uses'  => 'ModulosPoderesController@postDeleteModulosPoderes', 'as' => 'deletemodulospoderes']);
        Route::post('add_modulos_poderes', ['uses'  => 'ModulosPoderesController@postAddModulosPoderes', 'as' => 'addmodulospoderes']);
		//////////////////////////////////Modulos poderes////////////////////////////////

		//////////////////////////////////Plantilla perfil////////////////////////////////
        Route::get('plantilla_perfil',
        		[	'uses'	=> 'PlantillaPerfilController@getPlantillaNivel',
        			'as'	=> 'plantillanivel']);

		Route::post('plantilla_perfil',
				[	'uses'  => 'PlantillaPerfilController@postPlantillaNivel',
					'as'	=> 'plantillanivel']);

		Route::post('filtrarpoder',
				[	'uses'  => 'PlantillaPerfilController@postFiltrarPoder',
					'as' 	=> 'filtrarpoder']);

		Route::post('delete_plantilla_perfil',
				[	'uses'	=> 'PlantillaPerfilController@postDeletePlantillaPerfil',
					'as'	=> 'deleteplantillaperfil']);

        Route::post('add_plantilla_perfil',
        		[	'uses'	=> 'PlantillaPerfilController@postAddPlantillaPerfil',
        			'as'    => 'addplantillaperfil']);
		//////////////////////////////////Plantilla perfil////////////////////////////////
	});

	//////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////// FUNCIONABILIDAD DE SISTEMA DE COMITE //////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////
	Route::group(['namespace' => 'Comite', 'prefix' => 'comite'], function (){
		Route::get('registrou', ['uses' => 'RegistrouController@getRegistrou', 'as' => 'registrou']);
		Route::post('registrou', ['uses' => 'RegistrouController@postProcesaru', 'as' => 'registrou']);
		Route::post('registrouF', ['uses' => 'RegistrouController@postSubirfoto', 'as' => 'registrouF']);

		Route::get('clave', ['uses'  => 'ClaveController@getClave', 'as'    => 'clave']);
		Route::post('clave', ['uses' => 'ClaveController@postClave', 'as' => 'clave']);

		Route::get('mis_datos', ['uses'  => 'DatosController@getDatos', 'as'    => 'mis_datos']);
		Route::post('mis_datos', ['uses' => 'DatosController@postDatos', 'as' => 'mis_datos']);
		Route::post('mis_datosF', ['uses' => 'DatosController@postSubirfoto', 'as' => 'mis_datosF']);
		Route::post('mis_datosE', ['uses' => 'DatosController@postDelfoto', 'as' => 'mis_datosE']);
        Route::post('mis_datosC', ['uses' => 'DatosController@postDatosC', 'as' => 'mis_datosC']);

		Route::get('condominio', ['uses'  => 'CondominioController@getCondominio', 'as'    => 'condominio']);
		Route::post('condominio', ['uses' => 'CondominioController@postCondominio', 'as' => 'condominio']);
		Route::post('condominioF', ['uses' => 'CondominioController@postSubirfotoC', 'as' => 'condominioF']);
		Route::post('condominioE', ['uses' => 'CondominioController@postDelfotoC', 'as' => 'condominioE']);

		Route::get('instalaciones', ['uses'  => 'InstalacionesController@getInstalaciones', 'as'    => 'instalaciones']);
		Route::post('instalaciones', ['uses' => 'InstalacionesController@postInstalaciones', 'as' => 'instalaciones']);
		Route::post('instalacionesF', ['uses' => 'InstalacionesController@postSubirfotoI', 'as' => 'instalacionesF']);
		Route::post('instalacionesE', ['uses' => 'InstalacionesController@postDelfotoI', 'as' => 'instalacionesE']);

		Route::get('cartelera', ['uses'  => 'CarteleraController@getCartelera', 'as'    => 'cartelera']);
		Route::post('cartelera', ['uses' => 'CarteleraController@postCartelera', 'as' => 'cartelera']);
		Route::post('carteleraA', ['uses' => 'CarteleraController@postActcartelera', 'as' => 'carteleraA']);
		Route::get('carteleraM', ['uses' => 'CarteleraController@getMsjs', 'as' => 'carteleraM']);

		Route::get('reglamentos', ['uses'  => 'ReglamentosController@getReglamentos', 'as'    => 'reglamentos']);
		Route::post('reglamentos', ['uses' => 'ReglamentosController@postReglamentos', 'as' => 'reglamentos']);
		Route::post('reglamentosC', ['uses' => 'ReglamentosController@postSubirpdf', 'as' => 'reglamentosC']);
		Route::post('reglamentosE', ['uses' => 'ReglamentosController@postDelpdf', 'as' => 'reglamentosE']);
		Route::post('reglamentosD', ['uses'  => 'ReglamentosController@postDownload', 'as'    => 'reglamentosD']);

		Route::get('seguridad', ['uses'  => 'SeguridadController@getSeguridad', 'as'    => 'seguridad']);
		Route::post('seguridad', ['uses' => 'SeguridadController@postSeguridad', 'as' => 'seguridad']);
		Route::post('seguridadF', ['uses' => 'SeguridadController@postSubirfotoS', 'as' => 'seguridadF']);
		Route::post('seguridadE', ['uses' => 'SeguridadController@postDelfotoS', 'as' => 'seguridadE']);
		Route::post('seguridadC', ['uses' => 'SeguridadController@postConsultar', 'as' => 'seguridadC']);
		Route::post('seguridadT', ['uses' => 'SeguridadController@postTurnos', 'as' => 'seguridadT']);
		Route::post('seguridadVotar', ['uses' => 'SeguridadController@postVotar', 'as' => 'seguridadVotar']);
		Route::post('seguridadV', ['uses' => 'SeguridadController@postConsultaV', 'as' => 'seguridadV']);

		Route::get('proveedores', ['uses'  => 'ProveedoresController@getProveedores', 'as'    => 'proveedores']);
		Route::post('proveedores', ['uses' => 'ProveedoresController@postProveedores', 'as' => 'proveedores']);
		Route::post('proveedoresF', ['uses' => 'ProveedoresController@postSubirfotoP', 'as' => 'proveedoresF']);
		Route::post('proveedoresE', ['uses' => 'ProveedoresController@postDelfotoP', 'as' => 'proveedoresE']);
		Route::post('proveedoresVotar', ['uses' => 'ProveedoresController@postVotar', 'as' => 'proveedoresVotar']);
		Route::post('proveedoresC', ['uses' => 'ProveedoresController@postConsultaV', 'as' => 'proveedoresC']);

		Route::get('encuestas', ['uses'  => 'EncuestasController@getEncuesta', 'as'    => 'encuestas']);
		Route::post('encuestas', ['uses' => 'EncuestasController@postEncuesta', 'as' => 'encuestas']);
		// consultar opciones disponibles
		Route::post('encuestasO', ['uses' => 'EncuestasController@postEncuestaO', 'as' => 'encuestasO']);
		// agregar una nueva opcion de la encuesta
		Route::post('encuestasP', ['uses' => 'EncuestasController@postEncuestaP', 'as' => 'encuestasP']);
		// Eliminar un opcion de la encuesta
		Route::post('encuestasD', ['uses' => 'EncuestasController@postEncuestaD', 'as' => 'encuestasD']);
		// votar en la encuesta
		Route::post('encuestasE', ['uses' => 'EncuestasController@postEncuestaE', 'as' => 'encuestasE']);
		// ver Resultados en la encuesta
		Route::post('encuestasR', ['uses' => 'EncuestasController@postEncuestaR', 'as' => 'encuestasR']);

		Route::get('publicidad', ['uses'  => 'PublicidadController@getPublicidad', 'as'    => 'publicidad']);
		Route::post('publicidad', ['uses' => 'PublicidadController@postPublicidad', 'as' => 'publicidad']);
		Route::post('publicidadF', ['uses' => 'PublicidadController@postSubirfotoPu', 'as' => 'publicidadF']);
		Route::post('publicidadE', ['uses' => 'PublicidadController@postDelfotoPu', 'as' => 'publicidadE']);

		Route::get('comite', ['uses'  => 'ComiteController@getComite', 'as'    => 'comite']);
		Route::post('comite', ['uses' => 'ComiteController@postComite', 'as' => 'comite']);

		Route::get('apartamentos', ['uses'  => 'ApartamentosController@getApartamentos', 'as'    => 'apartamentos']);
		Route::post('apartamentos', ['uses' => 'ApartamentosController@postApartamentos', 'as' => 'apartamentos']);
		Route::post('apartamentosU', ['uses' => 'ApartamentosController@postUsuapartamentos', 'as' => 'apartamentosU']);
		Route::post('apartamentosD', ['uses' => 'ApartamentosController@postDelapartamentos', 'as' => 'apartamentosD']);

		Route::get('pagos', ['uses'  => 'PagosController@getPagos', 'as'    => 'pagos']);
		Route::post('pagos', ['uses' => 'PagosController@postPagos', 'as' => 'pagos']);

		Route::get('gastos_comunes', ['uses'  => 'GastosController@getGastos', 'as'    => 'gastos_comunes']);
		Route::post('gastos_comunes', ['uses' => 'GastosController@postGastos', 'as' => 'gastos_comunes']);
		Route::post('gastos_comunesB', ['uses' => 'GastosController@postBuscarc', 'as' => 'gastos_comunesB']);
		Route::post('gastos_comunesC', ['uses' => 'GastosController@postCatalogos', 'as' => 'gastos_comunesC']);
		Route::post('gastos_comunesA', ['uses' => 'GastosController@postPagosAptos', 'as' => 'gastos_comunesA']);
		Route::post('gastos_comunesPA', ['uses' => 'GastosController@postPagosAdicionales', 'as' => 'gastos_comunesPA']);
		Route::post('gastos_comunesPAB', ['uses' => 'GastosController@postPagosAdicionalesEliminar', 'as' => 'gastos_comunesPAB']);
		Route::post('gastos_comunesP', ['uses' => 'GastosController@postPagos', 'as' => 'gastos_comunesP']);
		Route::post('gastos_comunesPB', ['uses' => 'GastosController@postPagosEliminar', 'as' => 'gastos_comunesPB']);
		Route::post('gastos_comunesCM', ['uses' => 'GastosController@postCierreMes', 'as' => 'gastos_comunesCM']);
		Route::post('gastos_comunesCP', ['uses' => 'GastosController@postConfirmarP', 'as' => 'gastos_comunesCP']);
		Route::post('gastos_comunesRP', ['uses' => 'GastosController@postRechazarP', 'as' => 'gastos_comunesRP']);
		Route::post('gastos_comunesCGC', ['uses' => 'GastosController@postConsultaGastos', 'as' => 'gastos_comunesCGC']);

		Route::get('camaras', ['uses'  => 'CamarasController@getCamaras', 'as'    => 'camaras']);
		Route::post('camaras', ['uses' => 'CamarasController@postCamaras', 'as' => 'camaras']);

	});
});