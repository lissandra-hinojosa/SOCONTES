<?php session_start(); ?>
<?php include(__DIR__ . "/../../resources/dbConnect.php"); ?>
<?php include("../controllers/professorDbCtrl.php"); ?>
<?php include("../controllers/professorRecordsDbCtrl.php"); ?>

<!DOCTYPE html>
<html>
<head>
	<?php include("../templates/cdnHead.php"); ?>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<?php include("../templates/generalNavbar.php"); ?>
	<?php include("../templates/professorNavbar.php"); ?>
	
	<div class="container user-container">
		<!--TITLE-->
		<div class="col-md-6 offset-md-3 section-title">
			<h1>Historial</h1>
		</div>

		<!--Instructions Section-->
		<div class="mb-2 px-5 text-center">
			<p class="font-weight-light">En esta sección puedes buscar, ver y descargar tus Planes e Informes anuales</p>
		</div>

		<div><?php echo $success; ?></div>

  		<!--TABLE-->
		<div class="container" style="margin-top:80px;">
			<div class="row">
				<div class="col-md-10 offset-md-1">
					<table class="table table-hover" id="recordsTable">
					  	<thead class="thead-dark bg-color-blue">
					    	<tr>
						      <th>Nombre</th>
						      <th>Fecha de envío</th>
						      <th>Estado</th>
					    	</tr>
					  	</thead>
					  	<tbody>
					  		<?php while($rowPlanes = mysqli_fetch_array($resultPlanes)): ?>
					  			<tr>
						      		<td><a href="<?php echo '/../templates/createPlanPdf.php?id='.$rowPlanes['id']; ?>"
						      				target="_blank">PlanDeTrabajo<?php echo "_".$rowPlanes['yr']; ?></a></td>
						      		<td><?php echo is_null($rowPlanes['fecha_enviado'])?"No enviado":$rowPlanes['enviado']; ?></td>
						      		<td><?php echo is_null($rowPlanes['fecha_autorizado'])?"No autorizado":"Autorizado"; ?></td>
					    		</tr>
					  		<?php endwhile; ?>
					  		<?php while($rowInformes = mysqli_fetch_array($resultInformes)): ?>
					  			<tr>
						      		<td><a href="<?php echo '/../templates/createInformePdf.php?id='.$rowInformes['id']; ?>"
						      				target="_blank">InformeAnual<?php echo "_".$rowInformes['yr']; ?></a></td>
						      		<td><?php echo is_null($rowInformes['fecha_enviado'])?"No enviado":$rowInformes['enviado']; ?></td>
						      		<td><?php echo is_null($rowInformes['fecha_autorizado'])?"No autorizado":"Autorizado"; ?></td>
					    		</tr>
					  		<?php endwhile; ?>					 
					  	</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>


	<script type="text/javascript" src="../vendor/jquery-3.3.1.min.js"></script>
	<!--DATATABLE-->
	<?php include("../templates/dataTable.php"); ?>
	<script type="text/javascript" src="../controllers/generalDataTablesCtrl.js"></script>

	<?php include("../templates/cdnBody.php"); ?>
</body>
</html>
