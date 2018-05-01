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
					$xps_titulo		="Checklist";//<-- MODIFICABLE					
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
	$ruta_guarda_form = "guardar/guardar_model.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">

          <fieldset>
            <legend>CHECKLIST ASIGNADOS</legend>


        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">N°</th>
                <th class="text-center">Sel</th>
                <th>Checklist</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
<?
	$db	= new MySQL();
	$proy = xps_desencriptar($_GET['pro']);
	
	$sql = "SELECT 
			  `c`.`id_checklist`,
			  `c`.`nombre_checklist`,
				(SELECT 
				  `cp`.`id_chk_proy`
				FROM
				  `checklist_proyectos` `cp`
				WHERE
				  `cp`.`id_checklist` = `c`.`id_checklist` AND 
				  `cp`.`id_proyecto` = $proy) AS id_chk_proy  			  
			FROM
			  `checklist` `c`
			ORDER BY
				id_chk_proy DESC,
			  `c`.`estado_checklist` DESC,
			  `c`.`nombre_checklist`";	

//echo $sql;				  

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$ii = 1;
		$asignado = "";
		while($rs = $db->fetch_array($consulta)){

//success+check
//danger+times
				$success = '';
				$crear_s = "danger";//0
				$crear_c = "times";//0

			if($rs['id_chk_proy']!=""){
				$success = 'class="success"';
				$crear_s = "success";//1
				$crear_c = "check";//1
			}

			$id_chk_proy = is_null($rs['id_chk_proy']) ? 0 : $rs['id_chk_proy'];
			$accion = $id_chk_proy ? 0 : 1;

?>


              <tr id="<?=$rs['id_checklist']?>" <?=$success?>>
                <td class="text-center"><?=$ii++?></td>
                <td class="text-center">
                	<span style="cursor: pointer;" class="label label-<?=$crear_s?>" onclick="seleccionar('<?=xps_encriptar($accion)?>','<?=xps_encriptar($id_chk_proy)?>','<?=xps_encriptar($rs['id_checklist'])?>')">
                		<i class="fa fa-<?=$crear_c?>"></i>
                	</span>
                </td>                
                 <td><?=$rs['nombre_checklist']?></td>
               <td data-toggle="tooltip" data-placement="right" title="" data-original-title="A:<?=$accion?>,I:<?=$id_chk_proy?>,P:<?=$proy?>,C:<?=$rs['id_checklist']?>"></td>                
              </tr>
<?php
		}
	}
?>
			</tbody>
			<tfoot>
              <tr>
                <th id="respuesta" class="text-left" colspan="4">...</th>
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

	seleccionar = null;

	 $(function() {

	 	//guardar registros____________________________________________________________
   	        function checklist_select(accion,HdIdChPro,HiIdChecklist){

       //Guardar
		var dataString = [];
			dataString = dataString.concat({'accion':accion});
			dataString = dataString.concat({'HdIdProyecto':'<?=$_GET['pro']?>'});
			dataString = dataString.concat({'HdIdChPro':HdIdChPro});
	       	dataString = dataString.concat({'HiIdChecklist':HiIdChecklist});

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
	                 	<?php
	                 		if($accion>1){
//	                 			echo "$(location).attr('href','$xps_volver');";
	                     	}
	                     ?>
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