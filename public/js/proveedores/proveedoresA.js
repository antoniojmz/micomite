var RegistroProveedores = '';
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
    	var res = JSON.parse(respuesta.respuesta.f_registro_proveedor[0].f_registro_proveedor);
    	switch(res.code) {
    	    case '200':
                mensajesAlerta('Procesado!',res.des_code, 'info');
                $(".caja-foto").show();
                destruirTablaS('tablaProveedores');
                cargarTablaProveedores(respuesta.respuesta.v_proveedores);
                $("#id_proveedor").val(res.id_proveedor);
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
var cargarTablaProveedores = function(data){
    $("#tablaProveedores").dataTable({
        "columnDefs": [{
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
        "columns": [
            {"title": "Id","data": "id_proveedor",visible:0 },
            {"title": "RUT","data": "rut"},
            {"title": "Nombres","data": "nombres"},
            {"title": "Correo","data": "email"},
            {"title": "Teléfono","data": "telefono1"},
            {"title": "Movil","data": "movil"},
            {"title": "Dirección","data": "direccion"},
            {"title": "Comunas","data": "des_comunas"}
        ],
    });
};
var crearallcombos = function(data){
    crearcombo('#id_rubro','');
    crearcombo('#id_comunas','');

}
var Boton_agregar = function(){
    $("#spanTitulo").text("Registro de proveedores de servicios");
    $(".divForm").toggle();
    $(".caja-foto").hide();
    $('#FormProveedores')[0].reset();
    $("#id_proveedor").val("");
    $(".comboclear").val('').trigger("change");
}
var Boton_cancelar = function(){
    $("#spanTitulo").text("Proveedores de servicios");
    $(".divForm").toggle();
    $(".caja-foto").hide();    
    $('#FormProveedores')[0].reset();
    $("#id_proveedor").val("");
    $(".comboclear").val('').trigger("change");
    $('.foto-perfil').attr('src','/img/edificio.png')+ '?' + Math.random();
}
var pintarDatosActualizar= function(data){
    // console.log(data);
    $(".caja-foto").show();	
    $(".divForm").toggle();
    $("#spanTitulo").text("Actualización de datos");
    if (data.urlimage!=null){
        if (data.urlimage.length>4){
            $('.foto-perfil').attr('src',data.urlimage)+ '?' + Math.random();
            $("#image").val(data.urlimage);
        }
    }
    if(data.id_proveedor!=null){$("#id_proveedor").val(data.id_proveedor);}
    if(data.rut!=null){$("#rut").val(data.rut);}
    if(data.nombres!=null){$("#nombres").val(data.nombres);}
    if(data.email!=null){$("#email").val(data.email);}
    if(data.direccion!=null){$("#direccion").val(data.direccion);}
    if(data.telefono1!=null){
        var res = data.telefono1.split("-");
        $("#paist1").val(res[0]);
        $("#codigot1").val(res[1]);
        $("#numerot1").val(res[2]);
    }
    if(data.telefono2!=null){
        var res = data.telefono2.split("-");
        $("#paist2").val(res[0]);
        $("#codigot2").val(res[1]);
        $("#numerot2").val(res[2]);
    }
    if(data.movil!=null){
        var res = data.movil.split("-");
        $("#paism").val(res[0]);
        $("#codigom").val(res[1]);
        $("#numerom").val(res[2]);
    }
    if(data.website!=null){$("#website").val(data.website);}
    if(data.id_rubro!=null){$("#id_rubro").val(data.id_rubro).trigger("change");}
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
var ProcesarProveedor = function(){
    var comunas= $('#id_comunas').val().toString(); 
    var comunas = {'comunas': comunas}
    parametroAjax.data = $("#FormProveedores").serialize() + '&' + $.param(comunas);
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
var eliminarFoto = function(){
        $.ajax({
            url: rutaE,
            headers: {'X-CSRF-TOKEN': $('#_token').val()},
            type:'POST',
             data: {'id_proveedor':$('#id_proveedor').val()},
            async:false,
            dataType: 'JSON',
        })
        .done(function(d){
            console.log(d);
            $('.foto-perfil').attr('src','/img/edificio.png')+ '?' + Math.random();
            destruirTablaS('tablaProveedores');
   			cargarTablaProveedores(d);
        });
}
var actualizarFoto = function(){ 
    var formu=$(this);
    var nombreform=$(this).attr("id");
    var form = $('#FormProveedores').get(0); 
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
            	console.log(data);    
				if (data=='-2'){
					alert("Debe agregar una foto");
				}else{
					$('.foto-perfil').attr('src',data.rutadelaimagen)+ '?' + Math.random();
					destruirTablaS('tablaProveedores');
   					cargarTablaProveedores(data.v_proveedores);
				}
            },
            //si ha ocurrido un error
            error: function(data){
               alert("ha ocurrido un error al cargar su foto");  
            },
        });
};
var validarS=function(){$('#FormProveedores').formValidation('validate');};
$(document).ready(function(){
    $("#checkbox").click(function(){
        if($("#checkbox").is(':checked') ){
            $("#id_comunas").find('option').prop("selected",true);
            $("#id_comunas").trigger('change');
        }else{
            $("#id_comunas").find('option').prop("selected",false);
            $("#id_comunas").trigger('change');
        }
    });
	$("#spanTitulo").text("Proveedores de servicios");
	$("#activo").attr("checked",true);
    cargarTablaProveedores(d.v_proveedores);
    crearallcombos(d);
    $("#id_tipo_seguridad").change(function(){
		mostrarDependientes(combos);
	});
	$('#rutE').focusout(function(){
        var rutE=$('#rutE').val();
        if (rutE.length>5){consultarResponsable(rutE);}
    });
    var tableB = $('#tablaProveedores').dataTable();
    $('#tablaProveedores tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroProveedores = TablaTraerCampo('tablaProveedores',this);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaProveedores',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        pintarDatosActualizar(RegistroProveedores);
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
    $(document).on('click','#guardar',validarS);
     $('#FormProveedores').formValidation({
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
            'paist1': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'codigot1': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'numerot1': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'paist2': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'codigot2': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'numerot2': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'website': {
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
            'id_rubro': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'id_comunas': {
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
	    ProcesarProveedor();
	})
	.on('status.field.fv', function(e, data){
	    data.element.parents('.form-group').removeClass('has-success');
	});
});