<?php
/*
../img.php?r=doc.img/<?=$rs['img_tipo_doc']?>
$r = "accept.png";
echo "<img src='img.php?r=".$r."' width='100' height='92' id='logo_img' alt='Imagen' border=0 />";

*/
try{
	@session_start();
		$datos_rnl     = explode("|", $_SESSION['valida']['parametros']);
		$n_ruta      = $datos_rnl[1];
		
		if(isset($_GET['r']))
			$name = explode("/", $_GET['r']);
		else
			$name = explode("/", 'datagrid.img/ok.png');

		$existe		 = 0;//hasta este momento no existe el archivo
		$xps_dominio = "archivos";

		$encontrado = strpos(dirname(__FILE__), "\\");
		if($encontrado === false)
			$img_rute = explode("/", dirname(__FILE__)) ;//linux
		else
			$img_rute = explode("\\", dirname(__FILE__)) ;//windors
		
		$rute = "";
		foreach ($img_rute as $key => $value) {
			//    echo $value. "!=". $n_ruta."<br>";
			if($value != $n_ruta) $rute .= $value."/";
			else break;
		}
/*		echo "Dirname(_file_) : ".dirname(__FILE__);
		echo "<hr>".$n_ruta."<br>";
		echo $rute."<br>";
		exit;
	*/	
	//
	$ruta = $rute."/".$n_ruta."_".$xps_dominio."/".$name[0]."/"; //ruta correcta
	//	$ruta = "/var/www/html/mnk_".$xps_dominio."/".$name[0]."/"; //ruta armada a mano
	//	$ruta = "/root/codigo/".$n_ruta."_".$xps_dominio."/".$name[0]."/";//prueba 1
	//	$ruta = "/var/www/html/mnk_archivos/datagrid.img/"; //prueba 2

	//      echo dirname(__FILE__)."<hr>";

	//
	// 	echo $ruta."<hr>";
	//	exit();

	
      if ( !file_exists($ruta.$name[1]) ) {
        throw new Exception("Archivo ".$ruta.$name[1].", no encontrado");
      }	
	
		$directorio	= opendir($ruta);
			while ($archivo = readdir($directorio)){ 
				if($archivo==$name[1]){
					$existe = 1;//archivo existe
					break;
				}
			}
		
		if($existe==0) $name = $ruta."icon.png";//no existe
		else $name = $ruta.$name[1];//existe

	//      exit();

			$fp = fopen($name, 'rb');
		// send the right headers
			header("Content-Type: image/png");
			header("Content-Length: " . filesize($name));
			
		// dump the picture and stop the script
			fpassthru($fp);
		//	exit;
		//	fclose($fp);
		//	clearstatcache();	
	
} catch (Exception $e) {
		echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
}
	
	
?>