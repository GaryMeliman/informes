<?php

function crea_cbo_consulta($sql,$id_select=0){
		$db = new MySQL();
		
		$consulta = $db->consulta($sql);
		
		
		if($db->num_rows($consulta)>0){
			while($select = $db->fetch_array($consulta)){ 
				
				$selecciona = "";
				if($id_select==$select[0]) $selecciona = "selected";
				
				echo "<option value='" .xps_encriptar($select[0]). "' ".$selecciona.">" .$select[1]. "</option>\n";
			}
		}
}

?>