var cambionacionalidad = function(){
	($("#spam_nacionalidad").text() == "V")?$("#spam_nacionalidad").text("E"):$("#spam_nacionalidad").text("V");
	$("#nacionalidad").val($("#spam_nacionalidad").text());
	$('#naci').val($("#spam_nacionalidad").text() + $("#cedula").val());
};

var procesar = function(){

	$('#naci').val($("#nacionalidad").val() + $("#cedula").val());
	$('#actcuenta').submit();
}

$(document).ready(function(){
    $(document).on('click','#aceptar',procesar);
});