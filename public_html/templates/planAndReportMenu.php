<!--******************** VERTICAL NAVBAR*********************-->
	<!--AP = Anual Plan-->
	<div class="sticky-top">
		<div class="row">
			<div class="col-sm-12">
			    <div id="anualPlanLinks" class="list-group" role="tablist">
			      <a id="teachingLink" class="row list-group-item list-group-item-action active" data-toggle="list" href="#teachingSection" role="tab"><i class="fas fa-book"></i>Docencia<?php if($finDocencia){echo '<i class="fas fa-check"></i>';} ?></a>
			      <a id="investigationLink" class="row list-group-item list-group-item-action" data-toggle="list" href="#investigationSection" role="tab"><i class="fas fa-search"></i>Investigación<?php if($finInvestigacion){echo '<i class="fas fa-check"></i>';} ?></a>
			      <a id="tutorialsLink" class="row list-group-item list-group-item-action" data-toggle="list" href="#tutorialsSection" role="tab"><i class="fas fa-apple-alt"></i>Tutorías<?php if($finTutoria){echo '<i class="fas fa-check"></i>';} ?></a>
			      <a id="managementLink" class="row list-group-item list-group-item-action" data-toggle="list" href="#managementSection" role="tab"><i class="fas fa-calendar-alt"></i>Gestión<?php if($finGestion){echo '<i class="fas fa-check"></i>';} ?></a>
			      <a id="difusionLink" class="row list-group-item list-group-item-action" data-toggle="list" href="#difusionSection" role="tab"><i class="fas fa-bullhorn"></i>Difusión<?php if($finDifusion){echo '<i class="fas fa-check"></i>';} ?></a>
			      <a id="academicLink" class="row list-group-item list-group-item-action" data-toggle="list" href="#academicSection" role="tab"><i class="fas fa-graduation-cap"></i>Superación<?php if($finSuperacion){echo '<i class="fas fa-check"></i>';} ?></a>
			      <a id="timeSpentLink" class="row list-group-item list-group-item-action" data-toggle="list" href="#timeSpentSection" role="tab"><i class="fas fa-clock"></i>Tiempo<?php if($finTiempo){echo '<i class="fas fa-check"></i>';} ?></a>
			      <a id="commentsLink" class="row list-group-item list-group-item-action" data-toggle="list" href="#commentsSection" role="tab"><i class="fas fa-comment"></i>Comentarios<?php if($finComentarios){echo '<i class="fas fa-check"></i>';} ?></a>
			    </div>
			</div>
		</div>
		<!--General Buttons-->
		<hr>
		<?php if($reporte == "plan"): ?>
			<div class="row m-3">
					<a id="print" target="_blank"
						href="<?php echo '/../templates/createPlanPdf.php?id='.$rowPlanActual['id']; ?>" 
						class="<?php echo 'left-nav-btn btn btn-outline-secondary '; echo ($terminado)?'':'disabled'; ?>">
						<i class="fas fa-print"></i>Imprimir</a>
			</div>
			<div class="row m-3">
				<form method="post" action="/users/professorRecords.php">
					<input type="hidden" name="reportType" value="plan">
	  				<button id="saveAndSend" type="submit" name="reportId" value="<?php echo $rowPlanActual['id']; ?>"
	  					class="<?php echo 'left-nav-btn btn btn-outline-secondary '; echo ($terminado)?'':'disabled'; ?>">
	  					<i class="fas fa-share-square"></i>Terminar y enviar</button>
	  			</form>
			</div>
		<?php else: ?>
			<div class="row m-3">
					<a id="print" target="_blank"
						href="<?php echo '/../templates/createInformePdf.php?id='.$rowInformeActual['id']; ?>"  
						class="<?php echo 'left-nav-btn btn btn-outline-secondary '; echo ($terminado)?'':'disabled'; ?>">
						<i class="fas fa-print"></i>Imprimir</a>
			</div>
			<div class="row m-3">
				<form method="post" action="/users/professorRecords.php">
					<input type="hidden" name="reportType" value="informe">
	  				<button id="saveAndSend" type="submit" name="reportId" value="<?php echo $rowInformeActual['id']; ?>"
	  					class="<?php echo 'left-nav-btn btn btn-outline-secondary '; echo ($terminado)?'':'disabled'; ?>">
	  					<i class="fas fa-share-square"></i>Terminar y enviar</button>
	  			</form>
			</div>
		<?php endif; ?>
	</div>