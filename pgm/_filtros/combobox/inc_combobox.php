<?php

function crea_cbo($tabla,$valor,$nombre,$orden,$id_select,$ngrupo,$vgrupo){
		$db = new MySQL();
		
		$where="";
		$txt_xps_cbo = "";
		
		if($ngrupo!=""){
			$where = " where ".$ngrupo." in(".$vgrupo.")";
			$txt_xps_cbo = " (fitro)";
		}
		$sql = "SELECT ".$valor.", ".$nombre." FROM ".$tabla . $where. " ORDER BY ".$orden;
		$consulta = $db->consulta($sql);
		
		//echo $sql . "<br>";
		
		if($db->num_rows($consulta)>0){
			while($select = $db->fetch_array($consulta)){
				
				$selecciona = "";
				if($id_select==$select[0]) $selecciona = "selected";
				
				if(is_numeric($select[1])){//es numerico
					$valor_select = number_format($select[1],2,",",".");
				}
				else{
					$valor_select = $select[1];
				}
				
				echo "<option value='" .xps_encriptar($select[0]). "' ".$selecciona.">" .$valor_select. "</option>\n";
			}
		}
		else{
			echo "<option value='' selected>Sin datos $txt_xps_cbo - Debe incorporar datos en la tabla: [$tabla]</option>\n";
		}
}

?>