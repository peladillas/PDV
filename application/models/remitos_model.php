<?php 
class Remitos_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'remito',
				'id_remito',
				'monto', //ver si esto esta bien
				'id_remito'
		);
	}
	
	function getRemito($id)
	{
		$sql = "SELECT 	*
				FROM remito 
				INNER JOIN cliente ON(cliente.id_cliente = remito.id_cliente)
				WHERE
				remito.id_remito = '$id'";
		
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
	
	
	function suma_remito($inicio, $final, $id_cliente = NULL)
	{
		if($id_cliente === NULL)
		{
			$inicio	= date('Y-m', strtotime($inicio));
			$final	= date('Y-m', strtotime($final));
			
			$consulta = "SELECT 
						monto,
						fecha 
						FROM `remito` 
						WHERE
						DATE_FORMAT(fecha, '%Y-%m') >= '$inicio' AND
						DATE_FORMAT(fecha, '%Y-%m') <= '$final'";
		}
		else
		{
			$inicio	= date('Y-m-d', strtotime($inicio));
			$final	= date('Y-m-d', strtotime($final));
			
			$consulta = "SELECT 
						id_remito,
						monto,
						devolucion,
						fecha,
						cliente.id_cliente as id_cliente,
						nombre,
						apellido,
						alias 
						FROM `remito` 
						INNER JOIN 
						cliente ON(remito.id_cliente=cliente.id_cliente)
						WHERE
						DATE_FORMAT(fecha, '%Y-%m-%d') >= '$inicio' AND
						DATE_FORMAT(fecha, '%Y-%m-%d') <= '$final'";
		}
		
					
		$query = $this->db->query($consulta);
		
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



function getCliente($id)
	{
		$sql = 
			"SELECT 
				* 
			FROM 
				$this->_table
			WHERE 
				id_cliente = $id
			ORDER BY
				id_remito DESC";
				
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

} 
?>