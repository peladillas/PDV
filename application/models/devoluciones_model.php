<?php 
class Devoluciones_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'devolucion',
				'id_devolucion',
				'id_devolucion', //ver si esto esta bien
				'id_devolucion'
		);
	}
	
	function getCliente($id_cliente, $all = NULL)
	{
		if($all == NULL)
		{
			$consulta = 
			"SELECT 
					`devolucion`.`id_devolucion`,
					`devolucion`.`id_presupuesto`,
					`devolucion`.`fecha`,
					`devolucion`.`monto`,
					`devolucion`.`a_cuenta`,
					`devolucion`.`nota`			
				FROM 
					`devolucion` 
				INNER JOIN 
					`presupuesto` ON(devolucion.id_presupuesto = presupuesto.id_presupuesto)
				WHERE
					`presupuesto`.`id_cliente` = $id_cliente
					AND `devolucion`.`id_estado` = 1";		
				
		}
		else
		{
			$consulta = 
			"SELECT 
					`devolucion`.`id_devolucion`,
					`devolucion`.`id_presupuesto`,
					`devolucion`.`fecha`,
					`devolucion`.`monto`,
					`devolucion`.`a_cuenta`,
					`devolucion`.`nota`			
				FROM 
					`devolucion` 
				INNER JOIN 
					`presupuesto` ON(devolucion.id_presupuesto = presupuesto.id_presupuesto)
				WHERE
					`presupuesto`.`id_cliente` = $id_cliente";		
		}
		
		$query = $this->db->query($consulta);
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return FALSE;
		}
	}
	
	
	function suma_devolucion($inicio, $final, $id_cliente = NULL)
	{
		if($id_cliente === NULL)
		{
			$inicio	= date('Y-m', strtotime($inicio));
			$final	= date('Y-m', strtotime($final));
			
			$consulta = "SELECT 
						* 
						FROM `devolucion` 
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
						FROM `devolucion` 
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
