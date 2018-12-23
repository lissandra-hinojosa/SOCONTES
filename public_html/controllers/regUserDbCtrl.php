<?php 
$error = "";

// GETTING DATA FROM POST
$tipoUsuarioId = $_POST['tipoUsuarioId'];
$institucionId = $_POST['institucionId'];


// GETTING DATA FROM DATABASE TO SHOW
$queryTipoUsuario = "SELECT nombre FROM tipos_usuario WHERE id = " . $tipoUsuarioId;
$resultTipoUsuario = mysqli_query($link, $queryTipoUsuario);
$queryInstitucion = "SELECT nombre FROM instituciones WHERE id = " . $institucionId;
$resultInstitucion = mysqli_query($link, $queryInstitucion);

$rowTipoUsuario = mysqli_fetch_array($resultTipoUsuario);
$rowInstitucion = mysqli_fetch_array($resultInstitucion);


$queryDivisiones = "SELECT * FROM divisiones WHERE institucion_id = ". $institucionId;
$resultDivisiones = mysqli_query($link, $queryDivisiones);

//SUBMITING FORM
if(isset($_POST['nombre'])){
	$nombre = $_POST['nombre'];
	$apellidoPat = $_POST['apellidoPat'];
	$apellidoMat = $_POST['apellidoMat'];
	$email = $_POST['email'];
	$divisionId = $_POST['divisionId'];
	$contrasena = $_POST['contrasena'];
	$tipoUsuarioId = $_POST['tipoUsuarioId'];
	$institucionId = $_POST['institucionId'];
	$codigo = $_POST['codigo'];

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
	if(strlen($contrasena) < 6){
		$error .= "La Contraseña debe contener al menos 6 caracteres.<br>";
	}
	if($codigo == ""){
		$error .= "El campo Codigo es Obligarotio.<br>";
	}

	//VALIDATE UNIQUE EMAIL
	$queryUniqueUser = "SELECT id FROM usuarios WHERE email = '" . 
		mysqli_real_escape_string($link, $email) . "' AND institucion_id = " .
		$institucionId . " AND tipo_usuario_id = " . $tipoUsuarioId;
	$resultUniqueUser = mysqli_query($link, $queryUniqueUser);
	if(mysqli_num_rows($resultUniqueUser) > 0){
		$error .= "Este Correo Electrónico ya esta siendo utilizado.<br>";
	}

	//VALIDATE THE REGISTRATION CODE
	$queryCodigo = "";
	if($tipoUsuarioId == 1){
		$queryCodigo = "SELECT codigo_maestro FROM instituciones WHERE id = " . $institucionId;
	}
	else if($tipoUsuarioId == 2){
		$queryCodigo = "SELECT codigo_asistente FROM instituciones WHERE id = " . $institucionId;
	}
	else if($tipoUsuarioId == 3){
		$queryCodigo = "SELECT codigo_director FROM instituciones WHERE id = " . $institucionId;
	}

	$resultCodigo = mysqli_query($link, $queryCodigo);
	$rowCodigo = mysqli_fetch_array($resultCodigo);
	
	if($codigo != $rowCodigo['0']){
		$error .= "Código de Registro invalido.<br>";
	}


	if($error != ""){
		$error = '<div class="alert alert-danger" role="alert"><strong>Errores al registrarse:</strong><br>' . $error . '</div>';
	}
	else{
		$queryRegUsuario = "INSERT INTO usuarios (nombre, apellido_pat, apellido_mat, email, division_id, contrasena, tipo_usuario_id, institucion_id) VALUES ('" .
			mysqli_real_escape_string($link, $nombre) . "' ,'" .
			mysqli_real_escape_string($link, $apellidoPat) . "' ,'" .
			mysqli_real_escape_string($link, $apellidoMat) . "' ,'" .
			mysqli_real_escape_string($link, $email) . "' ," .
			$divisionId . " ,'" .
			md5(md5("md5") . mysqli_real_escape_string($link, $contrasena)) . "' ," .
			$tipoUsuarioId . " ," .
			$institucionId . ")";

		if(mysqli_query($link, $queryRegUsuario)){
			$querySession = "SELECT id FROM usuarios WHERE email = '" . 
				mysqli_real_escape_string($link, $email) . "' AND tipo_usuario_id = " .
				$tipoUsuarioId . " AND institucion_id = " . $institucionId; 
			$resultSession = mysqli_query($link, $querySession);
			$rowSession = mysqli_fetch_array($resultSession);
			$_SESSION['id'] = $rowSession['id'];
			$_SESSION['tipoUsuarioId'] = $tipoUsuarioId;

			if($tipoUsuarioId == 1){
				header("Location: http://socontes-com.stackstaging.com/users/professorRecords.php");
			}
			else if($tipoUsuarioId == 2){
				header("Location: http://socontes-com.stackstaging.com/users/assistantStats.php");
			}
			else if($tipoUsuarioId == 3){
				header("Location: http://socontes-com.stackstaging.com/users/directorPlans.php");
			}
		}
		else {
			echo "UPSY FROM THE DB";
		}
	}
}

?>