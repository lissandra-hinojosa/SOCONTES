<?php 
include(__DIR__ . "/../../resources/dbConnect.php");

// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once ('../vendor/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

//  ************************** QUERIES ****************************
date_default_timezone_set("America/Mexico_City");

$idPlan = $_GET['id'];

$queryInfo = "SELECT u.institucion_id, CONCAT(u.nombre, ' ', u.apellido_pat, ' ', u.apellido_mat) AS maestro, YEAR(ia.fecha_inicio) AS anio, u.email
	FROM planes_de_trabajo ia JOIN usuarios u ON u.id = ia.usuario_id WHERE ia.id = $idPlan";
$resultInfo = mysqli_query($link, $queryInfo);
$rowInfo = mysqli_fetch_array($resultInfo);
$idInstitucion = $rowInfo['institucion_id'];

// -------------- $maestro & $correo
$maestro = $rowInfo['maestro'];
$correo = $rowInfo['email'];

// -------------- $logo
$queryLogo = "SELECT logo, nombre FROM instituciones WHERE id = $idInstitucion";
$resultLogo = mysqli_query($link, $queryLogo);
$rowLogo = mysqli_fetch_array($resultLogo);
if(is_null($rowLogo['logo'])){
  $logo = "../uploads/logos/default.png";
}
else {
  $logo = "../uploads/logos/".$rowLogo['logo'];
}

// -------------- $nombreInstitucion
$nombreInstitucion = $rowLogo['nombre'];

// -------------- $anio
$anio = $rowInfo['anio'];

// -------------- $materias
$materias = "";
$queryPeriodos = "SELECT * FROM periodos WHERE institucion_id = $idInstitucion ORDER BY id ASC";
$resultPeriodos = mysqli_query($link, $queryPeriodos);
while($rowPeriodos = mysqli_fetch_array($resultPeriodos)){
	$materias .= "<dt>Periodo ".$rowPeriodos['descripcion'].":</dt>";

	$queryMaterias = "SELECT m.nombre, m.id FROM plan_tiene_materias im
		JOIN materias m ON m.id = im.materia_id
		WHERE plan_de_trabajo_id = $idPlan AND periodo_id = ".$rowPeriodos['id'];
	$resultMaterias = mysqli_query($link, $queryMaterias);
	while($rowMaterias = mysqli_fetch_array($resultMaterias)){
		$materias .= "<dd>".$rowMaterias['nombre']." con clave ".$rowMaterias['id']."</dd>";
	}
}

// -------------- $lineas
$lineas = "";
$queryLineas = "SELECT ip.tema, ip.linea, a.nombre AS area, p.nombre AS producto
	FROM plan_tiene_productos ip
	JOIN areas_conocimiento a ON a.id = ip.area_conocimiento_id
	JOIN tipos_producto p ON p.id = ip.tipo_producto_id
	WHERE ip.plan_de_trabajo_id = $idPlan";
$resultLineas = mysqli_query($link, $queryLineas);
$num = 1;
while($rowLineas = mysqli_fetch_array($resultLineas)){
	$lineas .= "<dt>Línea de Investigación ".$num." :</dt>
		<dd>Producto: ".utf8_encode($rowLineas['producto'])."</dd>
		<dd>Área: ".utf8_encode($rowLineas['area'])."</dd>
		<dd>Línea: ".$rowLineas['linea']."</dd>
		<dd>Tema: ".$rowLineas['tema']."</dd>";
	$num++;
}


// -------------- $tutorados
$tutorados = "";
$queryTutorados = "SELECT * FROM alumnos_tutoria_plan WHERE plan_de_trabajo_id = $idPlan";
$resultTutorados = mysqli_query($link, $queryTutorados);
while($rowTutorados = mysqli_fetch_array($resultTutorados)){
	$tutorados .= "<li>".$rowTutorados['alumno']."</li>";
}


// -------------- $actRetencion
$actRetencion = "";
$queryActRetencion = "SELECT ar.nombre FROM plan_tiene_actividades_retencion iar
	JOIN actividades_retencion ar ON ar.id = iar.actividad_retencion_id
	WHERE plan_de_trabajo_id = $idPlan";
$resultActRetencion = mysqli_query($link, $queryActRetencion);
while($rowActRetencion = mysqli_fetch_array($resultActRetencion)){
	$actRetencion .= "<li>".utf8_encode($rowActRetencion['nombre'])."</li>";
}

