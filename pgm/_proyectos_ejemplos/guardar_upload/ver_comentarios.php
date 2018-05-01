<?php

	require_once('../../inc_conexion.php');
//	print_r($_POST);

//	exit();
//####################################### 	CAMPOS #############################

/*
    $HdIdDocProyecto	= xps_desencriptar($_POST['HdIdDocProyecto']);
    $HdIdProyecto 		= xps_desencriptar($_POST['HdIdProyecto']);
    $HdIdEtapa 			= xps_desencriptar($_POST['HdIdEtapa']);
    $HdIdDocumentos 	= xps_desencriptar($_POST['HdIdDocumentos']);
    $HdIdEntrega 		= xps_desencriptar($_POST['HdIdEntrega']);
    $TXTComentario		= $_POST['TXTComentario'];
*/

	$HdIdProyecto 		= xps_desencriptar($_POST['HdIdProyecto']);

	$db = new MySQL();

			$sql = "SELECT 
					  IF(`u`.`foto_usuario`,CONCAT(`p`.`rut_pers`,'.png'),'sin_foto.png') AS foto_usuario,
					  CONCAT(`p`.`nombre_pers`, ' ', `p`.`paterno_pers`, ' ', `p`.`materno_pers`) AS `usuario`,
					  IFNULL((SELECT `c`.`nombre_cargo` 
					  	FROM `trabajadores` `t` 
					  		LEFT OUTER JOIN `trabajadores_cargo` `tc` ON (`t`.`id_trab` = `tc`.`id_trab`) 
					  		LEFT OUTER JOIN `cargos` `c` ON (`tc`.`id_cargo` = `c`.`id_cargo`) 
					  		WHERE `t`.`id_persona` = `p`.`id_persona` AND `tc`.`estado_cargo` = 1 LIMIT 1),'No definido') AS `cargo`,
					  `pdc`.`comentario`,
					  `ee`.`nombre_entrega`,
					  `ee`.`label_estado`,
					  `pdc`.`fecha_creacion`
					FROM
					  `proyectos_documentos_comentarios` `pdc`
					  LEFT OUTER JOIN `_usuarios` `u` ON (`pdc`.`id_usuario` = `u`.`id_usuario`)
					  LEFT OUTER JOIN `personas` `p` ON (`u`.`id_persona` = `p`.`id_persona`)
					  LEFT OUTER JOIN `estados_entregas` `ee` ON (`pdc`.`id_entrega` = `ee`.`id_entrega`)
					WHERE
					  `pdc`.`id_doc_proyecto` = $HdIdProyecto
					ORDER BY
					  `pdc`.`fecha_creacion`";


//					  echo $sql;

	$consulta = $db->consulta($sql);

  
			  if($db->num_rows($consulta)>0){
			  	$i=1;
				while($rs = $db->fetch_array($consulta)){
if( $i++ % 2 ){
	echo '          <li>
	            		<div class="row">
	              			<div class="col-xs-2">
	                			<div class="avatar">
	                  				<img src="../img.php?r=fotosusuarios.img/'.$rs['foto_usuario'].'">
	                			</div>
	              			</div>
							<div class="col-xs-10">
			                	<div class="chat-bubble chat-bubble-right">
									<div class="bubble-arrow"></div>
									<div class="meta-info"><a href="#">'.$rs['usuario'].' ['.$rs['cargo'].']</a> el '.xps_fecha(8,$rs['fecha_creacion']).'</div>
										<p>'.$rs['comentario'].'</p>
										<span class="label label-'.$rs['label_estado'].'">'.$rs['nombre_entrega'].'</span>
								</div>
			              	</div>
	            		</div>
	          		</li>';
}
else{
	echo '			<li>
						<div class="row">
							<div class="col-xs-10">
								<div class="chat-bubble chat-bubble-left">
									<div class="bubble-arrow"></div>
									<div class="meta-info"><a href="#">'.$rs['usuario'].' ['.$rs['cargo'].']</a> el '.xps_fecha(8,$rs['fecha_creacion']).'</div>
									<p>'.$rs['comentario'].'</p>
									<span class="label label-'.$rs['label_estado'].'">'.$rs['nombre_entrega'].'</span>
								</div>
							</div>
							<div class="col-xs-2">
								<div class="avatar">
									<img src="../img.php?r=fotosusuarios.img/'.$rs['foto_usuario'].'">
								</div>
							</div>
						</div>
					</li>';
}
				}
			  }else{
				   echo "<pre>new_persona.php";
				   echo "<pre>Necesita crear al Contacto";
			  }
	exit();
/**/

function guarda_doc(){
	try{
		@session_start();
			$datos_rnl	= explode("|", $_SESSION['valida']['parametros']);
			$n_ruta		= $datos_rnl[1];

			$name = "archivos.doc";//explode("/", $r);

			$existe		 = 0;//hasta este momento no existe el archivo
			$xps_dominio = "archivos";

			$encontrado = strpos(dirname(__FILE__), "\\");
			if($encontrado === false)
				$img_rute = explode("/", dirname(__FILE__)) ;//linux
			else
				$img_rute = explode("\\", dirname(__FILE__)) ;//windors
			
			$rute = "";
			foreach ($img_rute as $key => $value) {
				if($value != $n_ruta) $rute .= $value."/";
				else break;
			}

		$ruta = $rute."".$n_ruta."_".$xps_dominio."/".$name."/"; //ruta correcta

	      if ( !file_exists($ruta) ) {
	        throw new Exception("Ruta : ".$ruta.", no encontrada");
	      }	

	      return $ruta;
		
	} catch (Exception $e) {
			echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
			return "0";
	}	
}


  
?>