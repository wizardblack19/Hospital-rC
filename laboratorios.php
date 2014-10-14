<?php
	ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	if(login_check($mysqli) != true) {
	   header('Location: ./login?url='.dameURL());
	}

	
	
	
	
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
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/fonts/cuprum.css" rel="stylesheet" type="text/css">

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


	<script type="text/javascript">
		function cargar(div, desde)
		{
			$(div).load(desde);
		}
		setInterval( "cargar('#divtest', 'colab.php?r=<?php echo $_GET['r']?>&c=<?php echo $_GET['c']?>&id=<?php echo $_GET['id']?>')", 2000 );
	</script>
</head>



<body>

    <!-- Navbar -->
	<?php barra()?>
	<!-- /navbar -->


    <!-- Page header -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="logo"><a href="index.html" title=""><img src="images/logo.png" alt=""></a></div>

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



			<!-- Headings, Open Sans -->
                    <div class="panel panel-default">
                        <div class="panel-heading print"><h6 class="panel-title">Información general de pacientes</h6></div>
                        <div class="panel-body">

						
						
						
						
						
						
						
			<div class="row">
				<!-- col -->
				
				<?php 
				if ($_GET['r'] == "release" || !$_GET['t']){?>
					<div class="col-sm-9">
						<img src="./images/lab.jpg" width="100%"/>
					</div>
				
				<?php }else { ?>
				<div class="col-sm-9">
					<?php 
					$lab = db("SELECT * FROM `laboratorios` WHERE `codigo` LIKE '".$_GET['t']."'",$mysqli);
					
					
					
					?>
					
					<form class="form-horizontal" role="form" action="#" method="post" autocomplete="off">	
					
					<h1><?php echo $lab[0]['nombre']?></h1>		
					
					<textarea width="100%"  rows="20"></textarea>
					
					
					<p style="color:red;"><?php echo $lab[0]['tipomuestra']?> - <?php echo $lab[0]['colortapon']?></p>
					
					
						<div class="form-group">
							<label class="col-sm-2 control-label">Cassette: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" name="motivo" placeholder="Mililitros" />
							</div>
							
							<label class="col-sm-2 control-label">Blanco: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" name="motivo" placeholder="00" />
							</div>
							
							<label class="col-sm-2 control-label">Prueba: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" name="motivo" placeholder="00" />
							</div>
						
						
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Jeringas: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" value="1" name="motivo" placeholder="00" />
							</div>
							
							<label class="col-sm-2 control-label">Agujas: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" value="1" name="motivo" placeholder="00" />
							</div>
							
							<label class="col-sm-2 control-label">Curitas: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" value="1" name="motivo" placeholder="00" />
							</div>
						
						
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Control: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" name="motivo" placeholder="00" />
							</div>
							
							<label class="col-sm-2 control-label">Repetir: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" name="motivo" placeholder="00" />
							</div>
							
							<label class="col-sm-2 control-label">Calibrar: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" name="motivo" placeholder="00" />
							</div>
						
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Placa: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" name="motivo" placeholder="00" />
							</div>
							
							<label class="col-sm-2 control-label">Microlitos: </label>
							<div class="col-sm-2">
								<input type="text" class="required form-control" name="motivo" placeholder="00" />
							</div>
						
						</div>						
						<div class="form-actions text-right">
							<input type="submit" value="Guardar Resultados" class="btn btn-primary" />
						</div>						
					</form>
					
					
					
					
					
					
					
					
					
				</div>
				<?php } //termina if de paciente ?>

				<!-- // END col -->

				<!-- col informa de pacientes en cola-->
				<div class="col-sm-3 print">
				
					<div id="colores" class="widget">
						<div class="widget-head	">
							<h4 class="heading pull-left">Cola de pacientes</h4>
							<div class="clearfix"></div>
						</div>
						<div class="widget-body padding-none">
						    
							<div id="divtest">Cargando <br /> <img src="images/ajax-loader.gif" /></div>

						</div>
						<!-- // End Widget-body-->
					</div>
					<!-- // END widget -->
				</div> 
				<!-- // END col -->
				
			</div>
						
						
						
						
						
						
						
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

	
     
<script src="http://tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript">
/*tinymce.PluginManager.load('moxiemanager', 'http://www.tinymce.com/js/moxiemanager/plugin.min.js');*/

tinymce.init({
	selector: "textarea",
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste "
	],
	toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |  image",
	autosave_ask_before_unload: false
});
</script>
	
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