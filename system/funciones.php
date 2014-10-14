<?php
//Contruimos el objeto con la info del hospital

	function hospital($id){
		global $mysqli;
		$HH = db("SELECT * FROM `hospitales` LIMIT 0, 1",$mysqli);
		$data[]		=	$HH[0]['nombre'];
		$data[]		=	$HH[0]['direccion'];
		$data[]		=	$HH[0]['telefonos'];
		$data[]		=	$HH[0]['modulos'];
		return $data[$id];
	}

	function datauser($id,$mysqli){
		$sql = db("select nombre, apellido, titulo, tipo from usuarios where id = ".$id." limit 0,1",$mysqli);
		$_SESSION['d']['nombres'] 		= $sql[0]['nombre'];
		$_SESSION['d']['apellidos'] 	= $sql[0]['apellido'];
		$_SESSION['d']['titulo'] 		= $sql[0]['titulo'];
		$_SESSION['d']['tipo'] 			= $sql[0]['tipo'];
	}

	function sec_session_start() {
		setcookie('PHPSESSID', $_COOKIE['PHPSESSID'], time()+86400);
		//$session_name = 'sec_session_id'; //Configura un nombre de sesión personalizado
		//$secure = false; //Configura en verdadero (true) si utilizas https
		//$httponly = false; //Esto detiene que javascript sea capaz de accesar la identificación de la sesión.
		//ini_set('session.use_only_cookies', 1); //Forza a las sesiones a sólo utilizar cookies.
		//$cookieParams = session_get_cookie_params(); //Obtén params de cookies actuales.
		//session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
		//session_name($session_name); //Configura el nombre de sesión a el configurado arriba.
		session_start(); //Inicia la sesión php
		//session_regenerate_id(true); //Regenera la sesión, borra la previa.
	}
	
	
	
	function login($email, $password, $mysqli) {
	$sql="SELECT id, pass FROM usuarios WHERE nick = ? LIMIT 1";
   //Uso de sentencias preparadas significa que la inyección de SQL no es posible.
   if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('s', $email); //Liga "$email" a parámetro.
        $stmt->execute(); //Ejecuta la consulta preparada.
        $stmt->store_result();
        $stmt->bind_result($user_id, $db_password); //Obtiene las variables del resultado.
        $stmt->fetch();
        $password = base64_encode($password); //Hash de la contraseña con salt única.
        if($stmt->num_rows == 1) { //Si el usuario existe.
        //Revisamos si la cuenta está bloqueada de muchos intentos de conexión.
			if(checkbrute($user_id, $mysqli) == true) {
                //La cuenta está bloqueada
                //Envia un correo electrónico al usuario que le informa que su cuenta está bloqueada
                return false;
        } else {
        if($db_password == $password) { //Revisa si la contraseña en la base de datos coincide con la contraseña que el usuario envió.
			//¡La contraseña es correcta!
                $user_browser = $_SERVER['HTTP_USER_AGENT']; //Obtén el agente de usuario del usuario
                $user_id = preg_replace("/[^0-9]+/", "", $user_id); //protección XSS ya que podemos imprimir este valor
                $_SESSION['user_id'] = $user_id;
				
                
                $_SESSION['login_string'] = hash('sha512', $user_browser);
				
				datauser($user_id,$mysqli);

             //Inicio de sesión exitosa
                return true;    
        } else {
                //La conexión no es correcta
                //Grabamos este intento en la base de datos
                $now = time();
                $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
                return false;
        }
        }
        } else {
        //No existe el usuario.
        return false;
        }
	   }
	}


	function checkbrute($user_id, $mysqli) {
	   //Obtén timestamp en tiempo actual
	   $now = time();
	   //Todos los intentos de inicio de sesión son contados desde las 2 horas anteriores.
	   $valid_attempts = $now - (2 * 60 * 60);
	   if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
			$stmt->bind_param('i', $user_id);
			//Ejecuta la consulta preparada.
			$stmt->execute();
			$stmt->store_result();
			//Si ha habido más de 5 intentos de inicio de sesión fallidos
			if($stmt->num_rows > 5) {
			return true;
			} else {
			return false;
			}
	   }
	}

	function login_check($mysqli) {
	//Revisa si todas las variables de sesión están configuradas.
	if(isset($_SESSION['user_id'], $_SESSION['login_string'])) {
	$user_id = $_SESSION['user_id'];
	$login_string = $_SESSION['login_string'];
	$user_browser = $_SERVER['HTTP_USER_AGENT']; //Obtén la cadena de caractéres del agente de usuario
	$sql1="SELECT pass FROM usuarios WHERE id = ? LIMIT 1";	
     if ($stmt = $mysqli->prepare($sql1)) {
        $stmt->bind_param('i', $user_id); //Liga "$user_id" a parámetro.
        $stmt->execute(); //Ejecuta la consulta preparada.
        $stmt->store_result();
        if($stmt->num_rows == 1) { //Si el usuario existe
        $stmt->bind_result($password); //Obtén variables del resultado.
		$stmt->fetch();
        $login_check = hash('sha512', $user_browser);
        if($login_check == $login_string) {
                //¡¡¡¡Conectado!!!!
                return true;
        } else {
                //No conectado
                return false;
        }
        } else {
                //No conectado
                return false;
        }
     } else {
        //No conectado
        return false;
     }
   } else {
     //No conectado
     return false;
   }
} 



	function lugar(){
	$nombre_archivo = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
	//verificamos si en la ruta nos han indicado el directorio en el que se encuentra
	if ( strpos($nombre_archivo, '/') !== FALSE )
		//de ser asi, lo eliminamos, y solamente nos quedamos con el nombre sin su extension
		$nombre_archivo = preg_replace('/\.php$/', '' ,array_pop(explode('/', $nombre_archivo)));
	return $nombre_archivo;
	}

	function dameURL(){
	$url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
	$url = base64_encode($url);
	return $url;
	}
	function dameURL1(){
	$url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'];
	$url = base64_encode($url);
	return $url;
	}

	function CalculaEdad($fecha) {
		list($Y,$m,$d) = explode("-",$fecha);
		return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}


	function ceros($numero, $ceros=2){
		return sprintf("%0".$ceros."s", $numero );
	}
 

	function genero($g){
		if ($g==1){$gen = "Femenino";}
		if ($g==2){$gen = "Masculino";}
		return $gen;
	}

	
