<?php
	ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	if(login_check($mysqli) != true) {
	   header('Location: ./login?url='.dameURL());
	}
	$V=new EnLetras();
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
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="./js/jquery.min.js"></script>
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
<link rel="stylesheet" href="./api/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="./api/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
		
	<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto();
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
            <div class="logo"><a class="print" href="./" ><img class="print" src="images/logo.png" /></a></div>

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
	
	
	
	
	
	


	
	
	
	
            <!-- Form components -->
            <form class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF'] ?>?cod=<?php echo $_GET['cod'] ?>" method="post" enctype="multipart/form-data">
                <!-- Styled form components -->
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Cargar imagenes</h6></div>
                    <div class="panel-body">
					
						<div class="form-group">
                            <label class="col-sm-2 control-label">Tipo de Laboratorio: </label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <input type="radio" name="tipo" value="papanicolau" class="styled" checked>
                                    papanicolau
                                </label><!--
                                <label class="radio-inline">
                                    <input type="radio" name="inline-radio" class="styled" checked="checked">
                                    Checked
                                </label>
                                <label class="disabled radio-inline">
                                    <input type="radio" class="styled" checked="checked" disabled="disabled">
                                    Disabled
                                </label>-->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Por favor selecciones la imagen: </label>
                            <div class="col-sm-10">
                                <input name="fichero" type="file" class="styled">
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button name="submit" type="submit" class="btn btn-primary">Agregar Laboratorio</button>
                        </div>
                    </div>
                </div>
                <!-- /styled form components -->
            </form>
            <!-- /form components -->
		
	<?php
	if (isset($_POST['submit'])){
		if(is_uploaded_file($_FILES['fichero']['tmp_name'])) { // verifica haya sido cargado el archivo
			$rename = "papanicolao/".date('Ymd_His').$_FILES['fichero']['name'];
			//Insertar en labimg
			$paciente = $_GET['cod'];
			$name = date('Ymd_His').$_FILES['fichero']['name'];
			$tipo = $_POST['tipo'];
			if ($seguimiento = $mysqli->prepare("INSERT INTO labimg (paciente, imagen, tipo) VALUES (?,?,?)")) {
		   $seguimiento->bind_param('sss', $paciente, $name, $tipo);
		   $seguimiento->execute();
	}
			
			
			if(move_uploaded_file($_FILES['fichero']['tmp_name'], $rename)) { // se coloca en su lugar final
				echo "<b>Carga exitosa!. <br /> Datos:</b><br />";
				echo "Nombre: <i><a href=\"".$rename."\" rel=\"prettyPhoto[]\" >".$rename."</a></i><br />";
				echo "Tipo MIME: <i>".$_FILES['fichero']['type']."</i><br />";
				echo "Peso: <i>".$_FILES['fichero']['size']." bytes</i><br />";
				echo "<br><hr><br>";
			}
		}
	}
	?> 
		
		
		
		
		
		<!-- Footer -->
			<?php pie() ?>
		<!-- /footer -->
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
