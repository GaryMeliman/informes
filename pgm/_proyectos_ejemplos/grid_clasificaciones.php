<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../inc_base.php');	
?>

<!--//############   AQUI NUEVOS JS O CSS   ######################//
		ojo que todo los js de jquery estan al final de la página
					BORRAR SI NO SE OCUPA

    //############ FIN AQUI NUEVOS JS O CSS ######################//-->

</head>

<body class="glossed">

<?php
	$xps_titulo_barra = "PROYECTOS";
	$xps_ver_submenu  = 1;
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Proyectos'];
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-12">

<!-- INICIO CONTENIDO -->


    <ul class="big-search-results">
<?php

	$db	= new MySQL();

	$sql = "SELECT 
			  `pc`.`id_clasificacion`,
			  `pc`.`nombre_clasificacion`,
			  (SELECT COUNT(`p`.`id_proyecto`) AS `contare` FROM `plantillas_doc` `pd` LEFT OUTER JOIN `proyectos` `p` ON (`pd`.`id_plantilla_doc` = `p`.`id_plantilla_doc`) WHERE `pd`.`id_clasificacion` = `pc`.`id_clasificacion` AND `p`.`estado_proyecto` = 1) AS `contar`
			FROM
			  `proyectos_clasificacion` `pc`
			WHERE
			  `pc`.`estado_clasificacion` = 1";	

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$i = 1;
		while($rs = $db->fetch_array($consulta)){
?>	
      <li>
        <div class="row">
          <div class="col-md-2">
            <div class="result-meta">
              <i class="fa fa-file-text"></i>
              <span>Proyectos activos <?=$rs['contar']?></span>
            </div>
          </div>
          <div class="col-md-10">
            <div class="result-main">
              <h4><a href="grid_proyectos.php?cl=<?=xps_encriptar($rs['id_clasificacion'])?>"><?=$rs['nombre_clasificacion']?></a></h4>
              <p>Collaboratively administrate empowered <span class="result-match">markets</span> </p>
            </div>
          </div>
        </div>
      </li>
<?php
		}
	}
?>
    </ul>

<!--  FIN CONTENIDO   -->
		</div>	
	<?php
		for($i=1;$i<0;$i++){
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

</body>
</html>

<!-- @include _footer