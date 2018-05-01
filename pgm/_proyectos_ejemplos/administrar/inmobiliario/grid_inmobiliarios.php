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
	$xps_titulo_barra = "PROYECTOS";
	$xps_ver_submenu  = 0;
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
		<li>
			<div class="row">

          <div class="col-md-3">
            <div class="result-meta">
            	<a href="#" onclick="window.location.href=ruteador(1,'nuevo_inmobiliario.php?cl=<?=$_GET
						['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>');">
					<img src="../../../img.php?r=logos.img/agregar.png" alt="Agregar proyecto inmobiliario" class="img-max">			
					<b><span>Agregar proyecto inmobiliario</span></b>
				</a>
		          <div class="col-md-10">
		            <div class="result-main">
		              <h4><hr></h4>
		              <span class="result-match">&nbsp;</span><br>
						<div style="cursor: pointer" class="icon" onclick="window.location.href=ruteador(1,'../grid_administrar.php?cl=<?=$_GET
						['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>');">
							<i class="fa fa-mail-reply"></i> Volver
						</div>		          		              
		            </div>
		          </div>
            </div>
          </div>				
<?php

	$idproy = xps_desencriptar($_GET['pro']);

	$db	= new MySQL();

	$sql = "SELECT 
			  `pi`.`id_inmobiliario`,
			  `p`.`nombre_proyecto`,
			  `pi`.`nombre_inmobiliario`,
			  `pi`.`descripcion_inmobiliario`,
			  `pit`.`nombre_tipo_inmobiliario`,
			  `e`.`nombre_estado`,
			  `pi`.`logo_inmobiliario`,
			  `pi`.`estado_inmobiliario`
			FROM
			  `proyectos_inmobiliarios` `pi`
			  LEFT OUTER JOIN `estados` `e` ON (`pi`.`id_estado_proyecto` = `e`.`id_estado_proyecto`)
			  LEFT OUTER JOIN `proyectos` `p` ON (`pi`.`id_proyecto` = `p`.`id_proyecto`)
			  LEFT OUTER JOIN `proyectos_inmobiliarios_tipos` `pit` ON (`pi`.`id_tipo_inmobiliario` = `pit`.`id_tipo_inmobiliario`)
			WHERE
			  `pi`.`id_proyecto` = $idproy
			";	

//echo $sql;

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$i = 1;
		while($rs = $db->fetch_array($consulta)){


?>	

          <div class="col-md-3">
            <div class="result-meta">
				<img src="../../../img.php?r=logos.img/<?=$rs['logo_inmobiliario']?>" alt="<?=$rs['nombre_inmobiliario']?>" class="img-max">			
				<b><span><?=$rs['nombre_inmobiliario']?></span></b>
		          <div class="col-md-10">
		            <div class="result-main">
		              <h4></h4>
		              <p><?=$rs['nombre_estado']?></p>
					  <span class="result-match">Acción</span>
					  <div class="row">
					  	<div class="col-md-4">
							<div style="cursor: pointer" class="icon" onclick="window.location.href=ruteador(1,'editar_inmobiliario.php?cl=<?=$_GET
							['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=xps_encriptar($rs['id_inmobiliario'])?>');">
								<i class="fa fa-pencil"></i> Editar
							</div>
					  	</div>
					  	<div class="col-md-4">
							<div style="cursor: pointer;" class="icon" onclick="window.location.href=ruteador(1,'fichas/grid_fichas.php?cl=<?=$_GET
							['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=xps_encriptar($rs['id_inmobiliario'])?>');">
								<i class="fa fa-list-ul"></i> <b>Ficha</b>
							</div>
					  	</div>
					  	<div class="col-md-4">
							<div style="cursor: pointer" class="icon" onclick="window.location.href=ruteador(1,'unidades/grid_unidades.php?cl=<?=$_GET
							['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=xps_encriptar($rs['id_inmobiliario'])?>');">
								<i class="fa fa-home"></i> Unidades
							</div>
					  	</div>
					  </div>
		            </div>
		          </div>
            </div>
          </div>

<?php
		}
	}
?>
			</div>
		</li>
	</ul>

<!--  FIN CONTENIDO   -->

		</div>

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