<?php 
class Renglon_presupuesto_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'reglon_presupuesto',
				'id_renglon',
				'monto', //ver si esto esta bien
				'id_presupuesto'
		);
	}
	
	function Ultimos($cantidad)
	{
		$sql = "SELECT 
					* 
				FROM 
					`reglon_presupuesto`
				INNER JOIN 
					articulo ON(reglon_presupuesto.id_articulo =  articulo.id_articulo)
				ORDER BY
					id_renglon LIMIT 0 , $cantidad";

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
	
	function getDetalle($id)
	{
		$sql = "SELECT 
					* 
				FROM 
					`reglon_presupuesto`
				INNER JOIN 
					articulo ON(reglon_presupuesto.id_articulo =  articulo.id_articulo)
				WHERE
					reglon_presupuesto.id_presupuesto = '$id'";

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
	
	
	function getDetalle_where($datos, $condicion = NULL)
	{
		if($condicion == NULL || $condicion != 'AND')
		{
			$condicion = 'OR';
		}
		
		if(is_array($datos))
		{
			$query = "SELECT 
							* 
						FROM 
							`reglon_presupuesto`
						INNER JOIN 
							articulo ON(reglon_presupuesto.id_articulo =  articulo.id_articulo) 
						WHERE ";
			foreach ($datos as $key => $value) 
			{
				$query .= $this->_table.".".$key."='".$value."' ";
				$query.= $condicion." ";
			}
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
} 