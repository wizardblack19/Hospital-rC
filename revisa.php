<?php
/*
Scrip para buscar, actualizar o borrar registros
este scrip esta especializo para procesar los pedidos
de ventas
*/
	session_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	$user = $_SESSION['d']['nombres']." ".$_SESSION['d']['apellidos'];
	//Devolvemos total de gasto en campos
	if($_GET['tipo']=="ctotal"){
	$llave			= $_REQUEST['llave'];
	$descuento		= $_REQUEST['descuento'];
		$sql = db("SELECT SUM(total) as total FROM ventas WHERE llave=".$llave,$mysqli);
		$cc = $sql[0]['total'];
		$total = $cc - $descuento;
		//$a/$b*100
		echo ' <input type="text" id="cargo" value="'.$total.'.00" class="form-control" >';
	}
	
	
	//Generamos la orden
	if($_GET['tipo']=="orden"){
		$codigo 	= $_REQUEST['llave'];
		$nit 		= $_REQUEST['nit'];
		$dir 		= $_REQUEST['dir'];
		$nombre 	= $_REQUEST['nombre'];
		$descuento 	= $_REQUEST['descuento'];
		$cargo 		= $_REQUEST['cargo'];
		if($codigo){
			if ($temp = $mysqli->prepare("INSERT INTO ordenes (llave, genera, cliente, nit, dir, descuento, cargo) VALUES (?,?,?,?,?,?,?)")) {
			$temp->bind_param('sssssss', $codigo,$user,$nombre,$nit,$dir,$descuento,$cargo );
			$temp->execute();}
		}
		echo "Orden generada ";
	}
	

	//Actualizar orden desde ventas
	if($_GET['tipo']=="actualizar"){
		$codigo 	= $_REQUEST['llave'];
		$nit 		= $_REQUEST['nit'];
		$dir 		= $_REQUEST['dir'];
		$nombre 	= $_REQUEST['nombre'];
		$descuento 	= $_REQUEST['descuento'];
		$factura 	= $_REQUEST['factura'];
		$descuento 	= $_REQUEST['descuento'];
		$ids		= $_REQUEST['ids'];
		$pago		= $_REQUEST['pago'];
		if($codigo){

			$actualiza = db("UPDATE `ordenes` SET `estado` = '2', `despacha` = '".$user."', `cliente` = '".$nombre."', `nit` = '".$nit."', `dir` = '".$dir."', `nofac` = '".$factura."', `descuento` = '".$descuento."', `pago` = '".$pago."' WHERE `ordenes`.`id` =".$ids,$mysqli);
			$mysqli->query($actualiza);

		}
		echo '...';
	}


//revisamos codigo de producto, para evitar duplicidad
	if($_GET['tipo']=="producto"){
		$flag=0;
		$codigo = $_REQUEST['codigo'];
			$consulta = db("select * from producto where barras = '$codigo' ",$mysqli);
			   if($consulta[0]['barras']<>""){ 
				$flag=1;		
				}
		if ($flag==1){echo '<label style="color:#FF0000;">'.utf8_encode('Ya existe un artículo con este código').'</label>';}
	}

	
	
	
	
	
	
	
//revisamos unidades por medio del codigo
	if($_GET['tipo']=="unidades"){
	
		$codigo = $_REQUEST['nombre'];
		$bodega	= $_REQUEST['bodega'];

		if($existe = db("SELECT * FROM `producto` WHERE (`barras` LIKE '".$codigo."' or `nombre` LIKE '".$codigo."') limit 0,1",$mysqli)){
			
			if($existe[0]['tipos']=="1"){
			
			
			if($sql = db("SELECT * FROM `stock` WHERE `codigo` LIKE '".$existe[0]['barras']."' and bodega = '".$bodega."' limit 0,1",$mysqli)){
				$total = $sql[0]['cantidad'];
			}else {
				$total=0;
			}
			
			
			
			}
			if($existe[0]['tipos']=="2"){
			$total=99;
			}
		}else {
			$total=0;
		}

			
			echo '<input type="text" id="exi" value="'.$total.'" class="form-control" onmousemove="existencia()" disabled>';
	}
	
	
	
	
	
	
	
	
