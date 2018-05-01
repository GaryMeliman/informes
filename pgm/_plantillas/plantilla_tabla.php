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
	$xps_titulo_barra = "TÍTULO PLANTILLA";//<--------MODIFICABLE TITULO
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
					$xps_titulo		="Título Tabla";//<-- MODIFICABLE					
		            $xps_volver   	="../phpFileTree/";//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
					$xps_fullscreen	=1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
					$xps_color		=0;//<-- MODIFICABLE
					$xps_actualizar	=1;//<-- MODIFICABLE
					$xps_minimizar	=1;//<-- MODIFICABLE
					$xps_cerrar		=0;//<-- MODIFICABLE

					widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
				?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->


<div class="table-responsive">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th class="text-center">N°</th>
              <th class="text-center">ID</th>
              <th>Imagen</th>
              <th class="text-center">Nombre tipo</th>
              <th class="text-center">Nombre documento</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
<?php
/*
	$principal 		= $_GET['p'];
    $contratista	= $_GET['c'];
    $persona 		= xps_desencriptar($_GET['idp']);

	$db	= new MySQL();

	$sql	= "SELECT * FROM TABLA WHERE algo=$variable ORDER BY algo";

	$consulta = $db->consulta($sql);
	if($db->num_rows($consulta) > 0)
		while($rs = $db->fetch_array($consulta)){
*/
?>
            <tr>
              <td class="text-center">7</td>
              <td>_</td>
              <td>doc_on.png</td>
              <td class="text-center">Word</td>
              <td class="text-left">tt</td>
              <td class="text-center">
				<button type="button" class="btn btn-action btn-xs btn-primary" onclick="window.location.href=ruteador(1,'detalle_empresa.php?d=391|51847333435188503350');">
					<i class="fa fa-exclamation-circle"></i> Detalles
				</button>

				<button type="button" class="btn btn-action btn-xs btn-primary" onclick="window.location.href=ruteador(1,'editar_doc.php?d=<?=xps_encriptar(0)?>');">
					<i class="fa fa-pencil"></i> Editar
				</button>

              </td>
            </tr>
<?php
/*
		}//fin while
	}//fin if
	else{
		echo "    <tr>";
        echo '      <td colspan="6" class="text-center">No hay registros</td>';
        echo "    </tr>";
	}//fin else
*/	
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