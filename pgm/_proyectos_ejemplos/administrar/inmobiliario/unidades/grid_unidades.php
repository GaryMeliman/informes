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
	$xps_titulo_barra = "PROYECTOS";
	$xps_ver_submenu  = 0;
  require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php'); 
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Proyectos'];
//############## MENU ######################//	
?>



<div class="main-content">

  <div class="widget widget-green" style="height:530px">
        <?php
          $xps_titulo     ="Proyecto <b>".xps_desencriptar($_GET['n'])."</b>";//<-- MODIFICABLE         
          $xps_volver     ="../grid_inmobiliarios.php?cl=".$_GET['cl']."&pro=".$_GET['pro']."&n=".$_GET['n'];//<-- MODIFICABLE ruta de la página, vacio = sin botón
          $xps_fullscreen =1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
          $xps_color      =0;//<-- MODIFICABLE
          $xps_actualizar =1;//<-- MODIFICABLE
          $xps_minimizar  =0;//<-- MODIFICABLE
          $xps_cerrar     =0;//<-- MODIFICABLE

          widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
        ?>
    <div class="widget-content">

<?php

	$db	= new MySQL();

	$idproy = xps_desencriptar($_GET['pro']);
  $idpi   = xps_desencriptar($_GET['pi']);
	$id_inmobiliario = "";

	$sql = "SELECT 
        `pi`.`id_inmobiliario`,
        `p`.`nombre_proyecto`,
        `pi`.`nombre_inmobiliario`,
        `pi`.`descripcion_inmobiliario`,
        `rgc`.`nombre_comuna`,
        `pit`.`nombre_tipo_inmobiliario`,
        `e`.`nombre_estado`,
        `pi`.`logo_inmobiliario`,
        `pi`.`estado_inmobiliario`
      FROM
        `proyectos_inmobiliarios` `pi`
        LEFT OUTER JOIN `estados` `e` ON (`pi`.`id_estado_proyecto` = `e`.`id_estado_proyecto`)
        LEFT OUTER JOIN `proyectos` `p` ON (`pi`.`id_proyecto` = `p`.`id_proyecto`)
        LEFT OUTER JOIN `proyectos_inmobiliarios_tipos` `pit` ON (`pi`.`id_tipo_inmobiliario` = `pit`.`id_tipo_inmobiliario`)
        LEFT OUTER JOIN `rg_comuna` `rgc` ON (`pi`.`id_comuna` = `rgc`.`id_comuna`)
      WHERE
        `pi`.`id_inmobiliario` = $idpi		
			";	

//   echo $sql;

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$rspi = $db->fetch_array($consulta);
		
		$id_inmobiliario = $rspi['id_inmobiliario'];
?>	
  <div class="row">
          <div class="col-sm-4">
            <div class="avatar-w">
				<img src="../../../../img.php?r=logos.img/<?=$rspi['logo_inmobiliario']?>" alt="<?=$rspi['nombre_inmobiliario']?>" class="img-max">
            </div>
          </div>
      <div class="left-inner-shadow">            
                  <div class="col-sm-9 col-md-5 col-lg-8">
                    <div class="profile-main-info">
                      <h1><i class="fa fa-file-text-o"></i>  <?=$rspi['nombre_inmobiliario']?></h1>
                      <p style="text-align: justify;"><?=$rspi['descripcion_inmobiliario']?></p>

                      <a href="#">mnk.cl <i class="fa fa-external-link-square icon-left-margin"></i></a>
                    </div>
                    <div class="profile-details visible-lg">
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="icon"><i class="fa fa-map-marker"></i></div><?=$rspi['nombre_comuna']?>
                        </div>
                        <div class="col-lg-4">
                          <div class="icon"><i class="fa fa-calendar"></i></div> Dic 06
                        </div>
                        <div class="col-lg-4">
                          <div style="cursor: pointer" class="icon" onclick="window.location.href=ruteador(1,'editar_inmobiliario.php?cl=<?=$_GET
                ['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=xps_encriptar($id_inmobiliario)?>');"><i class="fa fa-pencil"></i></div> Editar
                </button>						  
                        </div>
                      </div>
                    </div>
                  </div>
      </div>            
  </div>				

<?php
	}
?>
  <br><br><hr>
	
