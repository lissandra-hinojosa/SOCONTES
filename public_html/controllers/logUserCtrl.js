$(function(){

	$("form").submit(function(e){
		var error = "";

		if($("#logEmail").val() ==  ""){
			error += "El campo Correo Electrónico es obligarotio.<br>";
		}
		if($("#logContrasena").val() == ""){
			error += "El campo Contraseña es obligatorio<br>";
		}


		if(error == ""){
    		return true;
    	}
    	else {
    		$("#error").html(
    			'<div class="alert alert-danger" role="alert"><strong>Errores al ingresar:</strong><br>' + error + '</div>'
    		);
    		$("html, body").animate({ scrollTop: 0 }, "slow");
    		return false;
    	}
	})
});