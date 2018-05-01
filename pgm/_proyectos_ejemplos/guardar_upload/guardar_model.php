<?php

	require_once('../../inc_conexion.php');
	print_r($_POST);
	print_r($_FILES);

//	exit();
//####################################### 	CAMPOS #############################

    $HdIdDocProyecto	= xps_desencriptar($_POST['HdIdDocProyecto']);
    $HdIdProyecto 		= xps_desencriptar($_POST['HdIdProyecto']);
    $HdIdEtapa 			= xps_desencriptar($_POST['HdIdEtapa']);
    $HdIdDocumentos 	= xps_desencriptar($_POST['HdIdDocumentos']);
    $HdIdEntrega 		= xps_desencriptar($_POST['HdIdEntrega']);
    $param 				= $_POST['param'];
    $TXTComentario		= $_POST['TXTComentario'];

//####################################### 	ARCHIVOS #############################

	$path 		= $_FILES['file']['name'];
	$ext 		= pathinfo($path, PATHINFO_EXTENSION);

	$sourcePath = $_FILES['file']['tmp_name'];
	$ruta_save  = guarda_doc() . $HdIdProyecto . "/" . $HdIdEtapa . "/";
	$targetPath = $ruta_save . $HdIdDocumentos."-".round(microtime(true)) . '.' . $ext;// end($_FILES['file']['name']);

//####################################### 	UPLOAD #############################

	if($_POST['estado'] == 3){
		if(!rmkdir($ruta_save)) echo "Nuevo directorio creado para el proyecto";

		move_uploaded_file($sourcePath, $targetPath);

/*		echo $targetPath;
		echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
		echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
		echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
*/		
	}
//	exit();   

//####################################### 	SUBIR A LA BD #############################

	$db = new MySQL();

    $accion = (($HdIdDocProyecto>0) ? 0 : 1);


	$documento = array();
//	$documento['ver'] 			 = 1;
	$documento['HdIdDocProyecto']= 0;
	$documento['HdIdProyecto'] 	 = 0;
	$documento['HdIdEtapa']		 = 0;
	$documento['HdIdDocumentos'] = 0;
	$documento['HdIdEntrega']	 = 1;
	$documento['datos1']		 = xps_encriptar($accion.",".$HdIdDocProyecto.",".$HdIdProyecto.",".$HdIdEtapa.",".$HdIdDocumentos.",".$HdIdEntrega);
	$documento['accion'] 		 = 9;	

/*
	var_dump($documento);

exit();			
*/


		if($consulta = $db->comentario('proyectos_documentos','', $documento , 2)){
			if($accion>0){
				$id_doc_proy = $db->insertId();
			}
			else{
				$id_doc_proy = $HdIdDocProyecto;	
			}

			session_start();
			$id_usuario = $_SESSION['valida']['id_usuario'];

			$comentario = array();
//			$comentario['ver'] 				= 1;
			$comentario['HdIdDocProyecto']	= 0;
			$comentario['HiUser']			= 0;
			$comentario['HdIdEntrega']	 	= 0;
			$comentario['TXTComentario']	= 0;
			$comentario['datos1']			= xps_encriptar($param.",".$id_doc_proy.",".$id_usuario.",".$HdIdEntrega.",".$TXTComentario);
			$comentario['accion']			= 6;

			if($consulta = $db->comentario('proyectos_documentos_comentarios','', $comentario , 2)){
				echo '<pre>detalle_pla.php';
				echo '<pre>Proyecto ingresado Correctamente';
			}
			else{
				echo '<pre>detalle_pla.php';
				echo "<pre>NO SE GUARDO EL COMENTARIO";								
			}
		}
		else{
			echo '<pre>detalle_pla.php';
			echo "<pre>NO SE GUARDO EL REGISTRO DOCUMENTO";				
		}


	exit();


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