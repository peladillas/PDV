<?php 
class Devoluciones_detalle_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'devolucion_detalle',
				'id_detalle',
				'id_detalle', //ver si esto esta bien
				'id_detalle'
		);
	}
} 
?>
