<?php include("../controllers/profileFileDbCtrl.php"); ?>
<nav class="navbar navbar-collapse shadow p-2 mb-4 bg-white rounded" id="generalNavbar">
	<a class="navbar-brand mx-3" href="#">		
		<!--Institution's logo-->
		<img src="<?php echo is_null($rowInstitucion['logo'])?'../uploads/logos/default.png':'../uploads/logos/'.$rowInstitucion['logo']; ?>" height="55px" alt="Logo de la Insitución">

		<!--Institution's name-->
		<div class="institution-name text-capitalize"><?php echo $rowInstitucion['nombre']; ?></div>
	</a>

	<!--Username-->
	<div class="dropdown" style="position: relative; z-index: 1000;">
		<a class="mx-4 dropdown-toggle" href="#" role="button" id="userLogDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black;"><?php echo $rowUsuario['nombre']; ?></a>
	  	<div class="dropdown-menu" aria-labelledby="userLogDropdown">
	    	<a class="dropdown-item" href="<?php echo '../users/' . $profileFile ?>">Perfil</a>
	    	<div class="dropdown-divider">
	    	</div>
  			<a class="dropdown-item" href="../controllers/closeSession.php">Cerrar Sesión</a>
		</div>
	</div>




</nav>