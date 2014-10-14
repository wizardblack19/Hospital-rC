<?php


	function error($numero,$texto){
	$ddf = fopen('error.log','a');
	fwrite($ddf,"[".date("r")."] Error $numero:$textorn");
	fclose($ddf);
	}
	set_error_handler('error');


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
		<link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./css/brain-theme.css" rel="stylesheet" type="text/css">
		<link href="./css/styles.css" rel="stylesheet" type="text/css">
		<link href="./css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="./css/print.css" rel="stylesheet" type="text/css" media="print" />
		<link href="./css/fonts/cuprum.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="./js/jquery.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/uniform.min.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/select2.min.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/inputmask.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/autosize.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/inputlimit.min.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/listbox.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/multiselect.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/validate.min.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/tags.min.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/uploader/plupload.full.min.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/uploader/plupload.queue.min.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
		<script type="text/javascript" src="./js/plugins/forms/wysihtml5/toolbar.js"></script>
		<script type="text/javascript" src="./js/plugins/interface/jgrowl.min.js"></script>
		<script type="text/javascript" src="./js/plugins/interface/datatables.min.js"></script>
		<script type="text/javascript" src="./js/plugins/interface/prettify.js"></script>
		<script type="text/javascript" src="./js/plugins/interface/fancybox.min.js"></script>
		<script type="text/javascript" src="./js/plugins/interface/colorpicker.js"></script>
		<script type="text/javascript" src="./js/plugins/interface/timepicker.min.js"></script>
		<script type="text/javascript" src="./js/plugins/interface/fullcalendar.min.js"></script>
		<script type="text/javascript" src="./js/plugins/interface/collapsible.min.js"></script>
		<script type="text/javascript" src="./js/bootstrap.min.js"></script>
		<script type="text/javascript" src="./js/application.js"></script>
		
	<script type="text/javascript">

	/* Busqueda automatica de productos por medio de nombre o codigo*/	
	function datag(){
		var monto 	= $('#monto').val();
		var estesaldo 	= $('#estesaldo').val();
		if(confirm("¿Está a punto de abonar esta cuenta con un monto de " + monto + " desea continuar?")) {
		
		$("#info").load("./system/proceso.php?tipo=abonar",{monto:monto,estesaldo:estesaldo,llave:'<?php echo $_GET['id'];?>'});
		setTimeout('document.location.reload()',2000);}
	}

	</script>
		
		
	</head>
	<body>

    <!-- Navbar -->
	<?php barra()?>
	<!-- /navbar -->

    <!-- Page header -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="logo"><a href="./" title=""><img src="./images/logo.png" alt=""></a></div>
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
				<div class="panel-heading print"><h6 class="panel-title">Departamento de Credito</h6></div>
				<div class="panel-body">
				
					<div class="row">
						<!-- col -->
						<div class="col-sm-12">
							<!-- Default table -->
							<?php 
							$cola = db("SELECT * FROM `credito` WHERE llave like '".$_GET['id']."'  ",$mysqli); 
							$abono = db("SELECT * FROM `h_credito` WHERE llave like '".$_GET['id']."'  ",$mysqli);
							$cuotar = $cola[0]['cuotas'] - count($abono);
							foreach($abono as $habono){ $totalabono[] = $habono['monto']; }
							$saldo = $cola[0]['total'] - array_sum($totalabono);
							
							$estacuota = $cola[0]['total'] / $cola[0]['cuotas'];
							?>



            <!-- Selects -->
            <form class="form-horizontal"  role="form" onsubmit="return:false">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h6 class="panel-title">Datos Generales</h6></div>
                            <div class="panel-body">
							
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Monto </label>
                                    <div class="col-sm-10">
                                        <input type="text" value="<?php echo $cola[0]['total']?>" class="form-control" />
                                    </div>
                                </div>
								
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Cuotas </label>
                                    <div class="col-sm-10">
                                       <input type="text" value="<?php echo $cola[0]['cuotas']?>" class="form-control"  />
                                    </div>
                                </div>
								
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Pendientes </label>
                                    <div class="col-sm-10">
                                        <input  type="text" value="<?php echo $cuotar;?>" class="form-control" />
                                    </div>
                                </div>								

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Cuota</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="<?php echo number_format($estacuota,2);?>" class="form-control" />
                                    </div>
                                </div>								
								
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Saldo</label>
                                    <div class="col-sm-10">
                                        <input id="estesaldo" type="text" value="<?php echo number_format($saldo,2);?>" class="form-control" />
                                    </div>
                                </div>
								
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h6 class="panel-title">Abonar Cuenta</h6></div>
                            <div class="panel-body">

								<div id="info"></div>
							
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Monto: </label>
                                    <div class="col-sm-10">
										<input id="monto" type="text" class="form-control" value="<?php echo number_format($estacuota,2);?>" />
                                    </div>
                                </div>

								<div class="form-actions text-right">
									<input type="button" value="Historial de Credito" onclick="datag()" class="btn btn-primary">
									<input type="button" value="Abonar Cuenta" onclick="datag()" class="btn btn-primary">
								</div>
								
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /selects -->									
									
									
							
							<!-- /default table -->
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