/* This file depends on "generalDataTables.js" where you can find the general configuration parameters*/

/* NOTE "Iterate tables"
    tableVariable.rows().every( function ( rowIdx, tableLoop, rowLoop ) { //Iteration
        var rowData = this.data(); //Gets full row data
        alert(rowData[0]); //Alerts first cell of the row                         
                                        
    } );
*/

var finalRow = [];
var others = "Otro";

/***TABLES***/
//Teaching
var subjectsTable;
var selectedSubjectsTable;

//Investigation
var investigationLineTable;
        var addInvestigationBtn = $('#addInvestigationBtn');
        var knowledgeAreaSelect = $('#knowledgeAreaSelect');
        var productSelect = $('#productSelect');
        var investigationNameTxt = $('#investigationNameTxt');
        var investigationTopicTxt = $('#investigationTopicTxt');
        var otherProductModal = $('#otherProductModal');
        var otherProductName = $('#otherProductName');
        var saveOtherProductBtn = $('#saveOtherProductBtn');
        var cancelOtherProductBtn = ('#cancelOtherProductBtn');
        //Alerts
        var investigationAlert = $('#investigationAlert');
        var productsAlert = $('#productsAlert');

//Tutorials
var tutorialsTable;
        var studentNameTxt = $('#studentNameTxt');
        var addStudentBtn = $('#addStudentBtn');
        //Alerts
        var tutorialsAlert = $('#tutorialsAlert');

//Management
var managementTable;
        var managementTypeSelect = $('#managementTypeSelect');
        var managementActTxt = $('#managementActTxt');
        var addManagementBtn =$('#addManagementBtn');
        //Alerts
        var managementAlert = $('#managementAlert');

//Difusion
var difusionTable;
        var difusionActTxt = $('#difusionActTxt');
        var addDifusionBtn =$('#addDifusionBtn');
        //Alerts
        var difusionAlert = $('#difusionAlert');

//Academic
var academicTable;
        //Select
        var academicActSelect = $('#academicActSelect');
        //Txt
        var academicInstitutionTxt = $('#academicInstitutionTxt');
        var academicDescriptionTxt = $('#academicDescriptionTxt');
        var otherAcademicTypeTxt = $('#otherAcademicTypeTxt');
        //Buttons
        var addAcademicBtn = $('#addAcademicBtn');
        var cancelOtherAcademicBtn = $('#cancelOtherAcademicBtn');
        var saveOtherAcademicBtn = $('#saveOtherAcademicBtn');
        //Modal
        var otherAcademicTypeModal = $('#otherAcademicTypeModal');
        //Alerts
        var academicAlert = $('#academicAlert');
        var otherAcademicTypeAlert = $('#otherAcademicTypeAlert');



