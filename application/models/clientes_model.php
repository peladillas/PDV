<?php 
class Clientes_model extends My_Model {
		
	public function __construct(){
	
		parent::construct(
				'cliente',
				'id_cliente',
				'nombre',
				'nombre'
		);
	}
	
	function getSumas($tipo)
	{
		if($tipo == 'tipos')
		{
			$sql = 
			"SELECT 
				count(*) as suma, 
				tipo_cliente.tipo as descripcion 
			FROM 
				`cliente` 
			INNER JOIN 
				tipo_cliente ON(cliente.id_tipo = tipo_cliente.id_tipo)
			GROUP BY 
				tipo_cliente.id_tipo";
		}
		else
		{
				$sql = 
			"SELECT 
				count(*) as suma, 
				condicion_iva.descripcion as descripcion 
			FROM 
				`cliente` 
			INNER JOIN 
				condicion_iva ON(cliente.id_condicion_iva = condicion_iva.id_condicion_iva)
			GROUP BY 
				condicion_iva.id_condicion_iva";
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
