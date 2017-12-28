var RegistroSeguridad = RegistroTurnos='';
var combos=caso=0;
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var ManejoRespuestaProcesarT = function(respuesta){
    destruirTablaS('tablaTurnos');
    cargarTablaTurnos(respuesta.respuesta.v_turnos);
    crearcombo('#id_turno',respuesta.respuesta.v_turnos);
}
var ManejoRespuestaProcesar = function(respuesta){
    if (respuesta.code=='200'){
    	var res = JSON.parse(respuesta.respuesta.f_registro_seguridad[0].f_registro_seguridad);
    	switch(res.code) {
    	    case '200':
                mensajesAlerta('Procesado!',res.des_code, 'info');
                $(".caja-foto").show();
                destruirTablaS('tablaSeguridad');
                cargarTablaSeguridad(respuesta.respuesta.v_seguridad);
                $("#id_seguridad").val(res.id_seguridad);
    	        break;
    	    case '-2':
    	        mensajesAlerta('Error',res.des_code, 'error');
    	        break;
    	    default:
    	        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    	} 
    }else{
        mensajesAlerta('Error','Comuniquese con el personal de sopore técnico', 'error');
    }
}
var cargarTablaSeguridad = function(data){
    $("#tablaSeguridad").dataTable({
        "paging":   false,
        "searching": false,
        "info": false,
        "columnDefs": [
        {
            "targets": -1,
            "data": null,
            "targets": [ 1 ],
            "searchable": true,
        }
        ],
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "data": data,
        "columns":[
        {"title": "Id","data": "id_seguridad",visible:0},
        {"title": "RUT","data": "rut"},
        {"title": "Nombres","data": "nombres"},
        {"title": "Correo","data": "email"},
        {"title": "Dirección","data": "direccion"},
        {"title": "Teléfono","data": "telefonoresidencial"},
        {"title": "Movil","data": "movil"}
        ],
    });
};