/***Tables initialisation***/
$(document).ready( function () {
    $.getScript('../controllers/generalDataTablesCtrl.js'); //loads general configuration to initialise tables
    investigationAlert.hide();
    productsAlert.hide();
    tutorialsAlert.hide();
    managementAlert.hide();
    difusionAlert.hide();
    academicAlert.hide();
    otherAcademicTypeAlert.hide();

/***************SUBJECTS TABLE****************/  
    subjectsTable = $('#subjectsTable').DataTable({
            "language":  languageSpanish,          
            select: selectMultiBlur,
            "lengthMenu": tablePageLength, 
            "sDom": oneBtnTableDom, //Dom
            "pagingType": numbersPagination,
            buttons: [
                {
                    text: 'Agregar',
                    className: 'add-table-btn',
                    action: function () {
                        addSelectToTable(subjectsTable,selectedSubjectsTable);                        
                    },
                    enabled: false
                }
            ]
    });
    oneBtnEnable(subjectsTable);

/***************SELECTED SUBJECTS TABLE****************/    
    selectedSubjectsTable = $('#selectedSubjectsTable').DataTable({
            "language":  languageSpanish,
            select: selectMultiBlur,
            "sDom": oneBtnTableDom, 
            "lengthMenu": tablePageLength,
            "pagingType": numbersPagination,
            buttons: [
                {
                    text: 'Eliminar',
                    titleAttr: 'Borrar',
                    className: 'btn-secondary',
                    action: function () {
                        removeSelectFromTable(selectedSubjectsTable);
                    },
                    enabled: false
                }
            ]
    });

    oneBtnEnable(selectedSubjectsTable); 


/***************INVESTIGATION LINE TABLE****************/
    investigationLineTable  = $('#investigationLineTable').DataTable({
            "language":  languageSpanish,
            select: selectMultiBlur,
            "sDom": oneBtnTableDom, 
            "lengthMenu": tablePageLength,
            "pagingType": numbersPagination,
            buttons: [
                {
                    text: 'Eliminar',
                    titleAttr: 'Borrar',
                    className: 'btn-secondary',
                    action: function () {
                        removeSelectFromTable(investigationLineTable);
                    },
                    enabled: false
                }
            ]
    });

    oneBtnEnable(investigationLineTable);

    productSelect.change(function() {
        if(productSelect.val() == others)
            openModal(otherProductModal);
    });


/*ADD INVESTIGATION VERIFICATIONS*/
    addInvestigationBtn.click(function(){
            investigationAlert.hide();
            productsAlert.hide();
        if( isEmptyOrSpacesString(investigationNameTxt.val()) || isEmptyOrSpacesString(investigationTopicTxt.val()) ){
            investigationAlert.show();
        }
        else if(productSelect.val() == others && isEmptyOrSpacesString(otherProductName.val())){
            productsAlert.show();
            openModal(otherProductModal);
        }         
        else{
            if(productSelect.val() == others)
                finalRow.push(otherProductName.val());
            else
                finalRow.push(productSelect.val());

            finalRow.push(knowledgeAreaSelect.val());
            finalRow.push(investigationNameTxt.val());
            finalRow.push(investigationTopicTxt.val());
            
            addRowToTable(finalRow,investigationLineTable);
            cleanTxt(investigationNameTxt);
            cleanTxt(investigationTopicTxt);
            productSelect.val($("#productSelect option:first").val());
            knowledgeAreaSelect.val($("#knowledgeAreaSelect option:first").val());

            finalRow = [];
        }
        
    });
    
/***************STUDENTS TABLE****************/
    
    tutorialsTable  = $('#tutorialsTable').DataTable({
            "language":  languageSpanish,
            select: selectMultiBlur,
            "sDom": oneBtnTableDom, 
            "lengthMenu": tablePageLength,
            "pagingType": numbersPagination,
            buttons: [
                {
                    text: 'Eliminar',
                    titleAttr: 'Borrar',
                    className: 'btn-secondary',
                    action: function () {
                        removeSelectFromTable(tutorialsTable);
                    },
                    enabled: false
                }
            ]
    });
    oneBtnEnable(tutorialsTable);

    /*ADD TUTORIALS VERIFICATIONS*/
    addStudentBtn.click(function(){
            tutorialsAlert.hide();
        if( isEmptyOrSpacesString(studentNameTxt.val())){
            tutorialsAlert.show();
        }        
        else{
            finalRow.push(studentNameTxt.val());
            addRowToTable(finalRow,tutorialsTable);
            cleanTxt(studentNameTxt);
            finalRow = [];
        }
        
    });

/***************MANAGEMENT TABLE****************/
   
    managementTable =$('#managementTable').DataTable({
            "language":  languageSpanish,
            select: selectMultiBlur,
            "sDom": oneBtnTableDom, 
            "lengthMenu": tablePageLength,
            "pagingType": numbersPagination,
            buttons: [
                {
                    text: 'Eliminar',
                    titleAttr: 'Borrar',
                    className: 'btn-secondary',
                    action: function () {
                        removeSelectFromTable(managementTable);
                    },
                    enabled: false
                }
            ]
    });
    oneBtnEnable(managementTable);

    /*ADD MANAGEMENT VERIFICATIONS*/
    addManagementBtn.click(function(){
            managementAlert.hide();
        if( isEmptyOrSpacesString(managementActTxt.val())){
            managementAlert.show();
        }        
        else{
            finalRow.push(managementTypeSelect.val());
            finalRow.push(managementActTxt.val());
            addRowToTable(finalRow,managementTable);
            cleanTxt(managementActTxt);
            managementTypeSelect.val($("#managementTypeSelect option:first").val());
            finalRow = [];
        }
        
        
    });

/***************DIFUSION TABLE****************/
   
    difusionTable = $('#difusionTable').DataTable({
            "language":  languageSpanish,
            select: selectMultiBlur,
            "sDom": oneBtnTableDom, 
            "lengthMenu": tablePageLength,
            "pagingType": numbersPagination,
            buttons: [
                {
                    text: 'Eliminar',
                    titleAttr: 'Borrar',
                    className: 'btn-secondary',
                    action: function () {
                        removeSelectFromTable(difusionTable);
                    },
                    enabled: false
                }
            ]
    });
    oneBtnEnable(difusionTable);

    /*ADD DIFUSION VERIFICATIONS*/
    addDifusionBtn.click(function(){
            difusionAlert.hide();
        if( isEmptyOrSpacesString(difusionActTxt.val()) ){
            difusionAlert.show();
        }        
        else{
            finalRow.push(difusionActTxt.val());
            addRowToTable(finalRow,difusionTable);
            cleanTxt(difusionActTxt);
            finalRow = [];
        }
        
    });

/*************** ACADEMIC TABLE****************/
    academicTable = $('#academicTable').DataTable({
            "language":  languageSpanish,
            select: selectMultiBlur,
            "sDom": oneBtnTableDom, 
            "lengthMenu": tablePageLength,
            "pagingType": numbersPagination,
            buttons: [
                {
                    text: 'Eliminar',
                    titleAttr: 'Borrar',
                    className: 'btn-secondary',
                    action: function () {
                        removeSelectFromTable(academicTable);
                    },
                    enabled: false
                }
            ]
    });

    oneBtnEnable(academicTable);

    academicActSelect.change(function() {
        if(academicActSelect.val() == others)
            openModal(otherAcademicTypeModal);
    });


    /*ADD ACADEMIC VERIFICATIONS*/
    addAcademicBtn.click(function(){
            academicAlert.hide();
            otherAcademicTypeAlert.hide();
        if( isEmptyOrSpacesString(academicInstitutionTxt.val()) ||  isEmptyOrSpacesString(academicDescriptionTxt.val()) ){
            academicAlert.show();
        }
        else if(academicActSelect.val() == others &&  isEmptyOrSpacesString(otherAcademicTypeTxt.val()) ){
            otherAcademicTypeAlert.show();
            openModal(otherAcademicTypeModal);
        }         
        else{
            if(academicActSelect.val() == others)
                finalRow.push(otherAcademicTypeTxt.val());
            else
                finalRow.push(academicActSelect.val());

            finalRow.push(academicInstitutionTxt.val());
            finalRow.push(academicDescriptionTxt.val());
            
            addRowToTable(finalRow,academicTable);
            cleanTxt(academicInstitutionTxt);
            cleanTxt(academicDescriptionTxt);
            cleanTxt(otherAcademicTypeTxt);
            academicActSelect.val($("#academicActSelect option:first").val());

            finalRow = [];
        }
        
    });


});
