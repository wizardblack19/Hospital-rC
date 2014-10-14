<?php
	require_once('./configdb.php');
	require_once('./funciones.php');
//-------------------------------------------------------------examen ---------------------------------------------------
	if ($_GET['lugar'] == "act"){

		//extraer info de id
		$datos  	= explode("/",$_POST['id']);
		//creamos variables de uso
		$campo  	= $datos[0]; //obtiene nombre de campo
		$tipob		= $datos[1]; //obtiene tipo de actualizacion
		$valor	    = $_POST['value']; // valor obtenido desde div
		//sentecia para actualizar

		if ($tipob=="1"){
			
			
			$sql = "UPDATE `hospital`.`consultas` SET `".$campo."` = '".$valor."' WHERE `consultas`.`id` = ".$_GET['idc'].";";
			$mysqli->query($sql);

		}
		if ($tipob=="2"){

			$sql = "UPDATE `hospital`.`p_historial` SET `".$campo."` = '".$valor."' WHERE `p_historial`.`id` = ".$_GET['idh'].";";
			$mysqli->query($sql);

		}

		echo $valor;
	 
	 }