// -------------- $actDisminucion
$actDisminucion = "";
$queryActDisminucion = "SELECT ar.nombre FROM plan_tiene_actividades_disminucion iar
	JOIN actividades_disminucion ar ON ar.id = iar.actividad_disminucion_id
	WHERE iar.plan_de_trabajo_id = $idPlan";
$resultActDisminucion = mysqli_query($link, $queryActDisminucion);
while($rowActDisminucion = mysqli_fetch_array($resultActDisminucion)){
	$actDisminucion .= "<li>".utf8_encode($rowActDisminucion['nombre'])."</li>";
}

// -------------- $gestion
$gestion = "";
$queryGestion = "SELECT g.nombre, ig.descripcion FROM plan_tiene_tipos_gestion ig
	JOIN tipos_gestion g ON g.id = ig.tipo_gestion_id
	WHERE ig.plan_de_trabajo_id = $idPlan";
$resultGestion = mysqli_query($link, $queryGestion);
while($rowGestion = mysqli_fetch_array($resultGestion)){
	$gestion .= "<li>".$rowGestion['descripcion']." para ".utf8_encode($rowGestion['nombre'])."</li>";
}

// -------------- $difusion
$difusion = "";
$queryDifusion = "SELECT actividad FROM actividades_difusion_plan WHERE plan_de_trabajo_id = $idPlan";
$resultDifusion = mysqli_query($link, $queryDifusion);
while($rowDifusion = mysqli_fetch_array($resultDifusion)){
	$difusion .= "<li>".$rowDifusion['actividad']."</li>";
}

// -------------- $superacion
$superacion = "";
$querySuperacion = "SELECT ig.nombre AS tipo, ig.escuela, g.nombre FROM plan_tiene_tipos_superacion ig
	JOIN tipos_superacion_academica g ON g.id = ig.tipo_superacion_academica_id
	WHERE ig.plan_de_trabajo_id = $idPlan";
$resultSuperacion = mysqli_query($link, $querySuperacion);
while($rowSuperacion = mysqli_fetch_array($resultSuperacion)){
	$superacion .= "<li>".utf8_encode($rowSuperacion['nombre'])." ".$rowSuperacion['tipo']." en ".$rowSuperacion['escuela']."</li>";
}

// -------------- $tiempo
$queryTiempo = "SELECT * FROM planes_de_trabajo WHERE id = $idPlan";
$resultTiempo = mysqli_query($link, $queryTiempo);
$rowTiempo = mysqli_fetch_array($resultTiempo);
$tiempo = "<li><span class='bold'>Docencia: </span>".$rowTiempo['horas_docencia']." horas</li>
	<li><span class='bold'>Investigación: </span>".$rowTiempo['horas_investigacion']." horas</li>
	<li><span class='bold'>Tutorías: </span>".$rowTiempo['horas_tutoria']." horas</li>
	<li><span class='bold'>Gestión: </span>".$rowTiempo['horas_gestion']." horas</li>
	<li><span class='bold'>Difusión: </span>".$rowTiempo['horas_difusion']." horas</li>
	<li><span class='bold'>Superación: </span>".$rowTiempo['horas_superacion']." horas</li>";

// -------------- $comentarios
$comentarios = $rowTiempo['comentarios'];

//

// ***************************************************************