class EnLetras
{ 
  var $Void = ""; 
  var $SP = " "; 
  var $Dot = "."; 
  var $Zero = "0"; 
  var $Neg = "Menos"; 
   
function ValorEnLetras($x, $Moneda )  
{ 
    $s=""; 
    $Ent=""; 
    $Frc=""; 
    $Signo=""; 
         
    if(floatVal($x) < 0) 
     $Signo = $this->Neg . " "; 
    else 
     $Signo = ""; 
     
    if(intval(number_format($x,2,'.','') )!=$x) //<- averiguar si tiene decimales 
      $s = number_format($x,2,'.',''); 
    else 
      $s = number_format($x,2,'.',''); 
        
    $Pto = strpos($s, $this->Dot); 
         
    if ($Pto === false) 
    { 
      $Ent = $s; 
      $Frc = $this->Void; 
    } 
    else 
    { 
      $Ent = substr($s, 0, $Pto ); 
      $Frc =  substr($s, $Pto+1); 
    } 

    if($Ent == $this->Zero || $Ent == $this->Void) 
       $s = "Cero "; 
    elseif( strlen($Ent) > 7) 
    { 
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) .  
             "Millones " . $this->SubValLetra(intval(substr($Ent,-6, 6))); 
    } 
    else 
    { 
      $s = $this->SubValLetra(intval($Ent)); 
    } 

    if (substr($s,-9, 9) == "Millones " || substr($s,-7, 7) == "Millón ") 
       $s = $s . "de "; 

    $s = $s . $Moneda; 

    if($Frc != $this->Void) 
    { 
       $s = $s . " " . $Frc. "/100"; 
       //$s = $s . " " . $Frc . "/100"; 
    } 
    $letrass=$Signo . $s . " Centavos."; 
    return ($Signo . $s . " Centavos."); 
    
} 


