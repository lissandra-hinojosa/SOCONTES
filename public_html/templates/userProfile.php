<div class="container user-container">
		<!--TITLE-->
		<div class="col-md-6 offset-md-3 section-title">
			<h1>Perfil</h1>
		</div>

		<form class="py-2" method="post">
            <!--Errores-->
            <div id="error"><?php echo $error.$success; ?></div>

            <!--Nombre-->
            <div class="form-group py-1">
                <label for="editNombre">Nombre(s)</label>
                <input type="text" class="form-control" id="editNombre" name="nombre" 
                	value="<?php echo $rowUsuario['nombre']; ?>">
            </div>

            <!--Apellidos-->
            <div class="form-group py-1">
                <label for="editApellidoPat">Apellido Paterno</label>
                <input type="text" class="form-control" id="editApellidoPat" name="apellidoPat"
                	value="<?php echo $rowUsuario['apellido_pat']; ?>">
            </div>
            <div class="form-group py-1">
                <label for="editApellidoMat">Apellido Materno</label>
                <input type="text" class="form-control" id="editApellidoMat" name="apellidoMat"
                	value="<?php echo $rowUsuario['apellido_mat']; ?>">
            </div>

            <!--Division-->
            <div class="form-group">
                <label for="editDivision">Division</label>
                <select class="form-control" id="editDivision" name="divisionId">
                    <?php while($rowDivisiones = mysqli_fetch_array($resultDivisiones)): ?>
                        <option value="<?php echo $rowDivisiones['id']; ?>"
                        	<?php if($rowDivisiones['id'] == $rowUsuario['division_id']){echo 'selected';} ?>>
                            <?php echo $rowDivisiones['nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!--Correo-->
            <div class="form-group py-1">
                <label for="editEmail">Correo Electrónico</label>
                <input type="email" class="form-control" id="editEmail" name="email"
                	value="<?php echo $rowUsuario['email']; ?>">
            </div>

            <!--Contraseñas-->
            <div class="form-group py-1">
                <label for="editContrasena">Contraseña Nueva</label>
                <input type="password" class="form-control" id="editContrasena" name="contrasenaNueva">
            </div>
            <div class="form-group py-1">
                <label for="editConfirmarContrasena">Confirmar Contraseña Nueva</label>
                <input type="password" class="form-control" id="editConfirmarContrasena">
            </div>

            <hr class="my-5">

            <div class="form-group py-1">
                <label for="contrasenaActual">Contraseña Actual</label>
                <input type="password" class="form-control" id="contrasenaActual" name="contrasenaActual">
            </div>

            <!--Editar Perfil/Cancelar-->
            <div class="form-group my-3">
                <button type="submit" class="btn btn-lg  btn-primary bg-color-blue mr-2">
                    Editar Perfil
                </button>
                <?php if($_SESSION['tipoUsuarioId'] == 1): ?>
                    <a href="professorRecords.php" class="btn btn-lg btn-secondary">Cancelar</a>
                <?php endif; ?>
                <?php if($_SESSION['tipoUsuarioId'] == 2): ?>
                    <a href="assistantStats.php" class="btn btn-lg btn-secondary">Cancelar</a>
                <?php endif; ?>
                <?php if($_SESSION['tipoUsuarioId'] == 3): ?>
                    <a href="directorPlans.php" class="btn btn-lg btn-secondary">Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
	</div>