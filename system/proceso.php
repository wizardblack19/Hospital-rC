<?php

	require_once('./configdb.php');
	require_once('./funciones.php');

	sec_session_start();
	//variable de control
	

	
//Guardar informacion de paciente

	if ($_GET['tipo']=="fichadepaciente"){

	$sexo				=		$_POST['sexo'];
	$nombre				=		$_POST['nombre'];
	$apellido			=		$_POST['apellido'];
	$direccion			=		$_POST['direccion'];
	$originario			=		$_POST['originario'];
	$correo				=		$_POST['correo'];
	$civil				=		$_POST['civil'];
	$dpi				=		$_POST['dpi'];
	$celular			=		$_POST['celular'];
	$telefono			=		$_POST['telefono'];
	$nacimiento			=		$_POST['nacimiento'];
	$ocupacion  		=		$_POST['ocupacion'];
	$afamiliar			=		$_POST['afamiliar'];
	$apacient			=		$_POST['apacient'];
	
	$quirur				=		$_POST['aquirur'];	
	$atraumatico		=		$_POST['atraumatico'];		
	$aalergicos			=		$_POST['aalergicos'];
	$obs				=		$_POST['obs'];
	$seguro				=		$_POST['seguro'];

	

	if ($seguimiento = $mysqli->prepare("INSERT INTO pacientes (sexo, nombre, apellido, direccion, originario, correo, civil, dpi, celular, telefono, nacimiento, ocupacion, afamiliar, apaciente, a_quirurgico, atraumatico, aalergicos,obs,seguro) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
	   $seguimiento->bind_param('issssssiiisssssssss', $sexo, $nombre, $apellido, $direccion, $originario, $correo, $civil, $dpi, $celular, $telefono, $nacimiento, $ocupacion, $afamiliar, $apacient,$quirur,$atraumatico,$aalergicos,$obs,$seguro);
	   $seguimiento->execute();
	}
	$id= $mysqli->insert_id;

	if ($id){
		//actualizar registro
		$act = db("UPDATE  `hospital`.`pacientes` SET  `codigo` =  'PSE".ceros($id, 7)."' WHERE  `pacientes`.`id` =".$id."",$mysqli);
		$mysqli->query($act);
	}
		header ("Location: ../nuevo.php?tipo=pacientefoto&id=".$id."&tipo=PSE".ceros($id, 7));

	}

	if($_GET['s']){
		echo $_GET['s'];
	}

	if ($_GET['tipo']=="consulta"){
	
	$paciente			=		$_GET['codigo'];
	$talla				=		$_POST['talla'];
	$tipo				=		$_POST['tipo'];
	$pulso				=		$_POST['pulso'];
	$peso				=		$_POST['peso'];
	$diastolica			=		$_POST['diastolica'];
	$sistolica			=		$_POST['sistolica'];
	$temperatura		=		$_POST['temperatura'];
	$rh					=		$_POST['rh'];
	$referido			=		$_POST['referido'];
	$doctor				=		$_POST['doctor'];
	$obs				=		$_POST['observaciones'];
	
	
	$fur				=		$_POST['fur'];
	$gestas				=		$_POST['gestas'];
	$partos				=		$_POST['partos'];
	$abortos			=		$_POST['abortos'];
	$cesarias			=		$_POST['cesarias'];	
	
	$user				=		$_SESSION['d']['nombres']." ".$_SESSION['d']['apellidos'];
	
	if ($rh	== ""){$rh = 0;}
	
	if ($seguimiento = $mysqli->prepare("INSERT INTO consultas (paciente, tipo, talla, pulso, peso, diastolica, sistolica, temperatura,fur,gestas,partos,abortos,cesarias, rh, ref, doctor, obs, user) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {  
	   $seguimiento->bind_param('siiiiiiiiiiiiissss', $paciente, $tipo, $talla, $pulso, $peso, $diastolica, $sistolica, $temperatura, $fur, $gestas, $partos, $abortos, $cesarias, $rh, $referido, $doctor, $obs, $user);
	   $seguimiento->execute();
	}
	$id= $mysqli->insert_id;

	if ($tipo==1){
		$ant = "Co";
	}	elseif ($tipo==2){
		$ant = "Go";
	}	elseif ($tipo==3){
		$ant = "Lc";
	}
	
	if ($id){
		//actualizar registro
		$act = db("UPDATE  `hospital`.`consultas` SET  `consulta` =  '".$ant.ceros($id, 7)."' WHERE  `consultas`.`id` =".$id."",$mysqli);
		$mysqli->query($act);
	}
		header ("Location: ../print.php?tipo=ticket&paciente=".$paciente."&consulta=".$ant.ceros($id, 7));
	
	}
	
	
	if ($_GET['tipo']=="ghistoria"){
	
	$paciente			=		$_GET['codigo'];
	$consulta			=		$_GET['consulta'];
	$motivo				=		$_POST['motivo'];
	$medica				=		$_POST['medica'];
	$examen				=		$_POST['examen'];
	$clinica			=		$_POST['clinica'];
	$tratamiento		=		$_POST['tratamiento'];
	$plan				=		$_POST['plan'];
	$lab				=		$_POST['lab'];
	$saldo				=		$_POST['saldo'];

	//$dat = "LabASIG";	
	//for ($i=0;$i<count($lab);$i++)    
	//{
		//$dat = $dat.", ".$lab[$i];
	//} 

	foreach($lab as $labos){
		$dat.=$labos."|";
    }
	
	
	if ($seguimiento = $mysqli->prepare("INSERT INTO p_historial (paciente, c_consulta, motivo, historia, examen_f, i_clinica, tratamiento, plan, laboratorios,saldo) VALUES (?,?,?,?,?,?,?,?,?,?)")) {  
	   $seguimiento->bind_param('ssssssssss', $paciente, $consulta, $motivo, $medica, $examen, $clinica, $tratamiento, $plan, $dat,$saldo);
	   $seguimiento->execute();
	}
	$id= $mysqli->insert_id;


		header ("Location: ".base64_decode($_GET['url'])."&saved=yes");
	
	}
	
	
	if ($_GET['tipo']=="empleado"){
		
	$titulo			=				$_POST['titulo'];
	$nombre			=				$_POST['nombre'];
	$apellido		=				$_POST['apellido'];	
	$user			=				$_POST['user'];
	$pass			=				base64_encode($_POST['pass']);
	$dep			=				$_POST['dep'];
	//$correo			=				$_POST['correo'];
	$porcentaje		=				$_POST['porcentaje'];		
		
		
		
	if ($seguimiento = $mysqli->prepare("INSERT INTO usuarios (nombre, apellido, titulo, nick, pass, tipo, porcentaje) VALUES (?,?,?,?,?,?,?)")) {  
	   $seguimiento->bind_param('sssssii',  $nombre, $apellido, $titulo, $user, $pass, $dep, $porcentaje);
	   $seguimiento->execute();
	}
	$id= $mysqli->insert_id;
		if($id==0){echo "Este es un error grave detectado en el núcleo del sistema, por favor repórtelo inmediatamente.";}
		
		header ("Location: ".base64_decode($_GET['url'])."&id=$id");
		
		
		
	}
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	if ($_GET['tipo']=="actualizar"){
	
	$id					=		$_GET['id'];
	$sexo				=		$_POST['sexo'];
	$nombre				=		$_POST['nombre'];
	$apellido			=		$_POST['apellido'];
	$direccion			=		$_POST['direccion'];
	$originario			=		$_POST['originario'];
	$correo				=		$_POST['correo'];
	$civil				=		$_POST['civil'];
	$dpi				=		$_POST['dpi'];
	$celular			=		$_POST['celular'];
	$telefono			=		$_POST['telefono'];
	$nacimiento			=		$_POST['nacimiento'];
	$ocupacion  		=		$_POST['ocupacion'];
	$afamiliar			=		$_POST['afamiliar'];
	$apacient			=		$_POST['apacient'];
	
	$quirur				=		$_POST['aquirur'];	
	$atraumatico		=		$_POST['atraumatico'];		
	$aalergicos			=		$_POST['aalergicos'];
	$obs				=		$_POST['obs'];
	$seguro				=		$_POST['seguro'];	
		
	

	$sql="UPDATE  `hospital`.`pacientes` SET  `sexo` =  '".$sexo."', nombre = '".$nombre."', apellido = '".$apellido."', direccion = '".$direccion."', originario = '".$originario."', correo = '".$correo."', civil = '".$civil."', dpi= '".$dpi."', celular = '".$celular."', telefono = '".$telefono."', nacimiento = '".$nacimiento."', ocupacion = '".$ocupacion."', afamiliar = '".$afamiliar."', apaciente = '".$apacient."', a_quirurgico = '".$quirur."', atraumatico = '".$atraumatico."', aalergicos = '".$aalergicos."', obs = '".$obs."', seguro = '".$seguro."'  WHERE  `pacientes`.`id` =".$id."";
	$mysqli->query($sql);
	header ("Location: ".base64_decode($_GET['url'])."&saved=yes");
		
		
		
	}
	
	
	//laboratorios
	
	if ($_GET['tipo']=="labo"){
	
	$cod				=		$_GET['cod'];
	
	$examenes			=		$_POST['lab'];
	$ref				=		$_POST['referido'];
	$apellido			=		$_POST['apellido'];
	$nombre				=		$_POST['nombre'];
	$peso				=		$_POST['peso'];
	$celular			=		$_POST['celular'];
	$telefono			=		$_POST['telefono'];
	
	
	
	
	if ($rh	== ""){$rh = 0;}
	
	if ($seguimiento = $mysqli->prepare("INSERT INTO laboratorio (nombre, apellido, celular, telefono, examenes, ref) VALUES (?,?,?,?,?,?)")) {  
	   $seguimiento->bind_param('ssiiss', $nombre, $apellido, $celular, $telefono, $examenes, $ref);
	   $seguimiento->execute();
	}
	$id= $mysqli->insert_id;

	if ($cod){
		$ant = $cod;
		$rsto = "&cod=".$ant."&return=TRUE";
		
	}	else
	{
		$ant = "999".$id;
		$rsto = "&cod=".$ant."&nombre=".$nombre."&apellido=".$apellido."&telefono=".$apellido."&celular=".$celular."&ref=".$ref."&return=TRUE";
	}	
	
	

	if ($id){
		//actualizar registro
		$act = db("UPDATE  `hospital`.`laboratorio` SET  `codigo` =  '".$ant."' WHERE  `laboratorio`.`id` =".$id."",$mysqli);
		$mysqli->query($act);
	}
			header ("Location: ".base64_decode($_GET['url']).$rsto);
	
	}
	
	
	
	/////////////////////////////////////////////////////// Seccion para ventas ////////////////////////////////////////
	
	
	if ($_GET['tipo']=="guardarp"){
	
	$barras				=		$_POST['barras'];
	$nombre				=		$_POST['nombre'];
	$precioa			=		$_POST['precioa'];
	$preciob			=		$_POST['preciob'];
	$precioc			=		$_POST['precioc'];
	$preciod			=		$_POST['preciod'];
	$seguro				=		$_POST['seguro'];
	$referencia			=		$_POST['referencia'];
	$tipos				=		$_POST['tipos'];
	
	if ($seguimiento = $mysqli->prepare("INSERT INTO producto (barras, nombre, precioa, preciob, precioc, preciod,seguro, tipos,referencia) VALUES (?,?,?,?,?,?,?,?,?)")) {  
	   $seguimiento->bind_param('sssssssis', $barras, $nombre, $precioa, $preciob, $precioc, $preciod, $seguro, $tipos,$referencia );
	   $seguimiento->execute();
	}
	$id= $mysqli->insert_id;

	if ($tipos == 2){
		header ("Location: ../nuevoproducto.php?l=puntodeventa&seg=99");
	}else {
		header ("Location: ".base64_decode($_GET['url'])."&id=".$id);
	}
	
	
	}
	
	/////////////////////// Guardamos existencia ///////////////////////
	
	if ($_GET['tipo']=="guardare"){
	
	$barras				=		$_POST['barras'];
	$fechai				=		$_POST['fechai'];
	$costo				=		$_POST['costo'];
	$proveedor			=		$_POST['proveedor'];
	$cantidad			=		$_POST['cantidad'];
	$caducidad			=		$_POST['caducidad'];
	$bodega				=		$_POST['bodega'];	
	
	if ($_GET['idS']){
	
	$sql = "UPDATE `hospital`.`stock` SET `proveedor` = '".$proveedor."', `cantidad` = '".$cantidad."', `costo` = '".$costo."', `caducidad` = '".$caducidad."', `ingreso` = '".$fechai."' WHERE `stock`.`id` = ".$_GET['idS'].";";
	$mysqli->query($sql);
	
	}else{
	
	
	
	if ($seguimiento = $mysqli->prepare("INSERT INTO stock (codigo, cantidad, proveedor, bodega, caducidad, ingreso) VALUES (?,?,?,?,?,?)")) {
	   $seguimiento->bind_param('ssssss', $barras,  $cantidad,   $proveedor, $bodega, $caducidad,$fechai);
	   $seguimiento->execute();
	}
	
	$id= $mysqli->insert_id;

	
	if ($seguimiento = $mysqli->prepare("INSERT INTO proveedores (idseg, cantidad, costo) VALUES (?,?,?)")){
	   $seguimiento->bind_param('sss', $id,  $cantidad,  $costo);
	   $seguimiento->execute();
	}
	
	
	

	
	}
	
	
	
	
	header ("Location: ../nuevoproducto.php?l=puntodeventa&seg=".$id);
	
	}
	
	
	
	//Guardamos credito
	if($_GET['tipo']=="credito"){
		$nombre		=		$_REQUEST['nombre'];
		$nit 		=		$_REQUEST['nit'];
		$ids		=		$_REQUEST['ids'];
		$dir		=		$_REQUEST['dir'];
		$temp		=		$_REQUEST['temp'];
		$factura	=		$_REQUEST['factura'];
		$cel		=		$_REQUEST['cel'];
		$tel		=		$_REQUEST['tel'];
		$ncuota		=		$_REQUEST['ncuota'];
		$ncargo		=		$_REQUEST['ncargo'];
		$total		=		$_REQUEST['total'];
		$user		=		$_SESSION['d']['nombres']." ".$_SESSION['d']['apellidos'];
	
	if ($tempo = $mysqli->prepare("INSERT INTO credito (llave, nombre, nit, id_v, direccion, nfactura, celular, telefono, cuotas, user, total, saldo ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)")) {
		$tempo->bind_param('ssssssssssss', $temp,$nombre,$nit,$ids,$dir,$factura,$cel,$tel,$ncuota,$user,$total,$total );
		$tempo->execute();}
		
	$actualiza = db("UPDATE `ordenes` SET `cliente` = '".$nombre."', `nit` = '".$nit."', `dir` = '".$dir."', `nofac` = '".$factura."', `pago` = '".$pago."' WHERE `ordenes`.`id` =".$ids,$mysqli);
	$mysqli->query($actualiza);
	
	echo '<div class="alert alert-success fade in widget-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-check"></i> Si actualizo el cargo para esta venta por favor actualiza la página dando clic <a href="javascript:location.reload()">aquí</a> o bien presione la tecla f5.
                    </div>';
	}
	
	
	
	
	
	
		//----------------------------------------------------------Guardamos consultas ginecologicas
	if($_GET['tipo']=="gineconsulta"){
	$examen		=	$_REQUEST['examen'];
	$codigo		= 	$_GET['codigo'];
	$consulta	= 	$_GET['consulta'];	
	
	if ($tempo = $mysqli->prepare("INSERT INTO c_ginecologica (paciente, consulta, sdg, peso, ta, fu, labs, dx, tratamiento, pesoII) VALUES (?,?,?,?,?,?,?,?,?,?)")) {
		$tempo->bind_param('ssssssssss', $codigo, $consulta, $examen[0],$examen[1],$examen[2],$examen[3],$examen[4],$examen[5],$examen[6],$examen[7] );
		$tempo->execute();}
	header ("Location: ".base64_decode($_GET['url']));	
	}
	
	
	
		//----------------------------------------------------------Guardamos datos generales de ginecologia
	if($_GET['tipo']=="hgineco"){
	$gine		=	$_REQUEST['gine'];
	$codigo		= 	$_GET['codigo'];
	$consulta	= 	$_GET['consulta'];
	$tema		=	"";
	$ginet		=	$_POST['ginet'];
	$ginea		=	$_POST['ginea'];
	$ginef		=	$_POST['ginef'];
	$gineh		=	$_POST['gineh'];
	$gineal		=	$_POST['gineal'];
	$gineto		=	$_POST['gineto'];
	$id			=	$_POST['id'];
	
	foreach($gine as $dgineco){
		$c++;
		
		if ($c==14){ $tema.=$ginet."|"; }
		elseif($c==15){ $tema.=$ginea."|"; }
		elseif($c==16){ $tema.=$ginef."|"; }
		elseif($c==17){ $tema.=$gineh."|"; }
		elseif($c==18){ $tema.=$gineal."|"; }
		elseif($c==19){ $tema.=$gineto."|"; }
		$tema.=$dgineco."|";
    }

	if ($id==""){
	if ($tempo = $mysqli->prepare("INSERT INTO general (paciente, data) VALUES (?,?)")) {
		$tempo->bind_param('ss', $codigo, $tema);
		$tempo->execute();}
		}else{
		$act = db("UPDATE  `hospital`.`general` SET  `data` =  '".$tema."' WHERE  `general`.`id` =".$id."",$mysqli);
		$mysqli->query($act);
		}
		
		
	header ("Location: ".base64_decode($_GET['url']));
	}	
	
	
	
	//----------------------------------------------------------Generar orden de compra
	if($_GET['tipo']=="orden"){


	if ($id==""){
	if ($tempo = $mysqli->prepare("INSERT INTO general (paciente, data) VALUES (?,?)")) {
		$tempo->bind_param('ss', $codigo, $tema);
		$tempo->execute();}
		}else{
		$act = db("UPDATE  `hospital`.`general` SET  `data` =  '".$tema."' WHERE  `general`.`id` =".$id."",$mysqli);
		$mysqli->query($act);
		}
		
		
	header ("Location: ".base64_decode($_GET['url']));
	}	
	
	
	
	
	
	//----------------------------------------------------------Borrar credito ------------------------------------------------------
	
	
	if($_GET['tipo']=="borrarcredito"){
		
		if($_GET['id']){
		$zona_ac = "DELETE FROM `credito` WHERE `id` = ".$_GET['id'].";";
		$mysqli->query($zona_ac);}
		header ("Location: ../credito.php");
	
	}
	
	
	//---------------------------------------------------------- Abonar Cuenta ------------------------------------------------------
	
	
	if($_GET['tipo']=="abonar"){
		$monto			=	$_REQUEST['monto'];	
		$llave			=	$_REQUEST['llave'];
		$estesaldo		=	$_REQUEST['estesaldo'] - $monto;
		if ($tempo = $mysqli->prepare("INSERT INTO h_credito (llave, monto) VALUES (?,?)")) {
			$tempo->bind_param('ss', $llave, $monto);
			$tempo->execute();}
				$act = db("UPDATE  `credito` SET  `saldo` =  '".$estesaldo."' WHERE  `llave` =".$llave."",$mysqli);
				$mysqli->query($act);

			?>
		<div class="alert alert-info fade in widget-inner">
			<button type="button" class="close" data-dismiss="alert">×</button>
			Cuenta abonada, espere un momento...
		</div>
	<?php
	}	
	
	
	
	