var RegistroUsuario='';
var caso=0;
var ManejoRespuestaProcesar = function(respuesta){
    var respuesta2=JSON.parse(respuesta.f_registro_usuario[0].f_registro_usuario);
    if (respuesta2.code=='200'){
        mensajesAlerta('Procesado!',respuesta2.des_code, 'info');
        Boton_cancelar();
        limpiarTabla();
        cargarTablaUsuarios(respuesta.v_usuarios);
    }else{
        mensajesAlerta('Error',respuesta2.des_code, 'error');
    };
}
var cargarTablaUsuarios = function(data){
    $("#tablaUsuarios").dataTable({
        "columnDefs": [
        {
            "targets": [ 1 ],
            "searchable": true
        }
        ],
        "language": {
            "url": "/DataTables-1.10.10/de_DE-all.txt"
        },
        "data": data,
        "columns":[
        {"title": "Id","data": "user_id",visible:0},
        {"title": "RUT","data": "rut"},
        {"title": "Nombres","data": "name"},
        {"title": "Correo","data": "email"},
        {"title": "Tipo usuario","data": "des_usuario"}
        ],
    });
};
var crearallcombos = function(data){
    crearcombo('#id_tipo',data);
}
var cargarFormularioC= function(data){
    caso=3;
    // console.log("este es el id a reiniciar"+data.user_id);
    $("#spanTitulo").text("Cambio de clave");
    $('#divTabla').hide();
    $('#divForm').show();
    $("#user_id").val(data.user_id);
    $('.caja-foto').hide();
    $('.noCambia').hide();
    $('.siCambia').show();
    $('.botonera').show();
}
var cargarFormulario= function(){
    caso=2;
    $('#divTabla').hide();
    $('#divForm').show();
}
// var pintarDatosActualizar= function(data){
//     if (data.urlimage!=null){
//         if (data.urlimage.length>1){
//             $('.foto-perfil').attr('src',data.urlimage)+ '?' + Math.random();
//         }
//     }
//     $("#spanTitulo").text("Actualización de datos");
//     $("#user_id").val(data.user_id);
//     if(data.rut!=null){$("#rut").val(data.rut);}
//     if(data.direccion!=null){$("#direccion").val(data.direccion);}
//     if(data.name!=null){$("#name").val(data.name);}
//     if(data.email!=null){$("#email").val(data.email);}
//     if(data.sexo!=null){$(".sexo").val(data.sexo);}
//     if(data.telefonoresidencial!=null){
//         var res = data.telefonoresidencial.split("-");
//         $("#paist").val(res[0]);
//         $("#codigot").val(res[1]);
//         $("#numerot").val(res[2]);
//     }
//     if(data.movil!=null){
//         var res = data.movil.split("-");
//         $("#paism").val(res[0]);
//         $("#codigom").val(res[1]);
//         $("#numerom").val(res[2]);
//     }
//     if(data.fecha_nacimiento!=null){
//         $("#fecha_nacimiento").val(moment(data.fecha_nacimiento).format('DD/MM/YYYY'));
//     }
//     $(".siCambia").hide();
//     $(".noCambia").show();
//     $(".botonera").show();
//     $(".caja-foto").show(); 
// }
var Boton_cancelar = function(){
    caso=0;
    $('.foto-perfil').attr('src','/img/foto.png')+ '?' + Math.random();
    $("#spanTitulo").text("");
    $('#divForm').hide();
    $('#divTabla').show();
    $('#FormUsuario')[0].reset();
    $("#id_tipo").val('').trigger("change");
    $("#user_id").val("");
    $(".botonera").hide();
}
var Boton_agregar = function(){
    cargarFormulario();
    $("#spanTitulo").text('Registro de usuario');
    $("#nacionalidad").text("V");
    $("#user_id").val("");
    $('#FormUsuario')[0].reset();
    $(".caja-foto").hide(); 
    $(".siCambia").hide(); 
    $(".noCambia").show(); 
    $(".botonera").show();
}
var limpiarTabla = function(){
    $('#tablaUsuarios').dataTable().fnClearTable();
    $('#tablaUsuarios').dataTable().fnDraw();
    $('#tablaUsuarios').dataTable().fnDestroy();
    $('#tablaUsuarios thead').empty();
};
var actualizarFoto = function(){ 
    var formu=$(this);
    var nombreform=$(this).attr("id");
    if(nombreform=="FormUsuario" ){ 
        var divresul="notificacion_resul_fci"
    }
        var form = $('#FormUsuario').get(0); 
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
              $('.foto-perfil').attr('src',data)+ '?' + Math.random();      
            },
            //si ha ocurrido un error
            error: function(data){
               alert("ha ocurrido un error al cargar su foto");  
            },
        });
};

var cambiarPass = function(){
    var password= $('#password').val();
    var user_id= RegistroUsuario.user_id;
    datos=[];
    datos = {
        caso:caso,
        password:password,
        user_id : user_id
    };
    $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': $('#_token').val()},
        type:'POST',
        async:false,
        dataType: 'JSON',
        data: {
            'datos':datos
        },
    })
    .done(function(d){
        var pass=JSON.parse(d.f_registro_usuario);
        mensajesAlerta('Procesado!',pass.des_code, 'info');
        Boton_cancelar();
    });
}
var ProcesarUsuario = function(){
        var rut= $('#rut').val();
        var name= $('#name').val();
        var email= $('#email').val();
        var id_tipo= $('#id_tipo').val();
        var remember_token= $('#_token').val();
        datos=[];
        datos = {
            caso:caso,
            rut:rut,
            name: name,
            email: email,
            id_tipo: id_tipo,
            remember_token: remember_token
        };
        $.ajax({
            url: ruta,
            headers: {'X-CSRF-TOKEN': $('#_token').val()},
            type:'POST',
            async:false,
            dataType: 'JSON',
            data: {
                'datos':datos
            },
        })
        .done(function(d){
            ManejoRespuestaProcesar(d);
        });
};

var validarU=function(){$('#FormUsuario').formValidation('validate');};
$(document).ready(function(){
    $(".botonera").hide();
    cargarTablaUsuarios(d.v_usuarios);
    crearallcombos(d.v_tipo_usuario);
    var tableB = $('#tablaUsuarios').dataTable();
    $('#tablaUsuarios tbody').on('click', 'tr', function (e) {
        tableB.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        RegistroUsuario = TablaTraerCampo('tablaUsuarios',this);
    });
    tableB.on('dblclick', 'tr', function () {
        $('#close').trigger('click');
    });
     $(function() {
        $.contextMenu({
            selector: '#tablaUsuarios',
            // selector: '.dataTable tbody tr',
            callback: function(key, options) {
                switch(key) {
                    case "1":
                        cargarFormularioC(RegistroUsuario);
                    break;
                }
            },
            items: {
                "1": {name: "Reiniciar clave", icon: "edit"},
            }
        });
    });
    $(document).on('click','#guardar',validarU);
    $(document).on('click','#cancelar',Boton_cancelar);
    $(document).on('click','#agregar',Boton_agregar);
    $(document).on('click','#cancelarP',Boton_cancelar);
    $(document).on('click','#guardarP',validarU);
  $('#FormUsuario').formValidation({
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
            'name': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'password': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'email': {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido.'
                        },
                        emailAddress: {
                            message: 'Ingrese una dirección de correo valida'
                        }
                    }
                },
        }
    }).on('success.form.fv', function(e){
        if(caso==2){ProcesarUsuario();}
        if(caso==3){cambiarPass();}
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});