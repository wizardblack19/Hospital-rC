<?php
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	//sec_session_start();

?>

	<ul class="list-group list-group-1 borders-none margin-none">
		<?php
		

			//$bs = $_SESSION['user_id'];
			$bs = $_GET['bs'];
		
		$cola = db("SELECT * FROM `consultas` WHERE `fecha` > '".date ('Y-m-d')." 00:00:00' and doctor like '".$bs."' order by `consultas`.`fecha` DESC 
LIMIT 0 , 30",$mysqli);
		foreach ($cola as $datos){
			$nn = db("SELECT * FROM `pacientes` WHERE `codigo` LIKE '".$datos['paciente']."'",$mysqli);
		?>
		<li class="<?php if ($datos['paciente'] == $_GET['r'] and $datos['consulta']==$_GET['c'] ){ ?>bg-info<?php } elseif ($datos['estado']==1){?>bg-danger<?php }?> list-group-item">
			<div class="media innerAll">
				<button class="pull-right btn btn-primary btn-stroke btn-xs" onClick="location.href='doctor?r=<?php echo $datos['paciente']?>&c=<?php echo $datos['consulta']?>&seg=<?php echo $datos['id']?>'"><i class="fa fa-arrow-right"></i></button>
				<img src="images/perfil.png" alt="<?php echo $nn[0]['nombre']?>" title="<?php echo $nn[0]['nombre']?>" width="35" class="pull-left thumb" />
				<div class="media-body">
					<h5 class="media-heading strong"><?php echo $nn[0]['nombre']?></h5>
					<h5 class="media-heading strong"><?php echo $nn[0]['apellido']?></h5>
					<ul class="list-unstyled">
						<li><i class="fa fa-phone"></i> <?php echo $nn[0]['celular']?></li>
						<li><i class="fa fa-map-marker"></i> <?php echo $nn[0]['direccion']."--".$bs?></li>
					</ul>
				</div>
			</div>
		</li>
		<?php
		}
		?>
	</ul>