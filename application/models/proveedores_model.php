<?php 
class Proveedores_model extends CI_Model {
	
	function getProveedor_precio($id){
		$query = $this->db->query("SELECT 	
				articulo.id_articulo,
				articulo.cod_proveedor,
				articulo.descripcion as descripcion,
				articulo.precio_costo,
				articulo.precio_venta_iva,
				articulo.precio_venta_sin_iva,
				articulo.iva as iva,
				proveedor.descripcion as proveedor,
				proveedor.descuento as descuento,
				proveedor.descuento2 as descuento2,
				proveedor.margen as margen,
				proveedor.impuesto as impuesto	
		FROM `articulo` 
		INNER JOIN proveedor
		ON(articulo.id_proveedor=proveedor.id_proveedor)
		WHERE
		proveedor.id_proveedor = '$id'");
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}else{
			return FALSE;
		}
	}
	
	function getProveedores($id = NULL){
		if($id != NULL)
		{
			$query = $this->db->query("SELECT * FROM proveedor WHERE proveedor.id_proveedor = $id");	
		}
		else
		{
			$query = $this->db->query("SELECT * FROM proveedor WHERE proveedor.id_estado=1 ORDER BY proveedor.descripcion");
		}
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return FALSE;
		}
	}
	
	function getTotalArticulos(){
		$sql = 
		"SELECT 
			count(proveedor.id_proveedor) as suma, 
			proveedor.descripcion 
		FROM 
			`articulo` 
		INNER JOIN 
			proveedor ON(articulo.id_proveedor = proveedor.id_proveedor) 
		GROUP BY 
			proveedor.id_proveedor
		ORDER BY
			suma DESC
		LIMIT 
			0, 20";		
			
		$query = $this->db->query($sql);	
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		else
		{
			return FALSE;
		}
	}

} 
?>
