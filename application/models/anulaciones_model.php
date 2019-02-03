<?php 
class Anulaciones_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'anulacion',
				'id_anulacion',
				'id_anulacion', //ver si esto esta bien
				'id_anulacion'
		);

	}
	
	function getAnulaciones($id)
	{
		$sql = "SELECT * FROM `anulacion`
				WHERE
				id_presupuesto = '$id'";
			
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
	
	function suma_anulacion($inicio, $final, $id_cliente = NULL)
	{
		if($id_cliente === NULL)
		{
			$inicio	= date('Y-m', strtotime($inicio));
			$final	= date('Y-m', strtotime($final));
			
			$consulta = "SELECT 
						*
						FROM `anulacion` 
						WHERE
						DATE_FORMAT(fecha, '%Y-%m') >= '$inicio' AND
						DATE_FORMAT(fecha, '%Y-%m') <= '$final'";
		}
		else
		{
			$inicio	= date('Y-m-d', strtotime($inicio));
			$final	= date('Y-m-d', strtotime($final));
			
			$consulta = "SELECT 
						*
						FROM `anulacion` 
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
} 
?>
