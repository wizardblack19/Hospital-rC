<?php
	ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	if(login_check($mysqli) != true) {
	  header('Location: ./login.php?url='.dameURL());
	}
	$bs	=	$_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo hospital(0);?></title>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/brain-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="css/fonts/cuprum.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/forms/uniform.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/select2.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/inputmask.js"></script>
<script type="text/javascript" src="js/plugins/forms/autosize.js"></script>
<script type="text/javascript" src="js/plugins/forms/inputlimit.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/listbox.js"></script>
<script type="text/javascript" src="js/plugins/forms/multiselect.js"></script>
<script type="text/javascript" src="js/plugins/forms/validate.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/tags.min.js"></script>

<script type="text/javascript" src="js/plugins/forms/uploader/plupload.full.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/uploader/plupload.queue.min.js"></script>

<script type="text/javascript" src="js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/wysihtml5/toolbar.js"></script>

<script type="text/javascript" src="js/plugins/interface/jgrowl.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/datatables.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/prettify.js"></script>
<script type="text/javascript" src="js/plugins/interface/fancybox.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/colorpicker.js"></script>
<script type="text/javascript" src="js/plugins/interface/timepicker.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/fullcalendar.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/collapsible.min.js"></script>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>
<link rel="stylesheet" href="./api/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="./api/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
		

	<script type="text/javascript">
		function cargar(div, desde)
		{
			$(div).load(desde);
		}
		setInterval( "cargar('#divtest', 'cola.php?r=<?php echo $_GET['r']?>&c=<?php echo $_GET['c']?>&id=<?php echo $_GET['id']?>&bs=<?php echo $bs ?>')", 2000 );
		
		
			function imprSelec(muestra){
			var ficha=document.getElementById(muestra);
			var ventimp=window.open(' ','popimpr');
			ventimp.document.write(ficha.innerHTML);
			ventimp.document.close();
			ventimp.print();
			ventimp.close();}
	
	

	
	$(document).ready(function () {
    $("input,select").bind("keydown", function (e) {
        if (e.keyCode == 13) {
            var allInputs = $("input,select");
            for (var i = 0; i < allInputs.length; i++) {
                if (allInputs[i] == this) {
                    while ((allInputs[i]).name == (allInputs[i + 1]).name) {
                        i++;
                    }

                    if ((i + 1) < allInputs.length) $(allInputs[i + 1]).focus();
                }
            }
        }
    });
});
	</script>
	<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto();
  });
</script>
</head>

