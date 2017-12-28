var RegistroPublicidad = '';
var combos=caso=0;
var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var ManejoRespuestaProcesar = function(respuesta){
    if (respuesta.code=='200'){
    	var res = JSON.parse(respuesta.respuesta.f_registro_publicidad[0].f_registro_publicidad);
    	switch(res.code){
    	    case '200':
                mensajesAlerta('Procesado!',res.des_code, 'info');
                $(".caja-foto").show();
                destruirTablaS('tablaPublicidad');
                cargarTablaPublicidad(respuesta.respuesta.v_publicidad);
                $("#id_publicidad").val(res.id_publicidad);
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
var cargarTablaPublicidad = function(data){
    $("#tablaPublicidad").dataTable({
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
        {"title": "Id","data": "id_publicidad",visible:0},
        {"title": "RUT","data": "rut"},
        {"title": "Nombres","data": "nombres"},
        {"title": "Correo","data": "email"},
        {"title": "Dirección","data": "direccion"},
        {"title": "Teléfono","data": "telefono"},
        {"title": "Movil","data": "movil"},
        {"title": "Comunas","data": "comunas"},

        ],
    });
};

var Boton_agregar = function(){
	$("#spanTitulo").text("Registro de publicidad");
    $("#activo").prop("checked",true);
    $(".divForm").toggle();
    $(".caja-foto").hide();
    $("#id_publicidad").val("");
    $('#FormPublicidad')[0].reset();
    $(".comboclear").val('').trigger("change");
}
var Boton_cancelar = function(){
    $("#spanTitulo").text("Publicidad y promociones");
    $(".divForm").toggle();
    $(".caja-foto").hide();    
    $("#id_publicidad").val("");
    $('#FormPublicidad')[0].reset();
    $("#id_publicidad").val("");
    $(".comboclear").val('').trigger("change");
    $('#foto-publicidad').attr('src','/img/banner_default_blue.png')+ '?' + Math.random();
}
var pintarDatosActualizar= function(data){
    $(".caja-foto").show();	
    $(".divForm").toggle();
    $("#spanTitulo").text("Actualización de datos");
    if (data.urlimage!=null){
        if (data.urlimage.length>4){
            $('#foto-publicidad').attr('src',data.urlimage)+ '?' + Math.random();
            $("#image").val(data.urlimage);
        }
    }
    if(data.id_publicidad!=null){$("#id_publicidad").val(data.id_publicidad);}
    if(data.rut!=null){$("#rut").val(data.rut);}
    if(data.nombres!=null){$("#nombres").val(data.nombres);}
    if(data.email!=null){$("#email").val(data.email);}
    if(data.direccion!=null){$("#direccion").val(data.direccion);}
    if(data.name!=null){$("#name").val(data.name);}
    if(data.telefono!=null){
        var res = data.telefono.split("-");
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
    if(data.id_comunas!=null){
        var res = data.id_comunas.split(",");
        $("#id_comunas").val(res).trigger("change");
    }
    if(data.descripcion!=null){$("#descripcion").val(data.descripcion);}
    if(!data.activo){
    	$("#activo").prop("checked",false);
    }else{
    	$("#activo").prop("checked",true);
    }
}
var ProcesarPublicidad = function(){
    var comunas= $('#id_comunas').val().toString(); 
    var comunas = {'comunas': comunas}
    parametroAjax.data = $("#FormPublicidad").serialize() + '&' + $.param(comunas);
    parametroAjax.ruta=ruta;
    respuesta=procesarajax(parametroAjax);
	ManejoRespuestaProcesar(respuesta);
};

var eliminarFoto = function(){
        $.ajax({
            url: rutaE,
            headers: {'X-CSRF-TOKEN': $('#_token').val()},
            type:'POST',
             data: {'id_publicidad':$('#id_publicidad').val(), 'urlimage':$("#image").val()},
            async:false,
            dataType: 'JSON',
        })
        .done(function(d){
            // console.log(d);
            $('#foto-publicidad').attr('src','/img/banner_default_blue.png')+ '?' + Math.random();
            destruirTablaS('tablaPublicidad');
   			cargarTablaPublicidad(d);
        });
}
var actualizarFoto = function(){ 
    var formu=$(this);
    var nombreform=$(this).attr("id");
    if(nombreform=="FormPublicidad" ){ 
        var divresul="notificacion_resul_fci"
    }
        var form = $('#FormPublicidad').get(0); 
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
					$('#foto-publicidad').attr('src',data.rutadelaimagen)+ '?' + Math.random();
					destruirTablaS('tablaPublicidad');
   					cargarTablaPublicidad(data.v_publicidad);
				}
            },
            //si ha ocurrido un error
            error: function(data){
               alert("ha ocurrido un error al cargar su foto");  
            },
        });
};
var validarP=function(){$('#FormPublicidad').formValidation('validate');};
$(document).ready(function(){
    crearcombo('#id_comunas','');
	$("#spanTitulo").text("Publicidad y promociones");
	$("#activo").prop("checked",true);
    cargarTablaPublicidad(d.v_publicidad);
    
    $("#checkbox").click(function(){
        if($("#checkbox").is(':checked') ){
            $("#id_comunas").find('option').prop("selected",true);
            $("#id_comunas").trigger('change');
        }else{
            $("#id_comunas").find('option').prop("selected",false);
            $("#id_comunas").trigger('change');
        }
    });
    var tableB = $('#tablaPublicidad').dataTable();
    $('#tablaPublicidad tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroPublicidad = TablaTraerCampo('tablaPublicidad',this);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaPublicidad',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        pintarDatosActualizar(RegistroPublicidad);
                        break;
                }
            },
            items: {
                "1": {name: "Editar", icon: "edit"},
            }
        });
    });
    $(document).on('click','#agregar',Boton_agregar);
    $(document).on('click','#cancelar',Boton_cancelar);
    $(document).on('click','#cargar',actualizarFoto);
    $(document).on('click','#eliminar',eliminarFoto);
    $(document).on('click','#guardar',ProcesarPublicidad);
     $('#FormPublicidad').formValidation({
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
            'paist': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'codigot': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'numerot': {
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
            'descripcion': {
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
	    ProcesarPublicidad();
	})
	.on('status.field.fv', function(e, data){
	    data.element.parents('.form-group').removeClass('has-success');
	});
});