<?php
require_once('./system/configdb.php');
require_once('./system/funciones.php');
sec_session_start();

if(login_check($mysqli) == true) {
   header('Location: ./');
}
if ($_GET['Process']=="logout"){
sec_session_start(); //Desconfigura todos los valores de sesión
$_SESSION = array(); //Obtén parámetros de sesión
$params = session_get_cookie_params(); //Borra la cookie actual
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]); //Destruye sesión
session_destroy();
header('Location: ./login?t=session_cerrada');
}

if ($_GET['Process']=="login"){

if(isset($_POST['nick'], $_POST['pass'])) {
   $email = $_POST['nick'];
   $password = $_POST['pass']; //La contraseña con hash
   if(login($email, $password, $mysqli) == true) {

		header('Location: ./?session='.rand(999999999999999,111111111111111));

		//Inicio de sesión exitosa
   } else {
    header('Location: ./login?error=RXJyb3IgYWwgaW50ZW50YXIgaW5ncmVzYXIsIHBvciBmYXZvciB2ZXJpZmlxdWUgc3Ugbm9tYnJlIGRlIHVzdWFyaW8geSBjb250cmFzZcOxYQ==');
	//Inicio de sesión fallida
        
   }
} else {
   header('Location: ./login?error=U2UgZGV0ZWN0w7MgdW4gZXJyb3IgYWwgcmVjaWJpciBsb3MgZGF0b3MsIHBvciBmYXZvciBpbnRlbnRhIGRlIG51ZXZvLg');
   //Las variaciones publicadas correctas no se enviaron a esta página
}



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

<style type="text/css">
<!--


#caja{
background-image:url(./images/fondos.jpg);
background-position: center center;
position:relative;
overflow:auto;
background-repeat:no-repeat;

} 
-->
</style>




</head>

<body id="caja" class="full-width">



    <!-- Page container -->
    <div  class="page-container container-fluid">
    
        <!-- Page content -->
        <div class="page-content">


            <!-- Login wrapper -->
            <div class="login-wrapper">
                <form action="login?Process=login" role="form" class="validate" method="post">
						
                    <div class="panel panel-default">
                        <div class="panel-heading"><h6 class="panel-title"><i class="fa fa-user"></i> Usuarios <?php echo hospital(0);?></h6></div>
                        <div class="panel-body">
                            <div class="form-group has-feedback">
                                <label>Usuario</label>
                                <input type="text" class="required form-control" name="nick" placeholder="Usuario" id="firstname">
                                <i class="fa fa-user form-control-feedback"></i>
                            </div>

                            <div class="form-group has-feedback">
                                <label>Contraseña</label>
                                <input type="password" class="required form-control" name="pass" placeholder="Contraseña" id="enter_password">
                                <i class="fa fa-lock form-control-feedback"></i>
                            </div>

                            <div class="row form-actions">
                                <div class="col-xs-6">
                                    <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="styled">
                                        Recuerdame
                                    </label>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-bars"></i> Ingresar</button>
                                </div>
                            </div>
                        </div>
                    </div>
					
				<div class="alert alert-info fade in widget-inner">
                    <button type="button" class="close" data-dismiss="alert">×</button>
					<?php if(!$_GET['error']){?>
                   Si no recuerda alguno de estos datos solicítelo al administrador de sistema
				   <?php } else { echo base64_decode($_GET['error']);}?>
				</div>
					
                </form>
            </div>  
            <!-- /login wrapper -->      

        
        </div>
        <!-- /page content -->

    </div>
    <!-- page container -->
<!--Scrip java -->



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
</body>
</html>
