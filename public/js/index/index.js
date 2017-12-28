$(document).ready(function(){
	$(document).ajaxStart(function (){
		//none, rotateplane, stretch, orbit, roundBounce, win8,
		//win8_linear, ios, facebook, rotation, timer, pulse,
		//progressBar, bouncePulse
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
		$('#content').waitMe('hide');
	});
});