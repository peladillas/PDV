<?php

$link = mysql_connect('localhost', 'root', '')
or die('No se pudo conectar: ' . mysql_error());

mysql_select_db('sarmiento') or die('No se pudo seleccionar la base de datos');

//connect to your database

$term = trim(strip_tags(utf8_decode($_GET['term'])));//retrieve the search term that autocomplete sends

$qstring = "SELECT cod_proveedor as value, descripcion as descrip,id_articulo,precio_venta_iva FROM articulo WHERE cod_proveedor LIKE '%".$term."%' limit 20";
$result = mysql_query($qstring) ;//query the database for entries containing the term

while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
{
		$row['value']=stripslashes(utf8_encode($row['value']));
		$row['desc']=$row['desc'];
		$row['id']=(int)$row['id_articulo'];
		$row['precio']=(float)$row['precio_venta_iva'];
		$row_set[] = $row;//build an array
}
echo json_encode($row_set);//format the array into json data
?>