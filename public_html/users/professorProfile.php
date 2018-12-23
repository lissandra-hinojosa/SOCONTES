<?php session_start(); ?>
<?php include(__DIR__ . "/../../resources/dbConnect.php"); ?>
<?php include("../controllers/professorDbCtrl.php"); ?>
<?php include("../controllers/userProfileDbCtrl.php"); ?>

<!DOCTYPE html>
<html>
<head>
	<?php include("../templates/cdnHead.php"); ?>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<?php include("../templates/generalNavbar.php"); ?>
	<?php include("../templates/professorNavbar.php"); ?>

	<?php include("../templates/userProfile.php"); ?>
	
	<script type="text/javascript" src="../vendor/jquery-3.3.1.min.js"></script>
	<?php include("../templates/cdnBody.php"); ?>

	<!-- Controllers -->
    <script type="text/javascript" src="../controllers/userProfileCtrl.js"></script>
</body>
</html>