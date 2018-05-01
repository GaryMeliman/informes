<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../inc_base.php');	
?>

</head>

<body class="glossed">

<?php
	$xps_titulo_barra = "USUARIOS";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 1;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Usuarios'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-12"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="Usuarios Sistema";//<-- MODIFICABLE					
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

<?php
	//BORRAME ESTO ES UN RELLENO__________________________________________________ 
?>
<div class="table-responsive">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th class="text-center">N°</th>
              <th class="text-center">Empresa</th>
              <th class="text-center"Cargo</th>
              <th class="text-center">Imagen</th>
              <th class="text-center">Usuario</th>
              <th class="text-center">Estado</th>
              <th class="text-center">Eliminado</th>
              <th class="text-center">Fecha</th>
            </tr>
          </thead>
          <tbody>

<?php

$id_user 	= $_SESSION['valida']['id_usuario'];

$sql = "SELECT
		  `u`.`id_usuario`,
		  `u`.`id_persona`,
		  IF(`u`.`foto_usuario`,CONCAT(`p`.`rut_pers`,'.png'),'sin_foto.png') AS foto_usuario, 
		  CONCAT(`p`.`nombre_pers`,' ',`p`.`paterno_pers`,' ',`p`.`materno_pers`) AS nombre,
		  `u`.`login_usuario`,
		  `u`.`password_usuario`,
		  `u`.`estado_usuario`,
		  `u`.`eliminado_usuario`,
		  `u`.`fecha_creacion_usuario`,
		  (SELECT CONCAT(`e`.`nom_fantasia_emp`, '|', `c`.`nombre_cargo`) AS `empresaycargo` 
		  	FROM `trabajadores` `t` 
			  	LEFT OUTER JOIN `empresas` `e` ON (`t`.`id_emp` = `e`.`id_emp`) 
			  	LEFT OUTER JOIN `trabajadores_cargo` `tc` ON (`t`.`id_trab` = `tc`.`id_trab`) 
			  	LEFT OUTER JOIN `cargos` `c` ON (`tc`.`id_cargo` = `c`.`id_cargo`) 
			  	LEFT OUTER JOIN `empresas_colaboradores` `ec` ON (`e`.`id_emp` = `ec`.`id_emp_hijo`) 
		  	WHERE `t`.`id_persona` = `p`.`id_persona` AND `t`.`estado_trab` = 1 AND `ec`.`estado_emp_col` = 1 LIMIT 1) AS `empresaycargo`
		FROM
		  `_usuarios` `u`
		  LEFT OUTER JOIN `personas` `p` ON (`u`.`id_persona` = `p`.`id_persona`)
		ORDER BY
		  empresaycargo,
		  nombre,
		  estado_usuario,
		  eliminado_usuario";

//echo "$sql<hr>";

//exit();

	$db	= new MySQL();


$consulta = $db->consulta($sql);

$existe = 0;


if($db->num_rows($consulta)>0){
	$i=1;
    while($rs = $db->fetch_array($consulta)){

    	$cargoyempresa = explode('|', $rs['empresaycargo']);
    	$empresa = $cargoyempresa[0];
    	$cargo   = $cargoyempresa[1];
?>    

            <tr>
              <td class="text-center"><?=$i++?></td>
              <td><?=$empresa?></td>
              <td class="text-center"><?=$cargo?></td>
              <td class="text-center">
              	<img src="../img.php?r=fotosusuarios.img/<?=$rs['foto_usuario']?>" alt="<?=$rs['nombre_pers']?>" width="30" height="30"></td>
              <td class="text-left"><?=$rs['nombre']?></td>
              <td class="text-center"><?=$rs['estado_usuario']?></td>
              <td class="text-center"><?=$rs['eliminado_usuario']?></td>
              <td class="text-center"><?=xps_fecha(1,$rs['fecha_creacion_usuario'])?></td>

              <td class="text-center">

				<button type="button" class="btn btn-action btn-xs btn-primary" onclick="window.location.href=ruteador(1,'adm/editar_usuario.php?u=<?=xps_encriptar($rs['id_usuario'])?>');">
					<i class="fa fa-pencil"></i> Editar
				</button>

				<button type="button" class="btn btn-action btn-xs btn-primary" onclick="window.location.href=ruteador(1,'detalle_empresa.php?d=391|51847333435188503350');">
					<i class="fa fa-exclamation-circle"></i> Detalles
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
		  	  var ruta_btn_01 = "plantilla.php";//ruta del nuevo bton
	          var nombre_bton = "Nuevo";
	          return a = $(this),
	          p = a.closest('.dataTables_wrapper').find('.clearfix'),
	          p.append( '<center><button onclick="window.location.href=ruteador(1,\''+ruta_btn_01+'\')" type="button" class="btn btn-iconed btn-primary btn-sm"><i class="fa fa-folder-open"></i> '+nombre_bton+'</button></center>' ) //NUEVO BTON
        })
      })
    }.call(this);
    ;
  </script>
<!--//############  AQUI NUEVOS JS O CSS   ######################//
		BORRAR SI NO SE OCUPA

    //############ FIN NUEVOS JS O CSS ######################//-->

<!-- @include _footer