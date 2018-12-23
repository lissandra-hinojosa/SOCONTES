<?php session_start(); ?>
<?php include(__DIR__ . "/../../resources/dbConnect.php"); ?>
<?php include("../controllers/professorDbCtrl.php"); ?>
<?php include("../controllers/professorAnualPlanDbCtrl.php"); ?>

<!DOCTYPE html>
<html>
<head>
	<?php include("../templates/cdnHead.php"); ?>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<?php include("../templates/generalNavbar.php"); ?>
	<?php include("../templates/professorNavbar.php"); ?>


<!--https://www.youtube.com/watch?v=Z9lCqK_VrEE-->

<div class="user-container text-centered responsive-space">
		<!--TITLE-->
		<div class="row">
			<div class="col-md-6 offset-md-3 section-title">
				<h1>Plan de Trabajo</h1>
			</div>
		</div>
<!--******************** VERTICAL NAVBAR*********************-->
	<!--AP = Anual Plan-->
		<div class="row">
			<div class="col-md-2">
				<?php include("../templates/planAndReportMenu.php"); ?>
			</div>
<!--******************** Anual Report Sections *********************-->
		<div class="col-md-9 px-5">
			<div id="anualPlanSections" class="tab-content">


			<!--******************** DOCENCIA/TEACHING *********************-->
				<div id="teachingSection" class="tab-pane fade show active" role="tabpanel" aria-labelledby="teachingLink">
					<div>
						<p class="subsection-title">Docencia<i tabindex="0" class="ml-3 fas fa-question-circle" role="button" data-toggle="popover" title="Docencia" data-content="Seleccione las materias a impartir de acuerdo al periodo."></i></p>
					</div>
					<div class="row">
						<!--Subjects Table-->
						<div class="col-xl-6">
							<p class="instruction-title">Materias</p>
							<table id="subjectsTable" class="table table-hover">
							  <thead>
								<tr>
								  <th>Clave</th>
								  <th>Materia</th>
								  <th>Periodo</th>
								  <th>Horas</th>
								</tr>
							  </thead>
							  <tbody>
								<?php foreach($rowTotal as $materia): ?>
										<tr>
										  <td><?php echo $materia['id']; ?></td>
										  <td><?php echo $materia['nombre']; ?></td>
										  <td><?php echo $materia['periodo']; ?></td>
										  <td><?php echo $materia['horas_semana']; ?></td>
										</tr>
								<?php endforeach; ?>
							  </tbody>
							</table>
						</div>
						<div class="col-xl-6">
							<!--Selected Subjects-->
							<table id="selectedSubjectsTable" class="table table-hover">
							<p class="instruction-title">Agregadas</p>
							  	<thead class="thead-dark">
									<tr>
								  		<th>Clave</th>
								  		<th>Materia</th>
								  		<th>Periodo</th>
								 		<th>Horas</th>
									</tr>
							  	</thead>
							  	<tbody>
							  		<?php while($rowMatReg = mysqli_fetch_array($resultMatReg)): ?>
							  			<tr>
							  				<td><?php echo $rowMatReg['id']; ?></td>
							  				<td><?php echo $rowMatReg['nombre']; ?></td>
							  				<td><?php echo $rowMatReg['descripcion']; ?></td>
							  				<td><?php echo $rowMatReg['horas_semana']; ?></td>
							  			</tr>
							  		<?php endwhile; ?>
							  	</tbody>
							</table>
						</div>
					</div>
					<form id="docenciaForm" method="post">
						<input type="hidden" name="abierto" value="true">
						<button id="saveDocencia" type="submit" class="btn btn-primary btn-block my-4" name="docenciaPost" value="true">
							Guardar sección
						</button>
					</form>
				</div>
			<!--******************** INVESTIGACION/INVESTIGATION *********************-->
				<div  id="investigationSection" class="tab-pane fade" role="tabpanel" aria-labelledby="investigationLink">
					<div>
						<p class="subsection-title">Investigación<i tabindex="0" class="ml-3 fas fa-question-circle" role="button" data-toggle="popover" title="Líneas de Investigación" data-content="Indique los nombres de las líneas de investigación que consisten en la generación, desarrollo y aplicación de conocimientos nuevos o relevantes en un campo o disciplina, junto con sus resultados esperados, área de conocimiento y temas relacionados."></i></p>
					</div>
					<div class="row">
						<div class="separate-box col-md-6">
							<!--Describe Investigation line-->
							<p class="instruction-title">Línea de Investigación</p>
							<!--General Alert-->
							<div id="investigationAlert" class="alert alert-warning" role="alert"> Ingrese todos los campos.
							</div>
								
							<div class="row">
								<div class="form-group col-md-6">
									<label for="productSelect">Producto a generar</label>
									<select id="productSelect" class="form-control">
										<?php while($rowProductos = mysqli_fetch_array($resultProductos)): ?>
											<option><?php echo utf8_encode($rowProductos['nombre']); ?></option>
										<?php endwhile; ?>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label for="knowledgeAreaSelect">Área de Conocimiento</label>
									<select id="knowledgeAreaSelect" class="form-control">
										<?php while($rowAreasConocimiento = mysqli_fetch_array($resultAreasConocimiento)): ?>
											<option><?php echo utf8_encode($rowAreasConocimiento['nombre']); ?></option>
										<?php endwhile; ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label for="investigationNameTxt">Nombre de la Línea</label>
									<input id="investigationNameTxt" type="text" class="form-control" aria-describedby="investigationLineHelp">
								</div>
								<div class="form-group col-md-6">
									<label for="investigationTopicTxt">Temas de Investigación</label>
									<input id="investigationTopicTxt" type="text" class="form-control" aria-describedby="investigationTopicHelp">
								</div>
							</div>
							<!--Add Button-->
							<div class="row">
								<button id="addInvestigationBtn" class="btn btn-primary add-table-btn col-md-6 offset-md-3" type="button">Agregar</button>
							</div>

						</div>
						<!--Added Investigation lines-->
						<div class="col-md-6">
							<table id="investigationLineTable" class="table table-hover">
							<p class="instruction-title">Agregadas</p>
							  	<thead class="thead-dark">
									<tr>
									  	<th>Producto</th>
									  	<th>Área</th>
									  	<th>Línea</th>
									  	<th>Tema</th>
									</tr>
								</thead>
								<tbody>
									<?php while($rowInvReg = mysqli_fetch_array($resultInvReg)): ?>
							  			<tr>
							  				<td><?php echo utf8_encode($rowInvReg['pnombre']); ?></td>
							  				<td><?php echo utf8_encode($rowInvReg['anombre']); ?></td>
							  				<td><?php echo $rowInvReg['linea']; ?></td>
							  				<td><?php echo $rowInvReg['tema']; ?></td>
							  			</tr>
							  		<?php endwhile; ?>
							  	</tbody>
							</table>
						</div>
					</div>
					<form id="investigacionForm" method="post">
						<input type="hidden" name="abierto" value="true">
						<button id="saveInvestigacion" type="submit" class="btn btn-primary btn-block my-4" name="investigacionPost" value="true">
							Guardar sección
						</button>
					</form>
				</div>
			<!--******************** TUTORÍAS/TUTORIALS *********************-->
				<div id="tutorialsSection" class="tab-pane fade" role="tabpanel" aria-labelledby="tutorialsLink">
					<div>
						<p class="subsection-title">Tutorías<i tabindex="0" class="ml-3 fas fa-question-circle" role="button" data-toggle="popover" title="Tutorías" data-content="Indique las actividades que lleva a cabo como parte de su función de docente, mediante las cuales apoya a los estudiantes para superar obstáculos relacionados con su aprendizaje e  incluya a sus alumnos de tutorado."></i></p>
					</div>
					
					<div class="row">
						<div class="separate-box col-md-6">
							<p class="instruction-title">Tutorados</p>
							<!--Alert students-->
							<div id="tutorialsAlert" class="alert alert-warning" role="alert"> Ingrese todos los campos.
							</div>
		
							<div class="form-group row px-5">
								<label for="studentNameTxt">Nombre del estudiante</label>
								<input id="studentNameTxt" type="text" class="form-control" aria-describedby="studentNameHelp">
								<small id="studentNameHelp" class="form-text text-muted">Indique el nombre del estudiante de tutorado.</small>
							</div>
							<!--Add Button-->
							<div class="row">
								<button id="addStudentBtn" class="btn btn-primary add-table-btn col-md-6 offset-md-3" type="button">Agregar</button>
							</div>
						</div>
						<!--Added Students-->
						<div class="col-lg-6">
							<table id="tutorialsTable" class="table table-hover">
							<p class="instruction-title">Agregados</p>
							  	<thead class="thead-dark">
									<tr>
								 		<th>Nombre</th>
									</tr>
							  	</thead>
							  	<tbody>
							  		<?php while($rowTutReg = mysqli_fetch_array($resultTutReg)): ?>
							  			<tr>
							  				<td><?php echo $rowTutReg['alumno']; ?></td>
							  			</tr>
							  		<?php endwhile; ?>
							  	</tbody>
							</table>
						</div>
					</div>

					<!--Actividades de retención y disminución-->
					<form id="tutoriasForm" method="post">
						<div class="row col-md-8 offset-md-2 my-5">
							<div class="separate-box col-sm-6">
								<p class="row instruction-title">Actividades de Retención</p>
								<?php while($rowActRetencion = mysqli_fetch_array($resultActRetencion)): ?>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" 
											<?php if(in_array($rowActRetencion['id'], $arrayTutRetReg)){echo 'checked';} ?>
											name="actRet[]" value="<?php echo $rowActRetencion['id']; ?>">
										<label class="form-check-label"><?php echo utf8_encode($rowActRetencion['nombre']); ?></label>
									</div>
								<?php endwhile; ?>
							</div>
							<div class="separate-box col-sm-6">
								<p class="row instruction-title">Actividades de Disminución</p>
								<?php while($rowActDisminucion = mysqli_fetch_array($resultActDisminucion)): ?>
									<div class="form-check">
										<input class="form-check-input" type="checkbox"
										<?php if(in_array($rowActDisminucion['id'], $arrayTutDisReg)){echo 'checked';} ?> 
											name="actDis[]" value="<?php echo $rowActDisminucion['id']; ?>">
										<label class="form-check-label"><?php echo utf8_encode($rowActDisminucion['nombre']); ?></label>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
						<input type="hidden" name="abierto" value="true">
						<button id="saveTutorias" type="submit" class="btn btn-primary btn-block my-4" name="tutoriasPost" value="true">
							Guardar sección
						</button>
					</form>
				</div>
			<!--******************** GESTIÓN/MANAGEMENT *********************-->
				<div id="managementSection" class="tab-pane fade" role="tabpanel" aria-labelledby="managementLink">
					<div>
						<p class="subsection-title">Gestión<i tabindex="0" class="ml-3 fas fa-question-circle" role="button" data-toggle="popover" title="Gestión" data-content="Indique las actividades que planea realizar para la planeación, elaboración, aplicación y evaluación de los procesos de aprendizaje de los estudiantes y de sus programas educativos."></i></p>
					</div>
					<div class="row">
						<div class="separate-box col-lg-6">
							<p class="instruction-title">Actividad de Gestión</p>
							<!--Alert management-->
							<div id="managementAlert" class="alert alert-warning" role="alert"> Ingrese todos los campos.
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label for="managementTypeSelect">Tipo de actividad</label>
									<select id="managementTypeSelect" class="form-control">
									    <?php while($rowTiposGestion = mysqli_fetch_array($resultTiposGestion)): ?>
                                            <option><?php echo utf8_encode($rowTiposGestion['nombre']); ?></option>
										<?php endwhile; ?>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label for="managementActTxt">Nombre de la actividad</label>
									<input id="managementActTxt" type="text" class="form-control" aria-describedby="managementHelp">
								</div>
							</div>
							<!--Add Button-->
							<div class="row">
								<button id="addManagementBtn" class="btn btn-primary add-table-btn col-md-6 offset-md-3" type="button">Agregar</button>
							</div>
						</div>
						<!--Added Activities-->
						<div class="col-lg-6">
							<table id="managementTable" class="table table-hover">
							<p class="instruction-title">Agregados</p>
							  <thead class="thead-dark">
								<tr>
								  <th>Tipo</th>
								  <th>Actividad</th>
								</tr>
							  </thead>
							  <tbody>
							      <?php while($rowGesReg = mysqli_fetch_array($resultGesReg)): ?>
							  			<tr>
							  				<td><?php echo utf8_encode($rowGesReg['nombre']); ?></td>
							  				<td><?php echo $rowGesReg['descripcion']; ?></td>
							  			</tr>
							  		<?php endwhile; ?>
							  </tbody>
							</table>
						</div>
					</div>
					<form id="gestionForm" method="post">
						<input type="hidden" name="abierto" value="true">
						<button id="saveGestion" type="submit" class="btn btn-primary btn-block my-4" name="gestionPost" value="true">
							Guardar sección
						</button>
					</form>
				</div>
			<!--******************** DIFUSIÓN/DIFUSION *********************-->
				<div id="difusionSection" class="tab-pane fade" role="tabpanel" aria-labelledby="difusionLink">
					<div>
						<p class="subsection-title">Difusión<i tabindex="0" class="ml-3 fas fa-question-circle" role="button" data-toggle="popover" title="Difusión" data-content="Indique las actividades orientadas a la difusión de la institución y el conocimiento."></i></p>
					</div>
					<div class="row">
						<div class="separate-box col-lg-6">
							<p class="instruction-title">Actividad de Difusión</p>
							<!--Alert-->
							<div id="difusionAlert" class="alert alert-warning" role="alert"> Ingrese la actividad.
							</div>
		
							<div class="form-group row px-5">
								<label for="difusionActTxt">Nombre de la actividad</label>
								<input id="difusionActTxt" type="text" class="form-control" aria-describedby="managementHelp">
								<small id="difusionHelp" class="form-text text-muted">Indique el nombre de la actividad que planea realizar.</small>
							</div>
							<!--Add Button-->
							<div class="row">
								<button id="addDifusionBtn" class="btn btn-primary add-table-btn col-md-6 offset-md-3" type="button">Agregar</button>
							</div>
						</div>
						<!--Added Activities-->
						<div class="col-lg-6">
							<table id="difusionTable" class="table table-hover">
							<p class="instruction-title">Agregados</p>
							  	<thead class="thead-dark">
									<tr>
								  		<th>Actividad</th>
									</tr>
							  	</thead>
							  	<tbody>
							  		<?php while($rowDifReg = mysqli_fetch_array($resultDifReg)): ?>
							  			<tr>
							  				<td><?php echo $rowDifReg['actividad']; ?></td>
							  			</tr>
							  		<?php endwhile; ?>
							  	</tbody>
							</table>
						</div>
					</div>
					<form id="difusionForm" method="post">
						<input type="hidden" name="abierto" value="true">
						<button id="saveDifusion" type="submit" class="btn btn-primary btn-block my-4" name="difusionPost" value="true">
							Guardar sección
						</button>
					</form>
				</div>
			<!--******************** SUPERACIÓN ACADÉMICA /ACADEMIC *********************-->
				<div id="academicSection" class="tab-pane fade" role="tabpanel" aria-labelledby="academicLink">
					<div>
						<p class="subsection-title">Superación Académica<i tabindex="0" class="ml-3 fas fa-question-circle" role="button" data-toggle="popover" title="Superación Académica" data-content="Indique las actividades planeadas para su formación, actualización y crecimiento académico."></i></p>
					</div>
					<div class="row">
						<div class="separate-box col-md-6">
							<!--Describe Academic activity line-->
							<p class="instruction-title">Actividad de superación</p>
							<!--General Alert-->
							<div id="academicAlert" class="alert alert-warning" role="alert"> Ingrese todos los campos.
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label for="academicActSelect">Tipo</label>
									<select id="academicActSelect" class="form-control">
										<?php while($rowTiposSup = mysqli_fetch_array($resultTipoSup)): ?>
                                            <option><?php echo utf8_encode($rowTiposSup['nombre']); ?></option>
										<?php endwhile; ?>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label for="academicInstitutionTxt">Institución</label>
									<input id="academicInstitutionTxt" type="text" class="form-control" aria-describedby="investigationLineHelp">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-12">
									<label for="academicDescriptionTxt">Descripción</label>
									<textarea class="form-control" id="academicDescriptionTxt" rows="2"></textarea>
								</div>
							</div>
							<!--Add Button-->
							<div class="row">
								<button id="addAcademicBtn" class="btn btn-primary add-table-btn col-md-6 offset-md-3" type="button">Agregar</button>
							</div>
						</div>

						<!--Added Investigation lines-->
						<div class="col-md-6">
							<table id="academicTable" class="table table-hover">
							<p class="instruction-title">Agregadas</p>
							  	<thead class="thead-dark">
									<tr>
								  		<th>Tipo</th>
								  		<th>Institución</th>
								  		<th>Descripción</th>
									</tr>
							  	</thead>
							  	<tbody>
							  		<?php while($rowSupReg = mysqli_fetch_array($resultSupReg)): ?>
							  			<tr>
							  				<td><?php echo utf8_encode($rowSupReg['nombre']); ?></td>
							  				<td><?php echo $rowSupReg['escuela']; ?></td>
							  				<td><?php echo $rowSupReg['descripcion']; ?></td>
							  			</tr>
							  		<?php endwhile; ?>
							  	</tbody>
							</table>
						</div>
					</div>
					<form id="superacionForm" method="post">
						<input type="hidden" name="abierto" value="true">
						<button id="saveSuperacion" type="submit" class="btn btn-primary btn-block my-4" name="superacionPost" value="true">
							Guardar sección
						</button>
					</form>
				</div>

			<!--******************** TIEMPO INVERTIDO/TIME SPENT *********************-->
				<div id="timeSpentSection" class="tab-pane fade" role="tabpanel" aria-labelledby="timeSpentLink">
					<div>
						<p class="subsection-title">Tiempo Invertido<i tabindex="0" class="ml-3 fas fa-question-circle" role="button" data-toggle="popover" title="Tiempo Invertido" data-content="Señale la cantidad de tiempo que planea dedicar a cada una de las secciones anteriores."></i></p>
					</div>
					<form id="tiempoForm" method="post">
						<div class="row col-sm-6 offset-sm-3">
							<div class="col-sm-6 offset-sm-3">
								<div class="row my-3">
									<div class="col-lg-6">Docencia<i tabindex="0" class="ml-3 fas fa-question-circle" style="color:grey; height: 5px !important; width: 5px !important;" role="button" data-toggle="popover" title="Docencia" data-content="Dato se calcula automaticamente de las materias seleccionadas en la sección de Docencia."></i></div> 
									<div class="col-lg-6">
										<input class="number-box-range sub" type="number" name="horasDocencia" 
											value="<?php echo $rowHorasPlan['horas_docencia']; ?>" min="0" max="40" readonly>

									</div>
								</div>
								<div class="row my-3">
									<div class="col-lg-6">Investigación</div> 
									<div class="col-lg-6">
										<input class="number-box-range sub" type="number" name="horasInvestigacion" 
											value="<?php echo $rowHorasPlan['horas_investigacion']; ?>" min="0" max="40">
									</div>
								</div>
								<div class="row my-3">
									<div class="col-lg-6">Tutorías</div> 
									<div class="col-lg-6">
										<input class="number-box-range sub" type="number" name="horasTutoria" 
											value="<?php echo $rowHorasPlan['horas_tutoria']; ?>" min="0" max="40">
									</div>
								</div>
								<div class="row my-3">
									<div class="col-lg-6">Gestión</div> 
									<div class="col-lg-6">
										<input class="number-box-range sub" type="number" name="horasGestion" 
											value="<?php echo $rowHorasPlan['horas_gestion']; ?>" min="0" max="40">
									</div>
								</div>
								<div class="row my-3">
									<div class="col-lg-6">Difusión</div> 
									<div class="col-lg-6">
										<input class="number-box-range sub" type="number" name="horasDifusion" 
											value="<?php echo $rowHorasPlan['horas_difusion']; ?>" min="0" max="40">
									</div>
								</div>
								<div class="row my-3">
									<div class="col-lg-6">Superación</div> 
									<div class="col-lg-6">
										<input class="number-box-range sub" type="number" name="horasSuperacion" 
											value="<?php echo $rowHorasPlan['horas_superacion']; ?>" min="0" max="40">
									</div>
								</div>
								<div class="row my-3">
									<div class="col-lg-6">TOTAL</div> 
									<div class="col-lg-6">
										<input class="number-box-range" type="number" min="40" max="40" id="horasTotal" readonly>
									</div>
								</div>
							</div>
						</div>
				
						<input type="hidden" name="abierto" value="true">
						<button id="saveTiempo" type="submit" class="btn btn-primary btn-block my-4" name="tiempoPost" value="true">
							Guardar sección
						</button>
					</form>
				</div>
			<!--******************** COMENTARIOS/COMMENTS *********************-->
				<div id="commentsSection" class="tab-pane fade" role="tabpanel" aria-labelledby="commentsLink">
					<div>
						<p class="subsection-title">Comentarios<i tabindex="0" class="ml-3 fas fa-question-circle" role="button" data-toggle="popover" title="Comentarios" data-content="En caso de ser requerido, puede agregar sus comentarios en esta sección referentes al plan de trabajo anual el cuál será dirigido a su director institucional."></i></p>
					</div>
					<form id="comentariosForm" method="post">
					    <div class="row">
                            <div class="form-group col-md-6 offset-md-3">
                                <textarea name="comentarios" class="form-control" id="commentsTxt" rows="10" placeholder="Escriba aquí sus comentarios..."><?php echo $comentarioActual; ?></textarea>
                            </div>
                        </div>
                        
						<input type="hidden" name="abierto" value="true">
						<button id="saveComentarios" type="submit" class="btn btn-primary btn-block my-4" name="comentariosPost" value="true">
							Guardar sección
						</button>
					</form>
				</div>
				<!--******************** Anual Report Sections ends *********************-->
			</div>
		</div>
	</div>

</div>
	
	<script type="text/javascript" src="../vendor/jquery-3.3.1.min.js"></script>
	<?php include("../templates/dataTable.php"); ?>
	<?php include("../templates/cdnBody.php"); ?>

	<!-- Controllers -->
	<script type="text/javascript" src="../controllers/anualPlanDataTableCtrl.js"></script>
	<script type="text/javascript" src="../controllers/professorAnualPlanCtrl.js"></script>
	<script type="text/javascript" src="../controllers/generalDataTablesCtrl.js"></script>
</body>
</html>