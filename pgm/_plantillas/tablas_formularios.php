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
	$xps_titulo_barra = "AYUDA PROGRAMACIÓN";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 1;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Proyectos'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
	          <?php
	            $xps_titulo   ="Comentarios tablas";//<-- MODIFICABLE         
		        $xps_volver   	="../phpFileTree/";//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
	            $xps_fullscreen =1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
	            $xps_color    =0;//<-- MODIFICABLE
	            $xps_actualizar =1;//<-- MODIFICABLE
	            $xps_minimizar  =1;//<-- MODIFICABLE
	            $xps_cerrar   =0;//<-- MODIFICABLE

	            widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
//+569 9437 1115

	$tabla = isset($_GET['d']) ? xps_desencriptar($_GET['d']) : 'documentos';	            
	          ?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->

<DIV class="row">
	<div class="col-md-6">
		<legend>TABLA : <b><?=$tabla?></b></legend>
	</div>
	<div class="col-md-6">
                <div class="form-group has-iconed">

                  <div class="iconed-input">
                  	<select name="HdIdTipoDoc_aux" id="HdIdTipoDoc_aux" class="form-control" onchange="$(location).attr('href','tablas_formularios.php?d='+this.value)">
                  		<option value='' selected>Seleccionar tabla</option>
						<?php
							$sql = "SELECT 
										TABLE_NAME as name,
										TABLE_NAME as value 
									FROM information_schema.TABLES 
									WHERE TABLE_SCHEMA = 'db_mnk';";
							crea_cbo_consulta($sql,$tabla)
						?>
			  		</select>
                  </div>
                </div>
	</div>	
</DIV>

<div class="table-responsive">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr class="warning">
              <th class="text-center">N°</th>
              <th>TIPO</th>
              <th class="text-center">KEY</th>              
              <th class="text-center">Nombre campo</th>
              <th class="text-center">OK</th>
              <th class="text-center">Nombre formulario</th>
              <th>Nulo</th>
            </tr>
          </thead>
          <tbody>
<?php

	$sql = "SELECT COLUMN_NAME, COLUMN_COMMENT, COLUMN_KEY, DATA_TYPE, IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$tabla'";

	//	echo $sql;
				  
		  $db = new MySQL();
		  $consulta = $db->consulta($sql);

			if($db->num_rows($consulta)>0){
				$i = 1;
				while($rs = $db->fetch_array($consulta)){

				if($rs['IS_NULLABLE'] == "YES"){
					$clase = 'class="success"';
				}
				else{
					$clase = 'class="danger"';
				}
?>		  
            <tr <?=$clase?>>
              <td class="text-center"><?=$i++?></td>
              <td><?=$rs['DATA_TYPE']?></td>
              <td class="text-center"><?=$rs['COLUMN_KEY']?></td>
              <td class="text-right"><?=$rs['COLUMN_NAME']?></td>
              <td class="text-center"><input type="checkbox"></td>
              <td class="text-left"><?=$rs['COLUMN_COMMENT']?></td>
              <td class="text-center"><?=$rs['IS_NULLABLE']?></td>
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
	<!-- *********** FIN ************ -->

	<!-- *********** PIÉ DE PÁGINA ************ -->
	<?php
		for($i=1;$i<29;$i++){
			echo "<br>";
		}
	?>		
		<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
	</div>

<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>

<!--//############  AQUI NUEVOS JS O CSS   ###################### -->



<!-- @include _footer