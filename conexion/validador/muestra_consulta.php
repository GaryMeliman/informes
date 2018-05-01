<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Prueba de SELECT y MySQL</title> 
</head> 
<body> 
<?php 


  // Devuelve todas las filas de una consulta a una tabla de una base de datos 
  // en forma de tabla de HTML 
  function sql_dump_result($result){ 
		$line = ''; 
		$head = '';
		
	  while($temp = mysqli_fetch_assoc($result)){ 
		if(empty($head)){ 
		  $keys = array_keys($temp); 
		  $head = '<tr bgcolor="#CCCCCC"><th>' . implode('</th><th>', $keys). '</th></tr>'; 
		}
		$line .= '<tr><td>' . implode('</td><td>', $temp). '</td></tr>'; 
	  }
	  
	  return '<table border="1">' . $head . $line . '</table>'; 
}

  // Se conecta al SGBD 
  
session_start(); 	
//	$_SESSION['valida'] = array($_POST['server'],$_POST['user'],$_POST['pass'],$_POST['dbase']);
	list($servidor,$usuario,$pws,$db) = $_SESSION['valida'];

  if(!($conexion = mysqli_connect($servidor,$usuario,$pws,$db))) 
    die("Error: No se pudo conectar a la bd");
		
  // consulta SQL: muestra todo el contenido de la tabla "books" 
  $consulta = $_POST['consulta'];
  // Ejecuta la sentencia SQL 
  $resultado = mysqli_query($conexion, $consulta);
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");

  // Muestra el contenido de la tabla como una tabla HTML	
  echo sql_dump_result($resultado); 
  
  // Libera la memoria del resultado
  mysqli_free_result($resultado);

  // Cierra la conexión con la base de datos 
  mysqli_close($conexion); 
?> 
</body> 
</html> 