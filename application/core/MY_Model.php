<?php 
class MY_Model extends CI_Model {
	
	protected $_table		= NULL;
	protected $_id			= NULL;
	protected $_order		= NULL;
	protected $_limit		= 1000;
	
	public function construct($table, $id, $order) {
		$this->_table 			= $table;
		$this->_id				= $id;
		$this->_order			= $order;
	}

/**********************************************************************************
 **********************************************************************************
 *
 * 				Trae todos los registros
 *
 * ********************************************************************************
 **********************************************************************************/

    function select($filtros = NULL) {
        $sql = "
		SELECT 	
			*
		FROM 
			$this->_table 
		WHERE ";

    	if ($this->db->field_exists('id_estado', $this->_table)) {
			$sql .= $this->_table.".id_estado = ".ESTADOS::ALTA;
		}

		if ($filtros == NULL) {
			if( substr($sql, -6) == 'WHERE ') {
				$sql .= " 1";
			}            
		} else if (is_array($filtros)) {
            foreach ($filtros as $key => $value) {
                $sql .= $this->_table.".".$key."='".$value."' AND";
            }
            $sql = substr($sql, 0, 3);
        } else {
            $sql .= $this->_table.".".$this->_id."= '$filtros'";
        }

        $sql .= "
		ORDER BY 
			$this->_table.$this->_order
		LIMIT 
			$this->_limit";
		
        return $this->getQuery($sql);
    }

 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Insert de registro
 * 
 * ********************************************************************************
 **********************************************************************************/	
	
	public function insert($datos) {
		if (is_array($datos)) {
            if ($this->db->field_exists('id_estado', $this->_table)) {
                $datos['id_estado'] = ESTADOS::ALTA;
            }

			$this->db->insert($this->_table , $datos);
			$id	=	$this->db->insert_id();	
		}
					
		return $id;
	}
	 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Update de registros
 * 
 * ********************************************************************************
 **********************************************************************************/	

	public function update($registro, $id) {
		$this->db->update(
			$this->_table, 
			$registro, 
			array($this->_id => $id)
		);
	}

/**********************************************************************************
 **********************************************************************************
 *
 * 				Función para armar la query
 *
 * ********************************************************************************
 **********************************************************************************/

    function getQuery($sql, $type = NULL) {
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            if($type === NULL || $type == 'objet') {
                foreach ($query->result() as $fila) {
                    $data[] = $fila;
                }
            } else if($type == 'array') {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
            }
            return $data;
        } else {
            return FALSE;
        }
    }
} 
?>
