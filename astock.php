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

                    <div class="panel panel-default">
                        <div class="panel-heading"><h6 class="panel-title">Listar Productos</h6></div>
                        <div class="panel-body">            


					<!-- Datatable with tools menu -->
								<div class="datatable-tools">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Código</th>
												<th>Nombre</th>
												<th>Precio A</th>
												<th>Precio B</th>
												<th>Precio C</th>
												<th>Precio D</th>
												<th>Seguro</th>
												<th>Existencia</th>
												<th><i class="fa fa-share"></i></th>
											</tr>
										</thead>
										<tbody>
										
										<?php 
										$sql = db("SELECT * FROM `producto` ",$mysqli);
										foreach ($sql as $datos){
											$stockes = db("SELECT * FROM `stock` WHERE `codigo` LIKE '".$datos['barras']."'",$mysqli);
										$n++;
										?>
											<tr <?php if($stockes[0]['cantidad']<6){?>class="danger"<?php }?>>
												<td><?php echo $n?></td>
												<td><p style="color:red"><?php echo $datos['barras']?></p></td>
												<td><?php echo $datos['nombre']?></td>
												<td><?php echo $datos['precioa']?></td>
												<td><?php echo $datos['preciob']?></td>
												<td><?php echo $datos['precioc']?></td>
												<td><?php echo $datos['preciod']?></td>
												<td><?php echo $datos['seguro']?></td>
												<td><?php echo $stockes[0]['cantidad']?></td>
												<td><a title="Usar" href="nuevoproducto?l=puntodeventa&id=<?php echo $datos['id']?>&tipo=act"><i class="fa fa-share"></i></a></td>
											</tr>

						<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							<!-- /datatable with tools menu -->	




      

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
