<?php 

	ini_set('default_charset', 'iso-8859-1');
	//ini_set('default_charset', 'UTF-8');
	setlocale(LC_ALL, 'es_ES');

class MySQL{

  private $host, $user, $pass, $db_name;
  private $conexion; 
  private $total_consultas;
  private $resultado;
  private $idInsertado;
  private $id_encriptado = "";
  private $retorno = "";
  public  $ip = "";
  public  $IpServer_Web = "";
  const DATETIME = 'Y-m-d H:i:s';
  const DATE = 'Y-m-d';

//* Constructor 
	public function __construct($connect_now = true){
		
		$this->ip = recuperaip();
		//echo "Conexi&oacute;n Web<br>IP : ".$ip."<br>";

		$this->IpServer_Web = "190.196.128.198";//26-08-2013


			$this->host 	= "190.96.85.102"; 		 // Host address
			$this->user 	= "admin";	 // User 
			$this->pass 	= "c3rt1f1cac10n";		 // Password
			$this->db_name 	= "asemchile";// Database		
		

		if ($connect_now)
			$this->MySQL();

		return;
	}

//* Destructor
	public function __destruct(){
		$this->cerrar_bd();
	}  

//* conecta a la base de datos
	public function MySQL(){ 
	
		if(!isset($this->conexion)){
			$this->conexion = mysqli_connect($this->host, $this->user, $this->pass, $this->db_name);
			/* verificar la conexión */
			if (!$this->conexion) {
				$var_error1 = 'Conexión error : (' . mysqli_connect_errno() . ') <br>';
				//$var_error2 = mysqli_error($this->conexion);
				die($var_error1."<br>IP ACTUAL____: ".$this->ip."<BR>IP REQUERIDO : ".$this->IpServer_Web);//."<br>".$this->host."-".$this->user."-".$this->pass."-".$this->db_name);
				mysqli_debug("d:t:o,/tmp/client.trace");
				exit();
			}
			else return true;
		}
		return false;
	}

// * CONSULTA A LA BD Y DEVUELVE EL VALOR DE LA CONSULTA
	public function consulta($consulta){ 
		
		$this->total_consultas++; 
			 
		$resultado = mysqli_query($this->conexion, $consulta);
		
		$this->resultado = $resultado;		
		
		if(!$resultado){ 
			die('<hr><b>Consulta Error</b> : (' . mysqli_connect_errno() . ') '.mysqli_error($this->conexion).'<br>');// . "<br>" . mysqli_error_list($this->conexion));
			mysqli_debug("d:t:o,/tmp/client.trace");
			exit();
		}		
		return $resultado;
	}

// * CONSULTA A LA BD Y DEVUELVE EL VALOR DE LA CONSULTA Y EL ID, ADEMAS OBLIGA LA ENTRADA DE DATOS EN UTF-8
	public function consulta_accion($consulta){ 
	
		$this->total_consultas++; 
			 
		$resultado	 		= mysqli_query($this->conexion, $consulta);
		$this->resultado 	= $resultado;
		$this->idInsertado	= (int) mysqli_insert_id($this->conexion);
	//	$acento		 		= mysqli_query($this->conexion,"SET NAMES 'utf8'");
		
		if(!$resultado){ 
			die('<hr><b>Consulta Error</b> : (' . mysqli_connect_errno() . ') <br>'.mysqli_error($this->conexion).'<br>');// . "<br>" . mysqli_error_list($this->conexion));
			mysqli_debug("d:t:o,/tmp/client.trace");
			exit();
		}		
		return $resultado;
	}

	public function multiconsulta($superconsulta){
	
		$superresultado = array();
		
		/* execute multi query */
		if (mysqli_multi_query($this->conexion, $superconsulta)) {
			do {
				/* store first result set */
				if ($result = mysqli_use_result($this->conexion)) {
					$superresultado[] = $result;
					mysqli_free_result($result);
				}
				/* print divider */
/*				if (mysqli_more_results($this->conexion)) {
					printf("-----------------\n");
				}*/
			} while (mysqli_more_results($this->conexion) && mysqli_next_result($this->conexion));
		}
		else{
			return false;	
		}
		
		return $superresultado;
		
	}

