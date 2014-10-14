<?php
	session_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
//require_once ('config.php');
//$conexion=get_db_conn();
$foto=date('YmdHis');
$filename = 'fotos/'.$foto. '.jpg';
$result = file_put_contents( $filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

//$sql = "INSERT INTO `fuentede_notas`.`imagenes` (`id`, `hash`, `foto`) VALUES (NULL, '".$_SESSION['hash']."', '$foto.jpg');";
//mysql_query($sql);

	$ffoto = $foto.".jpg";

	if ($seguimiento = $mysqli->prepare("INSERT INTO fotos (codigo, foto) VALUES (?,?)")) {     
	   $seguimiento->bind_param('ss', $_GET['tipo'], $ffoto);
	   $seguimiento->execute();
	}



$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
print "$url\n";


?>
