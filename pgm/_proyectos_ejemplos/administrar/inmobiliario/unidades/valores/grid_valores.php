<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>


<?php
    require_once('../../../../../inc_base.php');  
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

  <div class="widget widget-orange" style="height:530px">
        <?php
          $xps_titulo     ="Proyecto <b>".xps_desencriptar($_GET['n'])."</b>";//<-- MODIFICABLE         
          $xps_volver     ="../grid_unidades.php?cl=".$_GET['cl']."&pro=".$_GET['pro']."&n=".$_GET['n']."&pi=".$_GET['pi'];//<-- MODIFICABLE ruta de la página, vacio = sin botón
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

	$idu = xps_desencriptar($_GET['u']);
  $idpi   = xps_desencriptar($_GET['pi']);

  $sql = "SELECT 
            `u`.`id_unidad`,
            `u`.`tipologia_unidad`,
            `ut`.`nombre_tipo`,
            `u`.`mts_cuadrados`,
            `u`.`plano_unidad`
          FROM
            `unidades` `u`
            LEFT OUTER JOIN `unidades_tipos` `ut` ON (`u`.`id_unidad_tipo` = `ut`.`id_unidad_tipo`)
          WHERE
            `u`.`id_unidad` = $idu      
      ";  	

//   echo $sql;

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$rspi = $db->fetch_array($consulta);
		
?>	
  <div class="row">
          <div class="col-sm-4">
            <div class="avatar-w">
				<img src="../../../../../img.php?r=logos.img/<?=$rspi['plano_unidad']?>" alt="<?=$rs['tipologia_unidad']?>" class="img-max">
            </div>
          </div>
      <div class="left-inner-shadow">            
                  <div class="col-sm-9 col-md-5 col-lg-8">
                    <div class="profile-main-info">
                      <h1><i class="fa fa-file-text-o"></i>  <?=$rspi['tipologia_unidad']?></h1>
                      <p style="text-align: justify;">Tipología</p>

                      <a href="#">mnk.cl <i class="fa fa-external-link-square icon-left-margin"></i></a>
                    </div>
                    <div class="profile-details visible-lg">
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="icon"><i class="fa fa-map-marker"></i></div><?=$rspi['nombre_tipo']?>
                        </div>
                        <div class="col-lg-4">
                          <div class="icon"><i class="fa  fa-sort-numeric-asc"></i></div><?=$rspi['mts_cuadrados']?> Mts2
                        </div>
                        <div class="col-lg-4">
                          <i class="fa fa-pencil"></i>
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
              <th class="text-center">ID</th>
              <th>Unidad</th>
              <th class="text-center">Tipo</th>
              <th class="text-center">Mts2</th>
              <th class="text-center"></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
<?php

	$sql = "SELECT 
            `uv`.`id_unidad_valor`,
            `uv`.`valor_unidad`,
            `uv`.`fecha_valor`,
            `uv`.`estado_valor`
          FROM
            `unidades_valores` `uv`
          WHERE
            `uv`.`id_unidad` = $idu
          ORDER BY
            `uv`.`estado_valor` DESC	
			";	

//   echo $sql;

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$i = 1;
    $subarea = "";
		while($rs = $db->fetch_array($consulta)){
			
			$color_clasificacion = "";
?>
            <tr>
              <td class="text-center"><?=$i++?></td>
              <td class="text-center" style="background-color:<?=$color_clasificacion?>;opacity: 0.3;"><?=$rs['id_unidad_valor']?></td>
              <td><?=$rs['valor_unidad']?></td>
              <td class="text-center"><?=$rs['fecha_valor']?></td>
              <td class="text-center"><?=$rs['estado_valor']?></td>
              <td class="text-center"> </td>
              <td class="text-center">
                <button type="button" class="btn btn-action btn-xs btn-success" onclick="window.location.href=ruteador(1,'editar_unidad.php?cl=<?=$_GET
                ['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=$_GET['pi']?>&u=<?=xps_encriptar($rs['id_unidad'])?>');">
                  <i class="fa fa-pencil"></i> Editar
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
  <script type="text/javascript">
    !function () {
      $(function () {
        $('.datatable').each(function () {
          var ruta_btn_01 = "nuevo_valor.php?cl=<?=$_GET['cl']?>&pro=<?=$_GET['pro']?>&n=<?=$_GET['n']?>&pi=<?=$_GET['pi']?>&u=<?=$_GET['u']?>";//ruta del nuevo bton
            var nombre_bton = "Nuevo Valor";
            return a = $(this),
            p = a.closest('.dataTables_wrapper').find('.clearfix'),
            p.append( '<center><button onclick="window.location.href=ruteador(1,\''+ruta_btn_01+'\')" type="button" class="btn btn-iconed btn-primary btn-sm"><i class="fa fa-plus-square"></i> '+nombre_bton+'</button></center>' ) //NUEVO BTON
        })
      })
    }.call(this);
    <?=$subarea?>
  </script>


<!-- @include _footer