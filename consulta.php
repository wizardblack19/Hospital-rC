<?php
	//ob_start();
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

<script type="text/javascript">
	function pagoOnChange(sel) {
      if (sel.value=="2" ){
           $("#gineco").show();
      }
		else if (sel.value=="1"){
		           $("#gineco").hide();

		}
	}
</script>

<script type="text/javascript">
	/* Busqueda automatica de productos por medio de nombre o codigo*/	
	function buscar(){
		var var_codigo 	= $('#info').val();
		$("#search").load("data.php?tipo=consulta",{codigo:var_codigo});
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



			
			
			
			
			
		<!-- Headings, Open Sans -->
                    <div class="panel panel-default">
                        <div class="panel-heading"><h6 class="panel-title">Buscar Pacientes</h6></div>
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
						<h3> Detalle de Consulta </h3>

						<form class="form-horizontal validate" action="./system/proceso.php?tipo=consulta&codigo=<?php echo $_GET['codigo']?>" method="post" role="form">
							<div class="panel-body">

								<div class="form-group">
									<label class="col-sm-2 control-label">Tipo: <span class="mandatory">*</span></label>
									<div class="col-sm-10">
										<div class="radio">
											<label>
												<input type="radio" name="tipo" value="1" class="styled required" onChange="pagoOnChange(this)"/>
												 Consulta General
											</label>
									  
											<label>
												<input type="radio" name="tipo" value="2" class="styled" onChange="pagoOnChange(this)"/>
												 Gineco Obstetra
											</label>
											
											
										</div>
									</div>
								</div>
								
								
								<div class="form-group">
									<div class="col-md-2">
										<input type="text" class="form-control" name="talla" placeholder="Talla" />
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="pulso" placeholder="Pulso" />
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="peso" placeholder="Peso" />
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="diastolica" placeholder="Diastólica" />
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="sistolica" placeholder="Sistólica" />
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="temperatura" placeholder="Temperatura" />
									</div>							
								</div>

								<div class="form-group" id="gineco" style="display: none;">
									<div class="col-md-2">
										<input type="text" class="form-control" name="fur" placeholder="FUR" />
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="gestas" placeholder="Gestas" />
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="partos" placeholder="Partos" />
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="abortos" placeholder="Abortos" />
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" name="cesarias" placeholder="Cesarias" />
									</div>
									<!--<div class="col-md-2">
										<input type="text" class="form-control" name="temperatura" placeholder="Temperatura" />
									</div>-->
								</div>								
								
								
								<div class="form-group">
									<label class="col-sm-2 control-label">Hospitalización: </label>
									<div class="col-sm-10">
										<div class="widget-inner">

											<label class="checkbox-inline">
												<input type="checkbox" name="rh" value="1" class="styled" />
												Paciente requiere hospitalización
											</label>

										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Referido: </label>
									<div class="col-sm-4">
										<select data-placeholder="Referido..." name="referido" class="select">
											<option value=""></option>
											<option value="opt2">Dr. Jose</option>
											<option value="opt3">Dr. Roble</option>
											<option value="opt4">Dr. Ramos</option>
											<option value="opt5">Dr. Rodolfo</option>
										</select>
									</div>

									
									
								<label class="col-sm-2 control-label">Doctor: </label>
									<div class="col-sm-4">
										<select data-placeholder="Doctor que atiende" name="doctor" class="select">
											<option value="11">Dr. Hugo Cifuentes</option>
											<?php $docint = db("SELECT * FROM `usuarios` WHERE `tipo` = 3 ",$mysqli); 
												foreach($docint as $DI){
											?>
											<option value="<?php echo $DI['id']?>"><?php echo $DI['titulo'].". ".$DI['nombre']." ".$DI['apellido']; ?></option>
											
											
											<?php } ?>
										</select>
									</div>
									
									
									
									
									
									
									
									
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Observaciones: </label>
									<div class="col-sm-10">
										<textarea rows="5" cols="5" name="observaciones" class="form-control"></textarea>
									</div>
								</div>

								<div class="form-actions text-right">
									<input type="submit" value="Asignar Consulta" class="btn btn-primary">
								</div>

							</div>
						</form>
					


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
/* $cntACmp =ob_get_contents();
ob_end_clean();
$cntACmp=str_replace("\n",' ',$cntACmp);
$cntACmp=ereg_replace('[[:space:]]+',' ',$cntACmp);
ob_start("ob_gzhandler");
echo $cntACmp;
ob_end_flush(); */
?>