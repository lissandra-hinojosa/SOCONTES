<?php 

$tipoUsuarioId = $_POST['tipoUsuarioId'];

$queryInstituciones = "SELECT * FROM instituciones";
$resultInstituciones = mysqli_query($link, $queryInstituciones);

$queryTipoUsuario = "SELECT nombre FROM tipos_usuario WHERE id = " . $tipoUsuarioId;
$resultTipoUsuario = mysqli_query($link, $queryTipoUsuario);
$rowTipoUsuario = mysqli_fetch_array($resultTipoUsuario);

//SUBMITING THE FORM
if(isset($_POST['email'])){
	$institucionId = $_POST['institucionId'];
	$email = $_POST['email'];
	$contrasena = $_POST['contrasena'];

	//VALIDATIONS
	if($email == ""){
		$error .= "El campo Correo Electrónico es obligarotio.<br>";
	}
	if($contrasena == ""){
		$error .= "El campo Contraseña es obligatorio<br>";
	}

	//VALIDATE CREDENTIALS
	$queryCredentials = "SELECT id FROM usuarios WHERE email = '" . 
		mysqli_real_escape_string($link, $email) . "' AND tipo_usuario_id = " . 
		$tipoUsuarioId . " AND activado = 1 AND institucion_id = " . $institucionId . " AND contrasena = '" .
		md5(md5("md5") . mysqli_real_escape_string($link, $contrasena)) . "'";
	$resultCredentials = mysqli_query($link, $queryCredentials);
	if(mysqli_num_rows($resultCredentials) != 1){
		$error .= "Correo Electrónico, Contraseña y/o Institución incorrectos.<br>";
	}


	if($error != ""){
		$error = '<div class="alert alert-danger" role="alert"><strong>Errores al registrarse:</strong><br>' . $error . '</div>';
	}
	else{
		$rowCredentials = mysqli_fetch_array($resultCredentials);
		$_SESSION['id'] = $rowCredentials['id'];
		$_SESSION['tipoUsuarioId'] = $tipoUsuarioId;
		if($tipoUsuarioId == 1){
			header("Location: http://socontes-com.stackstaging.com/users/professorRecords.php");
		}
		else if($tipoUsuarioId == 2) {
			header("Location: http://socontes-com.stackstaging.com/users/assistantStats.php");
		}
		else if($tipoUsuarioId == 3) {
			header("Location: http://socontes-com.stackstaging.com/users/directorPlans.php");
		}
	}
}

?>