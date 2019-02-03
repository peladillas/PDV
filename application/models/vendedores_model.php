<?php 
class Vendedores_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'vendedor',
				'id_vendedor',
				'id_vendedor', //ver si esto esta bien
				'id_vendedor'
		);
	}
}
?>
