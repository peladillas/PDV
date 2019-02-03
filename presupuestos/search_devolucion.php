<?php



$link = mysql_connect('localhost', 'root', '')
or die('No se pudo conectar: ' . mysql_error());

mysql_select_db('sarmiento') or die('No se pudo seleccionar la base de datos');

//connect to your database


$term=$_POST['cliente'];

$qstring = "SELECT devolucion.id_devolucion as id,devolucion.monto as monto , devolucion.fecha as fecha, devolucion.nota as nota, devolucion.a_cuenta as a_cuenta
			FROM devolucion 
			INNER JOIN presupuesto 
			ON (presupuesto.id_presupuesto=devolucion.id_presupuesto ) WHERE devolucion.id_estado=1 and presupuesto.id_cliente=".$term;

$result = mysql_query($qstring) ;//query the database for entries containing the term

if(mysql_num_rows ( resource $result )>0){

	
	while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
	
	{
		$row['id']=stripslashes(utf8_encode($row['id']));
		$row['monto']=stripslashes(utf8_encode($row['monto']));
		$row['fecha']=stripslashes(utf8_encode($row['fecha']));
		$row['a_cuenta']=(float)$row['a_cuenta'];
		$row['nota']=stripslashes(utf8_encode($row['nota']));
		$row_set[] = $row;//build an array

	}

	$row_set[] = $row;//build an array
	echo json_encode($row_set);//format the array into json data



}else{


	
	echo json_encode("NO POSEE DEVOLUCIONES PENDIENTES");//format the array into json data



}






?>