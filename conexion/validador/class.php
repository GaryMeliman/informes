<?php

include_once('clases/Connect.class.php');


$operations="";
$class="";


if (isset($_POST['selectbase']))
{
	
	
	DatabaseConnection::set($_POST['server'],$_POST['user'],$_POST['pass'],$_POST['dbase']);
	$connect=DatabaseConnection::get()->handle();	

	$class.='<textarea name="consulta" cols="100%" rows="35">';
	if ($_POST['selectbase']=="generar clase")
	{ 
		$class.= getCode($_POST['select'],$connect,'class');
	}
	if ($_POST['selectbase']=="generar Insert")
	{ 
		$class.= getCode($_POST['select'],$connect,'insert');
	}
	elseif ($_POST['selectbase']=="generar Select")
	{
		$class.= getCode($_POST['select'],$connect,'select');
	}	
	elseif ($_POST['selectbase']=="generar Update")
	{
		$class.= getCode($_POST['select'],$connect,'update');
	}	
	elseif ($_POST['selectbase']=="generar Delete")
	{
		$class.= getCode($_POST['select'],$connect,'delete');
	}	
	$class.='</textarea>';
		
} 


if (isset($_POST['submit'])||isset($_POST['selectbase']))
{
session_start(); 	

	$_SESSION['valida'] = array($_POST['server'],$_POST['user'],$_POST['pass'],$_POST['dbase']);
	list($servidor,$usuario,$pws,$db) = $_SESSION['valida'];


	DatabaseConnection::set($servidor,$usuario,$pws,$db);
	if($connect=DatabaseConnection::get()->handle())
	{
		$query=new Query();
		
		$result=$query->executeQuery('SHOW TABLES');
		$option='';
		
		while($row=mysql_fetch_array($result))
		{
			$option.='<option value="'.$row[0].'">'.$row[0].'</option>';
		}
		
		
		$operations.= 'Seleccione la Tabla 
							<select name ="select">'.$option.'
							</select>
							<input type="submit" name="selectbase" value ="generar clase"/>	
							<input type="submit" name="selectbase" value ="generar Select"/>	
							<input type="submit" name="selectbase" value ="generar Insert"/>	
							<input type="submit" name="selectbase" value ="generar Update"/>	
							<input type="submit" name="selectbase" value ="generar Delete"/>	
							';
	}
}
else{
	// valores por defecto
$_POST['server']	='localhost';
$_POST['user']		='root';
$_POST['pass']		='';
$_POST['dbase']		='test';
}



print'<html>
		<form method="post" action="class.php">
		<table>
		<tr><td><label>Server:</label></td><td><input name="server" type="text" value="'.$_POST['server'].'"/></td></tr>
		<tr><td><label>User:</label></td><td><input name="user" type="text" value="'.$_POST['user'].'"/></td></tr>
		<tr><td><label>Pass:</label></td><td><input name="pass" type="text" value="'.$_POST['pass'].'"/></td></tr>
		<tr><td><label>Database:</label></td><td><input  name="dbase" type="text" value="'.$_POST['dbase'].'"/></td></tr>
		<tr><td></td><td><input type="submit" name="submit" value ="conectar"/></td></tr>
		</table><br/>
		'.$operations.'
		</form>
		
		<form method="post" name="consultar" action="muestra_consulta.php" target="resultado">
		<table border="1" width="100%">		
			<tr>
				<td>'.$class.'</td>
				<td width="80%" align="center" valign="middle"><iframe name="resultado" height="500" width="100%"></iframe></td>
			</tr>
			<tr><td><input type="submit" name="submit" value ="Consultar"/></td><td>-</td></tr>
		</table>
		</form>
	 </html>';




