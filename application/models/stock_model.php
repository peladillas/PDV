<?php 
class Stock_model extends My_Model {
		
	public function __construct(){
		parent::construct(
			'stock',
			'id_stock',
			'id_articulo',
			'id_articulo'
		);
	}
	
	public function movimiento ($registro) {
		if (isset($registro['id_articulo']) && isset($registro['id_comprobante']) && isset($registro['id_comprobante_tipo'])) {
			if(!isset($registro['id_almacen'])) {
	  			$registro['id_almacen'] = 1; // Almacen default
	  		}
			$registro['user_add'] = $this->session->userdata('id_usuario');
			$registro['date_add'] = date('Y/m/d H:i:s');
			
			$id_stock = $this->insert($registro);
		}
	}
} 
?>
