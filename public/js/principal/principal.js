var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};

var ManejoRespuestaProcesar= function(data){
    if (respuesta.code=='200'){
        switch(respuesta.respuesta.code) {
            case '200':
                mesage(1,respuesta.respuesta.des_code);
                $("#nameC").val("");
                $("#emailC").val("");
                $("#mensaje").val("");
                break;
            case '-2':
                mesage(2,respuesta.respuesta.des_code);
                break;
            default:
                mesage(2,'Comuniquese con el personal de sopore técnico');
        }
    }else{
        mesage(2,'Comuniquese con el personal de sopore técnico');

    }
}

var enviarComentario=function(){
    if($('#nameC').val()==""){
        $('#nameC').closest('.form-group').addClass('has-error');
        return;
    }
    $('#nameC').closest('.form-group').removeClass('has-error');

    if($('#emailC').val()==""){
        $('#emailC').closest('.form-group').addClass('has-error');
        return;
    }
    $('#emailC').closest('.form-group').removeClass('has-error');

    if($('#mensaje').val()==""){
        $('#mensaje').closest('.form-group').addClass('has-error');
        return;
    }
    $('#mensaje').closest('.form-group').removeClass('has-error');
    var datos = {name:$("#nameC").val(),email:$("#emailC").val(),mensaje:$("#mensaje").val()};
    parametroAjax.data = datos;
    parametroAjax.ruta=ruta;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaProcesar(respuesta);
}

var mostrarInicio=function(){
    $("#btnInicio").addClass("active");
    $("#btnLogin").removeClass("active");
    $("#btnEmpresa").removeClass("active");
    $("#btnContacto").removeClass("active");
    $('#divInicio').show("slow");
    $('#divLogin').hide("slow");
    $('#divEmpresa').hide("slow");
    $('#divContacto').hide("slow");
}

var mostrarLogin=function(){
    $("#btnInicio").removeClass("active");
    $("#btnLogin").addClass("active");
    $("#btnEmpresa").removeClass("active");
    $("#btnContacto").removeClass("active");
    $('#divInicio').hide("slow");
    $('#divLogin').show("slow");
    $('#divEmpresa').hide("slow");
    $('#divContacto').hide("slow");
}

var mostrarEmpresa=function(){
    $("#btnInicio").removeClass("active");
    $("#btnLogin").removeClass("active");
    $("#btnEmpresa").addClass("active");
    $("#btnContacto").removeClass("active");
    $('#divInicio').hide("slow");
    $('#divLogin').hide("slow");
    $('#divEmpresa').show("slow");
    $('#divContacto').hide("slow");
}

var mostrarContacto=function(){
    $("#btnInicio").removeClass("active");
    $("#btnLogin").removeClass("active");
    $("#btnEmpresa").removeClass("active");
    $("#btnContacto").addClass("active");
    $('#divInicio').hide("slow");
    $('#divLogin').hide("slow");
    $('#divEmpresa').hide("slow");
    $('#divContacto').show("slow");
}

var mostrarPass=function(){
    parametroAjax.data = {username:$("#username").val()};
    parametroAjax.ruta=rutaL;
    respuesta=procesarajax(parametroAjax);
    ManejoRespuestaBuscar(respuesta);
}

var VolverPass=function(){
    $("#divNoexiste").hide("slow");
    $("#spanName").text("");
    $("#avatar2").attr('src',"/img/avatar.png")+ '?' + Math.random();
    $("#username").val("");
    $("#divPass").hide("slow");
    $("#divLogins").show("slow");
    $("#nombre").text("");
     $("#username").removeClass('invalido');
}
var ManejoRespuestaBuscar= function(data){
    if (typeof(respuesta.respuesta[0])=="undefined"){
        $("#username").addClass('invalido');
        $("#spanNoexiste").text("Usuario no encontrado.");
        $("#divNoexiste").show("slow");
    }else{
        if (respuesta.code=='200'){
            var data = respuesta.respuesta[0];
            if (data.urlimage!=null){
                if (data.urlimage.length>3){
                    $('#avatar2').attr('src',data.urlimage)+ '?' + Math.random();
                }
            }
            if(data.name!=null){
                var nombre_completo=data.name.toLowerCase();
                $("#spanName").text(data.name);
                $("#nombre").text("    No eres "+nombre_completo+"?");                
            }
            $("#divLogins").hide("slow");
            $("#divPass").show("slow");
        }else{
            $("#divNoexiste").show("slow");
            $("#spanNoexiste").text("Hemos encontrado un problema, por favor vuelve a intentarlo.");
        }
    }
}
var validarP=function(){$('#FormContacto').formValidation('validate');};
$(document).ready(function(){
    $(document).ajaxStart(function (){
        //none, rotateplane, stretch, orbit, roundBounce, win8,
        //win8_linear, ios, facebook, rotation, timer, pulse,
        //progressBar, bouncePulse
        // el.waitMe({
        console.log("entre a waitme");
        $('#content').waitMe({    
            effect: 'win8_linear',
            text: '',
            bg : 'rgba(255,255,255,0.7)',
            color : ['#000000','#005aff','#002c7c'],
            maxSize: 30,
            source: 'img.svg',
            textPos: '',
            fontSize: '1px',
            onClose: function() {}
        }); 
    });

    $(document).ajaxStop(function() {
        console.log("en medio del waitme");
        $('#content').waitMe('hide');
        console.log("sali a waitme");
    });

    $(document).on('click','#btnSiguiente',mostrarPass);
    $(document).on('click','#spanNosoy',VolverPass);
    $(document).on('click','#btnInicio',mostrarInicio);
    $(document).on('click','#btnLogin',mostrarLogin);
    $(document).on('click','#btnEmpresa',mostrarEmpresa);
    $(document).on('click','#btnContacto',mostrarContacto);

    $(document).on('click','#btnSend',validarP);

        $('#FormContacto').formValidation({
        // message: 'El módulo le falta un campo para ser completado',
        fields: {
            'nameC': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
            'emailC': {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                    emailAddress: {
                        message: 'Ingrese una dirección de correo valida'
                    }
                }
            },
            'mensaje': {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido.'
                    },
                }
            },
        }
    }).on('success.form.fv', function(e){
        enviarComentario();
    }).on('status.field.fv', function(e, data){
        data.element.parents('.form-group').removeClass('has-success');
    });
});