function getCode($tabla,$connect,$op)
{
	$result = mysql_query("SELECT * FROM ".$tabla,$connect);
	$fields = mysql_num_fields($result);
	$rows   = mysql_num_rows($result);
	$table = mysql_field_table($result, 0);
	$a_data=Array();
	
	$buffer_atributes="";
	$buffer_set="";
	$buffer_get="";
	$primary_key=array();
	$primary_key_n=0;
	$buffer_mapping="\n\t\t".'$this->table="'.$table.'";';
	for ($i=0; $i < $fields; $i++) {
	    $type  = mysql_field_type($result, $i);
	    $name_original  = mysql_field_name($result, $i);
	   	$name=transformNames($name_original);
	    $len   = mysql_field_len($result, $i);
	    $flags = mysql_field_flags($result, $i);
	    $iskey=0;
	    
	    $a_data[$name_original]['type']=$type; 
	    $a_data[$name_original]['iskey']=false;
	    $a_data[$name_original]['flags']=$flags;
	    
	    if (searchFlag("primary_key",$flags))
	    {
	    	$primary_key[$primary_key_n]['value']=$name;
	    	$primary_key[$primary_key_n]['type']=$type;
	    	$a_data[$name_original]['iskey']=true;
	    	$iskey=1;
	    	$primary_key_n ++;
	    }
		
	    $buffer_set.=getSet($name,$type);
	    $buffer_mapping.=setMapping($name_original,$name,$flags,$type,$len,$iskey);
		$buffer_get.=getGet($name);
	}
	mysql_free_result($result);
	mysql_close();
	$classname=ucfirst($tabla);
	
	
	
	if ($op=='delete')
	{
		
		$where="";	
		foreach($a_data as $key=>$value)
		{
			if ($value['iskey'])
				{
						if ($value['type']=="int")
							{$where.=" ".$key."= $".transformNames($key);}
						else
							{$where.=" ".$key."='$".transformNames($key)."'";}
				}
		}
		return "delete ". $tabla .' where '.$where;
		
	}
	elseif ($op=='update')
	{
		
		$query="";
		$where="";	
		foreach($a_data as $key=>$value)
		{
			if ($value['iskey']==true)
				{
						if ($value['type']=="int")
							{$where.=" ".$key."= $".transformNames($key);}
						else
							{$where.=" ".$key."='$".transformNames($key)."'";}
				}
			else
				{	
						if ($value['type']=="int")
							{$query.=" ".$key."= $".transformNames($key);}
						else
							{$query.=" ".$key."='$".transformNames($key)."'";}
				}
		}
		return "update ". $tabla ." set ".$query .' where '.$where;
		
	}
	elseif ($op=='insert')
	{
		
				$sel="";
				$val="";
				foreach($a_data as $key=>$value)
				{
					if (!searchFlag('auto_increment',$value['flags']))
					{
							if (trim($sel)!="")
								{
									$sel.=",";
									$val.=",";
								}
									
									
									if ($value['type']=="int")
										{$val.=' $'.transformNames($key);}
									else
										{$val.="'$".transformNames($key)."'";}
							$sel.=$key;
					}					
				}
				
				$insert="insert into ".$tabla." (".$sel.") values (".$val.")";
				return $insert;
	}
	elseif ($op=='select')
	{
		
				$sel="";
				foreach($a_data as $key=>$value)
				{
							if (trim($sel)!="")
								{
									$sel.=",";
								}
							
							$sel.=$key;					
				}
				
				$select="select ".$sel." from ".$tabla;
				return $select;
	}
	elseif ($op=='class')
	{
		//*******************************************************// 
		$buffer="<?php\n";
		$buffer.="include_once('clases/pConnect.class.php');//configurar en este archivo la conexion a base de datos \n\n";
		$buffer.="Class $classname \n { \n";
		
		$buffer.=getAtributes()."\n";
		$buffer.="\n\t".'//-----------------Mapping---------------'."\n";
			
		$buffer.=getMapping($buffer_mapping)."\n";
		$buffer.="\n\t".'//-----------------Constructor---------------'."\n";
		
		$buffer.=getConstructor($tabla, $primary_key)."\n";
		
		$buffer.="\n\t".'//-----------------Set Methods---------------'."\n";
		$buffer.=$buffer_set."\n";
		
		$buffer.="\n\t".'//-----------------Get Methods---------------'."\n";
		$buffer.=$buffer_get."\n";
		
		$buffer.="\n\t".'//-----------------Other Methods---------------'."\n";
		$buffer.=getUpdate()."\n";
		$buffer.="\n}\n";
		$buffer.="\n?>";
		
		return  $buffer;
	}
}



function getMapping($mapping)
{
	$bmapping="\n\t".'private function Mapping()';
	$bmapping.="\n\t".'{';
	$bmapping.=$mapping;
	$bmapping.="\n\t".'}';
	return $bmapping;
}


function setMapping($nameOriginal,$name,$flags,$type,$len,$iskey)
{
	$mapping = "";
	$mapping.="\n\t\t".'$this->fields["'.$name.'"]'.'=Array("table"=>"'.$nameOriginal.'","flags"=>"'.$flags.'","type"=>"'. $type.'","len"=>"'.$len.'","change"=>false,"iskey"=>'.$iskey.');';
	return $mapping;
}