	public function consulta_sp($consulta,$total_consultas=1){
		
		for($ipaso = 1; $ipaso <= $total_consultas; $ipaso++){
			// fetch the first result set
			$result1 		= $ipaso == 1 ? $this->consulta($consulta) : mysqli_use_result($this->conexion);
			$column_count 	= mysqli_num_fields($result1) or die("ERROR display_db_query:" . mysql_error());

			// you have to read the result set here 
			
			echo "<table><tr>";
			while($row = mysqli_fetch_row($result1)) {
				echo "<td><b>".$ipaso."</b></td>";
				for($column_num = 0; $column_num < $column_count; $column_num++) {
					  print("<TD>$row[$column_num]</TD>\n");
				}
				echo "</tr>";
			}		
			echo "</table>";
			// now we're at the end of our first result set.
			mysqli_free_result($result1);
			
			//move to next result set
			mysqli_next_result($this->conexion);
	
		}
	}

//_____ MULTI CONSULTA _____________________________________________________________________
	public function consulta_sp_q($consulta,$nex=1){
			$result1 = $nex == 1 ? $this->consulta($consulta) : mysqli_use_result($this->conexion);			
			return $result1;
	}
	public function next_result(){
		return mysqli_next_result($this->conexion);
	}
//_____ MULTI CONSULTA _____________________________________________________________________

//_____ MUESTRA EL CONTENIDO DE UNA CONSULTA SOLO ENVIANDO LA CONSULTA _____________________________________________________________________
	public function listar_contenido_consulta($query_string){
		$result_id = $this->consulta($query_string);//mysql_query($query_string, $connection) or die("display_db_query:" . mysql_error());
		$this->display_db_table($result_id);						
	}

