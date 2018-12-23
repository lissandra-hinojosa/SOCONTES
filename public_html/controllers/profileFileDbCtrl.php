<?php

$profileFile = "#";

if($_SESSION['tipoUsuarioId'] == 1){
	$profileFile = "professorProfile.php";
}
else if ($_SESSION['tipoUsuarioId'] == 2){
	$profileFile = "assistantProfile.php";
}
else if ($_SESSION['tipoUsuarioId'] == 3){
	$profileFile = "directorProfile.php";
}
else if ($_SESSION['tipoUsuarioId'] == 4){
	$profileFile = "institutionProfile.php";
}

?>