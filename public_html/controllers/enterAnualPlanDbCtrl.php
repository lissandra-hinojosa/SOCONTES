<?php

$today = date("Y-m-d");
$abierto = false;

if($today >= $rowInstitucion['fecha_abre_plan'] && $today <= $rowInstitucion['fecha_cierra_plan']){
	$abierto = true;
}

?>