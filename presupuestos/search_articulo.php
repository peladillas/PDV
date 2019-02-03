<?php
include_once('conexion.php');
//connect to your database

$term = trim(strip_tags(utf8_decode($_GET['term'])));//retrieve the search term that autocomplete sends

$qstring = "SELECT 
				descripcion as value,
				id_articulo,
				precio_venta_sin_iva_con_imp, 
				iva as porc_iva 
			FROM 
				articulo 
			WHERE 
				(descripcion LIKE '%".$term."%' OR 
				cod_proveedor LIKE '%".$term."%') AND
				id_estado = 1 
			LIMIT 
				20 ";
$result = mysql_query($qstring) ;//query the database for entries containing the term

while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
{
		$row['value']	= stripslashes(utf8_encode($row['value']));
		$row['id']		= (int)$row['id_articulo'];
		$row['iva']		= (float)$row['porc_iva'];
		$row['precio']	= (float)$row['precio_venta_sin_iva_con_imp'];
		$row_set[]		= $row;//build an array
}

echo json_encode($row_set);//format the array into json data
?>