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
					$xps_titulo		="Roles";//<-- MODIFICABLE					
		            $xps_volver   	="grid_usuarios.php?cl=".$_GET['cl']."&pro=".$_GET['pro'];//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
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
	$accion = 3;//Actualizar
	//$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "guardar/guardar_model.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">
				<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
				<input type="hidden" name="HdIdProyecto" value="<?=$_GET['pro']?>">
				<input type="hidden" name="HiUser" value="<?=$_GET['u']?>">

          <fieldset>
            <legend>ROL ASIGNADO AL USUARIO</legend>


        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">N°</th>
                <th class="text-center">Sel</th>
                <th>Rol</th>
                <th class="text-center">Crear</th>
                <th class="text-center">Editar</th>
                <th class="text-center">Borrar</th>
                <th class="text-center">Subir</th>
                <th class="text-center">Ver</th>                
              </tr>
            </thead>
            <tbody>
<?
	$db	= new MySQL();
	$proy = xps_desencriptar($_GET['pro']);
	$user = xps_desencriptar($_GET['u']);
	
	$sql = "SELECT  `r`.`id_rol`,
					`r`.`nombre_rol`,
			       (SELECT GROUP_CONCAT(`rpe`.`id_permiso`) AS `permisos`
			         FROM `roles_privilegios` `rp`
			              LEFT OUTER JOIN `roles_permisos` `rpe` ON (`rp`.`id_permiso` =
			                `rpe`.`id_permiso`)
			         WHERE `rp`.`id_rol` = `r`.`id_rol`) AS `permisos`,
			        (SELECT 
						 IF((`pu`.`id_rol`=`r`.`id_rol`),'checked','') AS ch
						FROM
						  `proyectos_usuarios` `pu`
						WHERE
						  `pu`.`id_proyecto` = $proy AND 
						  `pu`.`id_usuario` = $user) AS rol_asignado
			FROM `roles` `r`
			ORDER BY `r`.`id_rol`";	

//echo $sql;				  

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$ii = 1;
		$asignado = "";
		while($rs = $db->fetch_array($consulta)){
			$permisos = explode(',', $rs['permisos']);
//success+check
//danger+times
			$crear_s = "danger";//1
			$crear_c = "times";//1
			$edit_s  = "danger";//2
			$edit_c  = "times";//2
			$del_s   = "danger";//3
			$del_c   = "times";//3
			$up_s    = "danger";//4
			$up_c    = "times";//4
			$ver_s   = "danger";//5
			$ver_c   = "times";//5

			for($i=0;$i<count($permisos);$i++){
				switch ($permisos[$i]) {
					case '1':	$crear_s = "success";
								$crear_c = "check";
						break;
					case '2':	$edit_s = "success";
								$edit_c = "check";
						break;
					case '3':	$del_s = "success";
								$del_c = "check";
						break;						
					case '4':	$up_s = "success";
								$up_c = "check";
						break;						
					case '5':	$ver_s = "success";
								$ver_c = "check";
						break;												
				}
			}

?>            	
              <tr <?=(($rs['rol_asignado']=='checked') ? 'class="success"' : '')?>>
                <td class="text-center"><?=$ii++?></td>
                <td>
                	<div class="checkbox">
		                	<input name="HdIdRol" id="HdIdRol" value="<?=xps_encriptar($rs['id_rol'])?>" <?=$rs['rol_asignado']?> type="radio">
                	</div>
                </td>                
                <td><?=$rs['nombre_rol']?></td>
                <td class="text-center"><span class="label label-<?=$crear_s?>"><i class="fa fa-<?=$crear_c?>"></i></span></td>
                <td class="text-center"><span class="label label-<?=$edit_s?>"><i class="fa fa-<?=$edit_c?>"></i></span></td>
                <td class="text-center"><span class="label label-<?=$del_s?>"><i class="fa fa-<?=$del_c?>"></i></span></td>
                <td class="text-center"><span class="label label-<?=$up_s?>"><i class="fa fa-<?=$up_c?>"></i></span></td>
                <td class="text-center"><span class="label label-<?=$ver_s?>"><i class="fa fa-<?=$ver_c?>"></i></span></td>
              </tr>
<?php
		}
	}
?>

			</tbody>
		  </table>
<br><br>
	            <div class="text-right form-group">
	              <button type="submit" class="btn btn-primary"  id="submit"><i class="fa fa-save"></i>Guardar</button>
	            </div>

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
<script>
	 $(function() {//guardar registros
   	    $('#submit').click(function(){
	        var dataString = $('#validateForm').serialize();
		    $.ajax({
		      type: "POST",
		//      dataType: 'json',
		      url: "<?=$ruta_guarda_form?>",//"guardar/guardar_model.php",
		      data: dataString,
		    }).done(function(respuesta){

		    	$("#formulario").fadeOut("slow");
		    	$('#validateForm').html("<div id='message'></div>");
		        $('#message').html("<h2>"+respuesta+"</h2>")
		        .fadeIn(1500, function() {
					$('#message').append("<a href='<?=$xps_volver?>'>Volver</a>");
	                 setTimeout(function () {
	                     $("#audiotag1")[0].play();
	                 }, 0);
	                 setTimeout(function () {
	                 	<?php
	                 		if($accion>1){
	                 			echo "$(location).attr('href','$xps_volver');";
	                     	}
	                     ?>
	                 }, 5000);
		        });

				//
		    });
			return false;
	    });
	});
</script>

<!-- @include _footer