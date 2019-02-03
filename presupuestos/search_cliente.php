<?php
include_once('conexion.php');
//connect to your database

$term = trim(strip_tags(utf8_decode($_GET['term'])));//retrieve the search term that autocomplete sends

$qstring = "SELECT 
				cuil as num_cuil, 
				direccion , 
				alias as value,
				id_cliente,
				apellido, 
				nombre 
			FROM 
				cliente 
			WHERE 
				
				(alias LIKE '%".$term."%' OR 
				cuil LIKE '%".$term."%') AND id_estado = 1
			LIMIT 20";
$result = mysql_query($qstring) ;//query the database for entries containing the term



while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
	
	{
		
		$row['value']=stripslashes(utf8_encode($row['value']));
		$row['nom']=stripslashes(utf8_encode($row['nombre']));
		$row['id']=(int)$row['id_cliente'];
		$row['ape']=(float)$row['apellido'];
		$row['cuil']=stripslashes(utf8_encode($row['num_cuil']));
		$row['dom']=stripslashes(utf8_encode($row['direccion']));
		$row_set[] = $row;//build an array

	}


//$row		= mysql_fetch_array($result,MYSQL_ASSOC);
//$row_set[]	= $row;//build an array
echo json_encode($row_set);//format the array into json data

?>