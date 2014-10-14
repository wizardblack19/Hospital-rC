<?php
	ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	//if(login_check($mysqli) != true) {
	//  header('Location: ./login?url='.dameURL());
	//}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo hospital(0);?></title>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/brain-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.jeditable.js"></script>
<script type="text/javascript" src="./js/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/forms/uniform.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/select2.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/inputmask.js"></script>
<script type="text/javascript" src="js/plugins/forms/autosize.js"></script>
<script type="text/javascript" src="js/plugins/forms/inputlimit.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/listbox.js"></script>
<script type="text/javascript" src="js/plugins/forms/multiselect.js"></script>
<script type="text/javascript" src="js/plugins/forms/validate.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/tags.min.js"></script>

<script type="text/javascript" src="js/plugins/forms/uploader/plupload.full.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/uploader/plupload.queue.min.js"></script>

<script type="text/javascript" src="js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/wysihtml5/toolbar.js"></script>

<script type="text/javascript" src="js/plugins/interface/jgrowl.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/datatables.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/prettify.js"></script>
<script type="text/javascript" src="js/plugins/interface/fancybox.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/colorpicker.js"></script>
<script type="text/javascript" src="js/plugins/interface/timepicker.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/fullcalendar.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/collapsible.min.js"></script>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>



<script type="text/javascript">
$(document).ready(function() {
     $('.textoss').editable('./system/actualizar.php?idh=<?php echo $_GET['id']?>&idc=<?php echo $_GET['idc']?>&lugar=act', {
         indicator : 'Guardando...',
         tooltip   : 'Click para editar...'
     });
 });
</script>

</head>

<body>

    <!-- Navbar -->
	<?php barra()?>
	<!-- /navbar -->


    <!-- Page header -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="logo"><a href="./" title=""><img src="images/logo.png" alt=""></a></div>

        </div>
    </div>
    <!-- /page header -->


    <!-- Page container -->
    <div class="page-container container-fluid">
    	
    	<!-- Sidebar -->
        <?php menu($_SESSION['d']['tipo']) ?>
		<!-- /sidebar -->

    
        <!-- Page content -->
        <div class="page-content">

            <!-- Page title -->
        	<div class="page-title">
                <h5><i class="fa fa-table"></i> Edición de Consultas  <small>Cualquier cambio o alteración es responsabilidad de los doctores o autores de la misma.</small></h5>
            </div>
            <!-- /page title -->
	<?php
		if($_GET['c'] and $_GET['p']){
		
		$gdata = db("SELECT * FROM `consultas` WHERE `paciente` LIKE '".$_GET['p']."' AND `consulta` LIKE '".$_GET['c']."' limit 0,1",$mysqli);
		$datap = db("SELECT * FROM `p_historial` WHERE `paciente` LIKE '".$_GET['p']."' AND `c_consulta` LIKE '".$_GET['c']."' limit 0,1",$mysqli);
		}
	?>

            <!-- Pre-scrollable table -->
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Modificando información de <?php echo $_GET['n'].$_GET['c']?></h6></div>
                <div class="table-responsive pre-scrollable">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Talla</th>
                                <th>Pulso</th>
                                <th>Peso</th>
                                <th>Diast</th>
								<th>Sisto</th>
								<th>Temp</th>
								<?php if(substr($_GET['c'], 0, 2)=="Go"){?>
                                <th>FUR</th>
                                <th>Gestas</th>
								<th>Parto</th>
                                <th>Abort</th>
                                <th>Cesaria</th>
								<?php } ?>
                                <th>HP</th>
								<th>M C</th>
                                <th>H M</th>
                                <th>E F</th>
                                <th>I C</th>
								<th>Trat</th>
                                <th>P E</th>
                                <th>Lab</th>								
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="textoss" id="talla/1"><?php echo $gdata[0]['talla']?></div></td>
                                <td><div class="textoss" id="pulso/1"><?php echo $gdata[0]['pulso']?></div></td>
                                <td><div class="textoss" id="peso/1"><?php echo $gdata[0]['peso']?></div></td>
                                <td><div class="textoss" id="diastolica/1"><?php echo $gdata[0]['diastolica']?></div></td>
                                <td><div class="textoss" id="sistolica/1"><?php echo $gdata[0]['sistolica']?></div></td>
                                <td><div class="textoss" id="temperatura/1"><?php echo $gdata[0]['temperatura']?></div></td>
								<?php if(substr($_GET['c'], 0, 2)=="Go"){?>
                                <td><div class="textoss" id="fur/1"><?php echo $gdata[0]['fur']?></div></td>
                                <td><div class="textoss" id="gestas/1"><?php echo $gdata[0]['gestas']?></div></td>
                                <td><div class="textoss" id="partos/1"><?php echo $gdata[0]['partos']?></div></td>
                                <td><div class="textoss" id="abortos/1"><?php echo $gdata[0]['abortos']?></div></td>
                                <td><div class="textoss" id="cesarias/1"><?php echo $gdata[0]['cesarias']?></div></td>
								<?php } ?>
                                <td><div class="textoss" id="rh/1"><?php echo $gdata[0]['rh']?></div></td>
                                <td><div class="textoss" id="motivo/2"><?php echo $datap[0]['motivo']?></div></td>
                                <td><div class="textoss" id="historia/2"><?php echo $datap[0]['historia']?></div></td>
                                <td><div class="textoss" id="examen_f/2"><?php echo $datap[0]['examen_f']?></div></td>
                                <td><div class="textoss" id="i_clinica/2"><?php echo $datap[0]['i_clinica']?></div></td>
                                <td><div class="textoss" id="tratamiento/2"><?php echo $datap[0]['tratamiento']?></div></td>
                                <td><div class="textoss" id="plan/2"><?php echo $datap[0]['plan']?></div></td>
                                <td><div class="textoss" id="laboratorios/2"><?php echo $datap[0]['laboratorios']?></div></td>
								
                            </tr>
                        </tbody>
                    </table>
                </div>
				
				<input class="btn btn-info btn-large print" type="button" value="Regresar" onclick="javascript:history.back();" />
				
            </div>
            <!-- /pre-scrollable table -->




            <!-- Footer -->
				<?php pie() ?>
            <!-- /footer -->
						
						
						
						
                            
                        </div>                     
                    </div>
                    <!-- /headings, Open Sans -->

        </div>
        <!-- /page content -->

    </div>
    <!-- page container -->

	
     

	
</body>
</html>

<?php
$cntACmp =ob_get_contents();
ob_end_clean();
$cntACmp=str_replace("\n",' ',$cntACmp);
$cntACmp=ereg_replace('[[:space:]]+',' ',$cntACmp);
ob_start("ob_gzhandler");
echo $cntACmp;
ob_end_flush();
?>
