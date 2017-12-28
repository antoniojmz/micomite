<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>correo</title>
	   <style>
		   .titulo {
			    color: #1e80b6;
			    padding-top: 20px;
			    padding-bottom: 10px;
			    padding-left: 20px;
			    padding-right: 20px;
		    }
		    .body{
		    	background-color: #ECECEC;	
		    }
		    .div_contenido{
			    color: #1e80b6;
			    padding-top: 20px;
			    padding-bottom: 10px;
			    padding-left: 20px;
			    padding-right: 20px;
			    background-color: #ffffff !important;
		   }
	   </style>
	</head> 
	<body class="body">
		<div class="titulo" ><center><h3>Mi Comité Online</h3></center></div>
		<hr>
		<div class=".div_contenido"><?= $contenido; ?></div>
	</body>
</html>