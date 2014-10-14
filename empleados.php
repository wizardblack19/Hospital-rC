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

</head>

<body>

    <!-- Navbar -->
	<?php barra()?>
	<!-- /navbar -->

    <!-- Page header -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="logo"><a href="/" title=""><img src="images/logo.png" width="280" alt="<?php echo hospital(0);?>"></a></div>

			
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
            <form class="form-horizontal validate" action="./system/proceso?tipo=empleado&url=<?php echo dameURL();?>" role="form" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Agregar Empleados</h6></div>
                    <div class="panel-body">
						<?php if($_GET['id']){?>
                        <div class="alert alert-info fade in widget-inner">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            Usuario agregado correctamente.
                        </div>
						<?php } ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Titúlo: </label>
                            <div class="col-sm-4">
                                <select data-placeholder="Ninguno" name="titulo" class="select">
                                    <option value=""></option>
                                    <option value="Enfro">Enfro.</option>
                                    <option value="Enfra">Enfra.</option>
                                    <option value="Dr">Dr.</option>
                                    <option value="Dra">Dra.</option>
                                    <option value="Lic">Lic.</option>
                                    <option value="Licda">Licda.</option>
                                </select>
                            </div>
                        
						    <label class="col-sm-2 control-label">Departamento: <span class="mandatory">*</span></label>
                            <div class="col-sm-4">
                                <select data-placeholder="Modulo administrativo" name="dep" class="required select">
                                    <option value=""></option>
                                    <option value="0">Recepción o Secretaría</option>
									<option value="3">Doctor Interno</option>
                                    <option value="4">Doctores Externo</option>
									

                                    <!--<option value="3">Hospital</option>
                                    <option value="4">Enfermería</option>
                                    <option value="5">Contabilidad</option>-->

                                </select>
                            </div>
						
						</div>						
						
						
						
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nombre: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nombre" />
                            </div>
                        
							<label class="col-sm-2 control-label">Apellido: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="apellido" />
                            </div>
						
						</div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Correo: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="user" />
								<span class="label label-danger label-block text-center">Se usara como usuario</span>
                            </div>
                        
							<label class="col-sm-2 control-label">Contraseña: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="pass" />
								<span class="label label-danger label-block text-center">No puede cambiarse en esta versión</span>
                            </div>
						
						</div>

                        
                        <div class="form-group" style="display:none">
						    <label class="col-sm-2 control-label">Comisión: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  name="porcentaje" placeholder="10"/>
								<span class="label label-danger label-block text-center">Guardar</span>

                            </div>
							
                        </div>		
						


                        <div class="form-actions text-right">
                            <input type="submit" value="Agregar Empleados" class="btn btn-primary">
                        </div>

                    </div>
                    
                </div>
            </form>
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