var cargarTablaTurnos = function(data){
    $("#tablaTurnos").dataTable({
        "paging":   false,
        "searching": false,
        "info": false,
        "columnDefs": [
        {
            "targets": -1,
            "data": null,
            "targets": [ 1 ],
            "searchable": false,
        }
        ],
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "data": data,
        "columns":[
        {"title": "Id","data": "id",visible:0},
        {"title": "Turno","data": "text"}
        ],
    });
};
var crearallcombos = function(data){
    crearcombo('#id_turno',data.v_turnos);
    crearcombo('#id_dias',data.v_dias);
    crearcombo('#id_tipo_seguridad',data.v_tipo_seguridad);
}
var Boton_agregar = function(){
	$("#spanTitulo").text("Registro del personal de seguridad");
    $(".divForm").toggle();
    $(".caja-foto").hide();
    $("#id_seguridad").val("");
    $('#FormSeguridad')[0].reset();
    $(".comboclear").val('').trigger("change");
}
var Boton_cancelar = function(){
	$("#spanTitulo").text("Registro del personal de seguridad");
    $(".divForm").toggle();
    $(".caja-foto").hide();    
    $("#id_seguridad").val("");
    $('#FormSeguridad')[0].reset();
    $("#id_seguridad").val("");
    $(".comboclear").val('').trigger("change");
    $('.foto-perfil').attr('src','/img/foto.png')+ '?' + Math.random();
}
var MostrarTurnos = function(){
    $('#modalTurnos').window('open');
    $("#spanTituloEncuesta").text("Registro de turnos para el personal de seguridad");
}
var volverTurnos = function(){
    $('#modalTurnos').window('close');
}
var pintarDatosActualizar= function(data){
    $(".caja-foto").show();	
    $(".divForm").toggle();
    $("#spanTitulo").text("Actualización de datos");
    if (data.urlimage!=null){
        if (data.urlimage.length>4){
            $('.foto-perfil').attr('src',data.urlimage)+ '?' + Math.random();
            $("#image").val(data.urlimage);
        }
    }
    if(data.id_seguridad!=null){$("#id_seguridad").val(data.id_seguridad);}
    if(data.rut!=null){$("#rut").val(data.rut);}
    if(data.nombres!=null){$("#nombres").val(data.nombres);}
    if(data.email!=null){$("#email").val(data.email);}
    if(data.direccion!=null){$("#direccion").val(data.direccion);}
    if(data.name!=null){$("#name").val(data.name);}
    if(data.telefonoresidencial!=null){
        var res = data.telefonoresidencial.split("-");
        $("#paist").val(res[0]);
        $("#codigot").val(res[1]);
        $("#numerot").val(res[2]);
    }
    if(data.movil!=null){
        var res = data.movil.split("-");
        $("#paism").val(res[0]);
        $("#codigom").val(res[1]);
        $("#numerom").val(res[2]);
    }
    if(data.cargo!=null){$("#cargo").val(data.cargo);}
    if(data.sueldo!=null){$("#sueldo").val(data.sueldo);}
    if(data.id_turno!=null){$("#id_turno").val(data.id_turno).trigger("change");}
    if(data.dias_semana!=null){
    	var res = data.dias_semana.split(",");
    	$("#id_dias").val(res).trigger("change");
    }
    if(data.id_tipo_seguridad!=null){$("#id_tipo_seguridad").val(data.id_tipo_seguridad).trigger("change");}
    if(data.rut_empresa!=null){$("#rutE").val(data.rut_empresa);}
    if(data.id_empresa!=null){$("#id_empresa").val(data.id_empresa);}
    if(data.des_empresa!=null){$("#des_empresa").val(data.des_empresa);}
    if(!data.activo){
    	$("#activo").prop("checked",false);
    }else{
    	$("#activo").prop("checked",true);
    }
}
var ProcesarSeguridad = function(){
	var dia= $('#id_dias').val().toString(); 
    var dias = {'dias': dia}
    parametroAjax.data = $("#FormSeguridad").serialize() + '&' + $.param(dias);
    parametroAjax.ruta=ruta;
    respuesta=procesarajax(parametroAjax);
	ManejoRespuestaProcesar(respuesta);
};
var mostrarDependientes= function(data){
	switch (parseInt($("#id_tipo_seguridad").val())) {
		case 1:
			$('#divSegExterna').hide();
		break;
		case 2:
			$('#divSegExterna').show();
		break;
		default:
			$('#divSegExterna').hide();
		break;
	}
}

var cargarTurnos=function(){
    caso=1;
    var camposNuevo = {
        'caso': caso
    }
    parametroAjax.data = $("#FormTurno").serialize() + '&' + $.param(camposNuevo);
    parametroAjax.ruta=rutaT;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarT(respuesta);
};
var elimiarTurno=function(){
    caso = 2;
    var cod_tabla=RegistroTurnos.id;
    var id_sede=RegistroTurnos.id_sede;
    parametroAjax.data = {'id_sede': id_sede, 'cod_tabla':cod_tabla,'caso':caso};
    parametroAjax.ruta=rutaT;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesarT(respuesta);
};


