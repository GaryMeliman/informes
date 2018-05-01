<?php
//Desarrollado por Jesus Liñán
//ribosomatic.com
//Puedes hacer lo que quieras con el código
//pero visita la web cuando te acuerdes

//Configuracion de la conexion a base de datos
$bd_host = "localhost"; 
$bd_usuario = "root"; 
$bd_password = "93539514"; 
$bd_base = "db_certificacion"; 

$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 

mysql_select_db($bd_base, $con); 

//consulta todos los empleados

$sql=mysql_query("SELECT * FROM _menu",$con);

//muestra los datos consultados
echo "<p>ID - Menu - Imagen</p> \n";
while($row = mysql_fetch_array($sql)){
	echo "<p>".$row['id_menu']." - ".$row['nombre_menu']." - ".$row['img_menu']."</p> \n";
}
?>