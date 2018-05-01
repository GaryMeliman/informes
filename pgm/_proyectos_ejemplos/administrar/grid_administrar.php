<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../../inc_base.php');	
?>

</head>

<body class="glossed">

<?php
	$xps_titulo_barra = "PROYECTOS";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 0;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
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
					$xps_titulo		="PROYECTOS";//<-- MODIFICABLE					
					$xps_volver		="../grid_proyectos.php?cl=".$_GET['cl'];//<-- MODIFICABLE ruta de la página, vacio = sin botón
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
              <th>Constructura</th>
              <th>Área</th>
              <th>Proyecto</th>
              <th>Subárea</th>
              <th class="text-center">Total Etapas</th>
              <th class="text-center">Total Proy.Inmobiliarios</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

<?php

	$db	= new MySQL();
	$proy = xps_desencriptar($_GET['pro']);
	
	$sql = "SELECT 
				  `pro`.`id_proyecto`,
				  `pro`.`id_emp`,
				  `pro`.`id_plantilla_doc`,
				  `e`.`nom_fantasia_emp`,
				  `cla`.`nombre_clasificacion`,
				  `pro`.`nombre_proyecto`,
				  `pro`.`f_inicio_proyecto`,
				  `pro`.`f_termino_proyecto`,
				  `pla`.`nombre_plantilla`,
					(SELECT COUNT(`e`.`id_etapa`) AS `total`
						FROM `etapas` `e`
						WHERE `e`.`id_plantilla_doc` = `pro`.`id_plantilla_doc`) AS total_etapas,
					(SELECT COUNT(pi.id_inmobiliario) FROM proyectos_inmobiliarios pi WHERE pi.id_proyecto = pro.id_proyecto) AS total_inmobiliario,
				  `pro`.`estado_proyecto`
				FROM
				  `proyectos` `pro`
				  LEFT OUTER JOIN `empresas` `e` ON (`pro`.`id_emp` = `e`.`id_emp`)
				  LEFT OUTER JOIN `plantillas_doc` `pla` ON (`pro`.`id_plantilla_doc` = `pla`.`id_plantilla_doc`)
				  LEFT OUTER JOIN `proyectos_clasificacion` `cla` ON (`pla`.`id_clasificacion` = `cla`.`id_clasificacion`)
				WHERE
					`pro`.`id_proyecto` = $proy
				ORDER BY
				  `e`.`nom_fantasia_emp`,
				  `cla`.`nombre_clasificacion`,
				  `pla`.`nombre_plantilla`,
				  total_etapas,
				  `pro`.`nombre_proyecto`";	

//echo $sql;				  

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$i = 1;
		while($rs = $db->fetch_array($consulta)){
			
			//PROYECTO INMOBILIARIO
			$ruta_inmobiliario = 'grid_inmobiliarios.php';//(is_null($rs['id_inmobiliario']) ? 'nuevo_inmobiliario.php' : 'grid_inmobiliarios.php');
?>		  
            <tr>
              <td><?=$i++?></td>
              <td><?=$rs['nom_fantasia_emp']?></td>
              <td><?=$rs['nombre_clasificacion']?></td>
              <td><?=$rs['nombre_proyecto']?></td>
              <td class="text-left"><?=$rs['nombre_plantilla']?></td>
              <td class="text-center"><?=$rs['total_etapas']?></td>
              <td class="text-center"><?=$rs['total_inmobiliario']?></td>
              <td class="text-center">
				<button type="button" class="btn btn-action btn-xs btn-success" onclick="window.location.href=ruteador(1,'editar_proy.php?cl=<?=$_GET['cl']?>&pro=<?=xps_encriptar($rs['id_proyecto'])?>');">
					<i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;Editar&nbsp;&nbsp;&nbsp;
				</button>
				<button type="button" class="btn btn-action btn-xs btn-info" onclick="window.location.href=ruteador(1,'usuarios/grid_usuarios.php?cl=<?=$_GET['cl']?>&pro=<?=xps_encriptar($rs['id_proyecto'])?>');">
					<i class="fa fa-users"></i> Usuarios
				</button>				
				<button type="button" class="btn btn-action btn-xs btn-warning" onclick="window.location.href=ruteador(1,'checklist/grid_checklist.php?cl=<?=$_GET['cl']?>&pro=<?=xps_encriptar($rs['id_proyecto'])?>');">
					<i class="fa fa-users"></i> Checklist
				</button>	
				<button type="button" class="btn btn-action btn-xs btn-primary" onclick="window.location.href=ruteador(1,'fichas/grid_fichas.php?cl=<?=$_GET['cl']?>&pro=<?=xps_encriptar($rs['id_proyecto'])?>');">
					<i class="fa fa-users"></i> Ficha
				</button>
				<button type="button" class="btn btn-action btn-xs btn-danger" onclick="window.location.href=ruteador(1,'inmobiliario/<?=$ruta_inmobiliario?>?cl=<?=$_GET['cl']?>&pro=<?=xps_encriptar($rs['id_proyecto'])?>&n=<?=xps_encriptar($rs['nombre_proyecto'])?>');">
					<i class="fa fa-users"></i> Inmobiliario
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


<!-- @include _footer