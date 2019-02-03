<?php 
class Remitos_detalle_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'remito_detalle',
				'id_remito_detalle',
				'monto', //ver si esto esta bien
				'id_remito_detalle'
		);

	}
	
	function getRemitos($id , $dev = NULL)
	{
		if($dev == NULL)
		{
			$sql = "SELECT 	
						presupuesto.id_presupuesto AS nro,
						presupuesto.fecha AS prefecha,
						presupuesto.monto AS premonto,
						remito_detalle.a_cuenta AS prea_cuenta,
						cliente.alias AS alias,
						remito_detalle.monto AS monto,
						estado_presupuesto.estado AS estado
					FROM 
						remito_detalle
					INNER JOIN 
						presupuesto ON(presupuesto.id_presupuesto = remito_detalle.id_presupuesto)
					INNER JOIN 
						estado_presupuesto ON(remito_detalle.id_estado_presupuesto = estado_presupuesto.id_estado)
					INNER JOIN 
						cliente ON(presupuesto.id_cliente = cliente.id_cliente)
					WHERE
						remito_detalle.id_remito = '$id'
					ORDER BY 
						presupuesto.id_presupuesto";
		}
		else
		{
			$sql = "SELECT 	
						devolucion.fecha as fecha,
						devolucion.monto as monto_dev,
						devolucion.a_cuenta as a_cuenta,
						devolucion.nota,
						remito_detalle.monto AS monto
					FROM 
						remito_detalle
					INNER JOIN 
						devolucion ON(devolucion.id_devolucion = remito_detalle.id_devolucion)
					WHERE
						remito_detalle.id_remito = '$id'
					ORDER BY 
						devolucion.id_devolucion";
		}
		
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
