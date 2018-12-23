$(function(){

	$("form").submit(function(e){
		var error = "";

		if($("#regNombre").val() ==  ""){
			error += "El campo Nombre es Obligarotio.<br>";
		}
		if($("#regApellidoPat").val() ==  ""){
			error += "El campo Apellido Paterno es Obligarotio.<br>";
		}
		if($("#regEmail").val() ==  ""){
			error += "El campo Correo Electrónico es Obligarotio.<br>";
		}
		if($("#regContrasena").val().length < 6){
			error += "La Contraseña debe contener al menos 6 caracteres.<br>";
		}
		else if($("#regContrasena").val() != $("#regConfirmarContrasena").val()){
			error += "La Contraseña no coincide.<br>"
		}
		if($("#regCodigo").val() ==  ""){
			error += "El campo Codigo de Registro es Obligarotio.<br>";
		}


		if(error == ""){
    		return true;
    	}
    	else {
    		$("#error").html(
    			'<div class="alert alert-danger" role="alert"><strong>Errores al registrarse:</strong><br>' + error + '</div>'
    		);

    		$("html, body").animate({ scrollTop: 0 }, "slow");

    		return false;
    	}
	})
});