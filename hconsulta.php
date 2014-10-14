<?php
	ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	if(login_check($mysqli) != true) {
	   header('Location: ./login?url='.dameURL());
	}

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
<script type="text/javascript">
	/* Busqueda automatica de productos por medio de nombre o codigo*/	
	function buscar(){
		var var_codigo 	= $('#info').val();
		$("#search").load("data.php?tipo=historia",{codigo:var_codigo});
	}
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
                    <div class="panel panel-default">
                        <div class="panel-heading"><h6 class="panel-title">Historial de consultas</h6></div>
                        <div class="panel-body">

						
						
						<?php if(!$_GET['consulta']){?>
						

							<!-- Error wrapper -->
							<div class="error-wrapper offline text-center">
								<h5>- Buscar pacientes por nombre o apellido -</h5>

								<!-- Error content -->
								<div class="error-content">
									
										<div class="input-group">
											<input type="text" id="info" class="form-control" placeholder="Nombre o apellido de paciente" />
											<span class="input-group-btn">
												<button class="btn btn-primary" type="button" onclick="buscar();">buscar</button>
											</span>
										</div>
									

									<div class="row">

									</div>
								</div>
								<!-- /error content -->

							</div>  
							<!-- /error wrapper -->
						
						
						<div class="datatable-tools" id="search"></div>

						
						
						
						
						
						
						
						
						<?php } 
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						if ($_GET['consulta']){
						//parte final generador y asignador de consulta
						?>

					            <!-- Page tabs -->
            <div class="tabbable page-tabs">

                        <!-- Accordion group 
						Mostramos historial en base de datos-->


							
								
                                <div class="row">
                                    <div class="col-md-12">

										<div class="panel-group widget" id="accordion">  
										  <?php
											//buscamos historia
											
											$bhistoria = db ("SELECT * FROM `p_historial` WHERE `paciente` LIKE '".$_GET['codigo']."' ORDER BY  `p_historial`.`fecha` DESC  ",$mysqli);
											if ($bhistoria[0]['paciente']==""){
											?>
												<h1>No hay historial para este paciente</h1>
										   
											<?php } else {
											
											foreach($bhistoria as $datos){
											
											$nn++;
											?>									
                                        
                                           

										<?php
						$sql = db("SELECT * FROM `consultas` WHERE `consulta` LIKE '".$datos['c_consulta']."' limit 0,1 ",$mysqli);?>   
										   
										   
										   <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h6 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $nn; ?>">Ver consulta <?php echo $datos['fecha']." - ".$datos['c_consulta']?> </a> < - - - - - - - - - - > <a href="modconsulta?c=<?php echo $datos['c_consulta']?>&p=<?php echo $_GET['codigo']?>&n=<?php echo $_GET['n']?>&id=<?php echo $datos['id']?>&idc=<?php echo $sql[0]['id']?>">Editar esta consulta</a>
                                                    </h6>
                                                </div>
                                               
											   <div id="collapse<?php echo $nn; ?>" class="panel-collapse collapse"> <!-- in en clase obliga a desplegar -->
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
									<span class="text-large strong"><?php echo $sql[0]['fur']?></span><br/>
									FUR
								</div>
							</div>
							<div class="col-md-2">
								<div class="innerAll text-center">
									<span class="text-large strong"><?php echo $sql[0]['gestas']?></span><br/>
									Gestas
								</div>
							</div>
							<div class="col-md-2">
								<div class="innerAll text-center">
									<span class="text-large strong"><?php echo $sql[0]['partos']?></span><br/>
									Partos
								</div>
							</div>

							<div class="col-md-2">
								<div class="innerAll text-center">
									<span class="text-large strong"><?php echo $sql[0]['abortos']?></span><br/>
									Abortos
								</div>
							</div>						
							<div class="col-md-2">
								<div class="innerAll text-center">
									<span class="text-large strong"><?php echo $sql[0]['cesarias']?></span><br/>
									Cesarias
								</div>
							</div>
							<div class="col-md-2">
								<div class="innerAll text-center">
									<span class="text-large strong"><?php echo $sql[0]['rh']?></span><br/>
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
            <!-- /page tabs -->
						
						

						<?php } ?>


						
						
						
						
						
						
						
												
            <!-- Footer -->
			<br />
			<br />
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