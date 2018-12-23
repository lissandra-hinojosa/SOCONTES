$(function(){

	$("form").submit(function(e){
		var error = "";

		if($("#editNombre").val() ==  ""){
			error += "El campo Nombre es Obligarotio.<br>";
		}
		if($("#editApellidoPat").val() ==  ""){
			error += "El campo Apellido Paterno es Obligarotio.<br>";
		}
		if($("#editEmail").val() ==  ""){
			error += "El campo Correo Electrónico es Obligarotio.<br>";
		}
		if($("#editContrasena").val().length > 0){
			if($("#editContrasena").val().length < 6){
				error += "La Contraseña Nueva debe contener al menos 6 caracteres.<br>";
			}
			else if($("#editContrasena").val() != $("#editConfirmarContrasena").val()){
				error += "La Contraseña no coincide.<br>";
			}
		}
		if($("#contrasenaActual").val() == ""){
			error += "El campo Contraseña Actual es Obligatorio.<br>";
		}
		else if($("#contrasenaActual").val().length < 6){
			error += "Contraseña Actual incorrecta.<br>";
		}


		if(error == ""){
    		return true;
    	}
    	else {
    		$("#error").html(
    			'<div class="alert alert-danger" role="alert"><strong>Errores al editar perfil:</strong><br>' + error + '</div>'
    		);

    		$("html, body").animate({ scrollTop: 0 }, "slow");

    		return false;
    	}
	})
});