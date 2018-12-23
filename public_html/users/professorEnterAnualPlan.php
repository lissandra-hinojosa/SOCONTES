<?php session_start(); ?>
<?php include(__DIR__ . "/../../resources/dbConnect.php"); ?>
<?php include("../controllers/professorDbCtrl.php"); ?>
<?php include("../controllers/enterAnualPlanDbCtrl.php"); ?>

<!DOCTYPE html>
<html>
<head>
	<?php include("../templates/cdnHead.php"); ?>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<?php include("../templates/generalNavbar.php"); ?>
	<?php include("../templates/professorNavbar.php"); ?>

	<div class="container user-container text-center">
		<!--TITLE-->
		<div class="row">
			<div class="col-md-6 offset-md-3 section-title">
				<h1>Plan de Trabajo</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<p>Abierto de <?php echo date("d/m/Y", strtotime($rowInstitucion['fecha_abre_plan'])); ?> a 
					<?php echo date("d/m/Y", strtotime($rowInstitucion['fecha_cierra_plan'])); ?>.</p>

				<?php if($abierto): ?>
					<form action="professorAnualPlan.php" method="post">
						<button class="btn btn-primary" name="abierto" value="true">Capturar Plan de Trabajo</button>
					</form>
				<?php else: ?>
					<a class="btn btn-primary disabled">Capturar Plan de Trabajo</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="../vendor/jquery-3.3.1.min.js"></script>
	<?php include("../templates/dataTable.php"); ?>
	<?php include("../templates/cdnBody.php"); ?>

	<!-- Controllers -->
	
</body>
</html>