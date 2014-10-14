	<?php
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');		
	$gdatos		= 		$_REQUEST['codigo'];
	?>	
	<!-- Datatable with tools menu -->
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Código</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Celular</th>
				<th>Telefono</th><?php if($_GET['tipo'] == "consulta"){?>
				<th>Dirección</th>
				<th><i class="fa fa-stethoscope"></i></th>
				<th><i class="fa fa-heart"></i></th>
				<td><i class="fa fa-plus-square"></i></td>
				<th><i class="fa fa-edit"></i></th><?php }  if($_GET['tipo'] == "historia"){?>
				<th>Historial</th>			
				<?php } ?>
			</tr>
		</thead>
		<tbody>
		<?php 
		$listar = db("SELECT * FROM `pacientes` WHERE `nombre` LIKE '%".$gdatos."%' or apellido like '%".$gdatos."%' or codigo like '%".$gdatos."%' limit 0,20",$mysqli);
		foreach ($listar as $datos){
		$n++;
		?>
		<tr>
			<td><?php echo $n?></td>
			<td><p style="color:red"><?php echo $datos['codigo']?></p></td>
			<td><?php echo $datos['nombre']?></td>
			<td><?php echo $datos['apellido']?></td>
			<td><?php echo $datos['celular']?></td>
			<td><?php echo $datos['telefono']?></td><?php if($_GET['tipo'] == "consulta"){?>
			<td><?php echo $datos['direccion']?></td>
			<td><a title="consulta" href="consulta.php?consulta=generar&codigo=<?php echo $datos['codigo']?>"><i class="fa fa-stethoscope"></i></a></td>
			<td><a title="laboratorio" href="laboratorio.php?cod=<?php echo $datos['codigo']?>"><i class="fa fa-heart"></i></a></td>
			<td><a title="laboratorio" href="subirimg.php?cod=<?php echo $datos['codigo']?>"><i class="fa fa-plus-square"></i></a></td>
			<td><a title="editar" href="nuevo.php?tipo=paciente&codigo=<?php echo $datos['codigo']?>&id=<?php echo $datos['id']?>"><i class="fa fa-edit"></i></a></td>
			<?php } if($_GET['tipo'] == "historia"){?>
			<td><a href="hconsulta.php?consulta=generar&codigo=<?php echo $datos['codigo']?>&n=<?php echo $datos['nombre']." ".$datos['apellido']?>">Historial</a></td>		
			<?php } ?>
		</tr><?php } ?>
		</tbody>
	</table>
	<!-- /datatable with tools menu -->