<?php 
class Actualizaciones_precion_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'actualizacion_precio',
				'id_actualizacion',
				'id_actualizacion', //ver si esto esta bien
				'id_actualizacion'
		);

	}
} 
?>
