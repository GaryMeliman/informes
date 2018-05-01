<?php

//ENCRIPTAR Y DESENCRIPTAR
include("encriptacion/inc_encriptacion.php");

//CREA CONTENIDO <option value=> DE UN COMBOBOX (SELECT)
include("combobox/inc_combobox.php");

//CREA CONTENIDO <option value=> DE UN COMBOBOX (SELECT) CON CONSULTA SQL
include("combobox/inc_combobox_consulta.php");

//CREA CONTENIDO <option value=> DE UN COMBOBOX ESTADO ACTIVO O INACTIVO SEGUN PARAMETRO
include("combobox/inc_combobox_estado.php");

//DA FORMATO A LA FECHA SEGUN REQUERIMIENTO (formato,fecha);
include("formato_fecha/inc_formato_fecha.php");

//CREAR CARPETA EN SERVIDOR rmkdir($path)
include("crear_directorios/inc_crear_directorio.php");

//Lee y escribe archivos excel
include("PHPExcel/PHPExcel.php");
include("PHPExcel/PHPExcel/IOFactory.php");

?>