// modulo caja buscamos precio

	if($_GET['tipo']=="precios"){
		$flag=0;
		$codigo 	= $_REQUEST['codigo'];
		$descuento	= $_REQUEST['descuento'];
		$tipos		= $_REQUEST['tiposs'];
		
		if ($codigo!="")
		{
		$consulta = db("select * from producto where barras = '$codigo' ",$mysqli);
			if ($consulta[0]['barras']<>""){
				$flag=1;
					if($descuento=="A"){
						$precio = $consulta[0]['precioa'];
					} if($descuento=="B"){
						$precio = $consulta[0]['preciob'];
					} if($descuento=="C"){
						$precio = $consulta[0]['precioc'];
					} if($descuento=="D"){
						$precio = $consulta[0]['preciod'];
					} if($descuento=="S"){
						$precio = $consulta[0]['seguro'];
					}
				}
		if ($flag==0){echo '<input name="precio" type="text" id="precio" value=""  />';}
		else{echo '<input name="precio" type="text" id="precio" value="'.$precio.'" onfocus="agrega_ticket()" />';}
		}
	}








//Descripcion del producto, solo retornamos el nombre	
	if($_GET['tipo']=="des"){
	$flag=0;
	$codigo = $_REQUEST['codigo'];
	if ($codigo!=""){
		$consulta = db("select * from producto where barras = '$codigo' ",$mysqli);
			if ($consulta[0]['barras']<>""){
					$flag=1;	
					$descripcion = $consulta[0]['nombre'];	
				}
	if ($flag==0){echo '<input name="descripcion" type="text" id="descripcion" value="" readonly="readonly" />';}
	else{echo utf8_encode('<input name="descripcion" type="text" id="descripcion" value="'.$descripcion.'" readonly="readonly" />');}
	}
	}
	













	
