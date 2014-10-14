<?php
	ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	if(login_check($mysqli) != true) {
	   header('Location: ./login.php?url='.dameURL());
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo hospital(0);?></title>

<link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="./css/datepicker.css" rel="stylesheet" type="text/css">
<link href="./css/brain-theme.css" rel="stylesheet" type="text/css">
<link href="./css/styles.css" rel="stylesheet" type="text/css">
<link href="./css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="./css/fonts/cuprum.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui.min.js"></script>

<script type="text/javascript" src="./js/plugins/forms/uniform.min.js"></script>
<script type="text/javascript" src="./js/plugins/forms/select2.min.js"></script>
<script type="text/javascript" src="./js/plugins/forms/inputmask.js"></script>
<script type="text/javascript" src="./js/plugins/forms/autosize.js"></script>
<script type="text/javascript" src="./js/plugins/forms/inputlimit.min.js"></script>
<script type="text/javascript" src="./js/plugins/forms/listbox.js"></script>
<script type="text/javascript" src="./js/plugins/forms/multiselect.js"></script>
<script type="text/javascript" src="./js/plugins/forms/validate.min.js"></script>
<script type="text/javascript" src="./js/plugins/forms/tags.min.js"></script>

<script type="text/javascript" src="./js/plugins/forms/uploader/plupload.full.min.js"></script>
<script type="text/javascript" src="./js/plugins/forms/uploader/plupload.queue.min.js"></script>

<script type="text/javascript" src="./js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
<script type="text/javascript" src="./js/plugins/forms/wysihtml5/toolbar.js"></script>

<script type="text/javascript" src="./js/plugins/interface/jgrowl.min.js"></script>
<script type="text/javascript" src="./js/plugins/interface/datatables.min.js"></script>
<script type="text/javascript" src="./js/plugins/interface/prettify.js"></script>
<script type="text/javascript" src="./js/plugins/interface/fancybox.min.js"></script>
<script type="text/javascript" src="./js/plugins/interface/colorpicker.js"></script>
<script type="text/javascript" src="./js/plugins/interface/timepicker.min.js"></script>
<script type="text/javascript" src="./js/plugins/interface/fullcalendar.min.js"></script>
<script type="text/javascript" src="./js/plugins/interface/collapsible.min.js"></script>

<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/application.js"></script>
<script type="text/javascript" src="./webcam.js"></script>
</head>

<body>

    <!-- Navbar -->
	<?php barra()?>
	<!-- /navbar -->


    <!-- Page header -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="logo"><a href="./" title=""><img src="./images/logo.png" alt=""></a></div>
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
            <!-- Form validation -->
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Ficha de paciente </h6></div>
					<?php if($_GET['saved']=="yes"){ ?>
						<div class="bg-info has-padding">
							Información actualizada correctamente
						</div>
					<?php }?>

				<?php if ($_GET['tipo'] == "paciente"){ 
					if($_GET['codigo']){
					$id = $_GET['id'];
					$lugares = "actualizar";
					$actdata = db("SELECT * FROM `pacientes` WHERE `codigo` LIKE '".$_GET['codigo']."'",$mysqli);
					$ext = "&id=$id";
					}else {
					$lugares = "fichadepaciente";
					};
				?>
				<form class="form-horizontal validate" action="./system/proceso.php?tipo=<?php echo $lugares.$ext; ?>&url=<?php echo dameURL()?>" method="post" role="form">
					<div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sexo: <span class="mandatory">*</span></label>
                            <div class="col-sm-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="sexo" value="1" class="styled required" <?php if($actdata[0]['sexo']=="1"){echo 'checked';}?> />
                                        Femenino
                                    </label>
                                    <label>
                                        <input type="radio" name="sexo" value="2" class="styled" <?php if($actdata[0]['sexo']=="2"){echo 'checked';}?> />
                                        Masculino
                                    </label>
                                </div>
                            </div>
							
                            <label class="col-sm-2 control-label">Seguro Medico: <span class="mandatory">*</span></label>
                            <div class="col-sm-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="seguro" value="Si" class="styled required" <?php if($actdata[0]['seguro']=="Si"){echo 'checked';}?> />
                                        Si
                                    </label>
                              
                                    <label>
                                        <input type="radio" name="seguro" value="No" class="styled" <?php if($actdata[0]['seguro']=="No"){echo 'checked';}?> />
                                        No
                                    </label>
                                </div>
                            </div>							
                        </div>
						
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nombres: <span class="mandatory">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="required form-control" value="<?php echo $actdata[0]['nombre']?>" name="nombre" />
                            </div>
                        </div>

						<div class="form-group">
                            <label class="col-sm-2 control-label">Apellidos: <span class="mandatory">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="required form-control" value="<?php echo $actdata[0]['apellido']?>" name="apellido" />
                            </div>
                        </div>

						<div class="form-group">
                            <label class="col-sm-2 control-label">Domicilio: </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="direccion" value="<?php echo $actdata[0]['direccion']?>" />
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-sm-2 control-label">Originario de: </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['originario']?>" name="originario" />
                            </div>
                        </div>						
						
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Correo: </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['correo']?>" name="correo" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Estado Civil: </label>
                            <div class="col-sm-4">
                                <select data-placeholder="Estado Civil" name="civil" class="select">
                                    <option value=""></option>
                                    <option <?php if($actdata[0]['civil']=="Solter@"){echo 'selected';}?> value="Solter@">Solter@</option>
                                    <option <?php if($actdata[0]['civil']=="Casad@"){echo 'selected';}?> value="Casad@">Casad@</option>
                                    <option <?php if($actdata[0]['civil']=="Divorciad@"){echo 'selected';}?> value="Divorciad@">Divorciad@</option>
                                    <option <?php if($actdata[0]['civil']=="Viud@"){echo 'selected';}?> value="Viud@">Viud@</option>
									<option <?php if($actdata[0]['civil']=="Unid@"){echo 'selected';}?> value="Unid@">Unid@</option>
                                </select>
                            </div>
							<label class="col-sm-2 control-label">DPI: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['dpi']?>" name="dpi" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Celular: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['celular']?>" name="celular" />
                            </div>
                        
							<label class="col-sm-2 control-label">Telefono: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['telefono']?>" name="telefono" />
                            </div>
						
						</div>
						
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Edad: </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['nacimiento']?>" name="nacimiento" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ocupación: </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['ocupacion']?>" name="ocupacion" />
                            </div>
                        </div>
						

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Antecedentes Familiares: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['afamiliar']?>" name="afamiliar" />
                            </div>
                        
							<label class="col-sm-2 control-label">Antecedentes Médicos: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['apaciente']?>" name="apacient" />
                            </div>
						
						</div>
						
						
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Antecedentes Quirúrgicos: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['a_quirurgico']?>" name="aquirur" />
                            </div>
                        
							<label class="col-sm-2 control-label">Antecedentes Traumáticos: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['atraumatico']?>" name="atraumatico" />
                            </div>
						
						</div>						
						
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Antecedentes Alérgicos: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['aalergicos']?>" name="aalergicos" />
                            </div>
                        
							<label class="col-sm-2 control-label">Observaciones: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $actdata[0]['obs']?>" name="obs" />
                            </div>
						
						</div>
						
                        <div class="form-actions text-right">
                            <input type="submit" value="Registrar Paciente" class="btn btn-primary">
                        </div>

                    </div>
				</form>
					<?php } else{ ?>
					<div class="panel-body">
					
						<!-- Controlador de camara arranque JS -->
						
						<div id="upload_results" align="center" width="100"></div>
						
						<div align="center">
							<script language="JavaScript">
								webcam.set_api_url( './test.php?tipo=<?php echo $_GET['tipo']?>' );
								webcam.set_quality( 100 );
								webcam.set_shutter_sound( true );
								document.write( webcam.get_html(440, 360) );
							</script>
		
						<div class="row-fluid">
							<div class="span12">
							<form>
								<input class="btn btn-info btn-large" type="button" value="Tomar Foto" onClick="webcam.freeze()" />
								<input class="btn btn-info btn-large" type="button" value="Otra foto" onClick="webcam.reset()" />
								<input class="btn btn-info btn-large" type="button" value="Guardar" onClick="do_upload()" />
								<input class="btn btn-info btn-large" type="button" value="continuar" onClick="location.href='./consulta.php?consulta=generar&codigo=<?php echo $_GET['tipo']?>&id=<?php echo $_GET['id']?>'" />
							</form>
							</div>
						</div>
		
						<script language="JavaScript">
							webcam.set_hook( 'onComplete', 'my_completion_handler' );
							function do_upload() {
								document.getElementById('upload_results').innerHTML = '<h1>Guardando</h1>';
								webcam.upload();
							}
							function my_completion_handler(msg) {
								if (msg.match(/(http\:\/\/\S+)/)) {
									var image_url = RegExp.$1;
									document.getElementById('upload_results').innerHTML = 
										'<img width="100" src="' + image_url + '" />';
									webcam.reset();
								}
								else alert("PHP Error: " + msg);
							}
						</script>
				
						</div>
					</div>
					<?php }?>
                    
                </div>
            
            <!-- /form validation -->



            <!-- Footer -->
				<?php pie() ?>
            <!-- /footer -->

        
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