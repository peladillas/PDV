<?php 
class Parametros_model extends MY_Model {
	
	public function __construct(){
		parent::construct(
			'parametro',
			'id_parametro',
			'parametro'
		);
	}

	
	function getParametroTipo($tipo) {
		$sql = 
		"SELECT
			*
		FROM 
			$this->_table
		INNER JOIN	
			parametro_tipo ON($this->_table.id_parametro_tipo =  parametro_tipo.id_parametro_tipo) 
		WHERE 
			parametro_tipo.parametro_tipo = '$tipo'
		ORDER BY
			$this->_table.start";

        return $this->getQuery($sql);
	}
}
?>
