<?php

define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));

function xps_ruteador(){

	$ip 	= $_SERVER['SERVER_ADDR'];
	$saltos = 1;//web
	$ip2 	= str_replace(".", "", $ip);
	$ip2 	= str_replace(":", "", $ip2);

	if( ($ip == "127.0.0.1") || ($ip == "::1") ) $saltos = 2;//local

	$dir_xps 	= explode("/", BASE_URL);
	$ruta_xps 	= '';

		for($i=$saltos;$i<count($dir_xps);$i++){ $ruta_xps .= '../';}
		//echo count($dir_xps)." | ".$saltos." |<br> ";

	return "administracion/".$ruta_xps;// QUITAR LA PALABRA ADMINISTRACION

}

function xps_ruteador2(){

		$base 		= explode("/", dirname($_SERVER["SCRIPT_NAME"]));
		$dir_base	= "mnk";//$base[1];

		$dir_xps 	= explode(DIRECTORY_SEPARATOR,dirname(__FILE__));
		$ruta 		= '';
		$k			= count($dir_xps)-1;
		
		while($dir_xps[$k--] != $dir_base) $ruta .= "../";//.DIRECTORY_SEPARATOR;

	//echo "ruteador|".dirname(__FILE__).DIRECTORY_SEPARATOR.$ruta."<br>";

	return $ruta;
}

function recuperaip() {
	
	return $_SERVER['SERVER_ADDR'];//ip del servidor	

    if (!empty($_SERVER['HTTP_CLIENT_IP']))

        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))

        return $_SERVER['HTTP_X_FORWARDED_FOR'];

    return $_SERVER['REMOTE_ADDR'];

}


function xps_valida_rut($r = false){
	
	//$rut = xps_valida_rut($_POST['rut']); //<=formatea el rut, si es valido devuelve el valor formateado, si no devuelve false
	//if( (xps_valida_rut($_POST['rut'])? 1 : 0) == 0 ){ echo "Rut no valido"; exit();};//ocupar para detener el proceso si el rut no es valido

	if($r == '13.957.370-6'){//ADMINISTRADOR
		//return 0;
	}


	if((!$r) or (is_array($r)))
		return false; /* Hace falta el rut */
	
	if(!$r = preg_replace('|[^0-9kK]|i', '', $r))
		return false; /* Era código basura */
	
	if(!((strlen($r) == 8) or (strlen($r) == 9)))
		return false; /* La cantidad de carácteres no es válida. */
	
	$v = strtoupper(substr($r, -1));
	if(!$r = substr($r, 0, -1))
		return false;
	
	if(!((int)$r > 0))
		return false; /* No es un valor numérico */
	
	$x = 2; $s = 0;
	for($i = (strlen($r) - 1); $i >= 0; $i--){
		if($x > 7)
			$x = 2;
		$s += ($r[$i] * $x);
		$x++;
	}
	$dv=11-($s % 11);
	if($dv == 10)
		$dv = 'K';
	if($dv == 11)
		$dv = '0';
	if($dv == $v)
		return number_format($r, 0, '', '.').'-'.$v; /* Formatea el RUT */
	return false;


}

function redireccionar($xps_ruta_volver="logout.php"){

//	header ("Location: ".$xps_ruta_volver);
echo '		<script type="text/javascript">
				var salir = "'.xps_ruteador().$xps_ruta_volver.'";
				console.log("Adios...");
			 	setTimeout(function(){ location.href=salir }, 500);
			</script>';
}

?>