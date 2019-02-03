<?php 
class Articulos_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'articulo',
				'id_articulo',
				'id_articulo', //ver si esto esta bien
				'id_articulo'
		);
	}
	
	function update_Articulo($datos, $id){
		$this->db->update('articulo', $datos, array('id_articulo' => $id));
	}
	
	function getArticulos_variacion($datos){
		$query = $this->db->query("
		SELECT 	articulo.id_articulo,
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
				proveedor.impuesto as impuesto,
				grupo.descripcion as grupo,
				categoria.descripcion as categoria,
				subcategoria.descripcion as subcategoria	
		FROM `articulo` 
		INNER JOIN proveedor
		ON(articulo.id_proveedor=proveedor.id_proveedor)
		INNER JOIN grupo
		ON(articulo.id_grupo=grupo.id_grupo)
		INNER JOIN categoria
		ON(articulo.id_categoria=categoria.id_categoria)
		INNER JOIN subcategoria
		ON(articulo.id_subcategoria=subcategoria.id_subcategoria)
		WHERE
		proveedor.descripcion like '%$datos[proveedor]%' AND
		grupo.descripcion like '%$datos[grupo]%' AND
		categoria.descripcion like '%$datos[categoria]%' AND
		subcategoria.descripcion like '%$datos[subcategoria]%' AND
		articulo.id_estado=1
		ORDER BY articulo.descripcion
		");
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return FALSE;
		}
	}
	
	function updatePrecios($articulos, $datos)
	{
		foreach ($articulos as $articulo) {
			
			$precio_viejo		= $articulo->precio_costo;// solo para depurar
			
			$precio_costo		= $articulo->precio_costo + ($articulo->precio_costo * ($datos['variacion'] / 100));// FUNCIONA PARA AUMENTOS Y DECREMENTOS POR LA MULTIP(+ * + = +     Y    + * -  = - )
			
			$costo_descuento1	= $precio_costo - ($precio_costo * ($articulo->descuento / 100));
			
			$costo_descuento	= $costo_descuento1 - ($costo_descuento1 * ($articulo->descuento2 / 100)); // APLICACION DE 2DO DESC ESCALONADO
			
			//02 - Precio con ganancia
			$precio_venta_sin_iva = $costo_descuento + ($costo_descuento * ($articulo->margen / 100));
			
			//2.5 - Precio con IMPUESTO 6%
			
			$precio_venta_sin_iva_con_imp = $precio_venta_sin_iva + ($precio_venta_sin_iva * ($articulo->impuesto / 100));
			
			//03 - Precio con iva
			$precio_venta_sin_iva_sin_imp	= $precio_venta_sin_iva;
			
			$precio_venta_con_iva_con_imp	= $precio_venta_sin_iva_con_imp + ($precio_venta_sin_iva_sin_imp * ($articulo->iva / 100));// precio c/dto1 c/dto2 s/iva s/imp c/margen +  %iva + %imp(p) 
			

			$articulo_update=array(
				'precio_costo'					=> $precio_costo,
				'precio_venta_sin_iva'			=> $precio_venta_sin_iva,
				'precio_venta_sin_iva_con_imp'	=> $precio_venta_sin_iva_con_imp,
				'precio_venta_iva'				=> $precio_venta_con_iva_con_imp,
				'margen'						=> $articulo->margen,
				'impuesto'						=> $articulo->impuesto
			);
									
			$this->db->update('articulo', $articulo_update, array('id_articulo' => $articulo->id_articulo));
			
		}
	}

} 
?>
