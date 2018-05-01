<?php
function xps_encriptar($string) {
	
	//return $string;
	
	if(empty($string) && $string!='0') xps_desencriptar_error(6,"Valor a encriptar vacio '".$string."'");
	
	  list($d,$m,$Y) = explode("-","06-12-1980");
	  $modelo = ( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	  $key	= $modelo.date('j');
	  $key2	= date('j');
	  $to_ascii = "";
	  $string = (string) $string;
	  
		  for ($i = 0; $i < strlen($string); $i++){
			  $v1 = ord($string[$i]) * $key;
			  $v2 = ord($string[$i]) * $key2;
			  
			  //echo ord($string[$i]) . "=>" . ($string[$i]) . "<br>";//visualiza el codigo encriptado paso a paso
			  
			  if($to_ascii == "") $to_ascii = ((strlen($string)* $key2)+$key) . "|" . (strlen($v1)) . $v1 . strlen($v2) . $v2;
			  else $to_ascii .= strlen($v1) .  $v1 . strlen($v2) . $v2;		
		  }
	  
	  		 //echo $to_ascii . "<hr><hr>";
	  
	  $decodificado = (string) xps_desencriptar($to_ascii);
	  
	  
	  	//echo $string ."==". $decodificado;
	  
	  
	  
	  if($string == $decodificado)
	  	return $to_ascii;
	  else
		xps_desencriptar_error(6,"Valor a encriptar no coincide : ".$string ."==". $decodificado);
}


function xps_desencriptar($string) {
	
	//return $string;
	
	$valor_base = $string;//
	
	$string = (string) $string;
	
	if(strrpos($string,"|")){
		
		list($d,$m,$Y) = explode("-","06-12-1980");
		$modelo = ( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
		$key	= $modelo.date('j');
		$key2	= date('j');
		$cadena = explode("|", $string);
		$paso_a = 0;
		$valor	= $cadena[1];
		$valor	= preg_replace("/[^0-9]/", "", $valor);//limpio cualquier caracter extraño
		$largo_cadena = ($cadena[0]-$key)/$key2;
		$decodificado = "";

		//CODIFICACION SEGUNDO PASO
		for($i = $paso_a; $i <= strlen($valor);$i++){
				if($paso_a>=strlen($valor)) xps_desencriptar_error(0);
			$base	 = $valor[$paso_a];
				if($base>=strlen($valor)) xps_desencriptar_error(1);
			$limiteA = $paso_a + $base;
				if(($limiteA+1)>=strlen($valor)) xps_desencriptar_error(2);
			$limiteB = $valor[$limiteA+1];
			$hasta	 = ($base + $limiteB)+2;
				if($hasta>strlen($valor)) xps_desencriptar_error(3);
			$paso 	 = substr($valor, $paso_a, $hasta );
			
			$cod_a = substr($valor, $paso_a+1, $base);
			$cod_b = substr($valor, $limiteA+2, $limiteB);
				//echo $cod_a . ">" . $cod_b . "<br>";
			
			$base_a = round($cod_a/$key);
			$base_b = round($cod_b/$key2);
				//echo "<br>".$base_a . ">" . $base_b . "<hr>";//CHEQUEA CODIGO IGUAL
			
			if($base_a==$base_b)
				$decodificado .= chr($base_a);
	
	
				//echo "<br>".$paso . "|>paso_a " . $paso_a . ">base " . $base . ">limiteA " . $limiteA . ">limiteB " . $limiteB . ">correte " . $hasta . "<br><br>";	
			$paso_a	+= strlen($paso);
			$i = $paso_a;
	
		}
		
		if(strlen($decodificado)==$largo_cadena){
			return $decodificado;//retorna valor decodificado		
		}

		xps_desencriptar_error(4);

	}	
	else{
		xps_desencriptar_error(5,"Valor a desencriptar : [".$valor_base."] NO COICIDE");
	}

}

function xps_desencriptar_error($error,$texto_extra=""){
	//return "ERROR <HR>";
	
	switch($error){
	
		case 0 :	cuadro_mensaje('RESTRINGIDO','CADENA MANIPULADA','a quebrado la cadena de envio, no podr&aacute; acceder a esta p&aacute;gina<br><br>[Cod.0]<br>'.$texto_extra.'<br>',1,1);
					//echo '<hr>a quebrado la cadena de envio, pa fuera.<br>Cod.0<hr>';
					// '0-'.$paso_a.'=>'.strlen($valor);
					break;
		case 1 :	cuadro_mensaje('RESTRINGIDO','CADENA MANIPULADA','a quebrado la cadena de envio, no podr&aacute; acceder a esta p&aacute;gina<br><br>[Cod.1]<br>'.$texto_extra.'<br>',1,1);
					//echo '<hr>a quebrado la cadena de envio, pa fuera.<br>Cod.1<hr>';
					 //'1-'.$base.'=>'.strlen($valor);
					break;
		case 2 :	cuadro_mensaje('RESTRINGIDO','CADENA MANIPULADA','a quebrado la cadena de envio, no podr&aacute; acceder a esta p&aacute;gina<br><br>[Cod.2]<br>'.$texto_extra.'<br>',1,1);
					//echo '<hr>a quebrado la cadena de envio, pa fuera.<br>Cod.2<hr>';
					//'2-'.($limiteA+1).'=>'.strlen($valor);
					break;
		case 3 :	cuadro_mensaje('RESTRINGIDO','CADENA MANIPULADA','a quebrado la cadena de envio, no podr&aacute; acceder a esta p&aacute;gina<br><br>[Cod.3]<br>'.$texto_extra.'<br>',1,1);
					//echo '<hr>a quebrado la cadena de envio, pa fuera.<br>Cod.3<hr>';
					 //'3-'.$hasta.'=>'.strlen($valor);
					break;
		case 4 :	cuadro_mensaje('RESTRINGIDO','CADENA MANIPULADA','a quebrado la cadena de envio, no podr&aacute; acceder a esta p&aacute;gina<br><br>[Cod.4]<br>'.$texto_extra.'<br>',1,1);
					//echo '<hr>a quebrado la cadena de envio, pa fuera.<br>Cod.4<hr>';
					//
					break;
		case 5 :	cuadro_mensaje('RESTRINGIDO','CADENA MANIPULADA','a quebrado la cadena de envio, no podr&aacute; acceder a esta p&aacute;gina<br><br>[Cod.5]<br>'.$texto_extra.'<br>',1,1);
					 //
					break;
		case 6 :	cuadro_mensaje('ERROR','NO SE PUEDE CODIFICAR','El dato no se puede codificar, revise el tipo y total de caracteres que quiere codificar<br><br>[Cod.6]<br>'.$texto_extra.'<br>',1,1);
					// echo '<hr>El valor no pudo ser codificado<br>Cod.6<hr>';
					 //
					break;
	}
	exit();
}

///__________________________-



function xps_encriptar_2($string) {//pryecto
	
	//return $string;
	
/*	if(empty($string) && $string!='0') xps_desencriptar_error(6,"Valor a encriptar vacio '".$string."'");
	
	  list($d,$m,$Y) = explode("-","06-12-1980");
	  $modelo = ( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	  $key	= $modelo.date('j');
	  $key2	= date('j');
	  $to_ascii = "";
	  
	  
*/	  


		$string = (string) $string;
	  
	  	$resultado = "";
		  for ($i = 0; $i < strlen($string); $i++){
			  $v1 = $string[$i];//ord();
			  echo $v1."-";
			  if (ctype_digit($v1))
				  $resultado .= letras_num($v1,2)."-";//Letras a Numeros
			  else
			  	  $resultado .= letras_num($v1,1)."-";//Numeros a Letras
		  }
	  
	  	echo "<br>".$resultado;
	  		 //echo $to_ascii . "<hr><hr>";
	  
/*	  $decodificado = (string) xps_desencriptar($to_ascii);
	  
	  
	  	//echo $string ."==". $decodificado;
	  
	  
	  
	  if($string == $decodificado)
	  	return $to_ascii;
	  else
		xps_desencriptar_error(6,"Valor a encriptar no coincide : ".$string ."==". $decodificado);
*/}

function letras_num($buscar,$tipo){

	$letras = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z"," ","-","_");
	
	if($tipo==1)//devuelve el numero de la letra
		return array_search($buscar,$letras);
	else
		return $letras[$buscar];

}




	
?>