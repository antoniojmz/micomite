function collapsar_menu(){
	var myLayout = $('body').layout();
	var west_size   = myLayout.state.west.size;
	if(west_size==240){
		myLayout.sizePane("west", 85);
		$("#img_logo").attr("src","../img/logo-single.png");
		$("#cssmenu").css("width","75px");
		$("#css_menu").attr("href","../css/menu/menu2.css");
		var myLayout = $('body').layout();
		myLayout.allowOverflow('west');
		$("#nombre_seccion").css("display","block");

	}else{
		myLayout.sizePane("west", 240);
		$("#img_logo").attr("src","../img/logo.png");
		$("#cssmenu").css("width","227px");
		$("#css_menu").attr("href","../css/menu/menu.css");
		var myLayout = $('body').layout();
		myLayout.resetOverflow('west');
		$("#nombre_seccion").css("display","none");
	}
}
function toggleFullScreen() {
	$(document).toggleFullScreen();
	if($(document).fullScreen()){
		$("#img_max").attr("src","../img/maximize.png");
	}else{
		$("#img_max").attr("src","../img/minimize.png");
	}
}
function toggle_east(){
	var myLayout = $('body').layout();
	myLayout.toggle("east");
}