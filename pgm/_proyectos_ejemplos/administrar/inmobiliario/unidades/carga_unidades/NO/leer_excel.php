<?php  

  require_once('../../../../inc_conexion.php');


 if(!empty($_FILES["excel_file"])){  

//      $connect = mysqli_connect("localhost", "root", "93539514", "db_PHPExcel");  

      $file_array = explode(".", $_FILES["excel_file"]["name"]);  

      if($file_array[1] == "xls" || $file_array[1] == "xlsx"){

//           include("PHPExcel/IOFactory.php");  
           $output = '';  
           $output .= "  
           <label class='text-success'>Data Inserted</label>  
                <table class='table table-bordered'>  
                     <tr>
                        <th>id_unidad</th>
                        <th>id_inmobiliario</th>
                        <th>id_unidad_tipo</th>
                        <th>tipologia_unidad</th>
                        <th>mts_cuadrados</th>
                        <th>numero_unidad</th>
                        <th>edificio_unidad</th>
                        <th>pisos_unidad</th>
                        <th>direccion_unidad</th>
                        <th>rol_unidad</th>
                        <th>tipo_unidad</th>
                        <th>plano_unidad</th>
                     </tr>  
                     ";  
           $object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);  

          $db = new MySQL();

           foreach($object->getWorksheetIterator() as $worksheet){  
                $highestRow = $worksheet->getHighestRow();  
                for($row=2; $row<=$highestRow; $row++){

                    $id_unidad        = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  1 , $row)->getValue());
                    $id_inmobiliario  = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  2 , $row)->getValue());
                    $id_unidad_tipo   = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  3 , $row)->getValue());
                    $tipologia_unidad = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  4 , $row)->getValue());
                    $mts_cuadrados    = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  5 , $row)->getValue());
                    $numero_unidad    = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  6 , $row)->getValue());
                    $edificio_unidad  = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  7 , $row)->getValue());
                    $pisos_unidad     = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  8 , $row)->getValue());
                    $direccion_unidad = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  9 , $row)->getValue());
                    $rol_unidad       = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  10  , $row)->getValue());
                    $tipo_unidad      = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  11  , $row)->getValue());
                    $plano_unidad     = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(  12  , $row)->getValue());

                     $query = "INSERT INTO `unidades` (
                                                      `id_unidad`,
                                                      `id_inmobiliario`,
                                                      `id_unidad_tipo`,
                                                      `tipologia_unidad`,
                                                      `mts_cuadrados`,
                                                      `numero_unidad`,
                                                      `edificio_unidad`,
                                                      `pisos_unidad`,
                                                      `direccion_unidad`,
                                                      `rol_unidad`,
                                                      `tipo_unidad`,
                                                      `plano_unidad`) 
                                              VALUE (
                                                      $id_unidad,
                                                      $id_inmobiliario,
                                                      $id_unidad_tipo,
                                                      $tipologia_unidad,
                                                      $mts_cuadrados,
                                                      $numero_unidad,
                                                      $edificio_unidad,
                                                      $pisos_unidad,
                                                      $direccion_unidad,
                                                      $rol_unidad,
                                                      $tipo_unidad,
                                                      $plano_unidad
                                                    )";

//                     mysqli_query($connect, $query); 

                      if($db->consulta($sql)){
                                       $output .=   " <tr class=''>
                                                        <td>".  $id_unidad  ."</td>
                                                        <td>".  $id_inmobiliario  ."</td>
                                                        <td>".  $id_unidad_tipo ."</td>
                                                        <td>".  $tipologia_unidad ."</td>
                                                        <td>".  $mts_cuadrados  ."</td>
                                                        <td>".  $numero_unidad  ."</td>
                                                        <td>".  $edificio_unidad  ."</td>
                                                        <td>".  $pisos_unidad ."</td>
                                                        <td>".  $direccion_unidad ."</td>
                                                        <td>".  $rol_unidad ."</td>
                                                        <td>".  $tipo_unidad  ."</td>
                                                        <td>".  $plano_unidad ."</td>
                                                      </tr>
                                                    ";
                      }
                      else{
                                       $output .=   " <tr class='danger'>
                                                        <td>".  $id_unidad  ."</td>
                                                        <td>".  $id_inmobiliario  ."</td>
                                                        <td>".  $id_unidad_tipo ."</td>
                                                        <td>".  $tipologia_unidad ."</td>
                                                        <td>".  $mts_cuadrados  ."</td>
                                                        <td>".  $numero_unidad  ."</td>
                                                        <td>".  $edificio_unidad  ."</td>
                                                        <td>".  $pisos_unidad ."</td>
                                                        <td>".  $direccion_unidad ."</td>
                                                        <td>".  $rol_unidad ."</td>
                                                        <td>".  $tipo_unidad  ."</td>
                                                        <td>".  $plano_unidad ."</td>
                                                      </tr>
                                                    ";
                      }
                }  
           }  
           $output .= '</table>';  
           echo $output;  
      }  
      else{  
           echo '<label class="text-danger">Archivo no es un excel</label>';  
      }  
 }  
 ?>  