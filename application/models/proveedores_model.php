<?php 
class Proveedores_model extends My_Model {

    public function __construct(){
        parent::construct(
            'proveedor',
            'id_proveedor',
            'descripcion',
            'descripcion'
        );
    }
	
	function getProveedor_precio($id){
        $sql = $this->db->query("
		SELECT 	
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
		FROM 
			`articulo` 
		INNER JOIN 
			proveedor ON (articulo.id_proveedor=proveedor.id_proveedor)
		WHERE
			proveedor.id_proveedor = '$id'");

        return $this->getQuery($sql);
	}
	
	function getTotalArticulos(){
		$sql ="
		SELECT 
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

        return $this->getQuery($sql);
	}

} 
?>
