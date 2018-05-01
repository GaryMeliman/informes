<?php

function rmkdir($path, $mode = 0755) {

    $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
	
    $e = explode("/", ltrim($path, "/"));

	if(is_dir($path))//ya fue creado
		return false;
	else{			 //es creado  
		mkdir($path, $mode, true);	
		return true;
	}
	exit();

}

?>