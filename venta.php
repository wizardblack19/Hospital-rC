<?php
	ob_start();
	require_once('./system/configdb.php');
	require_once('./system/funciones.php');
	sec_session_start();
	if(login_check($mysqli) != true) {
	   header('Location: ./login.php?url='.dameURL());
	}
	$llave = $_SESSION['user_id'].date('YmdHis');
	$sql = db("SELECT * FROM `producto` ",$mysqli);
	$arreglo_php = array();
	if(count($sql)==0)
	   array_push($arreglo_php, "No hay datos");
	else{
	  foreach($sql as $palabras){
		array_push($arreglo_php, $palabras["nombre"]);
		array_push($arreglo_php, $palabras["barras"]);
	  }}
	$fecha = date('Ymdhis');
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
<link href="./css/jquery-ui-1.8.17.custom.css" rel="stylesheet" type="text/css">
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

<style>

.cabecera {
    visibility: hidden;
	display: none;
}


</style>


	<script type="text/javascript">
	  $(function(){
		var autocompletar = new Array();
		<?php /*Esto es un poco de php para obtener lo que necesitamos*/
		 for($p = 0;$p < count($arreglo_php); $p++){ /*usamos count para saber cuantos elementos hay*/ ?>
		   autocompletar.push('<?php echo $arreglo_php[$p]; ?>');
		 <?php } ?>
		 $("#buscar").autocomplete({ /*Usamos el ID de la caja de texto donde lo queremos*/
		   source: autocompletar /*Le decimos que nuestra fuente es el arreglo*/
		 });
	  });
	/* Busqueda automatica de productos por medio de nombre o codigo*/	
	function producto(){
		var var_nombre 	= $('#buscar').val();
		var var_tiprec 	= $('#tdp').val();
		var var_bodega 	= $('#bod').val();
		var var_doctor 	= $('#doc').val();
		var var_tipopr 	= $('#tipo').val();
		var var_cantid 	= $('#can').val();
		var var_existe 	= $('#exi').val();
		if (var_existe != 9999999){
		if (var_nombre){
			$("#productos").load("./nventa.php?tipo=buscaproducto",{nombre:var_nombre,tipoprecio:var_tiprec,bodega:var_bodega,doctor:var_doctor,tipoproducto:var_tipopr,cantidad:var_cantid,llave:'<?php echo $fecha;?>'});
		}
		$("#pie").show();
		} else {
		alert ('No hay suficiente producto');
		}
		$('#buscar').val("");
		$('#can').val("1");

	}
	/*Borrar producto de la cola */
	function borra(id){
		var var_nombre 	= $('#buscar').val();
		$("#productos").load("./nventa.php?temporal=<?php echo $fecha;?>&id="+id,{nombre:var_nombre});
		$("#pie").show();
		total();
	}
	/*Existencia de productos */
	function existencia(){
		var var_nombre 	= $('#buscar').val();
		var var_bodega 	= $('#bod').val();
		$("#unidades").load("./revisa.php?tipo=unidades",{nombre:var_nombre,bodega:var_bodega});
	}
	/*Preparar seccion de impresion */
	function imprSelec(muestra){
	datoscotiza();	
	var ficha=document.getElementById(muestra);
	var ventimp=window.open(' ','popimpr');

	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
	
	borrartodo();
	
	}
	
	function datoscotiza(){
		var person = prompt("Ingrese el nombre del cliente");
		if (person != null) {
		document.getElementById("nombrec").innerHTML = person;
	}
	
	}
	
	
	
	function borrartodo() {
		if(confirm("¿A terminado de imprimir una cotización o bien a cancelado una orden? Si desea eliminar la cola por favor presione aceptar, si desea continuar con el pedido presione cancelar...")) {
			$("#productos").load("./nventa.php?temporal=<?php echo $fecha;?>");
			$("#pie").hide();
		}
	}
	
	
	/*ocultamos id pie de factura al terminar de cargar pagina */
	$( document ).ready(function() {
		$("#pie").hide();
	});
	
	/* Generar Orden */
	function orden(){
		var dir 		= $('#dir').val();
		var nit 		= $('#nit').val();
		var nombre 		= $('#nombre').val();
		var descuento 	= $('#descuento').val();
		var cargo	 	= $('#cargovisa').val();
	if (confirm("Esta a punto de generar esta orden esto no lo podra deshacer. Desea continuar")){
	/* afirmativo */	
		$("#hecho").load("./revisa.php?tipo=orden",{llave:'<?php echo $fecha;?>',nombre:nombre,nit:nit,dir:dir,descuento:descuento,cargo:cargo});
		  
		}
	setTimeout ("redireccionar()", 500);
	}
	
	function redireccionar(){
	  window.location="./venta.php?idsave=<?php echo date('Ymdhis')?>";
	}

	function total(){
		var descuento 	= $('#descuento').val();	
		$("#total").load("./revisa.php?tipo=ctotal",{llave:'<?php echo $fecha;?>',descuento:descuento});
	}	

	
	/* Borrar presupuesto o cancelar orden */
	</script>
</head>