$html ='
<!DOCTYPE html>
<html>

  <head>
  	  <title>Plan de Trabajo</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <!--<link media="all" type="text/css" rel="stylesheet" href="../css/pdf.css">-->

      <style type="text/css">


        @page { margin: 160px 50px;}
        #header { position: fixed; left: 0px; top: -145px; right: 0px; height: 110px;
          text-align: center; margin-top:30px; padding-top: 20px; margin-bottom: 0px !important;}
        #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 100px;}
        #footer .page:after { content: counter(page, decimal); }

        .avoid-page-break{
          page-break-inside: avoid;
        }

        .bold{
          font-weight: bold;
          margin-top: 5px; 
        }

        .bottom-blue-border{
          margin-bottom: 10px !important;
          border-bottom: 1px solid #337AB7;
        }

        .box{
          border: .7px solid #337AB7;
          border-radius: 5px;
          padding: 10px;
        }

        .main{
          margin: 0px 50px;
        }
        .main-text{
          font-size: 15px;
        }

        .float-left {
          float: left !important;
        }

        .float-right {
          float: right !important;
        }

        hr{
          color: #e2e4e5;
          margin-top: 30px;
          margin-bottom: 20px;
        }

        .justify{
          text-align: justify;
        }
        dt{
          font-weight: bold;
          margin-top: 5px; 
        }

        li, ul, dt,dl{
          margin: 0px !important;
          padding: 0px !important;
        }

        li,ul,dt,dd{
          font-size: 13px;
        }

        .logo{
          height: 65px;
          width: 65px;
          float: left;
          margin: 10px; 
        }

        .muted-text{
          color: grey;
        }

        .row {
            clear: both;
        }

        .text-right {
          text-align: right;
        }

        .text-center {
          text-align: center;
        }

        .text-left {
          text-align: left;
        }
        .header-text{ 
          margin-top: 20px;
          font-size: 20px;
          font-weight: bold;

        }
        .section-title{
          font-size: 1.2rem;
          font-weight: bold;
          margin-bottom: 15px;
        }

        .subsection-title{
          font-size: .9rem;
          font-weight: bold;
          margin-bottom: 14px;
        }

        .subsection{
          page-break-inside: avoid;
          margin: 0px 0px 0px 0px;
        }

        .signature-left {
          border-collapse: collapse;
          border-spacing: 0;
          float: left;
          height: 30px;
          padding: 70px 2px 2px 2px;
          page-break-inside: avoid;
          text-align: center;
          width: 30%;
          position: fixed; bottom:0px;
        }
        .signature-right {
          border-collapse: collapse;
          border-spacing: 0;
          float: right;
          height: 30px;
          padding: 70px 2px 2px 2px;
          page-break-inside: avoid;
          text-align: center;
          width: 30%;
          position: fixed; bottom:0px;
        }

        .name {
          border-collapse: collapse;
          border-spacing: 0;
          border-top: 1px solid black;
          page-break-inside: avoid;
          text-align: center;
        }

      </style>

  </head>

  <body>
<!--HEADER-->
    <div id="header" class="bottom-blue-border">
      <div>
        <img class="logo" src="'.$logo.'" height="55px" alt="Logo de la Institución">
      </div>
      <div class="float-right muted-text" style="font-size: 12px;">'.date("d/m/Y").' - '.date("h:i:s").'</div>
      <div class="header-text">Plan de trabajo anual - '.$anio.'</div>
      <div>'.$nombreInstitucion.'</div>
      <div class="muted-text" style="margin-top: 10px; font-size: 15px;">Profesor: '.$maestro.' <span style="margin-left:15px">Email:'.$correo.'</span></div>
    </div>
<!--FOOTER-->
    <div id="footer">
      <p class="page text-center muted-text">Página </p>
    </div>
<!--CONTENT-->
    <div id="content" class="main">
      <div class="avoid-page-break">
        <div class="text-center section-title">Descripción</div>
        <div class="justify main-text">
          El Plan anual de trabajo es un instrumento necesario para que '.$nombreInstitucion.' en coordinación con directores de carrera y el personal académico, organicen el trabajo individual en las actividades de <span class="bold">docencia, investigación, tutoría, gestión, difusión y superación académica</span> en apego a las metas institucionales.
        </div>
      </div>
      <hr>

<!--DOCENCIA-->
      <div>
        <div class="avoid-page-break">
          <div class="section-title">Docencia</div>
          <?php echo "Hola soy php"; ?>
          <div class="justify main-text">
            Es el conjunto de actividades que el proferor planea, dirige y evalúa, que están orientadas a impulsar el autoaprendizaje y la consecución de la formación integral del estudiante.
          </div>
        </div>
        <div class="subsection">
          <p class="subsection-title">1. Materias</p>
          <div class="box">
               '.$materias.' 
          </div>
        </div>
      </div>

      <hr>
<!--INVESTIGACION-->
      <div>
        <div class="avoid-page-break">
          <div class="section-title">Investigación</div>
          <div class="justify main-text">
            Función que realizan los profesores de tiempo completo y que consiste en la generación, desarrollo y aplicación de conocimientos nuevos o relevantes en un campo o disciplina existente, y que son resultado de la participación activa en cuerpos académicos a través de líneas generales de aplicación del conocimiento.
          </div>
        </div>
        <div class="subsection">
          <p class="subsection-title">1. Líneas de Investigación</p>
          <div class="box">
            <dl>
               '.$lineas.'
            </dl> 
          </div>
        </div>
      </div>
      <hr>
