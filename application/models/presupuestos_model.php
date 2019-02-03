<?php 
class Presupuestos_model extends MY_Model {
	
	public function __construct(){
		
		parent::construct(
				'presupuesto',
				'id_presupuesto',
				'monto', //ver si esto esta bien
				'id_presupuesto'
		);

	}
	
	function suma_presupuesto($inicio, $final, $id_cliente = NULL, $id_vendedor = NULL)
	{
		if($id_vendedor != NULL){
            $inicio         = date('Y-m', strtotime($inicio));
            $final          = date('Y-m', strtotime($final));
        
            $consulta = "
            SELECT 
                monto,
                fecha, 
                tipo,
                estado,
                id_vendedor 
            FROM 
                `presupuesto` 
            WHERE
                DATE_FORMAT(fecha, '%Y-%m') >= '$inicio' AND
                DATE_FORMAT(fecha, '%Y-%m') < '$final' AND
                id_vendedor = '$id_vendedor'";
		}else  if($id_cliente === NULL) {
			$inicio			= date('Y-m', strtotime($inicio));
			$final			= date('Y-m', strtotime($final));
		
			$consulta = "
			SELECT 
				monto,
				fecha, 
				tipo,
				estado,
				id_vendedor 
			FROM 
                `presupuesto` 
            WHERE
                DATE_FORMAT(fecha, '%Y-%m') >= '$inicio' AND
				DATE_FORMAT(fecha, '%Y-%m') < '$final'";
		}else if($id_cliente == '0') {
			$inicio			= date('Y-m-d', strtotime($inicio));
			$final			= date('Y-m-d', strtotime($final));
		
			$consulta = "
			SELECT 
                id_presupuesto,
				monto,
				fecha, 
				tipo.tipo as tipo,
				a_cuenta,
				nombre,
				apellido,
				alias,
				id_vendedor,
				cliente.id_cliente as id_cliente,
				estado_presupuesto.estado as estado 
			FROM 
                `presupuesto` 
            INNER JOIN 
			     cliente ON(presupuesto.id_cliente = cliente.id_cliente)
            INNER JOIN 
                tipo ON(presupuesto.tipo = tipo.id_tipo)
            INNER JOIN 
                estado_presupuesto ON(estado_presupuesto.id_estado = presupuesto.estado)
            WHERE
                DATE_FORMAT(fecha, '%Y-%m-%d') >= '$inicio' AND
				DATE_FORMAT(fecha, '%Y-%m-%d') < '$final'";
		}else {
			$inicio			= date('Y-m-d', strtotime($inicio));
			$final			= date('Y-m-d', strtotime($final));
		
			$consulta = "
			SELECT 
                id_presupuesto,
				monto,
				fecha, 
				tipo.tipo as tipo,
				a_cuenta,
				nombre,
				apellido,
				alias,
				id_vendedor,
				cliente.id_cliente as id_cliente,
				estado_presupuesto.estado as estado 
			FROM 
                `presupuesto` 
            INNER JOIN 
			     cliente ON(presupuesto.id_cliente = cliente.id_cliente)
            INNER JOIN 
                tipo ON(presupuesto.tipo = tipo.id_tipo)
            INNER JOIN 
                estado_presupuesto ON(estado_presupuesto.id_estado = presupuesto.estado)
            WHERE
                DATE_FORMAT(fecha, '%Y-%m-%d') >= '$inicio' AND
                DATE_FORMAT(fecha, '%Y-%m-%d') < '$final'
            ORDER BY 
                fecha";
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
	
	function get_top($inicio, $final,$cantidad = NULL)
	{
		if($cantidad == NULL){
			$cantidad = 10;
		}	
			
		
		$inicio			= date('Y-m', strtotime($inicio));
		$final			= date('Y-m', strtotime($final));
		
		$consulta = "SELECT 
					fecha, 
					sum(cantidad) as cantidad, 
					descripcion, 
					articulo.id_articulo 
					FROM presupuesto 
					INNER JOIN reglon_presupuesto ON(presupuesto.id_presupuesto = reglon_presupuesto.id_presupuesto)
					INNER JOIN articulo ON(reglon_presupuesto.id_articulo =  articulo.id_articulo)
					WHERE
					presupuesto.estado !=3 AND
					DATE_FORMAT(fecha, '%Y-%m') >= '$inicio' AND
					DATE_FORMAT(fecha, '%Y-%m') <= '$final'
					GROUP BY articulo.id_articulo
					ORDER BY cantidad DESC
					LIMIT 0,$cantidad";
					
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
	
	
	
	function getCliente($id)
	{
		$sql = 
			"SELECT 
				* 
			FROM 
				$this->_table
			INNER JOIN
				tipo ON(tipo.id_tipo = $this->_table.tipo)
			INNER JOIN
				estado_presupuesto ON(estado_presupuesto.id_estado = $this->_table.estado) 
			WHERE 
				id_cliente = $id
			ORDER BY
				id_presupuesto DESC";
				
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
