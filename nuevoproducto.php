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
<script type="text/javascript">

	function revisa_alta()
	{
		var var_codigo = $('#barras').val();
		$("#alerta").load("revisa.php?tipo=producto",{codigo:var_codigo});
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
            <div class="logo"><a href="/" title=""><img src="images/logo.png" width="280" alt="<?php echo hospital(0);?>"></a></div>

			
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

            <!-- Selects -->
			<?php if(!$_GET['id']){?>
            <form class="form-horizontal validate" action="./system/proceso?tipo=guardarp&url=<?php echo dameURL();?>" role="form" method="post" autocomplete="off">
                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h6 class="panel-title">Registrar producto</h6></div>
                            <div class="panel-body">

							<?php if ($_GET['seg']){?>

							<div class="alert alert-info fade in widget-inner">
								<button type="button" class="close" data-dismiss="alert">×</button>
								El producto ha sido agregado correctamente. <br />Agregue otro producto.

							</div>



							<?php } ?>
							<div id="alerta"></div>
							<div class="form-group">
								<div class="col-sm-3">
									<input id="barras" type="text" class="form-control required" name="barras" placeholder="Código de barras"  onkeyup="revisa_alta()" />
								</div>

								<div class="col-sm-6">
									<input type="text" class="form-control required" name="nombre" placeholder="Nombre, descripción o marca de producto"/>
								</div>
								<div class="col-sm-3">
									<select name="tipos" class="select">
										<option value="1">Producto</option>
										<option value="2">Servicio</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-2">
									<input type="text" class="form-control required" name="precioa" placeholder="Precio A" />
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="preciob" placeholder="Precio B" />
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="precioc" placeholder="Precio C" />
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="preciod" placeholder="Precio D" />
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="seguro" placeholder="Precio de seguro" />
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="referencia" placeholder="Referencia" />
								</div>
							</div>
							<div class="form-actions text-right">
								<input type="submit" value="Guardar producto" class="btn btn-primary" />
							</div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
			<?php } else {
			
			
			if($_GET['id']){	
				$paciente = db("SELECT * FROM `producto` WHERE `id` = ".$_GET['id']." limit 0,1",$mysqli);			
			}
			
			if($_GET['tipo']=="act"){
				$dat = db("SELECT * FROM `stock` where codigo like ".$paciente[0]['barras']." limit 0,1 ",$mysqli);
			}
			
			
			?>
			<form class="form-horizontal validate" action="./system/proceso?tipo=guardare&url=<?php echo dameURL();?>&id=<?php echo $_GET['id']?>&idS=<?php echo $dat[0]['id']?>" role="form" method="post" autocomplete="off">
                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h6 class="panel-title">Actualizar existencia de producto</h6></div>
                            <div class="panel-body">

							
							<div class="form-group">
							<label class="col-sm-2 control-label">Código: </label>
								<div class="col-sm-2">
									<input type="text" class="form-control" value="<?php echo $paciente[0]['barras']?>" disabled  />
									<input type="hidden" name="barras" value="<?php echo $paciente[0]['barras']?>" />
								</div>
							<label class="col-sm-2 control-label">Fecha de ingreso: </label>
								<div class="col-sm-4">
									<input type="text" class="datepicker form-control" name="fechai" value="<?php echo date('Y-m-d')?>" placeholder="Fecha de ingreso"/>
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control required" value="<?php echo $dat[0]['costo']?>" name="costo" placeholder="Costo" />
								</div>								
								
								
							</div>

							<div class="form-group">
								<div class="col-sm-2">
									<input type="text" class="form-control" value="<?php echo $dat[0]['proveedor']?>" name="proveedor" placeholder="Proveedor" />
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control required" value="<?php echo $dat[0]['cantidad']?>" name="cantidad" placeholder="Cantidad" />
								</div>
								<label class="col-sm-2 control-label">Bodega: </label>
								<div class="col-sm-2">		
									<select name="bodega" id="bodega" class="select select2">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
									</select>
								</div>
								<label class="col-sm-2 control-label"> </label>
								<div class="col-sm-2">
									<input type="text" class="datepicker form-control" value="<?php echo $dat[0]['caducidad']?>" name="caducidad" placeholder="Caducidad" />
								</div>
							</div>
							<div class="form-actions text-right">
								<input type="submit" value="<?php if($_GET['tipo']=="act"){?>Actualizar<?php } else{?>Guardar<?php }?>" class="btn btn-primary" />
							</div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
			
			
			
			
			
			
			
			
			
			
			<?php } ?>
            <!-- /selects -->


			

            <!-- Footer -->
				<?php pie() ?>
            <!-- /footer -->
			<script>
				$('.datepicker').datepicker({
						dateFormat: "yy-mm-dd",
						firstDay: 1,
						dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
						dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
						monthNames: 
							["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
							"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
						monthNamesShort: 
							["Ene", "Feb", "Mar", "Abr", "May", "Jun",
							"Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
				});
			</script>
        </div>
    </div>

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