	public function display_db_table($result_id) {
		
		$column_count = mysqli_num_fields($result_id) or die("ERROR display_db_query: " . mysqli_error($this->conexion));
		
		// Here the table attributes from the $table_params variable are added
		
		print("<TABLE border='5' >\n");
		// Print Headers
		print("<TR>");
			echo ("<TH>N&deg;</TH>");
		//encabezados columna
		for($column_num = 0; $column_num < $column_count; $column_num++) {
			$field_name = $result_id->fetch_field();//mysqli_field_seek($result_id, $column_num);//mysql_field_name($result_id, $column_num);
			echo ("<TH>".$field_name->name."</TH>");
		}
		
		print("</TR>\n");
		// Print the body
		$i=1;
		while($row = mysqli_fetch_row($result_id)) {
			print("<TR ALIGN=LEFT VALIGN=TOP>");
			echo "<td align=center><b>".$i++."</b></td>";
			for($column_num = 0; $column_num < $column_count; $column_num++) {
				  print("<TD>$row[$column_num]</TD>\n");
			}
			print("</TR>\n");
		}
		print("</TABLE>\n");
	}
//_____ FIN MUESTRA EL CONTENIDO DE UNA CONSULTA SOLO ENVIANDO LA CONSULTA _____________________________________________________________________

//* Obtiene una fila como una matriz asociativa, una matriz numérica o ambos
	public function fetch_array($consulta){
		return mysqli_fetch_array($consulta);
	}

//* Total de filas que entrega un resultado
	public function num_rows($consulta){
		return (int) @mysqli_num_rows($consulta);
	}

//* Total de filas que entrega un resultado
	public function goto_array($consulta,$posicion=0){
		return (int) mysqli_data_seek($consulta,$posicion);
	}

//* Total de filas que entrega la consulta
	public function num_rows_rev($consulta){
		$this->resCalc($consulta);
		return (int) mysqli_num_rows($consulta);
	}	

//* función que devuelve el total de consultas realizadas
	public function getTotalConsultas(){
		return $this->total_consultas; 
	}
	
//* Cierre la conexión a la base de datos
	public function cerrar_bd(){
		@mysqli_close($this->conexion);  
	}

// * Función para quitar caracteres url
	public function limpiacaracterUrl($cadena){
		
		$patron		 = '/(.*)\?/i';
		$sustitucion = '';
		$final		 = preg_replace($patron, $sustitucion, $cadena);
		return $final;

	} 

// * FUNCION QUE AUTOMATIZA LAS OPCIONES DE GUARDAR, ACTUALIZAR, BORRAR, ENCONTRAR NOMBRE DEL campo
//__________________________________________________________________________________________________
	public function comentario ($tabla, $campos = false, $registros = false, $configuracion=0){
	
/*				foreach($registros as $nombre_campo => $valor)
					echo $nombre_campo ."=>". $valor . "<br>";
*/

		$filtro_campos = "";

		if($campos){
			if (is_array($campos))
			  $campos = "`" . implode($campos, "`, `") . "`";
			
			$filtro_campos = " AND column_name IN('" . $campos . "')";
		}
	
		if($registros){
		
			$campos_bd	= "";
			$new_array	= array();
				  
			foreach($registros as $nombre_campo => $valor){
				
				if($nombre_campo == "retorno") $this->retorno = $valor;//RETORNO A LA GRILLA
								
				if($campos_bd=="") $campos_bd = "'" . $this->limpiacaracterUrl($nombre_campo) . "'"; 
				else $campos_bd .= ", '" . $nombre_campo . "'";
				$new_array[$this->limpiacaracterUrl($nombre_campo)] = $valor;
				
				if($this->limpiacaracterUrl($nombre_campo) == "accion"){
					$configuracion = $valor;
				}
			}
			$filtro_campos = "AND column_comment IN(" . $campos_bd . ")";
		}
//____________________________________TRANSACCIONAL______________________________________________________________		
		
		$tablas = array();
		if (is_array($tabla)){
			foreach($tabla as $letra_tabla => $nom_tabla){}
				
		
		}
//__________________________________FIN TRANSACCIONAL____________________________________________________________	
	//, COLUMN_COMMENT as comentario
		$sql = 	"SELECT COLUMN_NAME, COLUMN_COMMENT, COLUMN_KEY, DATA_TYPE, IS_NULLABLE
		   FROM INFORMATION_SCHEMA.COLUMNS
		   WHERE table_name = '".$tabla."' " . $filtro_campos ;
		   
//echo $sql."<hr>";
		   		
		$consulta = $this->consulta($sql);
		$this->commit();

		if($this->num_rows($consulta)>0){
			$rows = array();
			$claves_key = array();
			$colum_name = array();
			$v = 1;
			$primary_key = array();
						
			while($select = $this->fetch_array($consulta)){
				$colum_comment[$select[1]] = $select[0];
				foreach($new_array as $nombre_campoA => $valorA){
					//echo $nombre_campoA . "=" . $valorA . "=>". $select[1] . "<br>";
					if($nombre_campoA === $select[1]){
						//echo $select[2]."=>".$select[0]."=>".$valorA."<br>";//=>revisa el contenido del array
						if($select[2]=="PRI"){
							if(strrpos($valorA,"|")){
								$primary_key[$select[0]] = xps_desencriptar($valorA);
								$this->id_encriptado = $valorA;
								$rows[$select[0]] = xps_desencriptar($valorA);
							}
							else{
								$primary_key[$select[0]] = $valorA;
								$rows[$select[0]] = $this->reemplaza_caracteres($valorA);
							}
						}
						else
							if(strrpos($valorA,"|"))
								$rows[$select[0]] = xps_desencriptar($valorA);						
							else
								$rows[$select[0]] = $this->reemplaza_caracteres($valorA);
						
						$claves_key[$v++] = $this->reemplaza_caracteres($select[2]);

					}
				}
			}
			

			$v = 1;
			switch($configuracion){
				case 1 : //VER CAMPOS
							echo "<br>";
							echo "<table>";
							if($claves_key[$v]=="PRI"){
								echo "<tr><td colspan=4 align=center><b>Se ha detectado la PK<br>puedes actualizar y borrar registros</b><hr></td><tr>";
								if($this->idEncriptado()==""){
									echo "<tr><td colspan=4 align=center>
											<b><font color=#FF0000>FALLA DE SEGURIDAD<BR>LA CLAVE PRIMARIA NO ESTA ENCRIPTADA</font></b><br><br><hr>
										  </td><tr>";}
								else {
									echo "<tr><td colspan=4 align=center>
												<b><font color=#009900>EXCELENTE<BR>La clave primaria se encuentra encriptada<br>".$this->idEncriptado()."</font></b><br><br><hr>
											</td><tr>";}
							}
							else echo "<tr><td colspan=4><b>NO se detecto la primary key<br>solo puedes insertar registros</b><hr></td><tr>";
							foreach($rows as $field => $val)
								echo "<tr><td><b>". $claves_key[$v++] ."</b></td><td>rows['". $field ."']</td><td> = </td><td>" . $val . "</td></tr>";
							echo "</table><hr>";
							return false;
							break;
			
				case 2 : //INSERTAR CAMPOS
							if($this->insertar($rows, $tabla)) return true;
							else return false;
							break;
			
				case 3 : //ACTUALIZAR CAMPOS
							if($claves_key[$v]=="PRI"){
								if($this->update($rows, $tabla, $primary_key)) return true;
								else return false;
							}
							else{
								echo "<center>NO PUEDES ACTUALIZAR SIN UNA PRIMARY KEY</center>";
								return false;
							}
							break;
							
				case 4 : //ELIMINAR REGISTROS
							if($claves_key[$v]=="PRI"){
								if($this->delete($rows, $tabla)) return true;
								else return false;
							}
							else{
								echo "<center>NO PUEDES ELIMINAR SIN UNA PRIMARY KEY</center>";
								return false;
							}								
							break;
							
				case 5 : //DEVUELVE LOS CAMPOS DE FORMULARIO AL DATAGRID
							echo "<br>";
							echo "<table>";
							if($claves_key[$v]=="PRI") echo "<tr><td colspan=4 align=center><b>SI detecto la primary key<br>puedes actualizar y borrar registros</b><hr></td><tr>";
							else echo "<tr><td colspan=4><b>NO se detecto la primary key<br>solo puedes insertar registros</b><hr></td><tr>";
							foreach($rows as $field => $val)
							  echo "<tr><td><b>". $claves_key[$v++] ."</b></td><td>rows['". $field ."']</td><td> = </td><td>" . $val . "</td></tr>";
							echo "</table><hr>";
							return false;
							break;
				case 6 : //INSERTAR MULTIPLES REGISTROS _OK REVISADO
							if($this->insertarMultiple($rows, $tabla, $new_array)) return true;
							else return false;
							break;	
				case 7 : //INSERTAR MULTIPLES REGISTROS CODIFICADOS
							if($this->insertarcodificado($colum_comment, $registros, $tabla)) return true;
							else return false;
							break;												

				case 8 : //BUSCAR REGISTROS
							if($this->buscar_registros($colum_comment, $rows, $tabla)) return $this->resultado;
							else return false;
							break;												
				case 9 : //INSERTA O DESACTIVA OPCIONES _OK REVISADO
							if($this->actualizar_listas($rows, $tabla, $new_array)) return true;
							else return false;
							break;	

				case 10: //EJECUTA SECUENCIA SQL
							if($this->ejecuta_consulta($rows, $tabla, $new_array)) return true;
							else return false;
							break;	

			}
		}
		else{
			echo "<center><br><hr><font color=red>Olvido colocar los nombres de los campos de su formulario<br>en la tabla <b>[" . $tabla . "]</b></font><hr><br></center>";
			return false;
		}
	}

// * FUNCION QUE ADMINISTRA DISTRINTAS TABLAS Y REALIZA LA ACCION SOLICITADA
//__________________________________________________________________________________________________
	public function multi_tablas($v_post, $table, $config = 1){
		
		$registro 	= array();
		$datos 		= array();
		$acciones 	= array();
		$param 		= "";
		$d 			= 0;
		$tabla_prev = "";
		$error		= 0;
		$txt_error	= "";
		$accion		= 0;
		
		foreach($v_post as $campo => $valor){
			  if($d>1){
					
					$param = explode("*",$campo);
					
					if(count($param)>2){
						
						if($tabla_prev <> $table[$param[1]]){ 
							$registro = "";						// reinicia registros
							$registro['accion'] = $param[2];	//campo accion
							//echo "<hr>".$table[$param[1]]."<hr>";
							if(($param[2] == 0) || ($param[2] == 1)){//manejo de errores
								$error = 1;
								$txt_error = "<b>tabla  :</b>".$table[$param[1]]." <b>campo</b> ".$d." : ".$param[0]." <b>accion :</b> ".$param[2]." <b>valor :</b> ".$valor."<br>";
								break;
							}
						}					
						/*
						echo 	"<b>tabla  :</b>"  . $table[$param[1]] .
								" <b>campo</b> ".$d." : " . $param[0] . 
								" <b>accion :</b> " . $param[2] . 
								" <b>valor :</b> " . $valor .
								"<br>";
						*/
	
						$tabla_prev 		 = $table[$param[1]];
						$registro[$param[0]] = $valor ;
						$datos[$tabla_prev]  = $registro;
						
					}
			  }
		  $d++;
		}
	//__ CONTROL DE ERROR, TABLA SIN ACCION _______________-	
		if($error == 1){
			echo "<b>Error :</b> Se encontro una tabla con acci&oacute;n 0 ó 1<br>";
			echo $txt_error;
			return false;
			exit();	
		}
	//_____________________________________________________-
	

		foreach($datos as $tabla => $registros){ //Guarda en las Tablas

			if($config == 1){// modo configuracion____-
				echo "<br><hr><hr><hr><b>Tabla : ".$tabla."<br>";
					foreach($registros as $campo => $valor)
						echo $campo." = ".$valor."<br>";
				echo "<hr>";
			}
			else{
				if($this->comentario($tabla,'', $registros , 2))
						$accion = 1;
				else{
					echo "<b>Error : Tabla <b>'".$tabla."'</b><br>";
					var_dump($registros);
					echo "<hr>";
					return false;
					break;
				}
			}
		}
		
		if($accion == 1) return true;
		else return false;	
		
		exit();	

		
	}
	
// * Añadir caracteres de escape para la importación de datos
	public function escapeString($str){
		return mysqli_real_escape_string($this->conexion, rtrim($str));
	}

//* Insertar un nuevo registro 2
	public function insertar(array $values, $table)	{
				
		if (count($values) < 0)
			return false;
		
		foreach($values as $field => $val){
			if($val)
				$values[$field] = $this->escapeString($val);
		}
		
		$sql = "INSERT INTO `" . $table . "`(`" . implode(array_keys($values), "`, `") . "`) VALUES ('" . implode($values, "', '") . "')";
		
/*	echo $sql."<br>";
	exit();
	//	//return true;//false;// quita para poder guardar
*/		
		if ($this->consulta_accion($sql)) return true;
		else return false;
	}

//* Insertar multiples registros 6
	public function insertarMultiple(array $values, $table, array $campos)	{

/*
	echo implode(array_keys($values), "`, `") . "<hr>";
	echo "<hr><br>";

echo "<hr>Campos : ";
	var_dump($campos);
		echo "<hr> Valores :";
	var_dump($values);
	
	exit();
*/	

	
	$valida_ok 	= 0;
	$rows 		= array();
	$rows[] 	= "accion";
	$c			= 0;
	
			foreach($values as $nombre_campo => $val){
				$rows[] = $nombre_campo;
			}
				
			foreach($campos as $nombre_campo => $val){
				if((strrpos($val, "|"))>0) {
					$registros 	= explode(',',xps_desencriptar($val));
					$sql 		= "";
					
					// echo "<hr>desencriptar val = ".xps_desencriptar($val). "__". count($registros) ."<br>";
					// echo count($registros) .">". count($rows) . "<br>";
					
					if(count($registros) == count($rows)){

						if(count($registros)>1){
							for($h = 1; $h < count($registros); $h++){
								if($h == 1){ 
									$condiciones = $rows[$h] . "=" . $registros[$h];
									$datos 		 = "'".$registros[$h]."'";
								}
								else{ 
									$condiciones .= " and " . $rows[$h] . "=" . $registros[$h];
									$datos 		 .= ",'".$registros[$h]."'";
								}
							}
						
							if($registros[0] == 0){//__ELIMINAR					
								//echo "eliminar<br>";
								$sql = "DELETE IGNORE FROM ".$table." WHERE " . $condiciones .";";
							}
							if($registros[0] == 1){//__INSERTAR
								//echo "insertar<BR>";
								$sql = "INSERT IGNORE INTO `" . $table . "`(`" . implode(array_keys($values), "`, `") . "`) VALUES (".$datos.");";
							}

							if(array_key_exists('ver',$campos)){//SI ESTA EN MODO VISUALIZACION NO GUARDA.
								if($c++ == 0) echo "<HR><HR>MODO VISUALIZACION CONSULTAS 6<HR>";
								 echo $sql."<br>";
								 //exit();
							}
							else{							
								if($sql != ""){
									if ($this->consulta_accion($sql)){$valida_ok=1;}
									else{
										return false;
									};
								}
							}
							//if($valida_ok == false) echo "false";
							//echo "<br>";
						}
					}
				}
				
			}
			
	return $valida_ok;

	echo "<hr>LLEGAMOS ACA Y NO PASO NA'";

exit();

	}

//* Insertar, actualiza LISTAS 9
	public function actualizar_listas(array $values, $table, array $campos)	{

	$c = 0;

/*	echo "<hr>Values : ";	
	echo implode(array_keys($values), "`, `") . "<hr>";

	echo "<hr>campos : ";
	echo implode(array_keys($campos), "`, `") . "<hr>";	
//	var_dump($campos);

//	echo "<hr> valores : ";
//	echo implode(array_keys($campos), "`, `") . "<hr>";	
	var_dump($campos);
	echo "<hr>";
	
	exit();
*/
	
	$valida_ok 	= false;
	
	$up_date	= array();
		$up_date[]	= 'accion';

	$whe_re		= array();
		$whe_re[]	= 'accion';
		
	$update		= "";
	$total		= array();
	$total[] 	= "accion";//el primer dato que trae values es la accion 0=update, 1=insert	
	
			foreach($values as $nombre_campo => $val){
				if($val>0) 	$up_date[]	= $nombre_campo;// si el valor es 1 entonces es parte de los registros que se van actualizar
				else 		$whe_re[]	= $nombre_campo;// si el valor es 0 entonces es una condicion
				$total[] = $nombre_campo;
			}
			
			foreach($campos as $nombre_campo => $val){
				if((strrpos($val, "|"))>0) {
					
					$registros	= xps_desencriptar($val);
//					echo $registros . "<br>";
					if((strrpos($registros, ","))>0) {
						$valores 	= explode(',',xps_desencriptar($val));
						$sql 		= "";
						
				/*		echo "=>Valores : $nombre_campo : ".count($valores)."|<br>";
						var_dump($valores);
						echo "<br>";
				
						var_dump($total);
						echo "<br>total: ";
						var_dump($total);
						echo "<br><br>update: ";
						var_dump($up_date);
						echo "<br>where : ";
						var_dump($whe_re);
						echo "<br>";
					*/	
					//
				
						if( array_key_exists('ver',$campos)) echo "<hr><hr>".$nombre_campo . "=>" . (count($valores) ."<=>". count($total)) . "<br>";
					
						
					
						if(count($valores) == count($total)){ 
							
							$update		 = "";
							$condiciones = "";
							$datos		 = array();
							
							for($v = 1; $v < count($valores) ; $v++ ){
								//echo "<br>".$total[$v] ."=". $valores[$v] ."<br>";
								
								if(array_search( $total[$v],$up_date) ){
									if($update=="") $update  = $total[$v] ." = ". ($valores[$v] == 'Null' ? $valores[$v] : "'".$valores[$v]."'");
									else			$update .= ", ". $total[$v] ." = ". ($valores[$v] == 'Null' ? $valores[$v] : "'".$valores[$v]."'");
								}
	
								if(array_search( $total[$v],$whe_re) ){
									if($condiciones=="") $condiciones  = $total[$v] ."= '". $valores[$v]."'";
									else				 $condiciones .= " and ". $total[$v] ."= '". $valores[$v]."'";
								}
								
								if( ($valores[$v]!="") || (is_null($valores[$v])== false) ) $datos[$total[$v]] = $valores[$v];
							}
								
							
							if(count($valores)>1){
								if($valores[0] == 0){//__ACTUALIZAR	
									//echo "Actualizar<br>";
									if($condiciones != "")
										$sql = "UPDATE IGNORE ".$table." SET ".$update." WHERE " . $condiciones .";" ;
								}
								if($valores[0] == 1){//__INSERTAR
									//echo "insertar<BR>";
									$sql = "INSERT IGNORE INTO `" . $table . "`(`" . implode(array_keys($datos), "`, `") . "`) VALUES ('".implode("','", array_values($datos))."');";
								}
						
									//									echo "===>".$sql . "<hr>";
						
								if( array_key_exists('ver',$campos)){
									if($c++ == 0) echo "MODO VISUALIZACION CONSULTAS 9 - $table<BR><BR>";
									 echo $sql."<br>";
									 //exit();
								}
								else{
/*echo "===>".$sql . "<hr>";
//exit();

*/									if($sql != ""){
//										return true;
										if ($this->consulta_accion($sql)) $valida_ok=true;
										else return false;
									}
								}
							}
						}
					}
				}//fin array exist				
			}
	return $valida_ok;

	echo "<hr>LLEGAMOS ACA Y NO PASO NA'";

exit();

	}

	public function ejecuta_consulta($sql = ""){ //10
	
		if($sql != ""){
			if ($this->consulta_accion($sql)){
				return true;
			}
			else{ 
				return false;
			}
		}
		else return false;
	
	
	}

//* BUSCAR REGISTROS________________________________________
	public function buscar_registros($colum_comment, $rows, $tabla){

/*		var_dump($rows);
		echo "<br><br>";
*/
		$campos  = array();
		$filtros = array();
		foreach($rows as $field => $val){
			if($val == 0){
				$campos[$field] = 0;
					//echo ">". $field . "=" . $val . "<br>";
			}
			else{
				$filtros[] = $field . " = '" . $val . "'";
					//echo $field . "=" . $val . "<br>";
			}
		}
		
		$sql = "SELECT ". implode(array_keys($campos), ", ") . " FROM $tabla WHERE " . implode($filtros, " AND ").";";
		//echo $sql . "<hr>";
			
		if($this->num_rows($this->consulta($sql))>0) return true;
		else return false;
	
	}

//* Insertar multiples registros codificados________________________________________
	public function insertarcodificado(array $colum_comment, $registros, $table)	{
				
		if (count($colum_comment) < 0)
			return false;
		$i = 0;
		$sql = "";
		//$insertar = array();
		$cant = 0;

		foreach($colum_comment as $field => $val){
			$values[$field] = $this->escapeString($val);
		}
		
		$borrar = array();
		foreach($registros as $campos => $valores){			
			foreach(array_keys($colum_comment) as $key){
				echo $key . "=>" . $campos . "<hr>";
				if (preg_match("/$key/", $campos)){
					if(strrpos($valores,"|")){
						$paso = xps_desencriptar($valores);
						if(count($borrar)==0){
							$dato = explode(".",$paso);
							$caki = implode(($colum_comment), ", ");
							$caki = explode(",",$caki);
							$borrar[] = $caki[0];
							$borrar[] = $dato[0];
						}
						$insertar[] = str_replace(".",",",$paso);
					}
				}
			}
		}
		
		
		$sql_borra = "DELETE FROM ".$table." WHERE ".$borrar[0]." = ".$borrar[1];

		echo $sql_borra;
		exit();

		$sql  = "INSERT INTO `" . $table . "`(`" . implode(($colum_comment), "`, `") . "`) VALUES ";
		for($i=0;$i<count($insertar);$i++){
			if($i==0) $sql .= "(" . $insertar[$i] . ")";
			else $sql .= ", (" . $insertar[$i] . ")";		
		}


		echo $sql_borra . "<hr>" . $sql . "<br>";
		
		if ($this->consulta_accion($sql_borra)){
			if ($this->consulta_accion($sql)) return true;
			else return false;
		}
		else return false;		
		
		
/*		$this->begin();
		
		//$a1 = insertar(array $values, $table);//tabla
		
		$a2 = mysql_query("INSERT INTO rarara (l_id) VALUES('2')");
		
		if ($a1 and $a2) {
			$this->commit();
		} 
		else {        
			$this->rollback();
		}	
		
*/		
		
	

		
/*		echo $sql.";";
		return false;// quita para poder guardar
*/		
	}


//* Actualización de un registro de la base de datos
	public function update(array $values, $table, array $primary_key, $where = false, $limit = false){// 3

		if (count($values) < 0)
			return false;
		
		$fields = array();
		
		foreach($values as $key => $val){
				
			if( array_key_exists( $key, $primary_key ) ){
				if($where==false) $where = " WHERE ".$key." = '" . $val ."'";
				else $where .= " and ".$key." = '" . $val ."'";
			}
			else{
				if($val == "Null")
					$fields[] = "`" . $key . "` = " . $this->escapeString($val);
				else
					$fields[] = "`" . $key . "` = '" . $this->escapeString($val) . "'";
			}
			
		}

		//$where = ($where) ? " WHERE " . $where : '';
		$limit = ($limit) ? " LIMIT " . $limit : '';

		$sql = "UPDATE `" . $table . "` SET " . implode($fields, ", ") . $where . $limit;

//esto nunca va a pasar a menos que iguales los numeros
if(1==0){
		return $sql;
//		return true;
		exit();
	//DETENIENE LA EJECUCION DEL CODIGO PARA VER LA CONSULTA CON EL CAMPO VER INCLUIDO EN EL FORM
}

		//return true;//false;// quita para poder guardar
/*
*/

		if ($this->consulta_accion($sql))
			return true;
		else
			return false;
	}

//* Actualización de multiples registros de la base de datos
	public function updateMultiple(array $values, $table, $where = false, $limit = false){
		if (count($values) < 0)
			return false;
		
		$fields = array();
		foreach($values as $field => $val){
			$fields[] = "`" . $field . "` = '" . $this->escapeString($val) . "'";
			if($where==false) $where = " WHERE ".$field." = " . $val ;
		}

		//$where = ($where) ? " WHERE " . $where : '';
		$limit = ($limit) ? " LIMIT " . $limit : '';

		$sql = "UPDATE `" . $table . "` SET " . implode($fields, ", ") . $where . $limit;

		//echo $sql;
		//return false;// quita para poder guardar


		if ($this->consulta_accion($sql))
			return true;
		else
			return false;
	}

// * Eliminar filas
	public function delete(array $values, $table, $where = false){
		
		if (count($values) < 0)
			return false;
			
		$fields = array();
		$campo = "";
		foreach($values as $field => $val){
			if($campo=="") {$campo = $field; $registro =  $val;}
			else $registro .=  ", " . $val ;
		}
		
		$where = " WHERE ". $campo ." IN (". $registro .")";

		$sql = "DELETE FROM `" . $table . "`" . $where;
		
		echo $sql;
		return false;// quita para poder guardar
		

		if ($this->consulta_accion($sql))
			return true;
		else
			return false;
	}
	
// * Recoge el id del último registro insertado de la última consulta
	public function insertId(){
		return $this->idInsertado;// (int) mysqli_insert_id($this->conexion);
	}

// * Recoge el id encriptado para volver a la grilla
	public function idEncriptado(){
		return $this->id_encriptado;
	}
	
// * Recoge el id de retorno para volver a la grilla
	public function idRetorno(){
		return $this->retorno;
	}
	
//* Obtener Resultados mediante matriz asociativa
	public function fetchAssoc($consulta = false){
		return mysqli_fetch_assoc($consulta);
	}
	
//* Obtener Resultados mediante array enumerados en una fila
	public function fetchRow($consulta = false){
		return mysqli_fetch_row($consulta);
	}

//* Obtener una fila
	public function fetchOne($consulta = false){
		list($resultado) = $this->fetchRow($consulta);
		return $resultado;
	}
	
//* Obtener el encabezado de la consulta
	public function fieldNameArray($consulta = false){

		$nombre_encabezado = mysqli_fetch_fields($consulta);
	
		$k = 0;
		$encabezados = array();
		
		foreach ($nombre_encabezado as $val) {
	
			if($k==0) $varprimero = $val->name;
	
			$k++;
				
			if($k>1)
				if($varprimero == $val->name)
					break;
	
			$encabezados[] = $val->name;
			
		}
		
		return $encabezados;
	}
	
//* Libera la memoria del Resultado
	public function freeresultado(){
		return mysqli_free_resultado($this->resultado);
	}

//* 
	public function goto_registro($result,$campo=1){
		$result->data_seek($campo);
		//return mysqli_field_seek($resultado,$campo);
	}

// * Contar el número de campos de un Resultado
	public function countFields($resultado = false){
		$this->resCalc($resultado);
		return (int) mysqli_num_fields($resultado);
	}	
	
// * Obtener el número de filas afectadas de la última consulta
	public function affectedRows(){
		return (int) mysqli_affected_rows($this->conexion);
	}
	
// * Obtener la descripción del error de la última consulta
	public function error(){
		return mysqli_error($this->conexion);
	}

// * Volcado de información a la página de MySQL
	public function dumpInfo(){
		echo mysqli_info($this->conexion);
	}

// * Determinar el tipo de datos de una consulta
	private function resCalc(&$resultado){
		
		//echo "<hr>";
		
		if ($resultado == false)
			$resultado = $this->resultado;
		else {
			if (gettype($resultado) != 'resource')
				$resultado = $this->consulta($resultado);
		}

		return;
	}	

// * Reemplazar caracteres de la consulta
	public function reemplaza_caracteres($cadena){

		$p = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ','\'','ü','Ü','°');
		$r = array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&ntilde;','&Ntilde;','','&uuml;','&Uuml;','&deg;');

		$cadena = str_replace($p,$r,$cadena);
	
		return $cadena;
	}

	public function array_tablas($campos, $tablas, $accion = 2){

		if(is_array($tablas)){// is array

			$tabla 		= "";
			$registros 	= array();
			$paquete	= array();
			$i = 0;
			
				foreach($campos as $key => $values){
					 
					$key_p = $this->limpiacaracterUrl($key);
					$campo = explode("-" , $key_p);
					
			/*		if(isset($campo[1]))
						echo $campo[0] . ">" . $campo[1] . "<hr>";
			*/		
					if(isset($campo[1])){//si el campo no esta dividido pa fuera
						if($tabla != $campo[0]){
							if($i>0){
								$clave = array_search($tabla, $tablas);
								$registros['accion'] = $accion;
			/*					echo $clave . "<br>";
			*/					$paquete[$clave] = $registros;
								unset($registros);
								$registros 	= array();
							}
							$tabla = $campo[0];
							$i++;
						}
						
						$registros[$campo[1]] = $values;			
					}//_________________________________________________________
				}
								$clave = array_search($tabla, $tablas);
								$registros['accion'] = $accion;
								$paquete[$clave] = $registros;
								unset($registros);
			
				if($accion==1){
					foreach($paquete as $key => $values){
						echo $key . "=>";
						var_dump($values);
						echo "<br>";
					}
					exit();
					return true;
				}//fin foreach
				
			return $paquete;
		}// fin is array
		return false;
	}
	
	public function hilo_conexion(){
		/* determine our thread id */
		return mysqli_thread_id($this->conexion);	
	}
	
	public function matar_hilo($hilo){
		/* Kill connection */
		mysqli_kill($this->conexion, $hilo);		
	}
	
	
	public function begin() {
		/* disable autocommit */
		mysqli_autocommit($this->conexion, FALSE);		
	}

	public function rollback() {
		/* Rollback */
		mysqli_rollback($this->conexion);
			//$this->consulta("ROLLBACK");
		/* Free result */
		mysqli_free_result($this->consulta);		
	}

	public function commit() {
		/* commit insert */
		mysqli_commit($this->conexion);
		mysqli_autocommit($this->conexion, TRUE);
		//$this->consulta("COMMIT");
	}	
	
	
	
}//_______________FIN CLASE________________





include("funciones.php");
include("mensajes_advertencias.php");
include("imagenes.php");

?>