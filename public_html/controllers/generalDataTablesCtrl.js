/*	This File contains general configuration that applies to both
	the Anual Plan and the Anual Report
	"anualPlanDataTableCtrl.js" depends on this file
	"anualReportDataTableCtrl.js" depends on this file
*/

var recordsTable;

/*************** GENERAL CONFIGURATION *******************/
var popoverConfig = {
       trigger: 'hover focus'
    }

//var oneBtnTableDom = "<'row'<'col-sm-12'f><'col-sm-12'l>r> t <'row'<'col-xl-6'p><'col-xl-6'B>>";//Elements visual location
var oneBtnTableDom = "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>> tr <'row'<'col-sm-12 col-md-5'B><'col-sm-12 col-md-7'p>>";//Elements visual location
var justRowsTableDom = "<'row'> t <'row'<'col-xl-6'B>>";
var tablePageLength = [[5, 10, 25, 35, -1], [5, 10, 25, 35, "Todos"]]; //Value and displayed option
var selectMulti = {style: 'multi'}; 
var selectSingle = {style: 'single'};
var selectMultiBlur = {style: 'multi', blurable: true}; //Blurable: Click anywhere to deselect
var selectSingleBlur = {style: 'single', blurable: true}; //Blurable: Click anywhere to deselect
var numbersPagination = "numbers";


/*************** GENERAL FUNCTIONS *******************/

function addRowToTable(array, toTable){
	//The array needs to have 1 row
	toTable.row.add(array).draw();
}

//This function doesn't allow repeated rows
function addSelectToTable( fromTable , toTable){
	var notAddedRows;
    var rows = getSelectedRows(fromTable);
   	notAddedRows = addUniqueRowsToTable(rows, toTable);
    alreadySelectedAlert(notAddedRows);
    deselectRows(fromTable);
}

/*Id must be at first position (0) of the table*/
function addUniqueIdRowToTable( row, toTable, columnPosToCompare){
    var found = false;
    toTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) { //Iteration
        var rowData = this.data(); //Gets full row data 
        if(rowData[columnPosToCompare].toLowerCase() == row[columnPosToCompare].toLowerCase()){
            found = true; 
            //break;                                                  
        }
    } );
    if(!found){
        addRowToTable(row, toTable);
        return true; //Added row
    }
    else{
        return false; //Returns false if not added
    }
}


function addUniqueRowsToTable( rowsArray, toTable){
	var toTableElements = getAllTableRows(toTable);//Elements that are already in "toTable" to prevent duplication
	var totalRows = rowsArray.length;
	var existingRows = [];//Array of NOT ADDED rows (already existing)

	for(var i=0; i<totalRows; i++){
        //console.log(rows[0][i]); //Check Array
        if(toTableElements.indexOf(rowsArray[i]) == -1 ){ //If row is not in "toTable"
            toTableElements.push(rowsArray[i]); //Add row to elements of "toTable" 
            addRowToTable(rowsArray[i], toTable); //Insert row in "toTable"
        }
        else{
            existingRows.push("\n"+rowsArray[i]); //If is already in "toTable", save it in array
        }
    }
    
    return existingRows; //Returns NOT added row (existingRows=[row1,row2])
}

function alreadySelectedAlert(array){
	if(array.length > 0 ){
        if(array.length == 1)
            array+='\nYa está seleccionada.';
        else
            array+='\nYa han sido seleccionadas.';
        alert(array);
    }
}

function alreadyWrittenAlert(){
	//Generic message
	alert('\nYa ha ingresado estos datos.');
}

//??
function arrayToString(array){
	var result = "";
	for(var i=0; i < array.length; i++){
            result += array[i]; 
            if(i != (array.length - 1) )
                result += ', '; 
        }
	return result; 
}

function deselectRows(table){
	table.rows({selected:true}).deselect();
}

function cleanTxt(id){
	id.val('');
}

function closeModal(modalId){
    modalId.modal('hide');
}

//Returns array with table rows (elements=[row1, row2, row3])
function getAllTableRows(table){
	var elements = [];//Elements that are already in "table"
	//Get all elements
    table.rows().every( function ( rowIdx, tableLoop, rowLoop ) { //Iteration                        
        rowData = this.data(); //Gets full row data
        elements.push(rowData);//Saves row in last position of array                            
    } );
    return elements; //Returns array
}

function getNumSelectedRows(table){
    return table.rows( { selected: true } ).count();
}

//Returns array
function getSelectedRows(table){
	var selectedRows = table.rows({selected:true}).data().map(function(){
		return this; //Returns selected with additional information
	});
	return selectedRows[0]; //All the selected rows are in pos 0
	//Ex: selectedRows[0][1][2]; Means: (0)All Selected rows, (1) Second Row, (2) Third cell 
}

function isEmptyOrSpacesString(str){
    return str === null || str.match(/^ *$/) !== null;
}


//Works for tables with just one button
function oneBtnEnable(table){
    table.on( 'select deselect', function () {
        var selectedRows = table.rows( { selected: true } ).count();
         table.button( 0 ).enable( selectedRows > 0 ); //Enables/Disables if something/not selected
    } );
}

function enableBtnByTable(idBtn, table){
    table.on( 'select deselect', function () {
        var selectedRows = table.rows( { selected: true } ).count();
        if(selectedRows > 0 ){
            idBtn.removeAttr("disabled");  
        }
        else{
            idBtn.attr("disabled", "disabled");
        }
    } );
}

function openModal(modalId){
	modalId.modal('show');
}

function removeSelectFromTable(table){
	//Deletes all the selected rows from "table"
    table.rows({selected:true}).remove().draw();
}


/***************************** WHEN DOCUMENT READY ******************************/
$(document).ready(function(){
	/***************RECORDS TABLE****************/ 
    recordsTable = $('#recordsTable').DataTable( {
            "language":  languageSpanish,
            "info": false
        } );

    /***************ACTIVATE POPOVER****************/
	$(function () {
	  $('[data-toggle="popover"]').popover(popoverConfig)
	});

    /*NUMBER BOX RANGE*/
    $(".number-box-range").change(function(){
        if( isEmptyOrSpacesString($(this).val()) ){
            $(this).val(0);
        }
    });

});


//LANGUAGE PLUG-IN
var languageSpanish = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":      "Primero",
        "sLast":       "Último",
        "sNext":       "Siguiente",
        "sPrevious":   "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}