<body>

    <!-- Navbar -->
	<?php barra()?>
	<!-- /navbar -->


    <!-- Page header -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="logo"><a href="./" title=""><img src="images/logo.png" alt=""></a></div>
        </div>
    </div>
    <!-- /page header -->


    <!-- Page container -->
    <div class="page-container container-fluid">
    	<!-- Sidebar -->
        <?php menu($_SESSION['d']['tipo']) ?>
		<!-- /sidebar -->
        <!-- Page content -->
        <div class="page-content">
			<!-- Headings, Open Sans -->
			
		<?php
		if ($_GET['eliminar']=="yes"){
			//preparamos borrado de datos
			$zona_ac = "DELETE FROM `hospital`.`p_historial` WHERE `p_historial`.`id` = ".$_GET['id'].";";
			if($mysqli->query($zona_ac)){
		?>
                    <div class="alert alert-success fade in widget-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-check"></i> El registro ha sido eliminado.
                    </div>			
		<?php } else { ?>	
			
			        <div class="alert alert-danger fade in widget-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-times"></i> Algo salio mal, no se pudo eliminar el registro.
                    </div>
		<?php } } ?>			
			

			
                    <div class="panel panel-default">
                        <div class="panel-heading print"><h6 class="panel-title">Información general de pacientes</h6></div>
                        <div class="panel-body">

						
							<div class="row">
								<!-- col -->
								
								<?php 
								if ($_GET['r'] == "release" || $_GET['tipo'] == "paciente"){?>
									<div class="col-sm-9">
										<h1>Por favor seleccione un paciente de la cola --></h1>
										<img src="./images/paciente.jpg" width="100%" />
										<a href="./images/paciente.jpg" rel="prettyPhoto[gallery2]">ver modal</a>
									</div>
								<?php }else { ?>
								<div class="col-sm-9">

									<?php 
									//buscamos la informacion del paciente
									$data_pas = db("SELECT * FROM `pacientes` WHERE `codigo` LIKE '".$_GET['r']."'",$mysqli);
									//buscamos informacion de la consulta
									$data_con = db("SELECT * FROM `consultas` WHERE `paciente` LIKE '".$_GET['r']."' and consulta LIKE '".$_GET['c']."' ",$mysqli);
									//primera seccion informacion general
									$sq = db("UPDATE `hospital`.`consultas` SET `estado` = '1' WHERE `consultas`.`id` = ".$_GET['seg']." ",$mysqli);
									?>
									
									<div class="row demo-grid widget-inner print">
										
										<div class="col-md-10">
											<div>
											<!--<img src="images/perfil.png" class="thumb pull-left" alt="" width="100" /> -->
												<div class="media-body innerLR">
													<h4 class="media-heading text-large text-primary"><?php echo $data_pas[0]['nombre']." ".$data_pas[0]['apellido']?></h4>
													<p><?php echo genero($data_pas[0]['sexo'])?>, <?php echo $data_pas[0]['nacimiento']?> años de edad
													<br/>Ocupación<strong> <?php echo $data_pas[0]['ocupacion']?></strong> | Estado Civil<strong> <?php echo $data_pas[0]['civil']?></strong>
													<br/>Posee Seguro Medico <strong style="color:red"> <?php echo $data_pas[0]['seguro']?></strong> | Código<strong> <?php echo $data_pas[0]['codigo']?></strong> | Código de consulta<strong> <?php echo $data_con[0]['consulta']?></strong>
													</p>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div>
											<!--<img src="images/perfil.png" class="thumb pull-left" alt="" width="100" /> -->
												<div class="media-body innerLR">
											<img src="images/perfil.png" class="thumb pull-left" alt="" width="100%" /> 

												</div>
											</div>
										</div>						
										
									</div>
									<?php // segundo bloque, informacion relacionada ?>
									<div class="widget print">
									
										<div class="row demo-grid widget-inner ">
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['pulso']?></span><br/>
													Pulso
												</div>
											</div>
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['peso']?></span><br/>
													Peso
												</div>
											</div>
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['talla']?></span><br/>
													Talla
												</div>
											</div>

											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['diastolica']?></span><br/>
													Diastólica
												</div>
											</div>						
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['sistolica']?></span><br/>
													Sistólica
												</div>
											</div>
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['temperatura']?> °c</span><br/>
													Temperatura
												</div>
											</div>
										</div>
										<?php 
										//si es consulta gineco obstetra
										
										if(substr($_GET['c'], 0, 2)=="Go"){
										
										?>
										<div class="row demo-grid widget-inner ">
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['fur']?></span><br/>
													FUR
												</div>
											</div>
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['gestas']?></span><br/>
													Gestas
												</div>
											</div>
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['partos']?></span><br/>
													Partos
												</div>
											</div>

											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['abortos']?></span><br/>
													Abortos
												</div>
											</div>						
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['cesarias']?></span><br/>
													Cesarias
												</div>
											</div>
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['rh']?></span><br/>
													RH
												</div>
											</div>
										</div>
										<?php } //Fin de seccion gineco obstetra ?>
										<!--
										
										<div class="row demo-grid widget-inner ">
										
											<div class="col-md-6">
												<div class="innerAll text-center">
													<div class="media innerAll">
														<div class="pull-left">
															Presión
															<div class="strong">110/90 mmHh</div>
														</div>
														<div class="media-body innerAll">
															<div class="progress progress-small margin-none">
																<div class="progress-bar progress-bar-primary" style="width: 80%"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="innerAll text-center">
													<div class="media innerAll">
														<div class="pull-left">
															Ejercicio
															<div class="strong">2 horas, 30 min</div>
														</div>
														<div class="media-body innerAll">
															<div class="progress progress-small margin-none">
																<div class="progress-bar progress-bar-primary" style="width: 35%"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
											
										</div>
										
										-->
										
									</div>
									
									

									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
												<!-- Page tabs -->
							<div class="tabbable page-tabs">
								<ul class="nav nav-tabs print">
									<li class="active"><a href="#consulta" data-toggle="tab"><i class="fa fa-edit"></i> Consulta</a></li>
									<?php	if(substr($_GET['c'], 0, 2)=="Go"){?>
									<li><a href="#gineco" data-toggle="tab"><i class="fa fa-edit"></i> C Prenatal</a></li>
									<?php } ?>
									<li><a href="#datos" data-toggle="tab"><i class="fa fa-clipboard"></i> Generales</a></li>
									
									<li><a href="#navs" data-toggle="tab"><i class="fa fa-clock-o"></i> Historial</a></li>
									<li><a href="#navbars" data-toggle="tab"><i class="fa fa-stethoscope"></i> Lab Resultados</a></li>
									<!--<li><a href="#receta" data-toggle="tab"><i class="fa fa-file-text-o"></i> Receta</a></li>-->
								</ul>

								<div class="tab-content has-padding">
								
								
									<!-- Primer pestaña -->
								
									<div class="tab-pane active fade in" id="consulta">
										<div class="row">
											<div class="col-md-12">
											
											
	<form class="form-horizontal" role="form" action="./system/proceso?tipo=ghistoria&codigo=<?php echo $_GET['r']?>&consulta=<?php echo $_GET['c']?>&url=<?php echo dameURL()?>" method="post" autocomplete="off">	
	
	<?php if($_GET['saved']=="yes"){?>
	<div class="alert alert-info fade in widget-inner">
		<button type="button" class="close" data-dismiss="alert">×</button>
	   La información ha sido guardada correctamente.
	</div>						
	<?php } ?>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Motivo de consulta: <span class="mandatory">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="required form-control" name="motivo" />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Historia medica: <span class="mandatory">*</span></label>
		<div class="col-sm-10">
			<textarea name="medica" rows="2" cols="5" class="elastic form-control"></textarea>
		</div>
	</div>						

	<div class="form-group">
		<label class="col-sm-2 control-label">Examen Físico: <span class="mandatory">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="required form-control" name="examen" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Impresión clínica: <span class="mandatory">*</span></label>
		<div class="col-sm-10">
			<textarea name="clinica" rows="2" cols="5" class="elastic form-control"></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Tratamiento: <span class="mandatory">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="required form-control" name="tratamiento" />
		</div>
	</div>							
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Plan educacional: <span class="mandatory">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="required form-control" name="plan" />
		</div>
	</div>		

	<div class="form-group">
		<div class="col-sm-12">
			<div class="widget-inner">
				<label class="checkbox-inline">
					<input name="lab[]" type="checkbox" value="Ultrasonido" class="styled">
					Ultrasonido
				</label>
				<label class="checkbox-inline">
					<input name="lab[]" type="checkbox" value="Laboratorio" class="styled">
					Laboratorio
				</label>

				<label class="disabled checkbox-inline">
					<input name="lab[]" type="checkbox" value="Papanicolao" class="styled">
					Papanicolao
				</label>
				<label class="disabled checkbox-inline">
					<input name="lab[]" type="checkbox" value="Patologia" class="styled">
					Patologia
				</label>
				<label class="disabled checkbox-inline">
					<input name="lab[]" type="checkbox" value="RX" class="styled">
					RX
				</label>                                
				<label class="disabled checkbox-inline">
					<input name="lab[]" type="checkbox" value="Tomografia" class="styled">
					Tomografia
				</label>
				<input type="hidden" name="lab[]" value="." />
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Saldo por Cobrar: </label>
		<div class="col-sm-10">
			<input type="text" class="required form-control" name="saldo" />				
		</div>
	</div>
	
	<div class="form-actions text-right">
		<input type="submit" value="Guardar diagnostico" class="btn btn-primary" />
	</div>

		
	</form>	
											
											
											
											
											</div>
										<!-- /cerramos consulta -->	
										</div>				
									
									</div>
									
									<!-- datos añadidos ginecologia-->
									<?php	if(substr($_GET['c'], 0, 2)=="Go"){?>
									<div class="tab-pane fade in" id="gineco">
										<div class="row">
											<div class="col-md-12">
	<?php if($general = db("SELECT * FROM `general` WHERE `paciente` LIKE '".$_GET['r']."'",$mysqli)){
		$bdata = $general[0]['data'];
		$bdata = explode("|", $bdata); }?>
	<form class="form-horizontal" action="./system/proceso.php?tipo=hgineco&codigo=<?php echo $_GET['r']?>&consulta=<?php echo $_GET['c']?>&url=<?php echo dameURL()?>" method="post" autocomplete="off">
	
	<h4>P. Patológicos </h4>
	<div class="form-group">
		<label class="col-sm-2 control-label">Efermedades: </label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[0]){echo "$bdata[0]";} ?></textarea>
		</div>
		<label class="col-sm-2 control-label">Cirugias: </label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[1]){echo "$bdata[1]";} ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Transfuciones: </label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[2]){echo "$bdata[2]";} ?></textarea>
		</div>
		<label class="col-sm-2 control-label">Alergías: </label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[3]){echo "$bdata[3]";} ?></textarea>
		</div>
	</div>

	<h4>Ginecobstétricos </h4>
	<div class="form-group">
		<label class="col-sm-2 control-label">Menarquia: </label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[4]){echo "$bdata[4]";} ?></textarea>
		</div>
		<label class="col-sm-2 control-label">Ritmo: </label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[5]){echo "$bdata[5]";} ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">FUM: </label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[6]){echo "$bdata[6]";} ?></textarea>
		</div>
		<label class="col-sm-2 control-label">FPP: </label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[7]){echo "$bdata[7]";} ?></textarea>
		</div>
	</div>												

	<div class="form-group">
		<label class="col-sm-2 control-label">No Patológicos: </label>
		<div class="col-sm-10">
			<div class="widget-inner">
				<div class="col-sm-2">
					<input type="text" class="required form-control" <?php if ($bdata[8]){echo "value='$bdata[8]'";} ?> name="gine[]" placeholder="G" />
				</div>
				
				<div class="col-sm-2">
					<input type="text" class="required form-control" <?php if ($bdata[9]){echo "value='$bdata[9]'";} ?> name="gine[]" placeholder="P" />
				</div>
				
				<div class="col-sm-2">
					<input type="text" class="required form-control" <?php if ($bdata[10]){echo "value='$bdata[10]'";} ?> name="gine[]" placeholder="A" />
				</div>
				<div class="col-sm-2">
					<input type="text" class="required form-control" <?php if ($bdata[11]){echo "value='$bdata[11]'";} ?> name="gine[]" placeholder="C" />
				</div>                         
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Familiares: <span class="mandatory">*</span></label>
		<div class="col-sm-10">
			<textarea name="gine[]" rows="5" cols="5" class="elastic form-control"><?php if ($bdata[12]){echo "$bdata[12]";} ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Tabaquismo </label>
		<div class="col-sm-4">
			<label class="radio-inline">
				<input type="radio" name="ginet" <?php if ($bdata[13]=="si"){echo "checked='checked'";} ?> value="si" class="styled">
				SI
			</label>
			<label class="radio-inline">
				<input type="radio" name="ginet" <?php if ($bdata[13]=="no"){echo "checked='checked'";} ?> value="no" class="styled" >
				NO
			</label>
		</div>

		<label class="col-sm-2 control-label">Alcoholismo </label>
		<div class="col-sm-4">
			<label class="radio-inline">
				<input type="radio" name="ginea" <?php if ($bdata[15]=="si"){echo "checked='checked'";} ?> value="si" class="styled">
				SI
			</label>
			<label class="radio-inline">
				<input type="radio" name="ginea" <?php if ($bdata[15]=="no"){echo "checked='checked'";} ?> value="no" class="styled">
				NO
			</label>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Act. Física </label>
		<div class="col-sm-4">
			<label class="radio-inline">
				<input type="radio" name="ginef" <?php if ($bdata[17]=="si"){echo "checked='checked'";} ?> value="si" class="styled">
				SI
			</label>
			<label class="radio-inline">
				<input type="radio" name="ginef" <?php if ($bdata[17]=="no"){echo "checked='checked'";} ?> value="no" class="styled">
				NO
			</label>
		</div>

		<label class="col-sm-2 control-label">Hab. Higiene </label>
		<div class="col-sm-4">
			<label class="radio-inline">
				<input type="radio" name="gineh" <?php if ($bdata[19]=="si"){echo "checked='checked'";} ?> value="si" class="styled">
				SI
			</label>
			<label class="radio-inline">
				<input type="radio" name="gineh" <?php if ($bdata[19]=="no"){echo "checked='checked'";} ?> value="no" class="styled">
				NO
			</label>
		</div>
	</div>												
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Hab. Alimentarios </label>
		<div class="col-sm-4">
			<label class="radio-inline">
				<input type="radio" name="gineal" <?php if ($bdata[21]=="si"){echo "checked='checked'";} ?> value="si" class="styled">
				SI
			</label>
			<label class="radio-inline">
				<input type="radio" name="gineal" <?php if ($bdata[21]=="no"){echo "checked='checked'";} ?> value="no" class="styled">
				NO
			</label>
		</div>
	</div>													

	<div class="form-group">
		<label class="col-sm-2 control-label">Emb. Previos</label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[14]){echo "$bdata[14]";} ?></textarea>
		</div>
		<label class="col-sm-2 control-label">MPF. Previo</label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[16]){echo "$bdata[16]";} ?></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Emb. Deseado</label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[18]){echo "$bdata[18]";} ?></textarea>
		</div>
		<label class="col-sm-2 control-label">Grupo y RH</label>
		<div class="col-sm-4">
			<textarea name="gine[]" class="elastic form-control"><?php if ($bdata[20]){echo "$bdata[20]";} ?></textarea>
		</div>
	</div>

	<h4>Biometría </h4>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Talla: </label>
		<div class="col-sm-2">
			<input type="text" class="required form-control" <?php if ($bdata[22]){echo "value='$bdata[22]'";} ?> name="gine[]" />
		</div>
		<label class="col-sm-2 control-label">Peso Previo al embarazo: </label>
		<div class="col-sm-2">
			<input type="text" <?php if ($bdata[24]){echo "value='$bdata[24]'";} ?> class="required form-control" name="gine[]" />
		</div>
		<label class="col-sm-2 control-label">Peso inicial: </label>
		<div class="col-sm-2">
			<input type="text" <?php if ($bdata[25]){echo "value='$bdata[25]'";} ?> class="required form-control" name="gine[]" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Toxoide Tet. </label>
		<div class="col-sm-3">
			<label class="radio-inline">
				<input type="radio" name="gineto" <?php if ($bdata[23]=="1a"){echo "checked='checked'";} ?> value="1a" class="styled">
				1a.
			</label>
			<label class="radio-inline">
				<input type="radio" name="gineto" <?php if ($bdata[23]=="r"){echo "checked='checked'";} ?> value="r" class="styled">
				r
			</label>
		</div>
		<label class="col-sm-2 control-label">Antilnfluenza </label>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">Otra: <span class="mandatory">*</span></label>
		<div class="col-sm-10">
			<textarea name="gine[]" rows="2" cols="5" class="elastic form-control"><?php if ($bdata[26]){echo "$bdata[26]";} ?></textarea>
		</div>
	</div>
	
	<div class="form-actions text-right">
		<input type="submit" value="Guardar diagnostico" class="btn btn-primary" />
	</div>

		<input type="hidden" name="id" value="<?php echo $general[0]['id'];?>">
	</form>	
	<?php $hgico = db("SELECT * FROM `c_ginecologica` WHERE `paciente` LIKE '".$_GET['r']."'",$mysqli); if($hgico){?>
	<div class=" demo-grid widget-inner print">
		<div class="form-group">
			<div class="col-sm-1">SDG</div>
			<div class="col-sm-1">Peso</div>
			<div class="col-sm-1">TA</div>
			<div class="col-sm-1">FU</div>
			<div class="col-sm-2">Labs/US</div>
			<div class="col-sm-1">DX</div>
			<div class="col-sm-4">Tratamientos</div>
			<div class="col-sm-1">Peso</div>
		</div>
	</div>
	<?php foreach($hgico as $dgineco){?>
	<div class=" demo-grid widget-inner print">
		<b style="font-weight:bold;color:red;">Fecha <?php echo $dgineco['fecha']?></b>
		<div class="form-group">
			<div class="col-sm-1" style="height: 70px;"><?php echo $dgineco['sdg']?>&nbsp;</div>
			<div class="col-sm-1" style="height: 70px;"><?php echo $dgineco['peso']?>&nbsp;</div>
			<div class="col-sm-1" style="height: 70px;"><?php echo $dgineco['ta']?>&nbsp;</div>
			<div class="col-sm-1" style="height: 70px;"><?php echo $dgineco['fu']?>&nbsp;</div>
			<div class="col-sm-2" style="height: 70px;"><?php echo $dgineco['labs']?>&nbsp;</div>
			<div class="col-sm-1" style="height: 70px;"><?php echo $dgineco['sdg']?>&nbsp;</div>
			<div class="col-sm-4" style="height: 70px;"><?php echo $dgineco['tratamiento']?> &nbsp;</div>
			<div class="col-sm-1" style="height: 70px;"><?php echo $dgineco['peso']?>&nbsp;</div>
		</div>
	</div>
	<?php }} ?>
	<hr />
	<br />
	<form class="form-horizontal" action="./system/proceso.php?tipo=gineconsulta&codigo=<?php echo $_GET['r']?>&consulta=<?php echo $_GET['c']?>&url=<?php echo dameURL()?>" method="post" autocomplete="off">											
		<h4>Consultas</h4>
		<div class=" demo-grid widget-inner print">
			<div class="form-group">
				<div class="col-sm-2">
					<input type="text" class="required form-control" name="examen[]" placeholder="SDG" />
				</div>
				<div class="col-sm-2">
					<input type="text" class="required form-control" name="examen[]" placeholder="Peso" />
				</div>
				<div class="col-sm-2">
					<input type="text" class="required form-control" name="examen[]" placeholder="TA" />
				</div>
				<div class="col-sm-2">
					<input type="text" class="required form-control" name="examen[]" placeholder="FU" />
				</div>
				<div class="col-sm-4">
					<input type="text" class="required form-control" name="examen[]" placeholder="Labs/US" />
				</div>
			<br />
				<div class="col-sm-3">
					<input type="text" class="required form-control" name="examen[]" placeholder="DX" />
				</div>
				<div class="col-sm-6">
					<input type="text" class="required form-control" name="examen[]" placeholder="Tratamientos" />
				</div>
				<div class="col-sm-3">
					<input type="text" class="required form-control" name="examen[]" placeholder="peso" />
				</div>
			</div>
			<div class="form-actions text-right">
				<input type="submit" value="Guardar consulta" class="btn btn-primary" />
			</div>
		</div>
	</form>	
											
											</div>
										<!-- /cerramos consulta -->	
										</div>				
									
									</div>
									<?php } ?>
								
									<!-- Lista para datos generales -->
									<div class="tab-pane fade" id="datos">








									
											<div class="row demo-grid widget-inner ">
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Antecedentes familiares:</b> <?php echo $data_pas[0]['afamiliar']?> </p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Antecedentes médicos:</b> <?php echo $data_pas[0]['apaciente']?> </p>
												</div>
											</div>
											</div>
										
											<div class="row demo-grid widget-inner ">
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Antecedentes quirúrgicos:</b> <?php echo $data_pas[0]['a_quirurgico']?> </p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Antecedentes traumáticos:</b> <?php echo $data_pas[0]['atraumatico']?> </p>
												</div>
											</div>
											</div>
										
										
											<div class="row demo-grid widget-inner ">
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Antecedentes alérgicos:</b> <?php echo $data_pas[0]['aalergicos']?> </p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Observaciones:</b> <?php echo $data_pas[0]['obs']?> </p>
												</div>
											</div>
											</div>						
										
										
										
										
										
										

										
									</div>
									<!-- /Lista para datos generales  -->				

									<div class="tab-pane fade in" id="navs">
										<!-- Accordion group 
										Mostramos historial en base de datos-->
												<div class="row">
													<div class="col-md-12">
														<div class="panel-group widget" id="accordion">
															<?php //buscamos historia
															$bhistoria = db ("SELECT * FROM `p_historial` WHERE `paciente` LIKE '".$_GET['r']."' ORDER BY  `p_historial`.`fecha` DESC  ",$mysqli);
															if ($bhistoria[0]['paciente']==""){?>
																<h1>No hay historial para este paciente</h1>										   
															<?php } else { foreach($bhistoria as $datos){ $nn++; 
															$sql = db("SELECT * FROM `consultas` WHERE `consulta` LIKE '".$datos['c_consulta']."'  ",$mysqli);?>								
															<div class="panel panel-default">
																<div class="panel-heading">
																	<h6 class="panel-title">
																		<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $nn; ?>">Consulta <?php echo $datos['fecha']?> </a> <-------------> <a href="modconsulta?c=<?php echo $datos['c_consulta'] ?>&p=<?php echo $_GET['r'] ?>&n=<?php echo $data_pas[0]['nombre']." ".$data_pas[0]['apellido']?>&id=<?php echo $datos['id']?>&idc=<?php echo $sql[0]['id']?>"> Editar </a>
																		 <-------------> <a href="doctor.php?r=<?php echo $_GET['r'] ?>&c=<?php echo $_GET['c']?>&seg=<?php echo $_GET['seg'] ?>&eliminar=yes&id=<?php echo $datos['id']?>">Eliminar esta consulta</a>
																	</h6>
																</div>
															   
																<div id="collapse<?php echo $nn; ?>" class="panel-collapse collapse">
																<!-- in en clase obliga a desplegar -->
																	<div class="panel-body">
																		
																		<div class="row demo-grid widget-inner ">
																			<div class="col-md-2">
																				<div class="innerAll text-center">
																					<span class="text-large strong" style="color:red;font-weight: bold;"><?php echo $sql[0]['pulso']?></span><br/>
																					Pulso
																				</div>
																			</div>
																			<div class="col-md-2">
																				<div class="innerAll text-center">
																					<span class="text-large strong " style="color:red;font-weight: bold;"><?php echo $sql[0]['peso']?></span><br/>
																					Peso
																				</div>
																			</div>
																			<div class="col-md-2">
																				<div class="innerAll text-center">
																					<span class="text-large strong" style="color:red;font-weight: bold;"><?php echo $sql[0]['talla']?></span><br/>
																					Talla
																				</div>
																			</div>

																			<div class="col-md-2">
																				<div class="innerAll text-center">
																					<span class="text-large strong" style="color:red;font-weight: bold;"><?php echo $sql[0]['diastolica']?></span><br/>
																					Diastólica
																				</div>
																			</div>						
																			<div class="col-md-2">
																				<div class="innerAll text-center">
																					<span class="text-large strong" style="color:red;font-weight: bold;"><?php echo $sql[0]['sistolica']?></span><br/>
																					Sistólica
																				</div>
																			</div>
																			<div class="col-md-2">
																				<div class="innerAll text-center">
																					<span class="text-large strong" style="color:red;font-weight: bold;"><?php echo $sql[0]['temperatura']?> °c</span><br/>
																					Temp
																				</div>
																			</div>
																		</div>		
																		<?php 
										//si es consulta gineco obstetra
										
										if(substr($datos['c_consulta'], 0, 2)=="Go"){
										
										?>
										<div class="row demo-grid widget-inner ">
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['fur']?></span><br/>
													FUR
												</div>
											</div>
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['gestas']?></span><br/>
													Gestas
												</div>
											</div>
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['partos']?></span><br/>
													Partos
												</div>
											</div>

											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['abortos']?></span><br/>
													Abortos
												</div>
											</div>						
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['cesarias']?></span><br/>
													Cesarias
												</div>
											</div>
											<div class="col-md-2">
												<div class="innerAll text-center">
													<span class="text-large strong"><?php echo $data_con[0]['rh']?></span><br/>
													RH
												</div>
											</div>
										</div>
										<?php }		?>							   
																			




											<div class="row demo-grid widget-inner ">
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Motivo de consulta:</b> <?php echo $datos['motivo']?></p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Historia médica:</b> <?php echo $datos['historia']?></p>
												</div>
											</div>
											</div>
														
											<div class="row demo-grid widget-inner ">
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Examen Físico:</b> <?php echo $datos['examen_f']?></p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Impresión clínica:</b> <?php echo $datos['i_clinica']?></p>
												</div>
											</div>
											</div>
														
											<div class="row demo-grid widget-inner ">
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Tratamiento:</b> <?php echo $datos['tratamiento']?></p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="innerAll">
													<p><b style="color:blue">Plan educacional:</b> <?php echo $datos['plan']?></p> 
												</div>
											</div>
											</div>														
																		
											<div class="row demo-grid widget-inner ">
											<div class="col-md-12">
												<div class="innerAll">
													<p><b style="color:blue">Laboratorios:</b> <?php echo $datos['laboratorios']?></p>
												</div>
											</div>
											</div>															
																		
																	</div>
																</div>
															</div>
															
															
					   

					   
														
															<?php } } ?>
														</div>
													</div>
												</div>
												

										<!-- /accordion group -->

									</div>
									<!-- /first tab -->


									<!-- laboratorios -->
									<div class="tab-pane fade" id="navbars">
										Resultados Lab
									<?php if($labos = db("SELECT * FROM `labimg` WHERE `paciente` LIKE '".$_GET['r']."'",$mysqli)){?>	
									<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
									  <tr>
										<td width="4%" align="center" valign="middle">No.</td>
										<td width="32%" align="center" valign="middle">Tipo</td>
										<td width="42%" align="center" valign="middle">Fecha</td>
										<td width="22%" align="center" valign="middle">Ver</td>
									  </tr>
									  
									  <?php
									   foreach($labos as $info){
									  $n++;
									  ?>
									  <tr>
										<td align="center" valign="middle"><?php echo $n;?></td>
										<td align="center" valign="middle"><?php echo $info['tipo'];?></td>
										<td align="center" valign="middle"><?php echo $info['fecha'];?></td>
										<td align="center" valign="middle"><a href="papanicolao/<?php echo $info['imagen'];?>" rel="prettyPhoto[]">Ver Resultado</a></td>
									  </tr>
									  <?php } ?>
									  
									</table>
									<?php } ?>	
										
										
									</div>
									<!-- /second tab -->
									
									
									
									<!-- Cuarta pestaña -->
									
									<div class="tab-pane fade in" id="receta">
										<div class="row">
											<div class="col-md-12">
											
											
											
										<form class="form-horizontal" role="form" action="javascript:void(0)">
					
											
										<div id="print">	
										<div class="form-group">
											<label class="col-sm-2 control-label">Diagnostico </label>
											<div class="col-sm-10">
												<textarea cols="5" class="elastic form-control" placeholder="Diagnostico en formato texto"></textarea>
											</div>
										</div>
										</div>
										
										<div class="form-actions text-right">
											<input class="btn btn-info btn-large print" type="button" value="Imprimir" onclick="javascript:window.print();" />
										</div>

											
										</form>	
											
											
											
											
											
											
											
											
											
											
											
											</div>
										</div>				
									
									</div>
									
									
									
									
									
									
									
									
									

								</div>
							</div>
							<!-- /page tabs -->
							
							
							
									
									
									
									
									
								</div>
								<?php } //termina if de paciente ?>

								<!-- // END col -->

								<!-- col informa de pacientes en cola-->
								<div class="col-sm-3 print">
								
									<div id="colores" class="widget">
										<div class="widget-head	">
											<h4 class="heading pull-left">Cola de pacientes</h4>
											<div class="clearfix"></div>
										</div>
										<div class="widget-body padding-none">
											
											<div id="divtest">Cargando <br /> <img src="images/ajax-loader.gif" /></div>

										</div>
										<!-- // End Widget-body-->
									</div>
									<!-- // END widget -->
								</div> 
								<!-- // END col -->
								
							</div>
										
										
										
										
										
										
										
							<!-- Footer -->
								<?php pie() ?>
							<!-- /footer -->
										
										
										
										
											
										</div>                     
									
									
					</div>
                    <!-- /headings, Open Sans -->

        </div>
        <!-- /page content -->

    </div>
    <!-- page container -->

	
     

	
</body>
</html>

<?php
$cntACmp =ob_get_contents();
ob_end_clean();
$cntACmp=str_replace("\n",' ',$cntACmp);
$cntACmp=ereg_replace('[[:space:]]+',' ',$cntACmp);
ob_start("ob_gzhandler");
echo $cntACmp;
ob_end_flush();
?>