function SubValLetra($numero)  
{ 
    $Ptr=""; 
    $n=0; 
    $i=0; 
    $x =""; 
    $Rtn =""; 
    $Tem =""; 

    $x = trim("$numero"); 
    $n = strlen($x); 

    $Tem = $this->Void; 
    $i = $n; 
     
    while( $i > 0) 
    { 
       $Tem = $this->Parte(intval(substr($x, $n - $i, 1).  
                           str_repeat($this->Zero, $i - 1 ))); 
       If( $Tem != "Cero" ) 
          $Rtn .= $Tem . $this->SP; 
       $i = $i - 1; 
    } 

     
    //--------------------- GoSub FiltroMil ------------------------------ 
    $Rtn=str_replace(" Mil Mil", " Un Mil", $Rtn ); 
    while(1) 
    { 
       $Ptr = strpos($Rtn, "Mil ");        
       If(!($Ptr===false)) 
       { 
          If(! (strpos($Rtn, "Mil ",$Ptr + 1) === false )) 
            $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr); 
          Else 
           break; 
       } 
       else break; 
    } 

    //--------------------- GoSub FiltroCiento ------------------------------ 
    $Ptr = -1; 
    do{ 
       $Ptr = strpos($Rtn, "Cien ", $Ptr+1); 
       if(!($Ptr===false)) 
       { 
          $Tem = substr($Rtn, $Ptr + 5 ,1); 
          if( $Tem == "M" || $Tem == $this->Void) 
             ; 
          else           
             $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr); 
       } 
    }while(!($Ptr === false)); 

    //--------------------- FiltroEspeciales ------------------------------ 
    $Rtn=str_replace("Diez Un", "Once", $Rtn ); 
    $Rtn=str_replace("Diez Dos", "Doce", $Rtn ); 
    $Rtn=str_replace("Diez Tres", "Trece", $Rtn ); 
    $Rtn=str_replace("Diez Cuatro", "Catorce", $Rtn ); 
    $Rtn=str_replace("Diez Cinco", "Quince", $Rtn ); 
    $Rtn=str_replace("Diez Seis", "Dieciseis", $Rtn ); 
    $Rtn=str_replace("Diez Siete", "Diecisiete", $Rtn ); 
    $Rtn=str_replace("Diez Ocho", "Dieciocho", $Rtn ); 
    $Rtn=str_replace("Diez Nueve", "Diecinueve", $Rtn ); 
    $Rtn=str_replace("Veinte Un", "Veintiun", $Rtn ); 
    $Rtn=str_replace("Veinte Dos", "Veintidos", $Rtn ); 
    $Rtn=str_replace("Veinte Tres", "Veintitres", $Rtn ); 
    $Rtn=str_replace("Veinte Cuatro", "Veinticuatro", $Rtn ); 
    $Rtn=str_replace("Veinte Cinco", "Veinticinco", $Rtn ); 
    $Rtn=str_replace("Veinte Seis", "Veintiseís", $Rtn ); 
    $Rtn=str_replace("Veinte Siete", "Veintisiete", $Rtn ); 
    $Rtn=str_replace("Veinte Ocho", "Veintiocho", $Rtn ); 
    $Rtn=str_replace("Veinte Nueve", "Veintinueve", $Rtn ); 

    //--------------------- FiltroUn ------------------------------ 
    If(substr($Rtn,0,1) == "M") $Rtn = "Un " . $Rtn; 
    //--------------------- Adicionar Y ------------------------------ 
    for($i=65; $i<=88; $i++) 
    { 
      If($i != 77) 
         $Rtn=str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn); 
    } 
    $Rtn=str_replace("*", "a" , $Rtn); 
    return($Rtn); 
} 


function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr) 
{ 
  $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr); 
} 


