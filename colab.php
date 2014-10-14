<?php
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
?>

	<ul class="list-group list-group-1 borders-none margin-none">
		<?php
		$cola = db("SELECT * FROM `laboratorio` WHERE `fecha` > '".date ('Y-m-d')." 00:00:00' order by `laboratorio`.`fecha` DESC LIMIT 0 , 30",$mysqli);
		foreach ($cola as $datos){
			
			if ($datos['nombre']==""){
				$nn = db("SELECT * FROM `pacientes` WHERE `codigo` LIKE '".$datos['codigo']."'",$mysqli);
			}
		
		?>
		<li class="<?php if ( $datos['codigo']==$_GET['c'] ){ ?>bg-info<?php } elseif ($datos['estado']==1){?>bg-danger<?php }?> list-group-item">
			<div class="media innerAll">
				<button class="pull-right btn btn-primary btn-stroke btn-xs" onClick="location.href='laboratorios?t=<?php echo $datos['examenes']?>&c=<?php echo $datos['codigo']?>&seg=<?php echo $datos['id']?>'"><i class="fa fa-arrow-right"></i></button>
				<img src="images/perfil.png" alt="<?php echo $nn[0]['nombre']?>" title="<?php echo $nn[0]['nombre']?>" width="35" class="pull-left thumb" />
				<div class="media-body">
					<h5 class="media-heading strong"><?php echo $nn[0]['nombre'].$datos['nombre']?></h5>
					<h5 class="media-heading strong"><?php echo $nn[0]['apellido'].$datos['apellido']?></h5>
					<ul class="list-unstyled">
						<li><i class="fa fa-phone"></i> <?php echo $nn[0]['celular'].$datos['celular']?></li>
						<li><i class="fa fa-map-marker"></i> <?php echo $nn[0]['direccion'].$datos['telefono']?></li>
					</ul>
					<?php 
						$lab = db("SELECT * FROM `laboratorios` WHERE `codigo` LIKE '".$datos['examenes']."'",$mysqli);
					
					?>
					<p style="color: red;"><?php echo $lab[0]['nombre']?></p>
				</div>
			</div>
		</li>
		<?php
		}
		?>
	</ul>