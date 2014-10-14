<?php
	//ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	if(login_check($mysqli) != true) {
	   header('Location: ./login.php?url='.dameURL());
	}
	
		$user				=		$_SESSION['d']['nombres']." ".$_SESSION['d']['apellidos'];
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
	function buscar(){
		var fecha 	= $('#fecha').val();
		if(fecha){
			window.location='./cierre.php?time='+fecha;
		}else {
		
		alert('El campo de fecha y hora esta vacio.');
		}
	}
	
	
	function imprSelec(muestra){
	var ficha=document.getElementById(muestra);
	var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();}	
	
	
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
			<div class="panel-heading"><h6 class="panel-title">Buscar Pacientes</h6></div>
			<div class="panel-body">


			
			
			<?php if(!$_GET['consulta']){?>
			
				<!-- Error wrapper -->
				<div class="error-wrapper offline text-center">
					<h5>- Fecha y Hora de cierre ( Solo para esta caja )-</h5>

					<!-- Error content -->
					<div class="error-content">
						
							<div class="input-group">
								<input id="fecha" type="text" value="<?php echo date('Y-m-d H:i:s') ?>" class="form-control" placeholder="Fecha y Hora" />
								<span class="input-group-btn">
									<button class="btn btn-primary" type="button" onclick="buscar();">Generar Cierre</button>
								</span>
							</div>
						

						<div class="row">

						</div>
					</div>
					<!-- /error content -->

				</div>  
				<!-- /error wrapper -->
			
			<?php if($_GET['time']){?>
			<div id="print">
			<br /><br /><br />
	<!-- Datatable with tools menu -->
	<?php if($listar = db("SELECT * FROM  `ventas` WHERE  `fecha` >  '".date('Y-m-d')." 00:00:00' AND  `user` LIKE  '".$user."' ",$mysqli)){?>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Llave</th>
				<th>Producto</th>
				<th>Cantidad</th>
				<th>Precio Unitario</th>
				<th>Sub total</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		
		foreach ($listar as $datos){
		$n++;
		?><!--
		<tr>
			<td><?php echo $n?></td>
			<td><?php echo $datos['llave']?></td>
			<td><?php echo $datos['producto']?></td>
			<td><?php echo $datos['cantidad']?></td>
			<td><?php echo $datos['precio']?></td>
			<td><?php echo $datos['total']?></td>
		</tr> -->
		<?php 
		$calcula[]=$datos['total'];
		if ($datos['tipo'] == 1){
		$servicios[]= $datos['total'];
		}if ($datos['tipo'] == 2){
		$productos[]= $datos['total'];
		}
		} 
		
		//busca ordenes para extraer llave
		$orden = db("SELECT * FROM  `ordenes` WHERE  `fecha` >  '".date('Y-m-d')." 00:00:00' ",$mysqli); 
		foreach ($orden  as $inforden){
			unset ($totaltemporal);
			unset ($totaltemporal1);
			
			$prod = db("SELECT * FROM  `ventas` WHERE  llave like '".$inforden['llave']."' ",$mysqli);
				foreach($prod as $producto){
					if ($producto['tipo'] == 1){
						$totaltemporal[] = $producto['total'];
						}if ($producto['tipo'] == 2){
						$totaltemporal1[] = $producto['total'];
						}
				};
		
			if ($inforden['pago']== 1){
			@$efectivo[]= array_sum($totaltemporal);
			@$efectivo1[]= array_sum($totaltemporal1);
			}
			if ($inforden['pago']== 2){
			@$debito[]= array_sum($totaltemporal);
			@$debito1[]= array_sum($totaltemporal1);
			}
			if ($inforden['pago']== 3){
			@$cheque[]= array_sum($totaltemporal);
			@$cheque1[]= array_sum($totaltemporal1);
			}
			if ($inforden['pago']== 4){
			@$deposito[]= array_sum($totaltemporal);
			@$deposito1[]= array_sum($totaltemporal1);
			}
			if ($inforden['pago']== 5){
			@$mixto[]= array_sum($totaltemporal);
			@$mixto1[]= array_sum($totaltemporal1);
			}
			if ($inforden['pago']== 6){
			@$credito[]= array_sum($totaltemporal);
			@$credito1[]= array_sum($totaltemporal1);
			}
			
		}
		
		?>
		

		<tr>
			<td colspan="5"> Total de ventas en Efectivo (Productos)</td>
			<td><b style="color:red;"><?php echo number_format(array_sum($efectivo),2);?></b></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas en Efectivo (Servicios)</td>
			<td><b style="color:red;"><?php echo number_format(array_sum($efectivo1),2);?></b></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas en Tarjeta de credito / Debito (Productos)</td>
			<td><?php echo @number_format(array_sum($debito),2);?></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas en Tarjeta de credito / Debito (Servicios)</td>
			<td><?php echo @number_format(array_sum($debito1),2);?></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas en Cheque (Productos)</td>
			<td><?php echo @number_format(array_sum($cheque),2);?></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas en Cheque (Servicios)</td>
			<td><?php echo @number_format(array_sum($cheque1),2);?></td>
		</tr>		

		<tr>
			<td colspan="5"> Total de ventas en Deposito bancario (Productos)</td>
			<td><?php echo @number_format(array_sum($deposito),2);?></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas en Deposito bancario (Servicios)</td>
			<td><?php echo @number_format(array_sum($deposito1),2);?></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas en pagos mixtos (Productos)</td>
			<td><?php echo @number_format(array_sum($mixto),2);?></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas en pagos mixtos (Servicios)</td>
			<td><?php echo @number_format(array_sum($mixto1),2);?></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas al Credito (Productos)</td>
			<td><?php echo @number_format(array_sum($credito),2);?></td>
		</tr>

		<tr>
			<td colspan="5"> Total de ventas al Credito (Servicios)</td>
			<td><?php echo @number_format(array_sum($credito1),2);?></td>
		</tr>				

		<tr>
			<td colspan="5"> <b style="color:red;">Total de ventas, aplica para todas las formas de pago. (Incluye ventas al credito) (Total General)</b></td>
			<td><b style="color:red;"><?php echo number_format(array_sum($calcula),2);?></b></td>
		</tr>	
	
		
		</tbody>
	</table>
	<?php } else {?>
	
	<h1>No hay registros de venta para este usuario.</h1>
	<?php } ?>
	<!-- /datatable with tools menu -->			
			
			
			
			
			</div>
			<div class="form-actions text-right">
				<input type="button" value="Imprimir este reporte" onclick="imprSelec('print');" class="btn btn-primary">
			</div>			
			<?php }} ?>
			
			
			
			
			
			
			
			
			
			
			
			
			
		


			
			
			
			
			
			
			
									
<!-- Footer -->
<br />
<br />
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
/* $cntACmp =ob_get_contents();
ob_end_clean();
$cntACmp=str_replace("\n",' ',$cntACmp);
$cntACmp=ereg_replace('[[:space:]]+',' ',$cntACmp);
ob_start("ob_gzhandler");
echo $cntACmp;
ob_end_flush(); */
?>