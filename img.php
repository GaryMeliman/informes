<?php

    try{
      @session_start();
        $n_ruta = "pgm";

        if(isset($_GET['r']))
          $name = explode("/", $_GET['r']);
        else
          $name = explode("/", 'background/ok.png');

//          $name = explode("/", 'datagrid.img/ok.png');

        $existe      = 0;//hasta este momento no existe el archivo
        $xps_dominio = "archivos";

        $encontrado = strpos(dirname(__FILE__), "\\");
        if($encontrado === false)
          $img_rute = explode("/", dirname(__FILE__)) ;//linux
        else
          $img_rute = explode("\\", dirname(__FILE__)) ;//windors
        
        $rute = "";
        foreach ($img_rute as $key => $value) {
              //echo $value. "!=". $n_ruta."<br>|";
              $revision = "informes";//$n_ruta//===============> modificar aca
          if($value != $revision) $rute .= $value."/";
          else break;
        }

      $ruta = $rute.$n_ruta."_".$xps_dominio."/".$name[0]."/"; //ruta correcta
      
          if ( !file_exists($ruta.$name[1]) ) {
            throw new Exception("Archivo ".$ruta.$name[1].", no encontrado");
          } 
      
//      return $ruta;

        $directorio = opendir($ruta);
          while ($archivo = readdir($directorio)){ 
            if($archivo==$name[1]){
              $existe = 1;//archivo existe
              break;
            }
          }
        
        if($existe==0) $name = $ruta."icon.png";//no existe
        else $name = $ruta.$name[1];//existe

          $fp = fopen($name, 'rb');
        // send the right headers
          header("Content-Type: image/png");
          header("Content-Length: " . filesize($name));
          
        // dump the picture and stop the script
          fpassthru($fp);

    } catch (Exception $e) {
        echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
    }