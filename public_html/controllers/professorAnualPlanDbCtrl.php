<?php

if(isset($_POST['abierto'])){
	$reporte = "plan";

	// VALIDATES IF THE WORK PLAN ALREADY EXISTS
	$queryPlanActual = "SELECT * FROM planes_de_trabajo WHERE usuario_id = " . $rowUsuario['id'] . 
		" AND YEAR(fecha_inicio) = " . date("Y");
	$resultPlanActual = mysqli_query($link, $queryPlanActual);

	if(mysqli_num_rows($resultPlanActual) == 0){
		$queryPlanNuevo = "INSERT INTO planes_de_trabajo (usuario_id) VALUES (" . $rowUsuario['id'] . ")";
		mysqli_query($link, $queryPlanNuevo);
		$resultPlanActual = mysqli_query($link, $queryPlanActual);
	}
	$rowPlanActual = mysqli_fetch_array($resultPlanActual);

	//CHECK FOR FINISHED SECTIONS
	$finDocencia = $rowPlanActual['fin_docencia'];
	$finInvestigacion = $rowPlanActual['fin_investigacion'];
	$finTutoria = $rowPlanActual['fin_tutoria'];
	$finGestion = $rowPlanActual['fin_gestion'];
	$finDifusion = $rowPlanActual['fin_difusion'];
	$finSuperacion = $rowPlanActual['fin_superacion'];
	$finTiempo = $rowPlanActual['fin_tiempo'];
	$finComentarios = $rowPlanActual['fin_comentarios'];

	$terminado = ($finDocencia && $finInvestigacion && $finTutoria && $finGestion && 
		$finDifusion && $finSuperacion && $finTiempo && $finComentarios);


	// **************** DOCENCIA ***********************
	$queryMaterias = "SELECT * FROM materias WHERE institucion_id = " . $rowUsuario['institucion_id'];
	$queryPeriodos = "SELECT * FROM periodos WHERE institucion_id = " . $rowUsuario['institucion_id'];
	$resultPeriodos = mysqli_query($link, $queryPeriodos);
	$rowTotal = array();

	while($rowPeriodos = mysqli_fetch_array($resultPeriodos)){
		$resultMaterias = mysqli_query($link, $queryMaterias);
		while($rowMaterias = mysqli_fetch_array($resultMaterias)){
			$rowMaterias['periodo'] = $rowPeriodos['descripcion'];
			array_push($rowTotal, $rowMaterias);
		}
	}

	if(isset($_POST['docenciaPost'])){
		$queryDelete = "DELETE FROM plan_tiene_materias WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
		mysqli_query($link, $queryDelete);

		$values = "";
		for($i = 0; $i < (count($_POST)-2)/2; $i++){
			$queryId = "SELECT id FROM periodos WHERE descripcion = '" . $_POST['perId'.$i] . "'";
			$rowId = mysqli_fetch_array(mysqli_query($link, $queryId));
			$periodoId = $rowId['id'];

			$values .= "(".$rowPlanActual['id'].", '".$_POST['matId'.$i]."', ".$periodoId."),";
		}

		if($values != ""){
			$values = substr($values, 0, -1);
			
			$queryDocencia = "INSERT INTO plan_tiene_materias (plan_de_trabajo_id, materia_id, periodo_id) VALUES " . $values;
			if(!mysqli_query($link, $queryDocencia)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}

			$queryHorasDocencia = "SELECT SUM(horas_semana) AS horas FROM plan_tiene_materias pm
				JOIN materias m ON m.id = pm.materia_id
				WHERE plan_de_trabajo_id = " . $rowPlanActual['id'] .
				" GROUP BY plan_de_trabajo_id";
			$resultHorasDocencia = mysqli_query($link, $queryHorasDocencia);
			$rowHorasDocencia = mysqli_fetch_array($resultHorasDocencia);

			$querySetHoras = "UPDATE planes_de_trabajo SET horas_docencia = ".$rowHorasDocencia['horas'].
				" WHERE id = " . $rowPlanActual['id'];
			if(!mysqli_query($link, $querySetHoras)){
				echo "'OMG SORRY' SAID THE DATABASE HORAS";
			}

			$querySetFin = "UPDATE planes_de_trabajo SET fin_docencia = 1 WHERE id = " . $rowPlanActual['id'];
			$finDocencia = 1;
			if(!mysqli_query($link, $querySetFin)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}
		}
	}

	$queryMatReg = "SELECT m.id, m.nombre, pm.periodo_id, m.horas_semana, p.descripcion FROM plan_tiene_materias pm
		JOIN materias m ON pm.materia_id = m.id
        JOIN periodos p ON p.id = pm.periodo_id
		WHERE pm.plan_de_trabajo_id = " . $rowPlanActual['id'];
	$resultMatReg = mysqli_query($link, $queryMatReg);

	// **************** INVESTIGACION ***********************
	$queryProductos = "SELECT * FROM tipos_producto";
	$resultProductos = mysqli_query($link, $queryProductos);

	$queryAreasConocimiento = "SELECT * FROM areas_conocimiento";
	$resultAreasConocimiento = mysqli_query($link, $queryAreasConocimiento);

	if(isset($_POST['investigacionPost'])){
		$queryDelete = "DELETE FROM plan_tiene_productos WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
		mysqli_query($link, $queryDelete);

		$values = "";
		for($i = 0; $i < (count($_POST)-2)/4; $i++){
			$queryId = "SELECT id FROM tipos_producto WHERE nombre = '" . utf8_decode($_POST['producto'.$i]) . "'";
			$rowId = mysqli_fetch_array(mysqli_query($link, $queryId));
			$productoId = $rowId['id'];

			$queryId = "SELECT id FROM areas_conocimiento WHERE nombre = '" . utf8_decode($_POST['area'.$i]) . "'";
			$rowId = mysqli_fetch_array(mysqli_query($link, $queryId));
			$areaId = $rowId['id'];

			$values .= "(".$rowPlanActual['id'].", ".$productoId.", ".$areaId.", '".$_POST['tema'.$i]."', '".$_POST['linea'.$i]."'),";
		}

		if($values != ""){
			$values = substr($values, 0, -1);

			$queryInvestigacion = "INSERT INTO plan_tiene_productos VALUES " . $values;
			if(!mysqli_query($link, $queryInvestigacion)){
				echo "'OMG SORRY' SAID THE DATABASE";
				echo $queryInvestigacion;
			}

			$querySetFin = "UPDATE planes_de_trabajo SET fin_investigacion = 1 WHERE id = " . $rowPlanActual['id'];
			$finInvestigacion = 1;
			if(!mysqli_query($link, $querySetFin)){
				echo "'OMG SORRY SET' SAID THE DATABASE";
			}
		}
	}

	$queryInvReg = "SELECT p.nombre AS pnombre, a.nombre AS anombre, pp.linea, pp.tema FROM plan_tiene_productos pp
		JOIN tipos_producto p
		ON pp.tipo_producto_id = p.id
		JOIN areas_conocimiento a
		ON pp.area_conocimiento_id = a.id
		WHERE pp.plan_de_trabajo_id = " . $rowPlanActual['id'];
	$resultInvReg = mysqli_query($link, $queryInvReg);

	// **************** TUTORIAS ***************************
	$queryActRetencion = "SELECT * FROM actividades_retencion";
	$resultActRetencion = mysqli_query($link, $queryActRetencion);

	$queryActDisminucion = "SELECT * FROM actividades_disminucion";
	$resultActDisminucion = mysqli_query($link, $queryActDisminucion);

	if(isset($_POST['tutoriasPost'])){
		$queryDelete = "DELETE FROM plan_tiene_actividades_retencion WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
		mysqli_query($link, $queryDelete);
		$queryDelete = "DELETE FROM plan_tiene_actividades_disminucion WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
		mysqli_query($link, $queryDelete);
		$queryDelete = "DELETE FROM alumnos_tutoria_plan WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
		mysqli_query($link, $queryDelete);

		$attrs = 0;
		if(!empty($_POST['actRet'])){
			$attrs++;
			$valuesRet = "";
			for($i = 0; $i < count($_POST['actRet']); $i++){
				$valuesRet .= "(".$rowPlanActual['id'].", ".$_POST['actRet'][$i]."),";
			}
			$valuesRet = substr($valuesRet, 0, -1);

			$queryTutoriasRet = "INSERT INTO plan_tiene_actividades_retencion (plan_de_trabajo_id, actividad_retencion_id) VALUES ".
				$valuesRet;
			if(!mysqli_query($link, $queryTutoriasRet)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}
		}
		if(!empty($_POST['actDis'])){
			$attrs++;
			$valuesDis = "";
			for($i = 0; $i < count($_POST['actDis']); $i++){
				$valuesDis .= "(".$rowPlanActual['id'].", ".$_POST['actDis'][$i]."),";
			}
			$valuesDis = substr($valuesDis, 0, -1);

			$queryTutoriasDis = "INSERT INTO plan_tiene_actividades_disminucion (plan_de_trabajo_id, actividad_disminucion_id) VALUES ".
				$valuesDis;
			if(!mysqli_query($link, $queryTutoriasDis)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}
		}

		$values = "";
		for($i = 0; $i < (count($_POST)-2-$attrs); $i++){
			$values .= "(".$rowPlanActual['id'].", '".$_POST['alumno'.$i]."'),";
		}

		if($values != ""){
			$values = substr($values, 0, -1);

			$queryTutorias = "INSERT INTO alumnos_tutoria_plan (plan_de_trabajo_id, alumno) VALUES ".$values;
			if(!mysqli_query($link, $queryTutorias)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}

			$querySetFin = "UPDATE planes_de_trabajo SET fin_tutoria = 1 WHERE id = " . $rowPlanActual['id'];
			$finTutoria = 1;
			if(!mysqli_query($link, $querySetFin)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}
		}
	}

	$queryTutRetReg = "SELECT actividad_retencion_id FROM plan_tiene_actividades_retencion WHERE plan_de_trabajo_id = ".
		$rowPlanActual['id'];
	$resultTutRetReg = mysqli_query($link, $queryTutRetReg);
	$arrayTutRetReg = Array();
	while($rowTutRetReg = mysqli_fetch_array($resultTutRetReg)){
		array_push($arrayTutRetReg, $rowTutRetReg['actividad_retencion_id']);
	}

	$queryTutDisReg = "SELECT actividad_disminucion_id FROM plan_tiene_actividades_disminucion WHERE plan_de_trabajo_id = ".
		$rowPlanActual['id'];
	$resultTutDisReg = mysqli_query($link, $queryTutDisReg);
	$arrayTutDisReg = Array();
	while($rowTutDisReg = mysqli_fetch_array($resultTutDisReg)){
		array_push($arrayTutDisReg, $rowTutDisReg['actividad_disminucion_id']);
	}

	$queryTutReg = "SELECT alumno FROM alumnos_tutoria_plan WHERE plan_de_trabajo_id = ".$rowPlanActual['id'];
	$resultTutReg = mysqli_query($link, $queryTutReg);

	// **************** GESTION ****************************
    $queryTiposGestion = "SELECT * FROM tipos_gestion";
    $resultTiposGestion = mysqli_query($link, $queryTiposGestion);
    
    if(isset($_POST['gestionPost'])){
        $queryDelete = "DELETE FROM plan_tiene_tipos_gestion WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
		mysqli_query($link, $queryDelete);
        
        $values = "";
		for($i = 0; $i < (count($_POST)-2)/2; $i++){
            $queryId = "SELECT id FROM tipos_gestion WHERE nombre = '" . utf8_decode($_POST['tipoActDif'.$i]) . "'";
			$rowId = mysqli_fetch_array(mysqli_query($link, $queryId));
			$productoId = $rowId['id'];
            
			$values .= "(".$rowPlanActual['id'].", ".$productoId.", '".$_POST['actDif'.$i]."'),";
		}

		if($values != ""){
			$values = substr($values, 0, -1);
	        $queryGestion = "INSERT INTO plan_tiene_tipos_gestion (plan_de_trabajo_id, tipo_gestion_id, descripcion) VALUES " . $values;
	        if(!mysqli_query($link, $queryGestion)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}

			$querySetFin = "UPDATE planes_de_trabajo SET fin_gestion = 1 WHERE id = " . $rowPlanActual['id'];
			$finGestion = 1;
			if(!mysqli_query($link, $querySetFin)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}
		}
    }
    
    $queryGesReg = "SELECT g.nombre, pg.descripcion FROM plan_tiene_tipos_gestion pg
        JOIN tipos_gestion g
        ON g.id = pg.tipo_gestion_id
        WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
    $resultGesReg = mysqli_query($link, $queryGesReg);
    
	// **************** DIFUSION ***************************
	if(isset($_POST['difusionPost'])){
		$queryDelete = "DELETE FROM actividades_difusion_plan WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
		mysqli_query($link, $queryDelete);

		$values = "";
		for($i = 0; $i < (count($_POST)-2); $i++){
			$values .= "(".$rowPlanActual['id'].", '".$_POST['actDif'.$i]."'),";
		}

		if($values != ""){
			$values = substr($values, 0, -1);

			$queryDifusion = "INSERT INTO actividades_difusion_plan (plan_de_trabajo_id, actividad) VALUES " . $values;
			if(!mysqli_query($link, $queryDifusion)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}

			$querySetFin = "UPDATE planes_de_trabajo SET fin_difusion = 1 WHERE id = " . $rowPlanActual['id'];
			$finDifusion = 1;
			if(!mysqli_query($link, $querySetFin)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}
		}
	}

	$queryDifReg = "SELECT actividad FROM actividades_difusion_plan WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
	$resultDifReg = mysqli_query($link, $queryDifReg);

	// **************** SUPERACION ACADEMICA ****************
	$queryTipoSup = "SELECT nombre FROM tipos_superacion_academica";
	$resultTipoSup = mysqli_query($link, $queryTipoSup);

	if(isset($_POST['superacionPost'])){
		$queryDelete = "DELETE FROM plan_tiene_tipos_superacion WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
		mysqli_query($link, $queryDelete);

		$values = "";
		for($i = 0; $i < (count($_POST)-2)/3; $i++){
            $queryId = "SELECT id FROM tipos_superacion_academica WHERE nombre = '" . utf8_decode($_POST['tipo'.$i]) . "'";
			$rowId = mysqli_fetch_array(mysqli_query($link, $queryId));
			$tipoSuperacionId = $rowId['id'];
            
			$values .= "(".$tipoSuperacionId.", ".$rowPlanActual['id'].", '".$_POST['desc'.$i]."', '".$_POST['inst'.$i]."'),";
		}

		if($values != ""){
			$values = substr($values, 0, -1);
			$querySuperacion = "INSERT INTO plan_tiene_tipos_superacion (tipo_superacion_academica_id, plan_de_trabajo_id, nombre, escuela) VALUES ".$values;
			if(!mysqli_query($link, $querySuperacion)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}

			$querySetFin = "UPDATE planes_de_trabajo SET fin_superacion = 1 WHERE id = " . $rowPlanActual['id'];
			$finSuperacion = 1;
			if(!mysqli_query($link, $querySetFin)){
				echo "'OMG SORRY' SAID THE DATABASE";
			}
		}
	}
	$querySupReg = "SELECT s.nombre, ps.escuela, ps.nombre AS descripcion FROM plan_tiene_tipos_superacion ps
		JOIN tipos_superacion_academica s
		ON s.id = ps.tipo_superacion_academica_id
		WHERE plan_de_trabajo_id = " . $rowPlanActual['id'];
	$resultSupReg = mysqli_query($link, $querySupReg);

	// **************** TIEMPO INVERTIDO *******************
	if(isset($_POST['tiempoPost'])){
		$queryTiempo = "UPDATE planes_de_trabajo SET horas_investigacion = ".$_POST['horasInvestigacion'].
			", horas_tutoria = ".$_POST['horasTutoria'].
			", horas_gestion = ".$_POST['horasGestion'].
			", horas_difusion = ".$_POST['horasDifusion'].
			", horas_superacion = ".$_POST['horasSuperacion'].
			" WHERE id = " . $rowPlanActual['id'];

		if(!mysqli_query($link, $queryTiempo)){
			echo "'OMG SORRY' SAID THE DATABASE TIEMPO";
		}

		$querySetFin = "UPDATE planes_de_trabajo SET fin_tiempo = 1 WHERE id = " . $rowPlanActual['id'];
		$finTiempo = 1;
		if(!mysqli_query($link, $querySetFin)){
			echo "'OMG SORRY' SAID THE DATABASE";
		}
	}

	$queryHorasPlan = "SELECT horas_docencia, horas_investigacion, horas_tutoria, horas_gestion, horas_difusion, horas_superacion 
		FROM planes_de_trabajo WHERE id = " . $rowPlanActual['id'];
	$resultHorasPlan = mysqli_query($link, $queryHorasPlan);
	$rowHorasPlan = mysqli_fetch_array($resultHorasPlan);

	// **************** COMENTARIOS ***********************
    if(isset($_POST['comentariosPost'])){
        $queryComentarios = "UPDATE planes_de_trabajo SET comentarios = '" . $_POST['comentarios'] .
            "' WHERE id = " . $rowPlanActual['id'];
        if(!mysqli_query($link, $queryComentarios)){
			echo "'OMG SORRY' SAID THE DATABASE";
		}

		$querySetFin = "UPDATE planes_de_trabajo SET fin_comentarios = 1 WHERE id = " . $rowPlanActual['id'];
		$finComentarios = 1;
		if(!mysqli_query($link, $querySetFin)){
			echo "'OMG SORRY' SAID THE DATABASE";
		}
    }
    $queryComentarioActual = "SELECT comentarios FROM planes_de_trabajo WHERE id = " . $rowPlanActual['id'];
    $resultComentarioActual = mysqli_query($link, $queryComentarioActual);
    $rowComentarioActual = mysqli_fetch_array($resultComentarioActual);
    $comentarioActual = "";
    if(!is_null($rowComentarioActual['comentarios'])){
    	$comentarioActual = trim($rowComentarioActual['comentarios']);
    }
}
else {
	header("Location: http://socontes-com.stackstaging.com/users/professorEnterAnualPlan.php");
}			

?>