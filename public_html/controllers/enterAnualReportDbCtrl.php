<?php

$today = date("Y-m-d");
$abierto = false;

// Check If Anual Plan is already done
$queryPlanActual = "SELECT * FROM planes_de_trabajo WHERE usuario_id = " . $rowUsuario['id'] . 
	" AND YEAR(fecha_inicio) = " . date("Y") . " AND fecha_enviado IS NOT NULL";
$resultPlanActual = mysqli_query($link, $queryPlanActual);

if($today >= $rowInstitucion['fecha_abre_informe'] 
	&& $today <= $rowInstitucion['fecha_cierra_informe'] 
	&& mysqli_num_rows($resultPlanActual) > 0)
{
	$abierto = true;
}

?>