<?php 
$error = "";
$success = "";
if(isset($_COOKIE['success'])){
	$success = '<div class="alert alert-success" role="alert">Perfil actualizado exitosamente.</div>';
}

// GETTING DATA FROM DATABASE TO SHOW
$queryDivisiones = "SELECT * FROM divisiones WHERE institucion_id = " . $rowUsuario['institucion_id'];
$resultDivisiones = mysqli_query($link, $queryDivisiones);

//SUBMITING FORM
if(isset($_POST['nombre'])){
	$nombre = $_POST['nombre'];
	$apellidoPat = $_POST['apellidoPat'];
	$apellidoMat = $_POST['apellidoMat'];
	$email = $_POST['email'];
	$divisionId = $_POST['divisionId'];
	$contrasenaNueva = $_POST['contrasenaNueva'];
	$contrasenaActual = $_POST['contrasenaActual'];

	//VALIDATIONS
	if($nombre == ""){
		$error .= "El campo Nombre es Obligarotio.<br>";
	}
	if($apellidoPat == ""){
		$error .= "El campo Apellido Paterno es Obligarotio.<br>";
	}
	if($email == ""){
		$error .= "El campo Correo Electrónico es Obligarotio.<br>";
	}
	if(strlen($contrasenaNueva) > 0 && strlen($contrasenaNueva) < 6){
		$error .= "La Contraseña Nueva debe contener al menos 6 caracteres.<br>";
	}

	//VALIDATE PASSWORD
	if($rowUsuario['contrasena'] != md5(md5("md5") . mysqli_real_escape_string($link, $contrasenaActual))){
		$error .= "Contraseña Actual incorrecta.<br>";
	}

	
	//VALIDATE UNIQUE EMAIL
	$queryUniqueEmail = "SELECT id, tipo_usuario_id FROM usuarios WHERE email = '" . mysqli_real_escape_string($link, $email).
		"' AND tipo_usuario_id = ".$_SESSION['tipoUsuarioId'];
	$resultUniqueEmail = mysqli_query($link, $queryUniqueEmail);
	if(mysqli_num_rows($resultUniqueEmail) > 0){
		$rowUniqueEmail = mysqli_fetch_array($resultUniqueEmail);
		if($rowUniqueEmail['id'] != $_SESSION['id']){
			$error .= "Ese Correo Electronico ya esta siendo utilizado.<br>";
		}
	}

	if($error != ""){
		$error = '<div class="alert alert-danger" role="alert"><strong>Errores al registrarse:</strong><br>' . $error . '</div>';
	}
	else{
		if($contrasenaNueva == ""){
			$queryUpdateUsuario = "UPDATE usuarios SET nombre = '" .
			mysqli_real_escape_string($link, $nombre) . "', apellido_pat = '" . 
			mysqli_real_escape_string($link, $apellidoPat) . "', apellido_mat = '" .
			mysqli_real_escape_string($link, $apellidoMat) . "', email = '" .
			mysqli_real_escape_string($link, $email) . "', division_id = " .
			$divisionId . " WHERE id = " . $_SESSION['id'];
		}
		else {
			$queryUpdateUsuario = "UPDATE usuarios SET nombre = '" .
			mysqli_real_escape_string($link, $nombre) . "', apellido_pat = '" . 
			mysqli_real_escape_string($link, $apellidoPat) . "', apellido_mat = '" .
			mysqli_real_escape_string($link, $apellidoMat) . "', email = '" .
			mysqli_real_escape_string($link, $email) . "', contrasena = '" . 
			md5(md5("md5") . mysqli_real_escape_string($link, $contrasenaNueva)) . "', division_id = " .
			$divisionId . " WHERE id = " . $_SESSION['id'];
		}
		
		if(mysqli_query($link, $queryUpdateUsuario)){
			setcookie("success", "1", time() + 4);

			if($_SESSION['tipoUsuarioId'] == 1){
				header("Location: http://socontes-com.stackstaging.com/users/professorProfile.php");
			}
			else if($_SESSION['tipoUsuarioId'] == 2){
				header("Location: http://socontes-com.stackstaging.com/users/assistantProfile.php");
			}
			else if($_SESSION['tipoUsuarioId'] == 3){
				header("Location: http://socontes-com.stackstaging.com/users/directorProfile.php");
			}
		}
		else{
			echo "'OMG SORRY!' SAID THE DATABASE";
		}

		
	}
}

?>