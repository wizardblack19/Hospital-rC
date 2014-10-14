<?php
	ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	if(login_check($mysqli) != true) {
	   header('Location: ./login?url='.dameURL());
	}
	$llave = $_SESSION['user_id'].date('YmdHis');
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
	function producto(){
		var var_codigo 	= $('#search').val();
		var var_tipo 	= $('#tipos').val();
		if (var_codigo){
			$("#productos").load("revisa.php?tipo=buscaproducto",{codigo:var_codigo,tipop:var_tipo});
		}
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
            <!-- Page title -->
        	<div class="page-title">
                <h5><i class="fa fa-warning"></i> Listado de precios</h5>
            </div>
            <!-- /page title -->
            <div class="error-wrapper offline text-center">
                <!-- Error content -->
                <div class="error-content">
				
					<div class="form-group">
						<div class="col-sm-10">
							<select name="unstyled-select" id="tipos" onchange="producto()" class="required form-control">
								<option value="1">Medicamentos</option>
								<option value="2">Laboratorio</option>
							</select>
						</div>
					</div>
                    <div class="input-group">
                        <input type="text" id="search" onkeyup="producto()" class="form-control" placeholder="Escriba el codigo o nombre del producto">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">B</button>
                            </span>
                    </div>
                </div>
                <!-- /error content -->
            <!-- Pre-scrollable table -->
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Listado de productos</h6></div>
                <div class="table-responsive pre-scrollable">
                    <div id="productos"></div>
                </div>
            </div>
            <!-- /pre-scrollable table -->
            </div>

        
        </div>
        <!-- /page content -->
    </div>
    <!-- page container -->
</body>
</html>