<?php
//Desarrolla Marvin Lopez Version 1 2014
//NOTEPROGRES

////////////////////////////////////////////////////////// PREPARAMOS VARIABLES ////////////////////////////////////////
define( "HOST", "localhost"); //Nombre de Host
define( "USER", "root"); //El nombre de usuario de la base de datos.
define( "PASSWORD", "ceci5652"); //La contraseña de la base de datos.
define( "DATABASE", "hospital"); //El nombre de la base de datos.
define( 'DIRECTORIO', dirname(__FILE__) . '/' );
define( 'SYSTEM', 'system' );

////////////////////////////////////////////////////////// PREPARAMOS CONEXION ////////////////////////////////////////
$mysqli = mysqli_connect(HOST, USER, PASSWORD, DATABASE); // Conexion mysqli
$acentos = $mysqli->query("SET NAMES 'utf8'"); // Acentos Español
//Funcion para prevenir SQL Inyect
function db ($sql, $c) {
    $res = false;
	$q = ($c === null)?@mysqli_query($sql):@mysqli_query($c,$sql);
	if($q) {
		if(strpos(strtolower($sql),'select') === 0) {
			$res = array();
			while($r = mysqli_fetch_assoc($q)) {
				$res[] = $r;
			}
		} else {
			$res = ($c === null)?mysqli_affected_rows():mysqli_affected_rows($c);
		}
	}
	return $res;
}
////////////////////////////////////////////////////////// TERMINAMOS CONEXION ////////////////////////////////////////