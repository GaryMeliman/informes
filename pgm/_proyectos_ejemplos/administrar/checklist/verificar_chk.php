<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../../../inc_base.php');	
?>

<!--//############   AQUI NUEVOS JS O CSS   ######################//
		ojo que todo los js de jquery estan al final de la página
					BORRAR SI NO SE OCUPA

    //############ FIN AQUI NUEVOS JS O CSS ######################//-->

</head>

<body class="glossed">

<?php
	$xps_titulo_barra = "PROYECTOS";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 1;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Colaboradores'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="Verificación de items";//<-- MODIFICABLE					
		            $xps_volver   	="grid_checklist.php?cl=".$_GET['cl']."&pro=".$_GET['pro'];//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
					$xps_fullscreen	=1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
					$xps_color		=0;//<-- MODIFICABLE
					$xps_actualizar	=1;//<-- MODIFICABLE
					$xps_minimizar	=1;//<-- MODIFICABLE
					$xps_cerrar		=0;//<-- MODIFICABLE

					widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
				?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->
<?php
	//************ acciones que puede realizar el controlador segun la accion que se envie **************

	//$accion = 1;//Debug 1 y 5, muestra que puedes hacer con la informacion que envias por post al modelo
	//$accion = 2;//insertar
	//$accion = 3;//Actualizar
	//$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "guardar_verificacion/guardar_model.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">

          <fieldset>
            <div class="row">
            	<div class="col-md-9">
            		<legend><?=xps_desencriptar($_GET['n'])?></legend>
            	</div>
				<div class="col-md-3">
              		<div id="gauge-01" style="height:90px"></div>
				</div>


        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">N°</th>
                <th class="text-center">Sel</th>
                <th>Item</th>
                <th>Fecha</th>
                <th class="text-center">Cumplimiento</th>
                <th>Detalle</th>
                <th class="text-center"></th>                
              </tr>
            </thead>
            <tbody>
<?
	$db	= new MySQL();
	$id_chkp = xps_desencriptar($_GET['chkp']);//id_chk_proy
	$id_chk  = xps_desencriptar($_GET['chk']);//id_checklist
	
	$sql = "SELECT 
			  `cv`.`id_verificacion`,
			  `cv`.`nombre_verificacion`,
			  `cv`.`porcentaje_verificacion`,
					(SELECT 
					  `cvp`.`fecha_verificacion_proy`
					FROM
					  `checklist_verificacion_proyecto` `cvp`
					WHERE
					  `cvp`.`id_verificacion` = `cv`.`id_verificacion` AND 
					  `cvp`.`id_chk_proy` = $id_chkp) AS fecha_realizacion,
					(SELECT 
					  `cvp`.`detalle_verificacion_proy`
					FROM
					  `checklist_verificacion_proyecto` `cvp`
					WHERE
					  `cvp`.`id_verificacion` = `cv`.`id_verificacion` AND 
					  `cvp`.`id_chk_proy` = $id_chkp) AS detalle,
					(SELECT 
					  `cvp`.`cierre_verificacion_proy`
					FROM
					  `checklist_verificacion_proyecto` `cvp`
					WHERE
					  `cvp`.`id_verificacion` = `cv`.`id_verificacion` AND 
					  `cvp`.`id_chk_proy` = $id_chkp) AS cierre
			FROM
			  `checklist_verificacion` `cv`
			WHERE
			  `cv`.`id_checklist` = $id_chk";	