<?php //____________________ TABLA ______________________?>	
	
	
<div class="table-responsive">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th class="text-center">N°</th>
              <th class="text-center">IDV</th>
              <th class="text-center">ID</th>
              <th>Unidad</th>
              <th class="text-center">Tipo</th>
              <th class="text-center">Mts2</th>
              <th class="text-center">Valor</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
<?php


	$idproy = xps_desencriptar($_GET['pro']);

	$sql = "SELECT 
            `u`.`id_unidad`,
            `u`.`tipologia_unidad`,
            `ut`.`nombre_tipo`,
            `u`.`mts_cuadrados`,
             IFNULL((SELECT `uv`.`id_unidad_valor`
                FROM `unidades_valores` `uv`
                WHERE `uv`.`id_unidad` = `u`.`id_unidad` AND 
                  `uv`.`estado_valor` = 1
                LIMIT 1),0) AS id_v_u,  
             (SELECT `uv`.`valor_unidad`
                FROM `unidades_valores` `uv`
                WHERE `uv`.`id_unidad` = `u`.`id_unidad` AND 
                  `uv`.`estado_valor` = 1
                LIMIT 1) AS valor            
          FROM
            `unidades` `u`
            LEFT OUTER JOIN `unidades_tipos` `ut` ON (`u`.`id_unidad_tipo` = `ut`.`id_unidad_tipo`)
          WHERE
            `u`.`id_inmobiliario` = $id_inmobiliario			
			";	

// echo $sql;

	$consulta = $db->consulta($sql);
  $subarea = "";
	if($db->num_rows($consulta)>0){
		$i = 1;  
		while($rs = $db->fetch_array($consulta)){
			
			$color_clasificacion = "";
?>
            <tr>
              <td class="text-center"><?=$i++?></td>
              <td class="text-center"><?=$rs['id_v_u']?></td>              
              <td class="text-center" style="background-color:<?=$color_clasificacion?>;opacity: 0.3;"><?=$rs['id_unidad']?></td>
              <td><?=$rs['tipologia_unidad']?></td>
              <td class="text-center"><?=$rs['nombre_tipo']?></td>
              <td class="text-center"><?=$rs['mts_cuadrados']?></td>
              <td class="text-center"><?=number_format($rs['valor'], 0, ',', '.');?></td>
              <td class="text-center">
                <button type="button" class="btn btn-action btn-xs btn-success" onclick="window.location.href=ruteador(1,'editar_unidad.php?cl=<?=$_GET
                ['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=$_GET['pi']?>&u=<?=xps_encriptar($rs['id_unidad'])?>');">
                  <i class="fa fa-pencil"></i> Editar
                </button>
                <button type="button" class="btn btn-action btn-xs btn-danger" onclick="window.location.href=ruteador(1,'valores/grid_valores.php?cl=<?=$_GET
                ['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=$_GET['pi']?>&u=<?=xps_encriptar($rs['id_unidad'])?>');">
                  <i class="fa fa-pencil"></i> Valores
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

    </div>                

  </div>

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
  var ruta_btn_01  = "nueva_unidad.php?cl=<?=$_GET['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=xps_encriptar($id_inmobiliario)?>";
          var nombre_bton1 = "Agregar Unidad";
  var ruta_btn_02  = "carga_unidades/carga_rapida.php?cl=<?=$_GET['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=xps_encriptar($id_inmobiliario)?>";
          var nombre_bton2 = "Carga Unidades";
  var ruta_btn_03  = "carga_valores/carga_rapida.php?cl=<?=$_GET['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=xps_encriptar($id_inmobiliario)?>";
          var nombre_bton3 = "Carga Valores";

            return a = $(this),
            p = a.closest('.dataTables_wrapper').find('.clearfix'),
            p.append( '<center><button onclick="window.location.href=ruteador(1,\''+ruta_btn_01+'\')" type="button" class="btn btn-iconed btn-primary btn-sm"><i class="fa fa-plus-square"></i> '+nombre_bton1+'</button><button onclick="window.location.href=ruteador(1,\''+ruta_btn_02+'\')" type="button" class="btn btn-iconed btn-success btn-sm"><i class="fa fa-flash"></i> '+nombre_bton2+'</button><button onclick="window.location.href=ruteador(1,\''+ruta_btn_03+'\')" type="button" class="btn btn-iconed btn-warning btn-sm"><i class="fa fa-dollar"></i> '+nombre_bton3+'</button></center>' ); //NUEVO BTON
        });
      });
    }.call(this);
    <?=$subarea?>
  </script>

<!-- @include _footer