<body>

    <!-- Navbar -->
	<?php barra()?>
	<!-- /navbar -->
	
	
	
	
	            <!-- Form modal -->
            <div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5 class="modal-title">Datos Generales</h5>
                        </div>

                        <!-- Form inside modal -->
                        <form action="#" role="form">

                            <div class="modal-body has-padding">

                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <label>Nombre</label>
                                        <input type="text" id="nombre" placeholder="Nombre" class="form-control">
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="control-label">Nit</label>
                                        <input type="text" id="nit" placeholder="Nit" class="form-control">
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <label>Dirección</label>
                                        <input type="text" id="dir" placeholder="Dirección" class="form-control">
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="control-label">Id Orden</label>
                                        <input type="text" value="<?php echo $fecha;?>" class="form-control">
                                    </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="javascript:orden();">Guardar Orden</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- /form modal -->
	
	<!-- Page header -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="logo"><a href="./" title=""><img src="images/logo.png" width="280" alt="<?php echo hospital(0);?>"></a></div>
            <ul class="middle-nav">
                <li><a href="./precio.php" class="btn btn-default"><i class="fa fa-comments-o"></i> <span>Precios</span></a><!--<div class="label label-info">9</div>--></li>
            </ul>
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

            <!-- Right labels -->
            <form class="form-horizontal" action="#" role="form">
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title"><i class="fa fa-bars"></i> Punto de venta <small>Versión Alpha (Puede tener errores por favor verifique y reporte los errores que detecte)</small></h6></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-12 control-label text-left" style="color:red">* Seleccione un referido solo si aplica, se aplicara a todo incluyendo medicina, verifique siempre este campo segun sea el caso</label>
                        </div>	
                        <div class="form-group">
							<div id="hecho"></div>
                            <div class="col-sm-3">
                                <select data-placeholder="Referido si aplica" id="doc" class="select-search">
									<option value="">No refiere ningun Doctor</option>
									<?php $doc = db("SELECT * FROM `doctores` ",$mysqli);
									foreach ($doc as $doctor){ ?>
									<option value="<?php echo $doctor['id'];?>"><?php echo $doctor['nombre']?></option>
									<?php } ?>
                                </select>
                            </div>
							
                            <div class="col-sm-3">
                                <select data-placeholder="Tipo de Precio" id="tdp" class="select">
									<option value="A">Precio A</option>
									<option value="B">Precio B</option>
									<option value="B">Precio C</option>
									<option value="D">Precio D</option>
									<option value="S">Precio de Seguro</option>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <select data-placeholder="Bodega" id="bod" class="select">
									<option value="1">Bodega Principal</option>
									<option value="2">Bodega Caja</option>
									<option value="3">Bodega Doctor</option>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <select data-placeholder="Tipo de producto" id="tipo" class="select">
									<option value="1">Productos</option>
									<option value="2">Servicios</option>
                                </select>
                            </div>
							
                        </div>
                        <div class="form-group">
 					
                            <div class="col-sm-1">
                                <input type="text" id="can" value="1" class="form-control" placeholder="CT" />
                            </div>
							
                            <div class="col-sm-8">
                                <input id="buscar" type="text" class="form-control" onmousemove="existencia()" placeholder="Nombre de Articulo o Codigo de Barras" />
                            </div>
							
                            <div class="col-sm-1" id="unidades">
                                <input type="text" id="exi" value="0" onmousemove="existencia()" class="form-control" disabled />
							</div>
							
							<div class="form-actions text-left">
								<input type="button" onclick="existencia();producto();total();" value="agregar" onmousemove="existencia()" class="btn btn-primary" />
							</div>
							
                        </div>
						
				
					<!-- campo auto ajustable -->

                <div class="table-responsive pre-scrollable">
                    <div id="productos"></div>
					<div id="pie">
						<label class="col-sm-2 control-label text-left" style="color:red">Cargo Visa Cuotas %</label>	
						<div class="col-sm-2">
							<input type="text" id="cargovisa" class="form-control" value="" placeholder="+ 5" />
						</div>
						
						<label class="col-sm-2 control-label text-left" style="color:red">Descuento en Q.</label>
                            
						<div class="col-sm-2">
							<input type="text" id="descuento" class="form-control" value="" placeholder="- 0.00" />
						</div>
						
                        <label class="col-sm-2 control-label text-left" style="color:red">Tota a Pagar</label>
						
						<div class="col-sm-2" id="total">
							<input type="text" id="cargo" value="" class="form-control" placeholder="00.00" />
						</div>

						<br /><br /><br /><br />
					 
						<div class="col-sm-4">
							 <a class="btn btn-info btn-block" role="button" onclick="javascript:borrartodo();"> Cancelar </a>
						</div>					 
					 
						<div class="col-sm-4">
							 <a class="btn btn-info btn-block" onmousemove="total()" role="button" onclick="javascript:imprSelec('productos');"> Presupuesto</a>
						</div>

						<div class="col-sm-4">
							<a data-toggle="modal" onmousemove="total()" href="#form_modal" class="btn btn-info btn-block" role="button">Generar Orden</a> 
						</div>

						<label class="col-sm-12 control-label text-left" style="color:red">* Tenga en cuenta que solo se genera la orden de compra, esto no afecta la candidad de producto disponible, por lo que debe asegurar que la existencia de producto es correcta.</label>
					
					</div>
					
					
                </div>					



                    </div>
                </div>
            </form>
            <!-- /right labels -->
			
			
			
			
			
			
			
			
			
			

		
		
		
		<div id="resultado" align="center"></div>
		
		
		

		
		
		
		
		
		
		
		

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
