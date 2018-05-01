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
	echo $_SESSION['Proyectos'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-12"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="USUARIOS PROYECTOS";//<-- MODIFICABLE					
					$xps_volver		="../grid_administrar.php?cl=".$_GET['cl']."&pro=".$_GET['pro'];//<-- MODIFICABLE ruta de la página, vacio = sin botón
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
	//BORRAME ESTO ES UN RELLENO__________________________________________________ 
?>
<div class="table-responsive">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th>N°</th>
              <th class="text-center"></th>              
              <th>Empresa</th>
              <th>Usuario</th>
              <th>Rol</th>
              <th class="text-center">Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

<?php

	$db	= new MySQL();
	$proy = xps_desencriptar($_GET['pro']);
	
	$sql = "SELECT 
			  `pu`.`id_proyecto`,
			  `pu`.`id_usuario`,
			  `e`.`nom_fantasia_emp`,
			  CONCAT(`p`.`nombre_pers`, ' ', `p`.`paterno_pers`, ' ', `p`.`materno_pers`) AS `usuario`,
			  `r`.`nombre_rol`,
			  IF(`pu`.`estado_usuario_proy`,'Activo','Desactivado') AS estado_usuario_proy
			FROM
			  `proyectos_usuarios` `pu`
			  LEFT OUTER JOIN `_usuarios` `u` ON (`pu`.`id_usuario` = `u`.`id_usuario`)
			  LEFT OUTER JOIN `personas` `p` ON (`u`.`id_persona` = `p`.`id_persona`)
			  LEFT OUTER JOIN `empresas` `e` ON (`u`.`id_emp` = `e`.`id_emp`)
			  LEFT OUTER JOIN `roles` `r` ON (`pu`.`id_rol` = `r`.`id_rol`)
			WHERE
			  `pu`.`id_proyecto` = $proy
			ORDER BY
			  `e`.`nom_fantasia_emp`,
			  `pu`.`estado_usuario_proy` DESC,
			  `usuario`";	

//echo $sql;				  

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$i = 1;
		while($rs = $db->fetch_array($consulta)){
?>		  
            <tr>
              <td><?=$i++?></td>
              <td>_</td>
              <td><?=$rs['nom_fantasia_emp']?></td>
              <td><?=$rs['usuario']?></td>
              <td><?=$rs['nombre_rol']?></td>
              <td class="text-left"><?=$rs['estado_usuario_proy']?></td>
              <td class="text-center">
				<button type="button" class="btn btn-action btn-xs btn-success" onclick="window.location.href=ruteador(1,'asignar_rol.php?cl=<?=$_GET['cl']?>&pro=<?=xps_encriptar($rs['id_proyecto'])?>&u=<?=xps_encriptar($rs['id_usuario'])?>');">
					<i class="fa fa-pencil"></i>Permisos
				</button>
              </td>
            </tr>
<?php
		}
	}
?>

          </tbody>
        </table>
</div>
<?php
	//FIN BORRAME ESTO ES UN RELLENO______________________________________________		
?>


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
<!-- BTON NUEVO, EN TABLA SI NO SE OCUPA BORRAR -->
	<script type="text/javascript">
		!function () {
		  $(function () {
		    $('.datatable').each(function () {
		  	  var ruta_btn_01 = "usuarios_proy.php?cl=<?=$_GET['cl']?>&pro=<?=$_GET['pro']?>";//ruta del nuevo bton
	          var nombre_bton = "Usuarios";
	          return a = $(this),
	          p = a.closest('.dataTables_wrapper').find('.clearfix'),
	          p.append( '<center><button onclick="window.location.href=ruteador(1,\''+ruta_btn_01+'\')" type="button" class="btn btn-iconed btn-primary btn-sm"><i class="fa fa-folder-open"></i> '+nombre_bton+'</button></center>' ) //NUEVO BTON
        })
      })
    }.call(this);
    ;
  </script>

<!-- @include _footer