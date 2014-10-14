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
				<div class="panel-heading print"><h6 class="panel-title">Historial de Credito</h6></div>
				<div class="panel-body">
				
					<div class="row">
						<!-- col -->
						<div class="col-sm-12">
							<!-- Default table -->
							<div class="panel panel-default">
								<div class="panel-heading"><h6 class="panel-title">Pagos Realizados</h6></div>
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>ID Orden</th>
												<th>Monto</th>
												<th>Fecha de Pago</th>
												<th><i class="fa fa-print"></i></th>
												<th><i class="fa fa-eraser"></i></th>
											</tr>
										</thead>
										<tbody>
										<?php
										$cola = db("SELECT * FROM  `h_credito` where llave like '".$_GET['id']."' ORDER BY  `h_credito`.`id` DESC LIMIT 0 , 30 ",$mysqli);
										foreach($cola as $data){
										$i++;?>
											<tr>
												<td><?php echo $i;?></td>
												<td><?php echo $data['llave'];?></td>
												<td><?php echo $data['monto'];?></td>
												<td><?php echo $data['fecha'];?></td>
												<th><a href="./abonar.php?id=<?php echo $data['llave'];?>" title="Imprimir este recibo" ><i class="fa fa-print"></i></a></th>
												<th><a href="./system/proceso.php?tipo=borrarcredito&id=<?php echo $data['id'];?>" title="Borrar este registro" ><i class="fa fa-eraser"></i></a></th>
											</tr><?php } ?>
										</tbody>
									</table>
								</div>
							</div>
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


		 <!-- Form modal -->
            <div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5 class="modal-title">Datos Generales</h5>
                        </div>
						<?php $data = db("SELECT *  FROM `ordenes` WHERE `llave` LIKE '".$_GET['temporal']."' limit 0,1",$mysqli);?>
                        <!-- Form inside modal -->
                        <form action="#" role="form">

                            <div class="modal-body has-padding">

                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <label>Nombre</label>
                                        <input type="text" id="nombre" placeholder="Nombre" value="<?php echo $data[0]['cliente'];?>" class="form-control">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label">Nit</label>
                                        <input type="text" id="nit" placeholder="Nit" value="<?php echo $data[0]['nit'];?>" class="form-control">
                                    </div>
									<div class="col-sm-2">
                                        <label class="control-label">ID</label>
                                        <input id="IDs" type="text" value="<?php echo $data[0]['id'];?>" class="form-control" />
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <label>Dirección</label>
                                        <input type="text" id="dir" placeholder="Dirección" value="<?php echo $data[0]['dir'];?>" class="form-control" />
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="control-label">Orden</label>
                                        <input type="text" id="temp" value="<?php echo $_GET['temporal'];?>" class="form-control" />
                                    </div>
									<div class="col-sm-2">
                                        <label class="control-label">No. Factura</label>
                                        <input id="nofac" value="<?php echo $data[0]['nofac'];?>" type="text" value="" class="form-control" />
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <label>Celular</label>
                                        <input type="text" id="cel" placeholder="Celular" class="form-control" />
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="control-label">Tel. casa</label>
                                        <input type="text" id="tel" placeholder = "Tel. casa" class="form-control" />
                                    </div>
									<div class="col-sm-3">
                                        <label class="control-label">No. Cuotas</label>
                                        <input id="ncuota" value="" type="text" value="" class="form-control" />
                                    </div>
									<div class="col-sm-3">
                                        <label class="control-label">Cargo</label>
                                        <input id="ncargo" value="<?php echo $data[0]['cargo'];?>" type="text" value="" class="form-control" />
                                    </div>
                                    </div>
                                </div>
								
								
                                <div class="form-group">
                                    <div class="row">
										<div class="col-sm-12">
											<label class="control-label" style="color:red;">Por favor verifique la información antes de Guardar.</label>
											<label class="control-label" style="color:red;">Si modifica el cargo aplicado a esta venta, por favor actualice la factura para reflejar los cambios.</label>
											<label class="control-label" style="color:red;">Si se desea abonar esta cuenta diríjase al módulo de crédito, para el proceso correspondiente.</label>
										</div>
                                    </div>
                                </div>
								
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="javascript:credito();">Guardar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- /form modal -->

	
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