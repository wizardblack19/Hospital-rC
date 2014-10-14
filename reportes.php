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
<link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

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
<script type="text/javascript" src="js/plugins/interface/tabletools.min.js"></script>
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
        <?php menu() ?>
		<!-- /sidebar -->

    
        <!-- Page content -->
        <div class="page-content">

		
		
	            <!-- Page title -->
        	<div class="page-title">
                <h5><i class="fa fa-table"></i> Generador Cardex <small>Generar reportes de compra y venta.</small></h5>

            </div>
            <!-- /page title -->	
		
		
		
		
		
		
		

    <div class="container-fluid">
        <div class="page-header">

            <ul class="middle-nav">
			
                <li><a data-toggle="modal" role="button" href="#default_modal" class="btn btn-default"><i class="fa fa-dollar"></i> <span>Reporte de Compras</span></a><div class="label label-info">9</div></li>
                <li><a href="#" class="btn btn-default"><i class="fa fa-money"></i> <span>Reporte de Ventas</span></a></li>
                <li><a href="#" class="btn btn-default"><i class="fa fa-certificate"></i> <span>Consumo Interno</span></a></li>
            
			</ul>
        </div>
    </div>
            

			
            <!-- Form modal -->
            <div id="default_modal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5 class="modal-title">Fechas de Ingreso</h5>
                        </div>

                        <!-- Form inside modal -->
                        <form action="reportes?r=consulta" method="GET" role="form">

                            <div class="modal-body has-padding">

							
                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-sm-4">
                                        <input name="fecha1" type="text" placeholder="De" class="form-control datepicker">
                                    </div>

                                    <div class="col-sm-4">
                                        <input name="fecha2" type="text" placeholder="Hasta" class="form-control datepicker">
                                    </div>
									
									<div class="col-sm-4">
                                        <input type="submit" class="btn btn-info btn-block" value="Realizar Consulta" />
                                    </div>
									
                                    </div>
                                </div>


								

								

                            </div>



                        </form>
						
						
						
                    </div>
                </div>
            </div>
            <!-- /form modal -->
			
			
			
			
			
			
			
            <!-- Datatable with tools menu -->
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> Productos en Stock </h6></div>
                <div class="datatable-tools">
				
				
				
				<?php if (!$_GET['fecha']){?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Línea</th>
                                <th>Descripción</th>
                                <th>Precio</th>

                                <th>Existencia</th>
                                <th align="center">Pro 1</th>
                                <th align="center">Pro 2</th>
								<th align="center">Pro 3</th>
                                <th align="center">Mejor Pro</th>
								
                            </tr>
                        </thead>
                        <tbody><?php
							require("./venta/common.php");
							global $i, $j;
							mysql_select_db($mysql_database,$conexion) or die("Error");
								
							$registros=mysql_query("select * from articulos order by linea DESC ",$conexion) or die("Error:".mysql_error());
							while ($reg=mysql_fetch_array($registros))
								{
									$i++; 
									$j++;
									$codigo = $reg['codigo'];
									$descripcion = utf8_decode($reg['descripcion']);	
									$precio = $reg['precio'];
									$linea = $reg['linea'];
									$proveedor1 = utf8_decode($reg['proveedor1']);
									$costo1 = $reg['costo1']; 
									$proveedor2 = utf8_decode($reg['proveedor2']);
									$costo2 = $reg['costo2']; 
									$proveedor3 = utf8_decode($reg['proveedor3']);
									$costo3 = $reg['costo3'];
									
									$mejor_proveedor="";	
									$ganancia1=$precio-$costo1;
									$ganancia2=$precio-$costo2;
									$ganancia3=$precio-$costo3;
									
									if($costo1<$costo2 and $costo1<$costo3){$mejor_proveedor=$proveedor1.'<br />Q. '.$ganancia1;}
									if($costo2<$costo1 and $costo2<$costo3){$mejor_proveedor=$proveedor2.'<br />Q. '.$ganancia2;}
									if($costo3<$costo2 and $costo3<$costo1){$mejor_proveedor=$proveedor3.'<br />Q. '.$ganancia3;}
									
									$proveedor1.="<br />Q. ".$costo1;	$proveedor2.="<br />Q. ".$costo2;	$proveedor3.="<br />Q. ".$costo3;				
									$precio = "Q. ".number_format($reg['precio'],2,'.',",");
										
									if($j==1){$color="#EEEEEE";}else{$color="#DFDFDF"; $j=0;}
									
									$registros2=mysql_query("select existencia from inventario where codigo = '$codigo'",$conexion) or die("Error:".mysql_error());
									while ($reg2=mysql_fetch_array($registros2)){$existencia = $reg2['existencia'];}
									
									echo '
									<tr>
										<td>'.$codigo.'</td>
										<td>'.$linea.'</td>
										<td align="left">'.$descripcion.'</td>
										<td>'.$precio.'</td>
										<td>'.$existencia.'</td>
										<td>'.$proveedor1.'</td>
										<td>'.$proveedor2.'</td>
										<td>'.$proveedor3.'</td>
										<td>'.$mejor_proveedor.'</td>
									</tr>
									
									';
								}
								mysql_close($conexion);?>
					
  
  
                        </tbody>
                    </table>
				<?php } ?>
	
				<?php if ($_GET['fecha'] and $_GET['tipo']=="compra"){?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Línea</th>
                                <th>Descripción</th>
                                <th>Precio</th>

                                <th>Existencia</th>
                                <th align="center">Pro 1</th>
                                <th align="center">Pro 2</th>
								<th align="center">Pro 3</th>
                                <th align="center">Mejor Pro</th>
								
                            </tr>
                        </thead>
                        <tbody><?php
							require("./venta/common.php");
							global $i, $j;
							mysql_select_db($mysql_database,$conexion) or die("Error");
								
							$registros=mysql_query("select * from articulos order by linea DESC ",$conexion) or die("Error:".mysql_error());
							while ($reg=mysql_fetch_array($registros))
								{
									$i++; 
									$j++;
									$codigo = $reg['codigo'];
									$descripcion = utf8_decode($reg['descripcion']);	
									$precio = $reg['precio'];
									$linea = $reg['linea'];
									$proveedor1 = utf8_decode($reg['proveedor1']);
									$costo1 = $reg['costo1']; 
									$proveedor2 = utf8_decode($reg['proveedor2']);
									$costo2 = $reg['costo2']; 
									$proveedor3 = utf8_decode($reg['proveedor3']);
									$costo3 = $reg['costo3'];
									
									$mejor_proveedor="";	
									$ganancia1=$precio-$costo1;
									$ganancia2=$precio-$costo2;
									$ganancia3=$precio-$costo3;
									
									if($costo1<$costo2 and $costo1<$costo3){$mejor_proveedor=$proveedor1.'<br />Q. '.$ganancia1;}
									if($costo2<$costo1 and $costo2<$costo3){$mejor_proveedor=$proveedor2.'<br />Q. '.$ganancia2;}
									if($costo3<$costo2 and $costo3<$costo1){$mejor_proveedor=$proveedor3.'<br />Q. '.$ganancia3;}
									
									$proveedor1.="<br />Q. ".$costo1;	$proveedor2.="<br />Q. ".$costo2;	$proveedor3.="<br />Q. ".$costo3;				
									$precio = "Q. ".number_format($reg['precio'],2,'.',",");
										
									if($j==1){$color="#EEEEEE";}else{$color="#DFDFDF"; $j=0;}
									
									$registros2=mysql_query("select existencia from inventario where codigo = '$codigo'",$conexion) or die("Error:".mysql_error());
									while ($reg2=mysql_fetch_array($registros2)){$existencia = $reg2['existencia'];}
									
									echo '
									<tr>
										<td>'.$codigo.'</td>
										<td>'.$linea.'</td>
										<td align="left">'.$descripcion.'</td>
										<td>'.$precio.'</td>
										<td>'.$existencia.'</td>
										<td>'.$proveedor1.'</td>
										<td>'.$proveedor2.'</td>
										<td>'.$proveedor3.'</td>
										<td>'.$mejor_proveedor.'</td>
									</tr>
									
									';
								}
								mysql_close($conexion);?>
					
  
  
                        </tbody>
                    </table>
				<?php } ?>














	
					
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