//		  echo $sql;				  

	$consulta = $db->consulta($sql);

	$sumatoria = 0;
	if($db->num_rows($consulta)>0){
		$ii = 1;
		$asignado = "";
		while($rs = $db->fetch_array($consulta)){

//success+check
//danger+times
				$success = '';
				$crear_s = "danger";//0
				$crear_c = "times";//0
				$porcentaje = "";
				$fecha   = "";

			if($rs['fecha_realizacion']!=""){
				$success = 'class="success"';
				$crear_s = "success";//1
				$crear_c = "check";//1
				$porcentaje = $rs['porcentaje_verificacion']."%";
				$sumatoria += $rs['porcentaje_verificacion'];
				$fecha   = xps_fecha($rs['fecha_realizacion']);
			}

			$accion = $fecha ? 0 : 1;

?>


            <tr id="C<?=$rs['id_verificacion']?>" <?=$success?>>
                <td class="text-center"><?=$ii++?></td>
                <td class="text-center">
<?php
	if(!$rs['cierre']){
?>                	
                	<span style="cursor: pointer;" class="label label-<?=$crear_s?>" onclick="seleccionar('<?=xps_encriptar($accion)?>','<?=xps_encriptar($rs['id_verificacion'])?>')">
                		<i class="fa fa-<?=$crear_c?>"></i>
                	</span>
<?php
	}
	else{
					echo '<i class="fa fa-'.$crear_c.'"></i>';
	}
?>                	
                </td>                
                 <td><?=$rs['nombre_verificacion']?></td>
                 <td class="text-center"><?=$fecha?></td>
               <td class="text-center"><?=$porcentaje?>
               </td>
               <td class="text-left"><?=($rs['detalle'] ? $rs['detalle'] : '-')?></td>
               <td class="text-center"  data-toggle="tooltip" data-placement="right" title="" data-original-title="A:<?=$accion?>,C:<?=$id_chkp?>,V:<?=$rs['id_verificacion']?>,C:<?=$rs['cierre']?>">
<?php
	if(!$accion){
?>               	
					<button type="button" class="btn btn-action btn-xs btn-info" onclick="window.location.href=ruteador(1,'verificar_chk.php?cl=<?=$_GET['cl']?>&pro=<?=$_GET['pro']?>&chkp=<?=$_GET['chkp']?>&chk=<?=$_GET['chk']?>&n=<?=$_GET['n']?>');">
						<i class="fa fa-list-alt"></i>Detallar
					</button>
<?php
		if(!$rs['cierre']){
?>					
					<button type="button" class="btn btn-action btn-xs btn-warning" onclick="window.location.href=ruteador(1,'verificar_chk.php?cl=<?=$_GET['cl']?>&pro=<?=$_GET['pro']?>&chkp=<?=$_GET['chkp']?>&chk=<?=$_GET['chk']?>&n=<?=$_GET['n']?>');">
						<i class="fa fa-unlock"></i>&nbsp;&nbsp;Cerrar&nbsp;&nbsp;
					</button>
<?php
		}
		else{
					echo '<button type="button" class="btn btn-action btn-xs btn-danger"><i class="fa fa-lock"></i>Cerrado</button>';
		}
	}
?>
               </td>
            </tr>

<?php
		}
	}
?>
			</tbody>
			<tfoot>
<?php
	if($sumatoria>0){
?>				
			  <tr>
			  	<th class="text-right" colspan="4">Sumatoria : </th>
			  	<th class="text-center"><?=$sumatoria."%"?></th>
			  </tr>
<?php
	}
?>			  
              <tr>
                <th id="respuesta" class="text-left" colspan="5">...</th>
              </tr>
			</tfoot>			
		  </table>

          </fieldset>
        </form>


<!--  FIN CONTENIDO   -->
				</div>                
			</div>
		</div>	
	<?php
		for($i=1;$i<29;$i++){
			echo "<br>";
		}
	?>
	<!-- *********** FIN ************ -->
	</div>
	<!-- *********** PIÉ DE PÁGINA ************ -->
	<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>

<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>
<script src='<?=xps_ruteador()?>js/form_validation_339.js'></script>

<!--//############  AQUI NUEVOS JS O CSS   ###################### -->

<script type="text/javascript">
  var p = new JustGage({
    id: 'gauge-01',
    value: <?=$sumatoria?>,
    gaugeWidthScale: 0.9,
    min: 0,
    max: 100,
    showInnerShadow: !1,
    showMinMax: !1,
    gaugeColor: '#EAEAEA',
    title: 'Cumplimiento',
    label:'',
    levelColors: [
      '#DA0000',//rojo
      '#daca00',//amarillo
      '#00da07'//verde
    ]    
  });  

	seleccionar = null;

	 $(function() {

	 	//guardar registros____________________________________________________________
   	    function checklist_select(accion,HiIdVerificacion){

       //Guardar
		var dataString = [];
			dataString = dataString.concat({'accion':accion});
			dataString = dataString.concat({'HdIdChPro':'<?=$_GET['chkp']?>'});
	       	dataString = dataString.concat({'HiIdVerificacion':HiIdVerificacion});

	       	console.log(dataString);

//	    var dataString = $('#validateForm').serialize();
      	var dataString = JSON.stringify(dataString);
//          return false;

		    $.ajax({
		      type: "POST",
		//      dataType: 'json',
		      url: "<?=$ruta_guarda_form?>",//"guardar/guardar_model.php",
		      data: dataString,
		    }).done(function(respuesta){

		    	$("#formulario").fadeOut("slow");
		    	$('#respuesta').html("<div id='message'></div>");
		    	acciones  = respuesta.split("<pre>");
		    	if(acciones.length>0){
		    		respuesta = acciones[2];
		    		if(acciones[0].length>0)
		    			respuesta = acciones[0];
		    	}
		        $('#message').html("<h2>"+respuesta+"</h2>")
		        .fadeIn(1500, function() {
					//$('#message').append("<a href='<?=$xps_volver?>'>Volver</a>");
	                 setTimeout(function () {
	                     $("#audiotag1")[0].play();
	                 }, 0);
	                 setTimeout(function () {
	                 	location.reload();
	                 }, 500);
		        });

				//
		    });
			return false;
	    };

    	seleccionar = checklist_select;	 	

	});
</script>

<!-- @include _footer