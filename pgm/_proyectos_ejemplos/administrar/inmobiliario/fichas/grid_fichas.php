<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../../../../inc_base.php');	
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
					$xps_titulo		="Fichas Inmobiliarios <b>".xps_desencriptar($_GET['n'])."</b>";//<-- MODIFICABLE					
					$xps_volver		="../grid_inmobiliarios.php?cl=".$_GET['cl']."&pro=".$_GET['pro']."&n=".$_GET['n'];//<-- MODIFICABLE ruta de la página, vacio = sin botón
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
              <th class="text-center">ID</th>              
              <th>Fichas</th>
              <th class="text-center">Cumplimiento</th>
              <th class="text-center"></th>
              <th></th>              
              <th></th>
            </tr>
          </thead>
          <tbody>

<?php

	$db		= new MySQL();
	$id_inm = xps_desencriptar($_GET['pi']);
	


	$sql = "SELECT 
			  `pi`.`id_ficha_inm`,
			  `pi`.`id_ficha`,
			  `f`.`nombre_ficha`,
			  (SELECT SUM(`fi`.`porcentaje_item`) AS `porc` 
			  	FROM `fichas_items_inmobiliarios` `fii` 
			  		LEFT OUTER JOIN `fichas_items` `fi` ON (`fii`.`id_ficha_item` = `fi`.`id_ficha_item`) 
			  	WHERE `fii`.`id_ficha_inm` = `pi`.`id_ficha_inm`) AS `cumplimiento`
			FROM
			  `fichas_inmobiliarios` `pi`
			  LEFT OUTER JOIN `fichas` `f` ON (`pi`.`id_ficha` = `f`.`id_ficha`)
			WHERE
			  `pi`.`id_inmobiliario` = $id_inm
			ORDER BY
			  `f`.`nombre_ficha`";			  

// 			  echo $sql;				  

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$i = 1;
		while($rs = $db->fetch_array($consulta)){
?>		  
            <tr>
              <td><?=$i++?></td>
              <td style="background-color:#ececec;opacity: 0.3;"><?=$rs['id_ficha_inm']?></td>
              <td><?=$rs['nombre_ficha']?></td>
              <td class="text-center"><?=$rs['cumplimiento']?>%</td>
              <td></td>              
              <td class="text-left"></td>
              <td class="text-center">
				<button type="button" class="btn btn-action btn-xs btn-success" onclick="window.location.href=ruteador(1,'verificar_fi.php?cl=<?=$_GET['cl']?>&pro=<?=$_GET['pro']?>&pi=<?=$_GET['pi']?>&fi=<?=xps_encriptar($rs['id_ficha_inm'])?>&f=<?=xps_encriptar($rs['id_ficha'])?>&n=<?=xps_encriptar($rs['nombre_ficha'])?>');">
					<i class="fa fa-check"></i>Revisar
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
		  	  var ruta_btn_01 = "asignar_fi.php?cl=<?=$_GET['cl']?>&pro=<?=$_GET['pro']?>&pi=<?=$_GET['pi']?>&n=<?=$_GET['n']?>";//ruta del nuevo bton
	          var nombre_bton = "Fichas";
	          return a = $(this),
	          p = a.closest('.dataTables_wrapper').find('.clearfix'),
	          p.append( '<center><button onclick="window.location.href=ruteador(1,\''+ruta_btn_01+'\')" type="button" class="btn btn-iconed btn-primary btn-sm"><i class="fa fa-folder-open"></i> '+nombre_bton+'</button></center>' ) //NUEVO BTON
        })
      })
    }.call(this);
    ;
  </script>

<!-- @include _footer