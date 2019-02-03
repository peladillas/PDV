<?php 
class MY_Model extends CI_Model {
	
	protected $_table		= NULL;
	protected $_id			= NULL;
	protected $_name		= NULL;
	protected $_order		= NULL;
	protected $_data_table	= NULL;
	
	public function construct($table, $id, $name, $order, $data_table = NULL)
	{
		$this->_table 			= $table;
		$this->_id				= $id;
		$this->_name			= $name;
		$this->_order			= $order;
		$this->_data_table		= $data_table;
	}
	
	 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Trae todos los registros
 * 
 * ********************************************************************************
 **********************************************************************************/
	
	
	function getRegistros()
	{
		$sql = "SELECT 	*
				FROM $this->_table 
				WHERE
				$this->_table.id_estado = 1
				ORDER BY $this->_table.$this->_order";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) 
			{
				$data[] = $row;
			}
			
			return $data;
		}
		else
		{
			return FALSE;
		}
	}
	
	 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Trae registro por id
 * 
 * ********************************************************************************
 **********************************************************************************/
	
	
	function getRegistro($id)
	{
		$sql = "SELECT 	*
				FROM $this->_table 
				WHERE
				$this->_table.$this->_id = '$id'";
			
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) 
			{
				$data[] = $row;
			}
			
			return $data;
		}
		else
		{
			return FALSE;
		}
	
	}
	
	 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Trae registro por campo
 * 
 * ********************************************************************************
 **********************************************************************************/
	
	
	function getBusqueda($datos, $condicion = NULL)
	{
		if($condicion == NULL || $condicion != 'AND')
		{
			$condicion = 'OR';
		}
		
		if(is_array($datos))
		{
			$query = "SELECT * FROM $this->_table WHERE ";
			
			foreach ($datos as $key => $value) 
			{
				$query .= $this->_table.".".$key."='".$value."' ";
				$query.= $condicion." ";
			}
		}
		else
		{
			$query = "SELECT * FROM $this->_table WHERE 1";
		}

		$query = substr($query, 0, strlen($query)-(strlen($condicion)+1));
		
		$query = $this->db->query($query);
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		else
		{
			return FALSE;
		}
	
	}
	
	 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Insert de registro
 * 
 * ********************************************************************************
 **********************************************************************************/	
	
	public function insert($datos)
	{
		if(is_array($datos))
		{
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
	
	
	public function update($registro, $id){
		$this->db->update(
			$this->_table, 
			$registro, 
			array($this->_id => $id)
		);
	}
	
	

} 
?>
