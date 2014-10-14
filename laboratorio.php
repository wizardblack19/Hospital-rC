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





                



            <!-- Selects -->
            <form class="form-horizontal validate" action="./system/proceso?tipo=labo&url=<?php echo dameURL();?>&cod=<?php echo $_GET['cod']?>" role="form" method="post">
                <div class="row">

				
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h6 class="panel-title">Laboratorio Clínico</h6></div>
                            <div class="panel-body">


							<?php if($_GET['cod']){
							
								$paciente = db("SELECT * FROM `pacientes` WHERE `codigo` LIKE '".$_GET['cod']."' limit 0,1",$mysqli);
							
							
							} ?>
							
						<div class="form-group">
							<label class="col-sm-2 control-label">Laboratorio: </label>
							<div class="col-sm-4">
								<select data-placeholder="Laboratorios" name="lab" class="select-search required">
											<option value=""></option> 
											<option value="lab1">Acido Urico</option>
											<option value="lab2">Ac. Anti Chlamydia  Pneumoniae IgG</option>
											<option value="lab3">Ac. Anti Chlamydia  Pneumoniae IGM</option>
											<option value="lab4">Ig inmunoglobulina  A</option>
											<option value="lab5">Quilomicrones</option>
											<option value="lab6">17 Cetosteroides.</option>
											<option value="lab7">Ac Anti microsomales</option>
											<option value="lab8">Ac Anti Mycoplasma IGG</option>
											<option value="lab9">Ac Anti Mycoplasma IGM</option>
											<option value="lab10">Ac. Anti Cisticercosis IgG</option>
											<option value="lab11">Ac. Anti Citrulinados CCP</option>
											<option value="lab12">Ac. Anti Dengue + Ag. NS 1</option>
											<option value="lab13">Ac. Anti Dengue IgG</option>
											<option value="lab14">Ac. Anti Dengue IgM</option>
											<option value="lab15">Ac. Anti Epstein Barr IgG cuantificado</option>
											<option value="lab16">Ac. Anti Epstein Barr IgM cuantificado</option>
											<option value="lab17">Ac. Anti Helicobacter Pylori IGG</option>
											<option value="lab18">Ac. Anti Helicobacter Pylori IGM</option>
											<option value="lab19">Ac. Anti Leptospira  IGG</option>
											<option value="lab20">Ac. Anti Leptospira  IGM</option>
											<option value="lab21">Ac. Anti Paperas IgG</option>
											<option value="lab22">Ac. Anti Paperas IgM</option>
											<option value="lab23">Ac. Anti Sarampion IGG</option>
											<option value="lab24">Ac. Anti Sarampion IGM</option>
											<option value="lab25">Ac. Anti Serameba (Anticuerpos Amebianos)</option>
											<option value="lab26">Ac. Anti treponema pallidum IgM</option>
											<option value="lab27">Ac. Anti treponema pallidum Totales</option>
											<option value="lab28">Ac. Anti Trypanosoma Cruzi Totales (CHAGAS)</option>
											<option value="lab29">Ac. Antitiroglobulinas</option>
											<option value="lab30">Ac. Anti-tubercolosis Totales.</option>
											<option value="lab31">Ac. Chlamydia Trachomatis IGG</option>
											<option value="lab32">Ac. Chlamydia Trachomatis IGM</option>
											<option value="lab33">Acido Folico</option>
											<option value="lab34">Acido Urico.</option>
											<option value="lab35">Acido valpróico</option>
											<option value="lab36">Acido Venil Mandelico</option>
											<option value="lab37">Ag Giardia Lamblia</option>
											<option value="lab38">Ag Rotavirus/Adenovirus</option>
											<option value="lab39">Ag Sallmonella spp</option>
											<option value="lab40">Ag. De Chlamydia trachomatis</option>
											<option value="lab41">Ag. E de Hepatitis B (HBeAg)</option>
											<option value="lab42">Ag. E de Hepatitis B (HBsAg) Australiano</option>
											<option value="lab43">Ag. Entomoeba Histolytica</option>
											<option value="lab44">Ag. P 24 HIV (metodo Elisa)</option>
											<option value="lab45">Ag. Plasmodiun ssp. (Paludismo/malaria)</option>
											<option value="lab46">Ag+ Toxina A y B de Clostridium difficile</option>
											<option value="lab47">Albumina</option>
											<option value="lab48">Alcohol</option>
											<option value="lab49">Aldolasa</option>
											<option value="lab50">Alfa Fetoproteina (AFP)</option>
											<option value="lab51">Amilasa</option>
											<option value="lab52">Amilasa</option>
											<option value="lab53">Amonio</option>
											<option value="lab54">ANA. Ac. Antinucleares Latex Tamizaje</option>
											<option value="lab55">Anfetaminas</option>
											<option value="lab56">Anti  HBc IgM (Core IgM)</option>
											<option value="lab57">Anti  HBc Total (Core Total)</option>
											<option value="lab58">Anti Cardiolipina IgG Antifosfolipidos</option>
											<option value="lab59">Anti Cardiolipina IgM Antifosfolipidos</option>
											<option value="lab60">Anti DNA Nativo Elisa Doble Cadena</option>
											<option value="lab61">Anti Endomiciales  Panel IgG/IgA</option>
											<option value="lab62">Anti Endomiciales IgA Transglutaminasa</option>
											<option value="lab63">Anti Endomiciales IgG Transglutaminasa</option>
											<option value="lab64">Anti Gladinas Panel IgA</option>
											<option value="lab65">Anti Gladinas Panel IgG</option>
											<option value="lab66">Anti Gliadinas Panel IgG/IgA</option>
											<option value="lab67">Anti Hbe (Ac Anti Ag  de Superficie)</option>
											<option value="lab68">Anti Hbe (Ac Anti Ag E de Hepatitis B)</option>
											<option value="lab69">Anti HCV (Hepatitis C)</option>
											<option value="lab70">Anti HVA IgG  (Hepatits IgG)</option>
											<option value="lab71">Anti HVA IgM  (Hepatits IgG)</option>
											<option value="lab72">Anti Trombina III</option>
											<option value="lab73">Anticuagulante Lúpico</option>
											<option value="lab74">Antiestreptolisina O ASO Cuantificado (no latex)</option>
											<option value="lab75">Astrovirus</option>
											<option value="lab76">Azul de Metileno</option>
											<option value="lab77">B-12 Vitamina</option>
											<option value="lab78">Barbituricos</option>
											<option value="lab79">Benzodiacepina</option>
											<option value="lab80">Benzodiacepina (Diazepan Valium)</option>
											<option value="lab81">Bilirrubina Directa/Indirecta</option>
											<option value="lab82">Bilirrubina Total</option>
											<option value="lab83">BK  Orina Ziehl Neelsen</option>
											<option value="lab84">BK de Esputo Ziehl Neelsen</option>
											<option value="lab85">Brucella abortus (HUDDLESON)</option>
											<option value="lab86">CA 125 Cancer de Ovario</option>
											<option value="lab87">CA 15-3 Cancer de Mama</option>
											<option value="lab88">CA 19-9 Pancreas Gastrointestinales</option>
											<option value="lab89">Calcio</option>
											<option value="lab90">Calcio</option>
											<option value="lab91">Calculo Renal.</option>
											<option value="lab92">Captacion T3 CT3 Tuptake TU T3U</option>
											<option value="lab93">Captacion y Fijacion de Hierro.</option>
											<option value="lab94">Carbamazapina (Tegretol)</option>
											<option value="lab95">CEA Antigeno Carcinoembriogenico</option>
											<option value="lab96">Celulas LE</option>
											<option value="lab97">Citomegalovirus IgG  (Quimioluminiscencia)</option>
											<option value="lab98">Citomegalovirus IgM  (Quimioluminiscencia)</option>
											<option value="lab99">CK/CPK Total/CK NAC</option>
											<option value="lab100">CKMB/CPKMB</option>
											<option value="lab101">CKMM/CPKMM</option>
											<option value="lab102">Clasificacion de Anemia</option>
											<option value="lab103">Clinitest Azucares Reductores en Heces</option>
											<option value="lab104">Cloruro</option>
											<option value="lab105">Cocaina</option>
											<option value="lab106">Colesterol HDL (Medido no Calculado)</option>
											<option value="lab107">Colesterol LDL (Medido no Calculado)</option>
											<option value="lab108">Colesterol VLDL</option>
											<option value="lab109">Colesteron HDL/LDL (Medido no Calculado)</option>
											<option value="lab110">Colesteron Total.</option>
											<option value="lab111">Colinesterasa</option>
											<option value="lab112">Complemento C3 C4</option>
											<option value="lab113">Coombs Directo</option>
											<option value="lab114">Cooms Indirecto</option>
											<option value="lab115">Coprocultivo (Shigella/Salmonella/Yersinia)</option>
											<option value="lab116">Cortisol AM</option>
											<option value="lab117">Cortisol PM</option>
											<option value="lab118">Creatinina</option>
											<option value="lab119">Creatinina.</option>
											<option value="lab120">Crigobulina</option>
											<option value="lab121">Crioaglutininas Aglutininas Frias</option>
											<option value="lab122">Cuerpos Cetonicos de Suero</option>
											<option value="lab123">Cultivo Aerobico de Esputo</option>
											<option value="lab124">Cultivo Aerobico de Liquido</option>
											<option value="lab125">Cultivo de Hongos + KOH</option>
											<option value="lab126">Cultivo de Mycobacterium tuberculosis</option>
											<option value="lab127">Cultivo de Secrecion Vaginal/Uretral</option>
											<option value="lab128">Cultivo de Secreciones Varias</option>
											<option value="lab129">Cultivo de Semen</option>
											<option value="lab130">Curva de Tolerancia de Glucosa  5 horas</option>
											<option value="lab131">Curva de Tolerancia de Glucosa 3 horas.</option>
											<option value="lab132">Depuracion de Creatinina</option>
											<option value="lab133">Depuracion de Nitrogeno de Urea.</option>
											<option value="lab134">DHEA-SO4 Dehidroepiandrosterona</option>
											<option value="lab135">DHL</option>
											<option value="lab136">DHL Liquido  Ascitico</option>
											<option value="lab137">DHL Liquido pleural</option>
											<option value="lab138">DHL Sinovial</option>
											<option value="lab139">Digoxina</option>
											<option value="lab140">Dimero D</option>
											<option value="lab141">D-Xylosa Mala Absorcion Sprue.</option>
											<option value="lab142">Enema Salino</option>
											<option value="lab143">Eritrosedimentacion</option>
											<option value="lab144">Espermograma</option>
											<option value="lab145">Estradiol E2</option>
											<option value="lab146">Factor Du</option>
											<option value="lab147">Factor Reumatoide FR Cuantificado (no latex)</option>
											<option value="lab148">Fenitoina (Difenihidantoina) Epamin</option>
											<option value="lab149">Fernobarbital</option>
											<option value="lab150">Ferritina</option>
											<option value="lab151">Fibrinogeno</option>
											<option value="lab152">Fosfatasa Acida Prostatica.</option>
											<option value="lab153">Fosfatasa Acida Total</option>
											<option value="lab154">Fosfatasa Alcalina</option>
											<option value="lab155">Fosforo</option>
											<option value="lab156">Fosforo.</option>
											<option value="lab157">Frote Periferico (POR HEMATOLOGO)</option>
											<option value="lab158">Frote Periferico (POR QUIMICO BIOLOGO)</option>
											<option value="lab159">Fructosamina</option>
											<option value="lab160">FSH Hormona Foliculo Estimulante</option>
											<option value="lab161">Gama GT</option>
											<option value="lab162">Giemsa</option>
											<option value="lab163">Glucosa Postprandial</option>
											<option value="lab164">Glucosa Preprandial</option>
											<option value="lab165">Gota Gruesa</option>
											<option value="lab166">Gram</option>
											<option value="lab167">Grupo Sanguineo y Rh.</option>
											<option value="lab168">HCG Beta Cuantificada.</option>
											<option value="lab169">HCTH Hormona Adrenocorticotropica</option>
											<option value="lab170">Heces Completo</option>
											<option value="lab171">Helicobacter pylori</option>
											<option value="lab172">Hematologia completa con plaquetas</option>
											<option value="lab173">Hematologia completa con plaquetas</option>
											<option value="lab174">Hemocultivo en Sangre</option>
											<option value="lab175">Hemoglobina Glicosilada</option>
											<option value="lab176">Herpes IgG Tipo 1</option>
											<option value="lab177">Herpes IgG Tipo 2</option>
											<option value="lab178">Herpes IgM Tipo 1</option>
											<option value="lab179">Herpes IgM Tipo 2</option>
											<option value="lab180">Hidroxiprogesterona</option>
											<option value="lab181">Hierro</option>
											<option value="lab182">HIV Anticuerpos (electroquimioluminiscencia)</option>
											<option value="lab183">Homocisteina.</option>
											<option value="lab184">Hormona del Crecimiento Post (HGH)</option>
											<option value="lab185">Hormona del Crecimiento Pre (HGH)</option>
											<option value="lab186">IgA Inmunoglobulina E</option>
											<option value="lab187">IgG IInmunoglobulina M</option>
											<option value="lab188">IgG Inmunoglobulina G</option>
											<option value="lab189">Insulina 5 Horas Curva.</option>
											<option value="lab190">Insulina de 3 Hora curva</option>
											<option value="lab191">Insulina Postprandial</option>
											<option value="lab192">Insulina Prerpandial</option>
											<option value="lab193">KOH</option>
											<option value="lab194">LH Hornona Luteinizante</option>
											<option value="lab195">Lipasa</option>
											<option value="lab196">Lipidos Totales</option>
											<option value="lab197">Liquido Amniotico.</option>
											<option value="lab198">Liquido Ascitico</option>
											<option value="lab199">Liquido Cefalorraquideo.</option>
											<option value="lab200">Liquido Pleural.</option>
											<option value="lab201">Liquido Sinovial.</option>
											<option value="lab202">Litio</option>
											<option value="lab203">Magnesio</option>
											<option value="lab204">Magnesio.</option>
											<option value="lab205">Marihuana (Tetrahidrocanabinol THC)</option>
											<option value="lab206">Metanefrinas.</option>
											<option value="lab207">Microalbumina.</option>
											<option value="lab208">Mioglobina</option>
											<option value="lab209">Nitrogeno de Urea  BUN</option>
											<option value="lab210">Nitrogeno de Urea.</option>
											<option value="lab211">Orina Completa.</option>
											<option value="lab212">Orocultivo (Garganta)</option>
											<option value="lab213">Panel de Crecimiento Insulinico (igf1+bp3)</option>
											<option value="lab214">Panel de Drogras Doping 10 Parámetros</option>
											<option value="lab215">Panel de Parasitos</option>
											<option value="lab216">Parathormona (PTH)</option>
											<option value="lab217">Paternidad ADN</option>
											<option value="lab218">PCR Proteina C Reactica Cuantificada (no latex)</option>
											<option value="lab219">PCR Ultradensible</option>
											<option value="lab220">Pectico Natriuretico (PROBNP-ND)</option>
											<option value="lab221">Perfil de Lipidos</option>
											<option value="lab222">Potasio</option>
											<option value="lab223">Potasio.</option>
											<option value="lab224">Progesterona P4</option>
											<option value="lab225">Prolactina</option>
											<option value="lab226">Proteinas en LCR</option>
											<option value="lab227">Proteinas Tolates.</option>
											<option value="lab228">Proteinas Totales y Relacion  AG</option>
											<option value="lab229">Proteinas.</option>
											<option value="lab230">Prueba de Embarazo</option>
											<option value="lab231">PSA (Antigeno Prostatico Especifico) (APE)</option>
											<option value="lab232">PSA Libre</option>
											<option value="lab233">PSA Libre/Total y Relacion</option>
											<option value="lab234">PVA</option>
											<option value="lab235">Recuento de Blancos y Formula.</option>
											<option value="lab236">Recuento de Eosinofilos en Moco</option>
											<option value="lab237">Recuento de Eritrocitos.</option>
											<option value="lab238">Recuento de Plaquetas.</option>
											<option value="lab239">Recuento de Reticulositos.</option>
											<option value="lab240">Recuentom de Eusinofilos</option>
											<option value="lab241">Rubeola IgG (Quimioluminiscencia)</option>
											<option value="lab242">Rubeola IgM (Quimioluminiscencia)</option>
											<option value="lab243">Sangre Oculta Humana (Guayaco)</option>
											<option value="lab244">Secreciones en Fresco</option>
											<option value="lab245">Sodio</option>
											<option value="lab246">Sodio.</option>
											<option value="lab247">Sodio/Potasio</option>
											<option value="lab248">Strep Test</option>
											<option value="lab249">Sudan III</option>
											<option value="lab250">T3 Libre FT3</option>
											<option value="lab251">T3 T4 CT3 FT41</option>
											<option value="lab252">T3 T4 TSH</option>
											<option value="lab253">T3 T4 TSH CT3 FT41</option>
											<option value="lab254">T3 Triyodotironina</option>
											<option value="lab255">T3T4</option>
											<option value="lab256">T4 Libre  FT4 T7 T12 T4N</option>
											<option value="lab257">T4 Tiroxina</option>
											<option value="lab258">Test de Graham</option>
											<option value="lab259">Testosterona</option>
											<option value="lab260">Testosterona Libre</option>
											<option value="lab261">TGO/ASAT</option>
											<option value="lab262">TGP/ALAT</option>
											<option value="lab263">Tiempo de Protrombina.</option>
											<option value="lab264">Tiempo de Tromboplastina Patrcial</option>
											<option value="lab265">Tinta China</option>
											<option value="lab266">Tiroglobulinas</option>
											<option value="lab267">TORCH IgG (Quimiluminiscencia)</option>
											<option value="lab268">TORCH IgM (Quimiluminiscencia)</option>
											<option value="lab269">Toxoplasma IgG (Quimioluminiscencia)</option>
											<option value="lab270">Toxoplasma IgM (Quimioluminiscencia)</option>
											<option value="lab271">Transferrina</option>
											<option value="lab272">Transferrina % de Saturacion</option>
											<option value="lab273">Trigliceridos</option>
											<option value="lab274">Troponina I Cuantificada</option>
											<option value="lab275">Troponina T Cuantificada</option>
											<option value="lab276">TSH</option>
											<option value="lab277">Tzank</option>
											<option value="lab278">Urea.</option>
											<option value="lab279">Urocultivo  (Orina)</option>
											<option value="lab280">VDRL Sifilis Preliminar</option>
											<option value="lab281">Virus Influenza A y B en Moco</option>
											<option value="lab282">Virus Sinscitial Respirtoria en Moco.</option>
											<option value="lab283">Wel Felix Proteus OX 19 Rickettsiosis</option>
											<option value="lab284">Widal (A B H O )</option>
											<option value="lab285">Ziehl Neelsen Modificado (Coccidios enHeces)</option>
											<option value="lab286">USG OBSTETRICO EN 3RA Y 4TA DIMENSION</option>
											<option value="lab287">USG PROSTATICO</option>
											<option value="lab288">USG PELVICO ABDOMINAL</option>
											<option value="lab289">USG PELVICO VAGINAL</option>
											<option value="lab290">USG CUELLO TIROIDEO</option>
											<option value="lab291">USG RENAL Y VEJIGA URINARIA</option>
											<option value="lab292">USG TESTICULAR.</option>
											<option value="lab293">USG ABDOMINAL CON EMBRION CRL</option>
											<option value="lab294">USG OBSTETRICO CONVENCIONAL</option>
											<option value="lab295">USG VENOSO 1 PIERNA PREV CITA</option>
											<option value="lab296">USG VASCULAR 2 PIERNAS PREVIA CITA</option>
											<option value="lab297">USG VENOSO 2 PIERNAS PREV CITA</option>
											<option value="lab298">USG DE OJO PREVIA CITA</option>
											<option value="lab299">USG ESQUELETICO PREVIA CITA</option>
											<option value="lab300">USG DE HOMBRO PREVIA CITA</option>
											<option value="lab301">USG TRANSCRANEAL DOPPLER COLOR PREV CITA</option>
											<option value="lab302">USG DE MUSLO</option>
											<option value="lab303">USG  DOPPLER ARTICULAR PREV CITA</option>
											<option value="lab304">USG TEJIDOS BLANDOS</option>
											<option value="lab305">USG ABDOMEN INFERIOR</option>
											<option value="lab306">USG ABDOMEN TOTAL</option>
											<option value="lab307">USG  HEPATICO Y VIAS BILIARES</option>
											<option value="lab308">USG DE MAMAS</option>
											<option value="lab309">USG PERFIL BIOFISICO</option>
											<option value="lab310">USG ABDOMEN SUPERIOR</option>
											<option value="lab311">USG CONVENCIONAL DE MAMAS</option>
											<option value="lab312">RX TOBILLO MORTAJA</option>
											<option value="lab313">RX AP Y LATERAL</option>
											<option value="lab314">RX TORAX AP</option>
											<option value="lab315">RX APICOLORDOTICO</option>
											<option value="lab316">RX URETROCISTOGRAMA PREVIA CITA</option>
											<option value="lab317">RX VENOGRAMA PREVIA CITA</option>
											<option value="lab318">RX WATTER HPN</option>
											<option value="lab319">RX POSICION FETAL</option>
											<option value="lab320">RX ANTEBRAZO AP Y LATERAL</option>
											<option value="lab321">RX DE CRANEO AP Y LATERAL</option>
											<option value="lab322">RX CLAVICULA AP</option>
											<option value="lab323">RX ENEMA DE BARIO AYUNO PREPARACION PREV</option>
											<option value="lab324">RX DE ESCAPULA AP</option>
											<option value="lab325">RX ESCOLIOSIS DINAMICAS DER/IZQ</option>
											<option value="lab326">RX DE ESOFAGO</option>
											<option value="lab327">RX ESTERNON AP/LAT</option>
											<option value="lab328">RX EXTREMIDADES SUPERIORES</option>
											<option value="lab329">RX EXTREMIDADES INFERIORES</option>
											<option value="lab330">RX ESCANOGRAMA MEDICION DE HUESOS</option>
											<option value="lab331">RX FISTULOGRAMA MEDIO DE CONTRASTE</option>
											<option value="lab332">RX HISTEROSALPINGOGRAMA TROMPAS FALOPIO</option>
											<option value="lab333">RX DE HOMBRO AP</option>
											<option value="lab334">RX HUESOS LARGOS</option>
											<option value="lab335">RX HUESOS PROPIOS DE LA NARIZ</option>
											<option value="lab336">RX HUMERO</option>
											<option value="lab337">RX MAMOGRAFIA MAMAS</option>
											<option value="lab338">RX DE MANDIBULA</option>
											<option value="lab339">RX DE MANO</option>
											<option value="lab340">RX MANO IZQ Y DER</option>
											<option value="lab341">RX MASTOIDES BILATERAL</option>
											<option value="lab342">RX MAXILARES</option>
											<option value="lab343">RX DE MUNECA</option>
											<option value="lab344">RX NASOFARINGE LATERAL</option>
											<option value="lab345">RX ORBITAS CADWELL WATTERS</option>
											<option value="lab346">RX PELVIMETRIA EMBARAZADAS</option>
											<option value="lab347">RX PELVIS AP</option>
											<option value="lab348">RX PELVIS AP RANA NINOS</option>
											<option value="lab349">RX PIE</option>
											<option value="lab350">RX PIELOGRAMA INTRA VENOSO</option>
											<option value="lab351">RX PIERNA</option>
											<option value="lab352">RX DE PIE IZQ Y DER</option>
											<option value="lab353">RX DE MUÑECA</option>
											<option value="lab354">RX DE ANTEBRAZO</option>
											<option value="lab355">RX DE CODO</option>
											<option value="lab356">RX DE BRAZO</option>
											<option value="lab357">RX DE FEMUR</option>
											<option value="lab358">RX PLACA ADICIONAL</option>
											<option value="lab359">RX DE PUÑO</option>
											<option value="lab360">RX RODILLA AP/LATERAL</option>
											<option value="lab361">RX RODILLA AP/LATERAL Y AXIAL</option>
											<option value="lab362">RX SACRO Y COXIS</option>
											<option value="lab363">RX SENOS PARANASALES</option>
											<option value="lab364">RX SERIE GASTRODUODENAL</option>
											<option value="lab365">RX SERIE GASTROINTESTINAL</option>
											<option value="lab366">RX SERIE OSEA METASTASICA</option>
											<option value="lab367">RX SILLA TURCA</option>
											<option value="lab368">RX DE TOBILLO</option>
											<option value="lab369">RX DE ROTULA</option>
											<option value="lab370">CONSULTA PRECIO ESPECIAL</option>
											<option value="lab371">CONSULTA</option>
											<option value="lab372">CONSULTA Y ULTRASONIDO</option>
											<option value="lab373">CONSULTA Y PAPANICOLAU</option>
											<option value="lab374">CONSULTA POR LA NOCHE</option>
											<option value="lab375">TAC  ABDOMEN INFERIOR CON MEDIO</option>
											<option value="lab376">TAC ABDOMEN SUPERIOR CON MEDIO</option>
											<option value="lab377">TAC  DE CADERA CON MEDIO</option>
											<option value="lab378">TAC CEREBRAL CON MEDIO</option>
											<option value="lab379">TAC  DE COLUMNA CERVICAL CON MEDIO</option>
											<option value="lab380">TAC COLUMNA DORSAL CON MEDIO</option>
											<option value="lab381">TAC  COLUMNA LUMBAR CON MEDIO</option>
											<option value="lab382">TAC COLUMNA LUMBAR-LUMBOSACRA CON MEDIO</option>
											<option value="lab383">TAC  DE CUELLO CON MEDIO</option>
											<option value="lab384">TAC  DE MANDIBULA CON MEDIO</option>
											<option value="lab385">TAC  DE HOMBRO CON MEDIO</option>
											<option value="lab386">TAC DE ORBITAS CON MEDIO</option>
											<option value="lab387">TAC DE PROSTATA CON MEDIO</option>
											<option value="lab388">TAC DE PULMONES CON MEDIO</option>
											<option value="lab389">TAC DE RIÑONES CON MEDIO</option>
											<option value="lab390">TAC DE RODILLA CON MEDIO</option>
											<option value="lab391">TAC SILLA TURCA CON MEDIO</option>
											<option value="lab392">TAC DE TOBILLO CON MEDIO</option>
											<option value="lab393">TAC UROTAS DE DOS TOMAS CON Y SIN MEDIO</option>
											<option value="lab394">TAC  ABDOMEN INFERIOR SIN MEDIO</option>
											<option value="lab395">TAC ABDOMEN SUPERIOR SIN MEDIO</option>
											<option value="lab396">TAC  DE CADERA SIN MEDIO</option>
											<option value="lab397">TAC CEREBRAL SIN MEDIO</option>
											<option value="lab398">TAC  DE COLUMNA CERVICAL SIN MEDIO</option>
											<option value="lab399">TAC COLUMNA DORSAL SIN MEDIO</option>
											<option value="lab400">TAC  COLUMNA LUMBAR SIN MEDIO</option>
											<option value="lab401">TAC COLUMNA LUMBAR-LUMBOSACRA SIN MEDIO</option>
											<option value="lab402">TAC  DE CUELLO SIN MEDIO</option>
											<option value="lab403">TAC  DE MANDIBULA SIN MEDIO</option>
											<option value="lab404">TAC  DE HOMBRO SIN MEDIO</option>
											<option value="lab405">TAC DE ORBITAS SIN MEDIO</option>
											<option value="lab406">TAC DE PROSTATA SIN MEDIO</option>
											<option value="lab407">TAC DE PULMONES SIN MEDIO</option>
											<option value="lab408">TAC DE RIÑONES SIN MEDIO</option>
											<option value="lab409">TAC DE RODILLA SIN MEDIO</option>
											<option value="lab410">TAC SILLA TURCA SIN MEDIO</option>
											<option value="lab411">TAC DE TOBILLO SIN MEDIO</option> 
								
								</select>  
							</div>
							
								
								
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
									
									
									
									
									
									
									
									
							
						</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Apellido: </label>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php echo $paciente[0]['apellido'].$_GET['apellido'];?>" name="apellido" />
									</div>
								
									<label class="col-sm-2 control-label">Nombre: </label>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php echo $paciente[0]['nombre'].$_GET['nombre'];?>" name="nombre" />
									</div>
								
								</div>								
								
								<div class="form-group">
									<label class="col-sm-2 control-label">Celular: </label>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php echo $paciente[0]['celular'].$_GET['celular'];?>" name="celular" />
									</div>
								
									<label class="col-sm-2 control-label">Telefono: </label>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php echo $paciente[0]['telefono'].$_GET['telefono'];?>" name="telefono" />
									</div>
								
								</div>								
								

								<div class="form-actions text-right">
								<b style="color:red">* Si ha terminado de asignar laboratorios presione el botón continuar, para terminar la acción.</b> 
									<input type="submit" value="Enviar Laboratorio" class="btn btn-primary" />
									<?php if($_GET['return']==TRUE){ ?><input type="button" value="Continuar" class="btn btn-primary" onClick="location.href='./?'" /><?php } ?>
								</div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /selects -->


			

            <!-- Footer -->
				<?php pie() ?>
            <!-- /footer -->

        </div>
    </div>

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