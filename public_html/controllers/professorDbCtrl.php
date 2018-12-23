<?php

if(isset($_SESSION['id']) && $_SESSION['tipoUsuarioId'] == 1){
	$queryUsuario = "SELECT * FROM usuarios WHERE id = " . $_SESSION['id'];
	$resultUsuario = mysqli_query($link, $queryUsuario);
	$rowUsuario = mysqli_fetch_array($resultUsuario);

	$queryInstitucion = "SELECT * FROM instituciones WHERE id = " . $rowUsuario['institucion_id'];
	$resultInstitucion = mysqli_query($link, $queryInstitucion);
	$rowInstitucion = mysqli_fetch_array($resultInstitucion);

}
else {
	header("Location: http://socontes-com.stackstaging.com");
}

?>