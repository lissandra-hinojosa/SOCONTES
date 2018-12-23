$(function(){
	var rowData;

	// **************** DOCENCIA ***********************
	$("#saveDocencia").click(function(){
		selectedSubjectsTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) { //Iteration
	        rowData = this.data(); //Gets full row data
	        $("#docenciaForm").prepend(
	        	'<input type="hidden" name="matId'+ rowIdx +'" value="'+ rowData[0] +'">' + 
	        	'<input type="hidden" name="perId'+ rowIdx +'" value="'+ rowData[2] +'">');
	    });
	});

	// **************** INVESTIGACION ***********************
	$("#saveInvestigacion").click(function(){
		investigationLineTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) { //Iteration
	        rowData = this.data(); //Gets full row data
	        $("#investigacionForm").prepend(
	        	'<input type="hidden" name="producto'+ rowIdx +'" value="'+ rowData[0] +'">' + 
	        	'<input type="hidden" name="area'+ rowIdx +'" value="'+ rowData[1] +'">' + 
	        	'<input type="hidden" name="linea'+ rowIdx +'" value="'+ rowData[2] +'">' + 
	        	'<input type="hidden" name="tema'+ rowIdx +'" value="'+ rowData[3] +'">');
	    });
	});

	// **************** TUTORIAS ***************************
	$("#saveTutorias").click(function(){
		tutorialsTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) { //Iteration
	        rowData = this.data(); //Gets full row data
	        $("#tutoriasForm").prepend('<input type="hidden" name="alumno'+ rowIdx +'" value="'+ rowData[0] +'">');
	    });
	});

	// **************** GESTION ****************************
    $("#saveGestion").click(function(){
        managementTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) { //Iteration
	        rowData = this.data(); //Gets full row data
	        $("#gestionForm").prepend(
                '<input type="hidden" name="tipoActDif'+ rowIdx +'" value="'+ rowData[0] +'">' +
                '<input type="hidden" name="actDif'+ rowIdx +'" value="'+ rowData[1] +'">');
	    });
    });
    
	// **************** DIFUSION ***************************
	$("#saveDifusion").click(function(){
		difusionTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) { //Iteration
	        rowData = this.data(); //Gets full row data
	        $("#difusionForm").prepend('<input type="hidden" name="actDif'+ rowIdx +'" value="'+ rowData[0] +'">');
	    });
	});
	// **************** SUPERACION ACADEMICA ****************
	$("#saveSuperacion").click(function(){
		academicTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) { //Iteration
	        rowData = this.data(); //Gets full row data
	        $("#superacionForm").prepend(
	        	'<input type="hidden" name="tipo'+ rowIdx +'" value="'+ rowData[0] +'">' +
	        	'<input type="hidden" name="inst'+ rowIdx +'" value="'+ rowData[1] +'">' +
	        	'<input type="hidden" name="desc'+ rowIdx +'" value="'+ rowData[2] +'">');
	    });
	});

	// **************** TIEMPO INVERTIDO *******************
	function getTotal(){
		var totalHoras = parseInt($("input[name='horasDocencia']").val()) +
		parseInt($("input[name='horasInvestigacion']").val()) +
		parseInt($("input[name='horasTutoria']").val()) +
		parseInt($("input[name='horasGestion']").val()) +
		parseInt($("input[name='horasDifusion']").val()) +
		parseInt($("input[name='horasSuperacion']").val());

		$("#horasTotal").val(totalHoras.toString());
	}

	getTotal();
	$(".sub").change(function(){
		getTotal();
	});
    

	// **************** COMENTARIOS ***********************
        //NO TABLES

});