function searchFlag($flag,$fieldsFlag)
{
	if (trim($fieldsFlag)=="")
		{
			return false;
		}
	if(strpos($fieldsFlag,$flag)!==false)
		{
			return true;
		}
	else
		{
			return false;
		}
}
function transformNames($field)
{
	$array=array();
	$array=explode('_',$field);
	$final_name="";
	foreach($array as $key=>$value)
	{
		if ($key!=0)
		{$value=ucfirst($value);}
		$final_name.=$value;		
	}
	return $final_name;
}

function getConstructor($tabla,$primary_key)
{	
	$ifvars="if(";
	$vars="(";
	foreach($primary_key as $key=>$value)
	{
		if ($vars!="("){$vars.=",";$ifvars.=" && ";}
		
		$vars.='$'.$value['value'].'=NULL';
		$ifvars.='$'.$value['value'].'!=NULL';
	}
	$vars.=")";
	$ifvars.=")";
	
	
	
	$tabla=ucfirst($tabla);    	
	$con="\n\t".'function '.$tabla.$vars ;
	$con.="\n\t".'{';
	$con.="\n\t\t".'$this->Mapping();';
	
	
	
	
	$con.="\n\t\t".$ifvars;
	$con.="\n\t\t\t".'{';

	$con.="\n\t\t\t".'
	
				$sel="";
				foreach($this->fields as $key=>$value)
				{
						if (!$this->fields[$key][iskey])
						{
							if (trim($sel)!=""){$sel.=",";}
							$sel.=$key;					
						}			
				}
				
				$select="select ".$sel." from ".$this->table." where '.getWhere($primary_key).'";
				$query=new Query();
				if($result=$query->executeQuery($select));
				{
					if($row=mysql_fetch_array($result))
						{
							foreach($row as $key=>$value)
							{
								$this->fields[$key]["value"]=$value;
							}
						}
				}';
							
				
					
	$con.="\n\t\t\t".'}';
	
	$con.="\n\t".'}'."\n";
	return $con;	
}
function getAtributes()
{
	$attr="\n\t".'private $table;';
	$attr.="\n\t".'private $fields=array();';
	return $attr;
}

function getSet($field,$type)
{
	$ufield=ucfirst($field);    	
	$set="\n\t".'function set'.$ufield.'($value)';
	$set.="\n\t".'{';
	
	if ($type=="int")
		{$set.="\n\t\t".'$value=intval($value);';}
	elseif($type=="string")
		{$set.="\n\t\t".'$value=trim($value);';}
	
	$set.="\n\t\t".'$this->fields["'.$field.'"]["value"]=$value;';
	$set.="\n\t\t".'$this->fields["'.$field.'"]["change"]=true;';
	$set.="\n\t".'}'."\n";
	return $set;	
}

function getGet($field)
{
	$ufield=ucfirst($field);    	
	$get="\n\t".'function get'.$ufield.'()';
	$get.='{';
	$get.='return $this->fields["'.$field.'"]["value"];';
	$get.='}';
	return $get;	
}


function getWhere($primary_key)
{
	$where="";
	foreach($primary_key as $key=>$value)
	{
		if ($value['type']=="int")
			{$where.=" ".$value['value']."=$".$value['value'];}
		else
			{$where.=" ".$value['value']."=\'$". $value['value']."\'";}
	}
	
	return $where;

}

function getUpdate()
{
$val=	
"\n\t".'function update() 
	{
		$query="";
		$where="";	
		foreach($this->fields as $key=>$value)
		{
			if ($this->fields[$key][isKey])
				{
						if ($this->fields[$key][type]=="int")
							{$where.=" ".$key."=".intval($value);}
						else
							{$where.=" ".$key."=\'".tep_db_escape_string($value)."\'";}
				}
			else
				{	
					if ($this->fields[$key][change]=true)
					{
						if ($this->fields[$key][type]=="int")
							{$query.=" ".$key."=".intval($value);}
						else
							{$query.=" ".$key."=\'".tep_db_escape_string($value)."\'";}
					}
				}
		}
		if (trim($query)=="" or trim($where)=="" )
			{return false;}
			
			
		$sql="update ". $this->table ." set ".$query ." where ".$where;
		
		$query=new Query();
		$query->executeQuery($sql);
	}';
return $val;
}


?>