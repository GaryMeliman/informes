<?php


$host 	= "190.96.85.102";
$user 	= "admin";
$pwd 	= "c3rt1f1cac10n";

$link = mysql_connect( $host, $user, $pwd ) or die( "Error de conexión: " . mysql_error() );
echo "Conexión exitosa!";
mysql_close( $link );

?>