<?php 
class Intereses_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'interes',
				'id_interes',
				'id_interes', //ver si esto esta bien
				'id_interes'
		);
	}
	
	
	function getInteres($id) {
		$sql = "
		SELECT 
			* 
		FROM 
			`interes`
		WHERE
			interes.id_presupuesto = '$id'";

        return $this->getQuery($sql);
	}

}
?>
