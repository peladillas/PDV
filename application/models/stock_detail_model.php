<?php 
class Stock_detail_model extends My_Model {
		
	public function __construct(){
		parent::construct(
			'stock_detail',
			'id_stock',
			'id_articulo'
		);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Funcion para el moviemiento de Stock, entrante y saliente

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function movimiento ($registro) {
		// Guardamos el registro de movimiento de stock
		if (isset($registro['id_articulo']) && isset($registro['id_comprobante']) && isset($registro['id_comprobante_tipo'])) {
			if(!isset($registro['id_almacen'])) {
	  			$registro['id_almacen'] = 1; // Almacen default
	  		}
			$registro['user_add'] = $this->session->userdata('id_usuario');
			$registro['date_add'] = date('Y/m/d H:i:s');	
			$id_stock = $this->insert($registro);

			// Actualizamos el stock en la tabla articulos
			$stock = (isset($registro['cantidad_entrante']) ? $registro['cantidad_entrante'] : 0);
			$stock = (isset($registro['cantidad_saliente']) ? $stock - $registro['cantidad_saliente']: $stock);
			
			$query	= $this->db->query("
			UPDATE 
				articulo 
			SET 
				stock=stock+$stock 
			WHERE 
				id_articulo=$registro[id_articulo];");	
		} else {
			$id_stock = 0;
			
			if (!isset($registro['id_articulo'])) {
				log_message('ERROR', 'Movimiento de stock sin id_articulo datos =>'.print_r($registro, TRUE));
			} else if (!isset($registro['id_comprobante'])) {
				log_message('ERROR', 'Movimiento de stock sin id_comprobante datos =>'.print_r($registro, TRUE));
			} else if (!isset($registro['id_comprobante_tipo'])) {
				log_message('ERROR', 'Movimiento de stock sin id_comprobante_tipo datos =>'.print_r($registro, TRUE));
			}
		}
		
		return $id_stock;
	}
} 
?>
