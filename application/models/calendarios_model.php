<?php 
class Calendarios_model extends MY_Model {
	
	public function __construct(){
		parent::construct(
		'calendario',
		'id_calendario',
		'id_calendario'
		);
	}
	
	
	function getCalendarios() {
		$sql = 
			"SELECT
			 	*
			FROM 
				$this->_table
			INNER JOIN	
				color ON($this->_table.id_color =  color.id_color) 
			ORDER BY
				$this->_table.start";

        return $this->getQuery($sql);
	}
}
?>
