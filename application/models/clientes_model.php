<?php 
class Clientes_model extends My_Model {
		
	public function __construct(){
		parent::construct(
			'cliente',
			'id_cliente',
			'nombre'
		);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Para buscar clients por nombre o alias

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	function getFilters($filtro) {
		$sql = "
		SELECT 
				*
		FROM 
				cliente 
		WHERE 
			(nombre LIKE '%".$filtro."%' OR 
			apellido LIKE '%".$filtro."%' OR
			alias LIKE '%".$filtro."%') AND
			id_estado = 1 
		LIMIT 
			20 ";

        $registros = $this->getQuery($sql);

        $row_set = [];

        foreach ($registros as $cliente) {

            $value = ($cliente->apellido != '' ? $cliente->apellido.' ' : '');
            $value .= ($cliente->nombre != '' ? $cliente->nombre.' ' : '');
            $value .= ($cliente->alias != '' ? ','.$cliente->alias : '');

            $row['apellido'] = stripslashes(utf8_encode($cliente->apellido));
            $row['nombre'] = stripslashes(utf8_encode($cliente->nombre));
            $row['direccion'] = stripslashes(utf8_encode($cliente->direccion));
            $row['cuil'] = stripslashes(utf8_encode($cliente->cuil));
            $row['celular'] = stripslashes(utf8_encode($cliente->celular));
            $row['value'] = stripslashes(utf8_encode($value));
            $row['id_cliente'] = (int)$cliente->id_cliente;
            $row_set[] = $row;
        }

       return $row_set;
	}


	function getSumas($tipo) {
		if($tipo == 'tipos') {
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
		} else {
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

        return $this->getQuery($sql);
	}
} 
?>
