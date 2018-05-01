<!DOCTYPE html>
<html>

<head>
<?php
		require_once('../../inc_base.php');	
?>

  <title>PGM</title>

</head>

<body  class="glossed">



<?php
	$xps_titulo_barra = "PARAMETROS";
	$xps_ver_submenu  = 1;
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Parametros'];
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-12"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="Cargos";//<-- MODIFICABLE					
		            $xps_volver   	="";//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
					$xps_fullscreen	=1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
					$xps_color		=0;//<-- MODIFICABLE
					$xps_actualizar	=0;//<-- MODIFICABLE
					$xps_minimizar	=0;//<-- MODIFICABLE
					$xps_cerrar		=0;//<-- MODIFICABLE

					widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
				?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->

<div class="table-responsive">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th>N°</th>
              <th>ID</th>
              <th>Empresa</th>
              <th>Giro</th>
              <th>Categoría</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
<?php

	$db	= new MySQL();

//PARAMETROS
$id_emp = 1;//$_SESSION['valida']['id_muni'];

	$sql = "SELECT 
				  `c`.`id_cargo`,
				  `c`.`nivel_jerarquico`,
				  `c`.`nombre_cargo`,
				  `c`.`estado_cargo`,
				  `c`.`fecha_incorporacion`
				FROM
				  `cargos` `c`
				WHERE
				  `c`.`id_emp` = $id_emp
				ORDER BY
				  `c`.`estado_cargo` DESC,
				  `c`.`nivel_jerarquico`,
				  `c`.`nombre_cargo`";	

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$i = 1;
		while($rs = $db->fetch_array($consulta)){
?>		  
            <tr>
              <td><?=$i++?></td>
              <td>_</td>
              <td><?=$rs['nivel_jerarquico']?></td>
              <td><?=$rs['nombre_cargo']?></td>
              <td class="text-right"><?=$rs['estado_cargo']?></td>
              <td class="text-right">
				<button type="button" class="btn btn-action btn-xs btn-primary" onclick="window.location.href=ruteador(1,'editar_cargo.php?c=<?=xps_encriptar($rs['id_cargo'])?>');">
					<i class="fa fa-info-circle"></i> Editar
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
		  	  var ruta_btn_01 = "nuevo_cargo.php";//ruta del nuevo bton
	          var nombre_bton = "Nuevo cargo";
	          return a = $(this),
	          p = a.closest('.dataTables_wrapper').find('.clearfix'),
	          p.append( '<center><button onclick="window.location.href=ruteador(1,\''+ruta_btn_01+'\')" type="button" class="btn btn-iconed btn-primary btn-sm"><i class="fa fa-folder-open"></i> '+nombre_bton+'</button></center>' ) //NUEVO BTON
        })
      })
    }.call(this);
    ;
  </script>


<!-- @include _footer