<?php 
class Renglon_presupuesto_model extends MY_Model {
	
	public function __construct(){
		parent::construct(
            'reglon_presupuesto',
            'id_renglon',
            'id_renglon'
		);
	}
	
	function Ultimos($cantidad) {
		$sql = "
        SELECT 
		  * 
		FROM 
		  $this->_table
		INNER JOIN 
		  articulo ON(reglon_presupuesto.id_articulo =  articulo.id_articulo)
		ORDER BY
		  $this->_table.$this->_id LIMIT 0 , $cantidad";

        return $this->getQuery($sql);
	}
	

	function getDetalle($datos) {
		$sql = "
        SELECT 
		  * 
		FROM 
		  `reglon_presupuesto`
		INNER JOIN 
		  articulo ON(reglon_presupuesto.id_articulo =  articulo.id_articulo) 
		WHERE ";
		
		if(is_array($datos)) {
            foreach ($datos as $key => $value){
                $sql .= $this->_table.".".$key."='".$value."' AND";
			}

            $sql = substr($sql, 0, 3);
		}else{

		    $sql .=  $this->_table.".".$this->_id."='".$datos."'";
        }

        return $this->getQuery($sql);
	}
} 