var cambionacionalidad = function(){
	($("#spam_nacionalidad").text() == "V")?$("#spam_nacionalidad").text("E"):$("#spam_nacionalidad").text("V");
	$("#nacionalidad").val($("#spam_nacionalidad").text());
};

$(document).ready(function(){
	$('#cedula').on('keypress',function(e){
		if(e.which != 13){return};
		$('.vtCedula').blur();
		$('#buscar_registro').submit();
	});
});