var parametroAjax = {
    'token': $('input[name=_token]').val(),
    'tipo': 'POST',
    'data': {},
    'ruta': '',
    'async': false
};
var ManejoRespuestaProcesar = function(respuesta){
    console.log(respuesta);
    // console.log(respuesta.respuesta);
    if (respuesta.code=='200'){
    	var res = respuesta.respuesta;
    	switch(res.code) {
    	    case '200':
                $("#divRespuesta").removeClass("alert-danger");
                $("#divRespuesta").addClass("alert-success");
                $("#spanRespuesta").text(res.des_code);
                $("#recuperar").val("");
                break;
            case '-2':
                $("#divRespuesta").removeClass("alert-success");
                $("#divRespuesta").addClass("alert-danger");
                $("#spanRespuesta").text(res.des_code);
                break;
            default:
                $("#divRespuesta").removeClass("alert-success");
                $("#divRespuesta").addClass("alert-danger");
                $("#spanRespuesta").text('Comuniquese con el personal de sopore técnico');

    	        break;
        } 
    }else{
        $("#divRespuesta").removeClass("alert-success");
        $("#divRespuesta").addClass("alert-danger");
        $("#spanRespuesta").text('Comuniquese con el personal de sopore técnico');
    }
}
var enviarDato = function(){
    parametroAjax.data = $("#Formrecuperar").serialize();
    parametroAjax.ruta=ruta;
    respuesta=procesarajax(parametroAjax);
	ManejoRespuestaProcesar(respuesta);
};
$(document).ready(function(){
    $(document).ajaxStart(function (){
        //none, rotateplane, stretch, orbit, roundBounce, win8,
        //win8_linear, ios, facebook, rotation, timer, pulse,
        //progressBar, bouncePulse
        $('#content').waitMe({
            effect : 'win8_linear',
            text : '',
            bg : 'rgba(255,255,255,0.7)',
            color : ['#000000','#005aff','#002c7c'],
            sizeW : '',
            sizeH : ''
        });
    });
    $(document).ajaxStop(function() {
        $('#content').waitMe('hide');
    });
    $(document).on('click','#enviar',enviarDato);
});