//tipo temporal guardamos la informacion de las compra
	if($_GET['tipo']=="temporal"){
	$codigo		=	$_REQUEST['codigo'];
	$cantida	=	$_REQUEST['cantida'];
	$precio		=	$_REQUEST['precio'];
	$llavess	=	$_REQUEST['llaves'];
	$monto		=	$precio * $cantida;
	//$monto	=	number_format($monto, 2);
	$user		=	$_REQUEST['user'];
	$tipo		=	$_REQUEST['tiposs'];
	$doctor		=	$_REQUEST['doctor'];
	$descuento	= 	$_REQUEST['descuento'];
	$bodega		= 	$_REQUEST['bodega'];
	//buscamos la informacion del producto
	$infop = db("SELECT * FROM `producto` WHERE `barras` = ".$codigo." LIMIT 0, 1 ",$mysqli);	
	//Guardamos informacion de este producto
	$articulo = $infop[0]['nombre'];
	//insertamos registro
		if ($temp = $mysqli->prepare("INSERT INTO temporal (llave, cantidad, articulo, precio, monto, user) VALUES (?,?,?,?,?,?)")) {
		$temp->bind_param('ssssss', $llavess, $cantida, $articulo, $precio, $monto, $user );
		$temp->execute();}
	if($tipo==2){
	//insertamos registro para las comisiones de los doctores
		if ($temp = $mysqli->prepare("INSERT INTO comisiones (id_doctor, tipo, monto) VALUES (?,?,?)")) {
		$temp->bind_param('iss', $doctor,$descuento,$monto );
		$temp->execute();}		
	}
	//mostramos todos los datos de esta llave
	$consulta = db("select * from temporal where llave  = '$llavess' ",$mysqli);
	foreach ($consulta as $data){?>
	<table class="ticket_cuerpo" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td width="93" align="center"><?php echo $data['cantidad'];?></td>
		  <td width="452" align="center"><?php echo $data['articulo'];?></td>
		  <td width="115" align="center"><?php echo $data['precio'];?></td>
		  <td width="124" align="center"><?php echo $data['monto']?></td>
		  <td width="66" align="center"><a href="#" onclick="borra_salida(<?php echo $codigo?>,<?php echo $llavess;?>,<?php echo $data['id'];?>,<?php echo $data['monto'];?>)"><img src="./images/borrar.png" /></a></td>
		</tr>
	</table>
	<?php	}
	//Si el insertado temporal es correcto pasamos a actualizar el stock
	//Buscamos la cantidad actual de stock restamos lo temporal y actualizamos
	$stock = db("SELECT * FROM `stock` WHERE `codigo` LIKE '".$codigo."' and bodega = ".$bodega." limit 0,1",$mysqli);
	$enstock = $stock[0]['cantidad'];
	$enstock = $enstock - $data['cantidad'];
	$actual  = "UPDATE `hospital`.`stock` SET `cantidad` = '".$enstock."' WHERE `stock`.`codigo` = $codigo;";
	$mysqli->query($actual);
	echo "Llave digital ".$llavess;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
//borramos registros de las bases temporal en caso de ser servicio lo borramos
	if($_GET['tipo']=="borrar"){
	$codigo		=	$_REQUEST['codigo'];
	$llave		=	$_REQUEST['llave'];
	$id 		=	$_REQUEST['id'];
	$tipo		=	$_REQUEST['tiposs'];
	$doctor		=	$_REQUEST['doctor'];	
	$bodega		= 	$_REQUEST['bodega'];	

	//Buscamos la cantidad actual de stock
	$stock = db("SELECT * FROM `stock` WHERE `codigo` LIKE '".$codigo."' and bodega = ".$bodega." limit 0,1",$mysqli);
	$enstoc  = $stock[0]['cantidad'];
	//Buscamos la cantidad en temporal
	$tempor  = db("SELECT * FROM `temporal` WHERE `id` = ".$id." LIMIT 0, 1 ",$mysqli);
	$entemp  = $tempor[0]['cantidad'];
	//actualizamos stock
	$enstock = $enstoc + $entemp;
	$actual  = "UPDATE `hospital`.`stock` SET `cantidad` = '".$enstock."' WHERE `stock`.`codigo` = $codigo;";
	$mysqli->query($actual);
	
	
	
	
	
	//borramos articulo
		$zona_ac = "DELETE FROM `hospital`.`temporal` WHERE `temporal`.`id` = ".$id.";";
		$mysqli->query($zona_ac);
	//si es servicio cancelado lo quitamos de las comisiones
		//if($tipo==2){
		//$comis = "DELETE FROM `hospital`.`comisiones` WHERE `comisiones`.`id` = ".$id.";";
		//$mysqli->query($comis);
	
	//}

	

	//buscamos la informacion del producto
	$infop = db("SELECT * FROM `producto` WHERE `barras` = ".$codigo." LIMIT 0, 1 ",$mysqli);	
	//Guardamos informacion de este producto
	$articulo = $infop[0]['nombre'];
	
	//mostramos todos los datos de esta llave
	$consulta = db("select * from temporal where llave  = '$llave' ",$mysqli);
	foreach ($consulta as $data){?>
	<table class="ticket_cuerpo" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td width="93" align="center"><?php echo $data['cantidad'];?></td>
		  <td width="452" align="center"><?php echo $data['articulo'];?></td>
		  <td width="115" align="center"><?php echo $data['precio'];?></td>
		  <td width="124" align="center"><?php echo $data['monto']?></td>
		  <td width="66" align="center"><a href="#" onclick="borra_salida(<?php echo $codigo?>,<?php echo $llave;?>,<?php echo $data['id'];?>,<?php echo $data['monto'];?>)"><img src="./images/borrar.png" /></a></td>
		</tr>
	</table>
	<?php	}		
	echo "Llave digital ".$llave;
	}
	if($_GET['tipo']=="buscaproducto"){
	$id 		=	$_REQUEST['codigo'];
	$tipo 		=	$_REQUEST['tipop'];
	$sql = db("SELECT * FROM `producto` WHERE (`barras` LIKE '%".$id."%' or nombre LIKE '%".$id."%') and tipos = ".$tipo." ",$mysqli);
	echo $tipo;
	?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Descripci&oacute;n</th>
					<th>Precio A</th>
					<th>Precio B</th>
					<th>Precio C</th>
					<th>Precio D</th>
					<th>Seguro</th>
					<th>DT</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach($sql as $dato){?>		
				<tr>
					<td><?php echo $dato['barras'];?></td>
					<td><?php echo $dato['nombre'];?></td>
					<td><?php echo $dato['referencia'];?></td>
					<td><?php echo $dato['precioa'];?></td>
					<td><?php echo $dato['preciob'];?></td>
					<td><?php echo $dato['precioc'];?></td>
					<td><?php echo $dato['preciod'];?></td>
					<td><?php echo $dato['seguro'];?></td>
					<td> <a href="nuevoproducto.php?l=puntodeventa&id=<?php echo $dato['id']; ?>&tipo=act"><span class="label label-info">usar</span></a></td>
				</tr>
	<?php } ?>			
			</tbody>
        </table>
	<?php	
	}
		
		
		
		
		
		
		
		