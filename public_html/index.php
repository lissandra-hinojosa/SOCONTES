<!DOCTYPE html>
<html>
<head>
	<?php include("templates/cdnHead.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<?php include("templates/loginNavbar.php"); ?>

	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">Software de Control Escolar</h1>
			<p class="lead">Genera tus Planes de Trabajo e Informes Anuales de manera rápida y sencilla.</p>
			<hr class="my-4">
			<div class="login-step-1">
				<button class="btn btn-lg btn-info" id="reg-btn">Regístrate</button>
				<button class="btn btn-lg btn-primary bg-color-blue" id="log-btn">Ingresa</button>
			</div>
			<div class="login-step-2-reg">
				<h3>Registrarse como: </h3>
				<form class="row" method="post">
					<button class="m-1 col-md btn btn-lg btn-info" 
						formaction="forms/regUserToInstitution.php" name="tipoUsuarioId" value="1">Maestro</button>
					<button class="m-1 col-md btn btn-lg btn-info" 
						formaction="forms/regUserToInstitution.php" name="tipoUsuarioId" value="2">Asistente</button>
					<button class="m-1 col-md btn btn-lg btn-info" 
						formaction="forms/regUserToInstitution.php" name="tipoUsuarioId" value="3">Director</button>
					<button class="m-1 col-md btn btn-lg btn-info" 
						formaction="forms/regInstitution.php" name="tipoUsuarioId" value="4">Institución</button>
					<button class="m-1 col-md btn btn-lg btn-secondary login-back" type="button">
						<i class="fas fa-arrow-left"></i>
					</button>
				</form>
			</div>
			<div class="login-step-2-log">
				<h3>Ingresar como:</h3>
				<form class="row" method="post">
					<button class="m-1 col-md btn btn-lg btn-primary bg-color-blue" 
						formaction="forms/logUser.php" name="tipoUsuarioId" value="1">Maestro</button>
					<button class="m-1 col-md btn btn-lg btn-primary bg-color-blue" 
						formaction="forms/logUser.php" name="tipoUsuarioId" value="2">Asistente</button>
					<button class="m-1 col-md btn btn-lg btn-primary bg-color-blue" 
						formaction="forms/logUser.php" name="tipoUsuarioId" value="3">Director</button>
					<button class="m-1 col-md btn btn-lg btn-primary bg-color-blue" 
						formaction="forms/logInstitution.php" name="tipoUsuarioId" value="4">Institución</button>
					<button class="m-1 col-md btn btn-lg btn-secondary login-back" type="button">
						<i class="fas fa-arrow-left"></i>
					</button>
				</form>
			</div>

		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md text-center">
				<i class="fas fa-chart-pie fa-3x"></i>
				<h3>Compara las Estadísticas</h3>
				<p>Mira las estadísticas generadas por los reportes de los maestros organizadas por secciones.</p>
			</div>
			<div class="col-sm text-center">
				<i class="fas fa-clock fa-3x"></i>
				<h3>Ahorra Tiempo</h3>
				<p>Utiliza las herramientas para autocompletar y comparar facilmente los reportes.</p>
			</div>
			<div class="col-sm text-center">
				<i class="fas fa-check-square fa-3x"></i>
				<h3>Autoriza los Reportes</h3>
				<p>Autoriza cada Plan de Trabajo e Informe Anual e imprímelos.</p>
			</div>
		</div>
	</div>


	<script type="text/javascript" src="vendor/jquery-3.3.1.min.js"></script>
	<?php include("templates/cdnBody.php"); ?>

	<!----- CONTROLLERS ----->
	<script type="text/javascript" src="controllers/indexCtrl.js"></script>
</body>
</html>