function Parte($x) 
{ 
    $Rtn=''; 
    $t=''; 
    $i=''; 
    Do 
    { 
      switch($x) 
      { 
         Case 0:  $t = "Cero";break; 
         Case 1:  $t = "Un";break; 
         Case 2:  $t = "Dos";break; 
         Case 3:  $t = "Tres";break; 
         Case 4:  $t = "Cuatro";break; 
         Case 5:  $t = "Cinco";break; 
         Case 6:  $t = "Seis";break; 
         Case 7:  $t = "Siete";break; 
         Case 8:  $t = "Ocho";break; 
         Case 9:  $t = "Nueve";break; 
         Case 10: $t = "Diez";break; 
         Case 20: $t = "Veinte";break; 
         Case 30: $t = "Treinta";break; 
         Case 40: $t = "Cuarenta";break; 
         Case 50: $t = "Cincuenta";break; 
         Case 60: $t = "Sesenta";break; 
         Case 70: $t = "Setenta";break; 
         Case 80: $t = "Ochenta";break; 
         Case 90: $t = "Noventa";break; 
         Case 100: $t = "Cien";break; 
         Case 200: $t = "Doscientos";break; 
         Case 300: $t = "Trescientos";break; 
         Case 400: $t = "Cuatrocientos";break; 
         Case 500: $t = "Quinientos";break; 
         Case 600: $t = "Seiscientos";break; 
         Case 700: $t = "Setecientos";break; 
         Case 800: $t = "Ochocientos";break; 
         Case 900: $t = "Novecientos";break; 
         Case 1000: $t = "Mil";break; 
         Case 1000000: $t = "Millón";break; 
      } 

      If($t == $this->Void) 
      { 
        $i = $i + 1; 
        $x = $x / 1000; 
        If($x== 0) $i = 0; 
      } 
      else 
         break; 
            
    }while($i != 0); 
    
    $Rtn = $t; 
    Switch($i) 
    { 
       Case 0: $t = $this->Void;break; 
       Case 1: $t = " Mil";break; 
       Case 2: $t = " Millones";break; 
       Case 3: $t = " Billones";break; 
    } 
    return($Rtn . $t); 
} 

}

	function mes(){
	
		$mes = date('m');
		if($mes == "1"){
		$text = "Enero";
		}
		if($mes == "2"){
		$text = "Febrero";
		}
		if($mes == "3"){
		$text = "Marzo";
		}
		if($mes == "4"){
		$text = "Abril";
		}
		if($mes == "5"){
		$text = "Mayo";
		}
		if($mes == "6"){
		$text = "Junio";
		}
		if($mes == "7"){
		$text = "Julio";
		}
		if($mes == "8"){
		$text = "Agosto";
		}
		if($mes == "9"){
		$text = "Septiembre";
		}
		if($mes == "10"){
		$text = "Octubre";
		}
		if($mes == "11"){
		$text = "Noviembre";
		}
		if($mes == "12"){
		$text = "Diciembre";
		}
		return $text;
	}
	//objeto html

	function barra(){?>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="hidden-lg pull-right">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-right">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-chevron-down"></i>
                    </button>

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
                        <span class="sr-only">Toggle sidebar</span>
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <ul class="nav navbar-nav navbar-left-custom">
                    <li class="user dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="./images/perfil.png" alt="">
                            <span><?php echo $_SESSION['d']['titulo'].". ".$_SESSION['d']['nombres']." ".$_SESSION['d']['apellidos'] ?></span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <!--<li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                            <li><a href="#"><i class="fa fa-tasks"></i> Tasks</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>-->
                            <li><a href="./login.php?Process=logout"><i class="fa fa-mail-forward"></i> Salir</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-icon sidebar-toggle"><i class="fa fa-bars"></i></a></li>
                </ul>
            </div>

            <ul class="nav navbar-nav navbar-right collapse" id="navbar-right">

                <li>
                    <a href="#">
                        <i class="fa fa-hospital-o"></i>
                        <span>Camillas disponibles</span>
                        <strong class="label label-danger"><?php echo rand(9,1);?></strong>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-windows"></i>
                        <span>Conectado con Servidor: <?php echo php_uname('n');?></span>
                    </a>
                </li>
				
				<li>
                    <a href="#">
                        <i class="fa fa-unlock"></i>
                        <span>LLave</span>
                        <strong class="label label-danger"><?php echo $_SESSION['user_id'];?></strong>
                    </a>
                </li>	
				
            </ul>
        </div>
    </div>
	<?php }

	function menu($tipo){ ?>
	<div class="sidebar collapse">
        	<ul class="navigation">
            	<li <?php if(lugar()=="index" || !lugar() ){?>class="active" <?php }?>><a href="./"><i class="fa fa-laptop"></i> Escritorio</a></li>
                <li <?php if(lugar()=="nuevo" || lugar()=="consulta"){?>class="active" <?php }?>>
                    <a href="#" class="expand" <?php if(lugar()=="nuevo" || lugar()=="consulta" || lugar()=="laboratorio"){?>id="second-level"<?php }?>><i class="fa fa-wheelchair"></i> Pacientes</a>
                    <ul>
                        <li <?php if(lugar()=="nuevo" ){?>class="active" <?php }?>><a href="nuevo.php?tipo=paciente">Nuevo</a></li>
                        <li <?php if(lugar()=="consulta" ){?>class="active" <?php }?>><a href="consulta.php?agregar=paciente">Consulta</a></li>
						<li <?php if(lugar()=="laboratorio" ){?>class="active" <?php }?>><a href="laboratorio.php?r=v1">Laboratorio</a></li>
                    </ul>
                </li>
				<?php if($tipo<>3){?>
               <li <?php if(lugar()=="nuevoproducto" || lugar()=="credito" || lugar()=="cierre" || lugar()=="venta" || lugar()=="ordenes" || lugar()=="inventario" || lugar()=="reportes" || lugar()=="nproducto" || lugar()=="astock"){?>class="active" <?php }?>>
                    <a href="ventaframe.php" class="expand" <?php if(lugar()=="ventaframe" || lugar()=="cierre" || lugar()=="ordenes" || lugar()=="nuevoproducto" || lugar()=="venta" || lugar()=="credito" || lugar()=="ventas" || lugar()=="inventario" || lugar()=="reportes" || lugar()=="nproducto" || lugar()=="aproducto" || lugar()=="astock"){?>id="second-level"<?php }?>><i class="fa fa-money"></i> Punto de Venta</a>
                    <ul>
                        <li <?php if(lugar()=="venta" || lugar()=="ventas" ){?>class="active" <?php }?>><a href="venta.php?l=puntodeventa">Venta Directa</a></li>
						<li <?php if(lugar()=="nuevoproducto" ){?>class="active" <?php }?>><a href="nuevoproducto.php?l=puntodeventa">Nuevo Producto</a></li>
						
                        <li <?php if(lugar()=="ordenes" ){?>class="active" <?php }?>><a href="ordenes.php?l=puntodeventa">Ordenes</a></li>
						<li <?php if(lugar()=="cierre" ){?>class="active" <?php }?>><a href="cierre.php">Cierre de caja</a></li>
                        <!--<li <?php if(lugar()=="inventario" ){?>class="active" <?php }?>><a href="inventario?r=generar">Inventario de Productos</a></li>
                        <li <?php if(lugar()=="nproducto" ){?>class="active" <?php }?>><a href="nproducto?t=producto">Nuevo Producto</a></li>
                        <li <?php if(lugar()=="astock" ){?>class="active" <?php }?>><a href="astock?a=nuevo">Agregar Producto a Stock</a></li>
                        <li <?php if(lugar()=="reportes" ){?>class="active" <?php }?>><a href="reportes">Generador de Cardex</a></li>
						-->
						<li <?php if(lugar()=="aproducto" ){?>class="active" <?php }?>><a href="aproducto.php">Agregar Producto</a></li>
						<li <?php if(lugar()=="credito" ){?>class="active" <?php }?>><a href="./credito.php">Creditos</a></li>
					</ul>
                </li>
				
				<?php } if($tipo==1){?>
                <li <?php if(lugar()=="doctor" || lugar()=="hconsulta"){?>class="active" <?php }?>>
                    <a href="#" class="expand" <?php if(lugar()=="doctor" || lugar()=="hconsulta"){?>id="second-level"<?php }?>><i class="fa fa-user-md"></i> Doctores</a>
                    <ul>
                        <li <?php if(lugar()=="doctor" ){?>class="active" <?php }?>><a href="doctor.php?tipo=paciente">Pacientes</a></li>
                        <li <?php if(lugar()=="hconsulta" ){?>class="active" <?php }?>><a href="hconsulta.php?agregar=paciente">Historia de consultas</a></li>
                    </ul>
                </li>
			
                <li <?php if(lugar()=="laboratorios" ){?>class="active" <?php }?>><a href="laboratorios.php?r=v1"><i class="fa fa-stethoscope"></i> Laboratorios</a></li>

                <!-- <li><a href="#"><i class="fa fa-medkit"></i> Enfermería</a></li>
				<li><a href="#"><i class="fa fa-h-square"></i> Hospitalización</a></li>-->
				
				
				<li <?php if(lugar()=="empleados"){?>class="active" <?php }?>>
                    <a href="#" class="expand" <?php if(lugar()=="empleados" || lugar()=="inventario" || lugar()=="reportes"){?>id="second-level"<?php }?>><i class="fa fa-briefcase"></i> Administrativo</a>
                    <ul>
                        <li <?php if(lugar()=="empleados" ){?>class="active" <?php }?>><a href="empleados.php?l=v1">Agregar Empleados</a></li>
						<!--<li ><a href="visuals.html">Buscar Receta Medica</a></li>
                        <li <?php if(lugar()=="inventario" ){?>class="active" <?php }?>><a href="inventario?r=generar">Inventario de Productos</a></li>
                        <li <?php if(lugar()=="nproducto" ){?>class="active" <?php }?>><a href="nproducto?t=producto">Nuevo Producto</a></li>
                        <li <?php if(lugar()=="astock" ){?>class="active" <?php }?>><a href="astock?a=nuevo">Agregar Producto a Stock</a></li>
                        <li <?php if(lugar()=="reportes" ){?>class="active" <?php }?>><a href="reportes">Generador de Cardex</a></li>
                        <li><a href="content_grid.html">Porcetanjes de Descuento</a></li>-->
                    </ul>
                </li>
				
				
				
				<?php } ?>



				<?php if($tipo==3){?>
                <li <?php if(lugar()=="doctor" || lugar()=="hconsulta"){?>class="active" <?php }?>>
                    <a href="#" class="expand" <?php if(lugar()=="doctor" || lugar()=="hconsulta"){?>id="second-level"<?php }?>><i class="fa fa-user-md"></i> Doctores</a>
                    <ul>
                        <li <?php if(lugar()=="doctor" ){?>class="active" <?php }?>><a href="doctor.php?tipo=paciente">Pacientes</a></li>
                        <li <?php if(lugar()=="hconsulta" ){?>class="active" <?php }?>><a href="hconsulta.php?agregar=paciente">Historia de consultas</a></li>
                    </ul>
                </li>
				
				
				<?php } ?>


				<!--
                <li><a href="#" class="expand"><i class="fa fa-warning"></i> Error pages <span class="label label-warning">6</span></a>
                	<ul>
                        <li><a href="403.html">403 page</a></li>
                        <li><a href="404.html">404 page</a></li>
                        <li><a href="405.html">405 page</a></li>
                        <li><a href="500.html">500 page</a></li>
                        <li><a href="503.html">503 page</a></li>
                        <li><a href="offline.html">Website is offline</a></li>
                    </ul>
                </li>
                <li><a href="#" class="expand"><i class="fa fa-copy"></i> Blank pages <span class="label label-warning">6</span></a>
                    <ul>
                        <li><a href="blank_fixed_navbar.html">Fixed navbar</a></li>
                        <li><a href="blank_static_navbar.html">Static navbar</a></li>
                        <li><a href="blank_collapsed_sidebar.html">Collapsed sidebar</a></li>
                        <li><a href="blank_full_width.html">Full width page</a></li>
                    </ul>
                </li> -->
            </ul>
        </div>
        


	<?php }

	function pie(){ ?>
	            <div class="footer print">
                &copy; Copyright 2014 - <?php echo date('Y')?>. Todos los derechos reservados. Desarrolla <a href="http://www.noteprogres.com" title="Centro de Desarrollo NoteProgres">NoteProgres</a>
            </div>
	<?php }		

	
	