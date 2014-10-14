<?php
	ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	if(login_check($mysqli) != true) {
	   header('Location: ./login.php?url='.dameURL());
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

<link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="./css/brain-theme.css" rel="stylesheet" type="text/css">
<link href="./css/styles.css" rel="stylesheet" type="text/css">
<link href="./css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="./css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css'>

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
	function imprSelec(muestra){
		var ficha=document.getElementById(muestra);
		var ventimp=window.open(' ','popimpr');
		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		ventimp.print();
		ventimp.close();
		$("#continuando").load("./system/proceso.php?tipo=print",{codigo:'<?php echo $_GET['nit']?>',nombre:'<?php echo $_GET['nombre']?>',direccion:'<?php echo $_GET['direccion']?>',telefono:'<?php echo $_GET['tel']?>',temp:'<?php echo $_GET['temporal']?>',no:'<?php echo $_GET['nofac']?>'});
		}
		
	function credito(){
		var nombre 		= $('#nombre').val();
		var nit 		= $('#nit').val();
		var ids		 	= $('#IDs').val();
		var dir 		= $('#dir').val();
		var temp		= $('#temp').val();
		var factura 	= $('#nofac').val();
		var cel		 	= $('#cel').val();
		var tel		 	= $('#tel').val();
		var ncuota	 	= $('#ncuota').val();
		var ncargo	 	= $('#ncargo').val();
		var total	 	= $('#total').val();
		$("#continuando").load("./system/proceso.php?tipo=credito",{nombre:nombre,nit:nit,ids:ids,dir:dir,temp:temp,factura:factura,cel:cel,tel:tel,ncuota:ncuota,ncargo:ncargo,total:total});
		
		
		/*alert('Almacenamiento correcto.');*/
		
		
		$(".modal").modal("hide");
		
		setTimeout ("redireccionar()", 2000);
		}

	function redireccionar(){
	  window.location="./credito.php?idsave=<?php echo date('Ymdhis')?>";
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
            <div class="logo"><a class="print" href="./" ><img class="print" src="./images/logo.png" /></a></div>

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
	<?php if($_GET['temporal']){
		
		//buscamos la informacion de la orden para imprimir factura
		$ordenes = db("SELECT * FROM `ordenes` WHERE `llave` LIKE '".$_GET['temporal']."'",$mysqli);
	?>
	
	<div id="continuando"></div>
	
	<div id="print">
		<center>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="10%" height="55">&nbsp;</td>
					<td width="10%">&nbsp;</td>
					<td width="55%">&nbsp;</td>
					<td width="13%">&nbsp;</td>
					<td width="12%"><?php echo date('d/m/Y');//echo date('d')." de ".mes()." del ".date('Y');?></td>
				</tr>
				<tr>
					<td height="79">&nbsp;</td>
					<td>&nbsp;</td>
					<td><p><?php echo $ordenes[0]['cliente'];?></p>
					<p>&nbsp;</p>
					<p><?php echo $ordenes[0]['dir'];?></p>    </td>
					<td><p><?php echo $ordenes[0]['nit'];?></p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>    </td>
					<td align="right" valign="bottom">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><div align="center">&nbsp;</div></td>
					<td><div align="center">&nbsp;</div></td>
					<td><div align="center">&nbsp;</div></td>
					<td><div align="center">&nbsp;</div></td>
					<td><div align="center">&nbsp;</div></td>
				</tr><?php $llave = db("SELECT * FROM `ventas` WHERE `llave` LIKE '".$_GET['temporal']."'",$mysqli);
					foreach($llave as $dat){ $c++; ?>
				<tr>
					<td>&nbsp;</td>
					<td><div align="center"><?php echo $dat['cantidad']?></div></td>
					<td><div align="center"><?php echo $dat['producto']?></div></td>
					<td><div align="center">Q. <?php echo $dat['precio']?></div></td>
					<td><div align="center">Q. <?php echo $dat['total']?></div></td>
				</tr><?php 
				
				$sumas = db("SELECT SUM(total) as total FROM ventas WHERE llave=".$_GET['temporal'],$mysqli);
				
				
				

				}
				//buscamos descuento en tabla de ordenes
				if($ordenes[0]['descuento']>0){
				$total = $sumas[0]['total'] - $ordenes[0]['descuento'];
				$limite = 14;
				?>
				
				<tr>
					<td colspan="4" align="center">Descuento especial</td>
					<td><div align="center">Q. <?php echo $ordenes[0]['descuento'];?></div></td>
				</tr>
				
				<?php
				}else {
				$limite = 15;
					$total = $sumas[0]['total'];
				}

				//buscamos cargo
				if($ordenes[0]['cargo']>0){
				$totalcargo = (($sumas[0]['total'] * $ordenes[0]['cargo']) / 100);
				$limite = 14;
				$total = $sumas[0]['total'] + round($totalcargo) - $ordenes[0]['descuento'];
				?>
				
				<tr>
					<td colspan="4" align="center">Cargo Visa Cuotas</td>
					<td><div align="center">Q. <?php echo round($totalcargo).".00";?></div></td>
				</tr>
				
				<?php
				}else {
				$limite = 15;
				
				}				
				
				$tope = $limite - $c;
				  for($x=1;$x<$tope;$x=$x+1){ ?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr><?php } ?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><?php
						$con_letra=strtoupper($V->ValorEnLetras($total,"Quetzales")); 
						echo $con_letra;
					?></td>
					<td>&nbsp; <input type="hidden" id="total" value="<?php echo $total;?>" /></td>
					<td><div align="center"> Q. <?php echo number_format($total, 2);?> </div></td>
				</tr>
			</table>
			<div class="col-sm-4"><a onclick="window.print();" class="btn btn-info btn-block print" role="button">Imprimir Factura</a></div>
			<div class="col-sm-4"><a data-toggle="modal" onmousemove="total()" class="btn btn-info btn-block print" role="button" href="#form_modal">Venta al Credito</a></div>
			<div class="col-sm-4"><a class="btn btn-info btn-block print" role="button" onclick="javascript:location.href='./ordenes.php?l=puntodeventa'">Ver Ordenes en cola</a></div>
		</center>
	</div>
	
	<?php } else{ ?>
		
		
		
		
		
		
	<div id="print">
		<center>
			<h1>Ticket de Consulta</h1>
			<p>Paciente: <?php echo $_GET['paciente']?></p>
			<p>Consulta: <?php echo $_GET['consulta']?></p>
			<img src="barras.php?t=<?php echo $_GET['consulta']?>" style="display:block;margin:0 auto 0 auto;"  />
			<input class="btn btn-info btn-large print" type="button" value="Imprimir" onclick="javascript:window.print();" />
			<input class="btn btn-info btn-large print" type="button" value="Continuar" onclick="javascript:location.href='./'" />
		</center>
	</div>
		
	<?php } ?><br /><br />
		
		
		<!-- Footer -->
			<?php pie() ?>
		<!-- /footer -->
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
