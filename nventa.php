<?php
	session_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	
	$cargo = 5;
	
	$user = $_SESSION['d']['nombres']." ".$_SESSION['d']['apellidos'];
	
	$var_nombre 	= $_REQUEST['nombre'];
	$var_tiprec 	= $_REQUEST['tipoprecio'];
	$var_bodega 	= $_REQUEST['bodega'];
	$comision 		= $_REQUEST['doctor'];
	$var_tipopr 	= $_REQUEST['tipoproducto'];
	$var_cantid 	= $_REQUEST['cantidad'];
	$var_cantid 	= $_REQUEST['cantidad'];	
	
	//borrar producto
	if($_GET['temporal']){
		if($_GET['id']){
			$zona_ac = "DELETE FROM `hospital`.`ventas` WHERE `ventas`.`id` = ".$_GET['id'];
			$mysqli->query($zona_ac);}
		else {
			if($_GET['orden'] =="borrar"){
			//borrado de orden
			$zona_ac = "DELETE FROM `hospital`.`ordenes` WHERE `ordenes`.`llave` = ".$_GET['temporal'];
			$mysqli->query($zona_ac);
			}
			$zona_ac = "DELETE FROM `hospital`.`ventas` WHERE `ventas`.`llave` = ".$_GET['temporal'];
			$mysqli->query($zona_ac);
		}
		$llave			= $_GET['temporal'];
	}
	if($_GET['id']==""){
	//Busca precio PHP
		$llave			= $_REQUEST['llave'];
		$sql = db("SELECT * FROM `producto` WHERE `nombre` LIKE '".$var_nombre."' or `barras` LIKE '".$var_nombre."' limit 0,1",$mysqli);
		if($var_tiprec=="A"){$precio = round((($sql[0]['precioa'] * $cargo) / 100) + $sql[0]['precioa']);}
		if($var_tiprec=="B"){$precio = round((($sql[0]['preciob'] * $cargo) / 100) + $sql[0]['precioa']);}
		if($var_tiprec=="C"){$precio = round((($sql[0]['precioc'] * $cargo) / 100) + $sql[0]['precioa']);}
		if($var_tiprec=="D"){$precio = round((($sql[0]['preciod'] * $cargo) / 100) + $sql[0]['precioa']);}
		if($var_tiprec=="S"){$precio = round((($sql[0]['seguro']  * $cargo) / 100) + $sql[0]['precioa']);}
	//calculo de gasto total
		$total = $precio * $var_cantid;
	//Guardamos toda la informacion obtenida, para luego listarla por la llave temporal
	if ($temp = $mysqli->prepare("INSERT INTO ventas (cantidad, producto, precio, total, user, comision, tipo, llave) VALUES (?,?,?,?,?,?,?,?)")) {
	$temp->bind_param('ssssssss', $var_cantid, $sql[0]['nombre'], $precio, $total, $user, $comision, $var_tipopr, $llave );
	$temp->execute();}	
	}
	
	if($temp = db("SELECT * FROM `ventas` WHERE `llave` LIKE '".$llave."'",$mysqli)){
?>


<div align="center" class="cabecera">
<img class="cabecera" src="./images/logo.png" />
<h1>Presupuesto</h1>
<p align="left">Nombre: <span id="nombrec"></span></p>
<p align="left">Clave: <?php echo $llave?></p>
<p align="left">Fecha: <?php echo date('d/m/Y H:i:s');?></p>
</div>


<table width="95%" border="0" class="table" cellspacing="2" align="center" cellpadding="2">
  <tr>

 	<td align="center" width="5%" valign="middle"><i class="fa fa-times"></i></td>
    <td align="center" width="10%"valign="middle">Cant</td>
    <td align="center" width="60%" valign="middle">Artículo</td>
    <td align="center" width="10%" valign="middle">Precio</td>
	<td align="center" width="10%" valign="middle">Total</td>
 	<td align="center" width="5%" valign="middle"><i class="fa fa-check"></i></td>
  </tr>

<?php 

	foreach($temp as $info){
?>
  
  
  <tr>
	<td align="center" valign="middle"><a href="javascript:borra(<?php echo $info['id'];?>)" onclick="borra(<?php echo $info['id'];?>)" ><i class="fa fa-times"></i> </a></td>
    <td align="center" valign="middle"><?php echo $info['cantidad'];?></td>
    <td align="center" valign="middle"><?php echo $info['producto'];?></td>
    <td align="center" valign="middle"><?php echo $info['precio'];?></td>
	<td align="center" valign="middle"><?php echo $info['total'];?></td>
	<td align="center" valign="middle"><a href="javascript:borra(<?php echo $info['id'];?>)" onclick="borra(<?php echo $info['id'];?>)" ><i class="fa fa-check"></i> </a></td>
  </tr>  
  
<?php } 

$sql = db("SELECT SUM(total) as total FROM ventas WHERE llave=".$llave,$mysqli);

?>
  
  
  <tr>
    <td align="right" valign="middle" colspan="3"></td>
	<td align="center" valign="middle" ><b>Total</b></td>
	<td align="center" valign="middle" ><?php echo $sql[0]['total']?></td>
	<td align="center" valign="middle" ></td>
  </tr>  
  
  
</table>



<div align="center" class="cabecera">
<p>Este presupuesto tiene validez por una semana, estos precios aplican en ventas en efectivo, tenga en cuenta que la disponibilidad de producto puede verse afectada de forma diaria.</p>
</div>

<?php }else {?>
	<script type="text/javascript">
		$( document ).ready(function() {
			$("#pie").hide();
		});
	</script>
<?php

}