<!--TUTORÍAS-->
      <div>
        <div class="avoid-page-break">
          <div class="section-title">Actividades de tutelaje</div>
          <div class="justify main-text">
            Actividades que lleva a cabo como parte de su función de docente, mediante las cuales apoya a los estudiantes a superar obstáculos que frenan su aprendizaje, orientándolo personalmente y/o canalizándolo a los servicios que ofrece la Universidad.
          </div>
        </div>
        <div class="subsection">
          <p class="subsection-title">1. Tutorados</p>
          <div class="box">
            <ul style="list-style-type:none">
                '.$tutorados.'
            </ul> 
          </div>
        </div>
        <div class="subsection">
          <p class="subsection-title">3. Actividades de retención de alumnos</p>
          <div class="box">
            <ul style="list-style-type:none">
                '.$actRetencion.'
            </ul> 
          </div>
        </div>
        <div class="subsection">
          <p class="subsection-title">4. Actividades para la disminución de reprobación de alumnos</p>
          <div class="box">
            <ul style="list-style-type:none">
                '.$actDisminucion.'
            </ul> 
          </div>
        </div>
      </div>

      <hr>

<!--GESTIÓN-->
      <div>
        <div class="avoid-page-break">
          <div class="section-title">Actividades de gestión académica</div>
          <div class="justify main-text">
            Planeación y evaluación de los procesos de aprendizaje de los estudiantes, la elaboración de sus programas educativos y de los cursos, la elaboración, aplicación y evaluación de las competencias, la participación en múltiples y diversas comisiones y comités de su cuerpo académico o academia.
          </div>
        </div>
        <div class="subsection">
          <p class="subsection-title">1. Gestión académica</p>
          <div class="box">
            <ul style="list-style-type:none">
                '.$gestion.'
            </ul> 
          </div>
        </div>
      </div>

      <hr>

<!--DIFUSIÓN-->
      <div>
        <div class="avoid-page-break">
          <div class="section-title">Actividades de difusión académica</div>
          <div class="justify main-text">
            Actividades orientadas a la difusión de la institución y el conocimiento, mediante la participación de conferencias, seminarios, congresos, cursos, talleres, etc.
          </div>
        </div>
        <div class="subsection">
          <p class="subsection-title">1. Difusión académica</p>
          <div class="box">
            <ul style="list-style-type:none">
                '.$difusion.'
            </ul> 
          </div>
        </div>
      </div>

      <hr>

<!--SUPERACIÓN ACADÉMICA-->
      <div>
        <div class="avoid-page-break">
          <div class="section-title">Actividades de superación académica</div>
          <div class="justify main-text">
            Es el proceso permanente de formación, actualización e intercambio académico para consolidar el perfil del personal académico y en conssecuencia, el logro del eje estratégico institucional de impulsar la consolidación de los cuerpos académicos y fortalecimiento de la planta académica.
          </div>
        </div>
        <div class="subsection">
          <p class="subsection-title">1. Difusión académica</p>
          <div class="box">
            <ul style="list-style-type:none">
                '.$superacion.'
            </ul> 
          </div>
        </div>
      </div>

      <hr>

<!--TIEMPO INVERTIDO-->
      <div>
        <div class="avoid-page-break">
          <div class="section-title">Tiempo Invertido</div>
          <div class="justify main-text">
            Cantidad de tiempo que planea dedicar cada una de las secciones anteriores.
          </div>
        </div>
        <div class="subsection">
          <p class="subsection-title">1. Distribución de tiempos</p>
          <div class="box">
            <ul style="list-style-type:none">
            	'.$tiempo.'
            </ul> 
          </div>
        </div>
      </div>

      <hr>

<!--COMENTARIOS-->
      <div>
        <div class="avoid-page-break">
          <div class="section-title">Comentarios</div>
          <div class="justify main-text" style="margin-bottom: 10px;">
            Comentarios referentes al plan de trabajo anual.
          </div>
        </div>
        <div class="subsection">
          <div class="box" style="margin-bottom: 15px;">
            '.$comentarios.'
          </div>
        </div>
      </div>

<!--End main-->
		<div style="margin-top:30px;">
	        <div class="signature-left">
	          <div class="name">
	            Firma del director de división
	          </div>
	        </div>
	        <div class="signature-right">
	          <div class="name">
	            Firma del profesor
	          </div>
	        </div>
        </div>

      </div>

      <!--<p style="page-break-before: always;">the second page</p>-->
    </div>

  </body>

</html>

';

utf8_decode($html);
// Instanciamos un objeto de la clase DOMPDF.
$pdf = new DOMPDF();
 
// Definimos el tamaño y orientación del papel que queremos.
$pdf->set_paper("A4", "portrait");
 
// Cargamos el contenido HTML.
$pdf->load_html($html, 'UTF-8');
 
// Renderizamos el documento PDF.
$pdf->render();
 
// Enviamos el fichero PDF al navegador.
$pdf->stream('my.pdf',array('Attachment'=>0));

?>