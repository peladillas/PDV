<?php
include_once('conexion.php');
//connect to your database


$fecha		= date('Y-m-d H:i:s');
$monto		= $_POST['total'];
$id_cliente	= $_POST['cliente'];
$tipo		= $_POST['tipo'];
$estado		= $_POST['estado'];
$dto		= $_POST['desc'];
$id_vendedor   = $_POST['vendedor'];

$codigos_a_cargar	= $_POST['codigos_art'];
$cant_a_cargar		= $_POST['cantidades'];
$precios_a_cargar	= $_POST['precios'];


//CARGO PRESUPUESTO 

$qstring = "INSERT INTO presupuesto (fecha,monto,id_cliente,tipo,estado,descuento, id_vendedor) VALUES('$fecha',$monto,$id_cliente,$tipo,$estado,$dto, $id_vendedor)";
$result = mysql_query($qstring) or die(mysql_error());//query the database for entries containing the term

//CARGO PRESUPUESTO 



//CARGO REGLON PRESUPUESTO //


$id_presupuesto=mysql_insert_id();


for ($i=0; $i<count($codigos_a_cargar); $i++ ) {

$qstring = "INSERT INTO reglon_presupuesto (id_presupuesto,id_articulo,cantidad,precio,estado) 
			
			VALUES($id_presupuesto,$codigos_a_cargar[$i],$cant_a_cargar[$i],$precios_a_cargar[$i],1)";

$result = mysql_query($qstring) or die(mysql_error());//query the database for entries containing the term



}
//CARGO REGLON PRESUPUESTO //


?>