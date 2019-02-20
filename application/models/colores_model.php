<?php 
class Colores_model extends MY_Model {
	
	public function __construct(){
		parent::construct(
			'color',
			'id_color',
			'id_color'
		);
	}

	function getColores($id_calendario) {
		$sql = 
		"SELECT 
			backgroundColor 
		FROM 
			color 
		INNER JOIN 
			calendario ON (color.id_color = calendario.id_color) 
		WHERE 
			id_calendario = '$id_calendario' ";

        return $this->getQuery($sql);
	}
}
?>
