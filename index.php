<!DOCTYPE html>
<html lang="en" ng-app="cuotas">
<head>
	<meta charset="UTF-8">
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src= "https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js"></script>
	<script src="https://code.angularjs.org/1.4.7/angular-route.min.js"></script>


	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	
	<script src= "controlador.js"></script>

	<title>Cuotas - Logia Masonica</title>
</head>
<body>
	<header>Cuotas - Logia Masonica</header>
	<br/>
	
	<div class="container" >
		<div class="row">
			<nav class="navbar navbar-default" role="navigation">
			  <!-- El logotipo y el icono que despliega el menú se agrupan
			       para mostrarlos mejor en los dispositivos móviles -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Desplegar navegación</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Cuotas - Logia Masonica</a>
				</div>
 
				<!-- Agrupar los enlaces de navegación, los formularios y cualquier
				   otro elemento que se pueda ocultar al minimizar la barra -->
				<div id="navbar-ex1-collapse" class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="active"><a href="#/ListaMiembros">Lista de Miembros</a></li>
						<li><a href="#/NuevoMiembro">Nuevo Miembro</a></li>
						<li><a href="#/ModificarCuo">Modificar Cuotas</a></li>
						<li><a href="">Estadisticas</a></li>
					</ul>
				</div>
			</nav>	
		</div>		
	</div>
	<br/>
	
	<div ng-view> </div>




</body>
</html>