var consultarResponsable=function(rutE){
    parametroAjax.data =  {rutE: rutE};
    parametroAjax.ruta = rutaC;
    parametroAjax.token = $("#_token").val();
    var respuesta = procesarajax(parametroAjax);
    if (respuesta.code=200){
	    if(!jQuery.isEmptyObject(respuesta.respuesta[0])){
	    	$('#id_empresa').val(respuesta.respuesta[0].user_id);
	    	$('#des_empresa').val(respuesta.respuesta[0].name);
	    }else{
    	    mensajesAlerta('Error','Empresa no encontrada, Por favor contacte al personal Informático', 'error');

	    }
    }
};
var eliminarFoto = function(){
        $.ajax({
            url: rutaE,
            headers: {'X-CSRF-TOKEN': $('#_token').val()},
            type:'POST',
             data: {'id_seguridad':$('#id_seguridad').val(), 'urlimage':$("#image").val()},
            async:false,
            dataType: 'JSON',
        })
        .done(function(d){
            // console.log(d);
            $('.foto-perfil').attr('src','/img/foto.png')+ '?' + Math.random();
            destruirTablaS('tablaSeguridad');
   			cargarTablaSeguridad(d);
        });
}
var actualizarFoto = function(){ 
    var formu=$(this);
    var nombreform=$(this).attr("id");
    if(nombreform=="FormSeguridad" ){ 
        var divresul="notificacion_resul_fci"
    }
        var form = $('#FormSeguridad').get(0); 
        var formData = new FormData(form);
        //hacemos la petición ajax  
        $.ajax({
            url: rutaF,  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //una vez finalizado correctamente
            success: function(data){
            	// console.log(data);    
				if (data=='-2'){
					alert("Debe agregar una foto");
				}else{
					$('.foto-perfil').attr('src',data.rutadelaimagen)+ '?' + Math.random();
					destruirTablaS('tablaSeguridad');
   					cargarTablaSeguridad(data.v_seguridad);
				}
            },
            //si ha ocurrido un error
            error: function(data){
               alert("ha ocurrido un error al cargar su foto");  
            },
        });
};
var validarS=function(){$('#FormSeguridad').formValidation('validate');};
$(document).ready(function(){
	$("#spanTitulo").text("Registro del personal de seguridad");
	$("#activo").prop("checked",true);
    $('#horaI').timepicki();
    $('#horaF').timepicki();
    cargarTablaSeguridad(d.v_seguridad);
    cargarTablaTurnos(d.v_turnos);
    crearallcombos(d);
    $("#id_tipo_seguridad").change(function(){
		mostrarDependientes(combos);
	});
	$('#rutE').focusout(function(){
        var rutE=$('#rutE').val();
        if (rutE.length>5){consultarResponsable(rutE);}
    });
    var tableB = $('#tablaSeguridad').dataTable();
    $('#tablaSeguridad tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroSeguridad = TablaTraerCampo('tablaSeguridad',this);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaSeguridad',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        pintarDatosActualizar(RegistroSeguridad);
                        break;
                }
            },
            items: {
                "1": {name: "Editar", icon: "edit"},
            }
        });
    });
    var tableC = $('#tablaTurnos').dataTable();
    $('#tablaTurnos tbody').on('click', 'tr', function (e) {
        tableC.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroTurnos = TablaTraerCampo('tablaTurnos',this);
    });
    tableC.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaTurnos',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        elimiarTurno(RegistroTurnos);
                        break;
                }
            },
            items: {
                "1": {name: "Eliminar", icon: "delete"},
            }
        });
    });
    $(document).on('click','#agregar',Boton_agregar);
    $(document).on('click','#cancelar',Boton_cancelar);
    $(document).on('click','#cargar',actualizarFoto);
    $(document).on('click','#eliminar',eliminarFoto);
    $(document).on('click','#guardar',validarS);
    $(document).on('click','#spanTurnos',MostrarTurnos);
    $(document).on('click','#cancelarT',volverTurnos);
    $(document).on('click','#cargarT',cargarTurnos);
// Clase moneda para formato de dinero
$('.moneda').priceFormat({
    prefix:'',
    centsSeparator:',',
    thousandsSeparator:'.'
});
     $('#FormSeguridad').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'rut': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'nombres': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'email': {
                    validators: {
                        emailAddress: {
                            message: 'Ingrese una dirección de correo valida'
                        }
                    }
                },
            'direccion': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'paism': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'codigom': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'numerom': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'cargo': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'sueldo': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'id_turno': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'id_dias': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'id_tipo_seguridad': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'rutE': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'des_empresa': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },                                                                               
        }
    })
	.on('success.form.fv', function(e){
	    ProcesarSeguridad();
	})
	.on('status.field.fv', function(e, data){
	    data.element.parents('.form-group').removeClass('has-success');
	});
});