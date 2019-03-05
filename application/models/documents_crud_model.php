<?php

class documents_CRUD_Model  extends CI_Model  {
	function __construct() {
        parent::__construct();
    }
	
	
	function insert($postData){
		$datos[$postData['IdEntityField']] = $postData['IdEntityValue'];
		$datos[$postData['TotalField']] = $postData['TotalValue'];
		$datePost = split('-', $postData['DateValue']);
		$datos[$postData['DateField']] = $datePost[2].'/'.$datePost[1].'/'.$datePost[0].' '.date('H:i:s');

		$this->db->insert($postData['HeadTable'] , $datos);
		$id	=	$this->db->insert_id();	
		
		return $id;
	}
	
	function getFilters($controller, $filtro){
		switch ($controller) {
		    case 'articulos/':
		        return $this->getArticulos($filtro);
		        break;
		    case 'clientes/':
		        return $this->getClientes($filtro);
		        break;
		}
	}

/*---------------------------------------------------------------------------------
 -----------------------------------------------------------------------------------

                Función para armar la query

 -----------------------------------------------------------------------------------
  ---------------------------------------------------------------------------------*/

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

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Para buscar artiuclos por descripcion o codigo proveedor

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    function getArticulos($filtro) {
        $sql = "
		SELECT 
			*
		FROM 
			articulo 
		WHERE 
			(descripcion LIKE '%".$filtro."%' OR 
			cod_proveedor LIKE '%".$filtro."%') AND
			id_estado = 1 
		LIMIT 
			20";
			
		$registros = $this->getQuery($sql);
			
		$row_set = array();
		if($registros){
			foreach ($registros as $articulo) {
				$row['value']	= stripslashes(utf8_encode($articulo->descripcion));
				$row['id']		= (int)$articulo->id_articulo;
				$row['iva']		= (float)$articulo->iva;
				$row['precio']	= (float)$articulo->precio_venta_sin_iva_con_imp;
				$row_set[]		= $row;
			}
		}
		
		return $row_set;
    }

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Para buscar clients por nombre o alias

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    function getClientes($filtro) {
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

        $row_set = array();

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
            $row['id'] = (int)$cliente->id_cliente;
            $row_set[] = $row;
        }

        return $row_set;
    }
}
