<?php
class documents_CRUD_Model  extends CI_Model  {
	function __construct() {
        parent::__construct();
    }
/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
                Función para armar la query
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
	
	
	function insert($postData){
		
		if($postData['type'] == 'head'){
			$table = $postData['HeadTable'];
			$datos[$postData['IdEntityField']] = $postData['IdEntityValue'];
			$datos[$postData['TotalField']] = $postData['TotalValue'];
			$datePost = explode('-', $postData['DateValue']);
			$datos[$postData['DateField']] = $datePost[2].'/'.$datePost[1].'/'.$datePost[0].' '.date('H:i:s');
		} else {
			$table = $postData['detailTable'];
			$datos[$postData['detailIdHeadField']] = $postData['detailIdHeadValue'];
			$datos[$postData['detailIdItemField']] = $postData['detailIdItemValue'];
			$datos[$postData['detailQuantityField']] = $postData['detailQuantityValue'];
			$datos[$postData['detailPriceField']] = $postData['detailPriceValue'];
			$this->setStockMove($postData);
		}
		
		$this->db->insert($table, $datos);
		$id	= $this->db->insert_id();
		return $id;
	}
/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
        Movimiento de stock
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
    function setStockMove($postData){
        $movimiento = ($postData['stockInOut'] == 'in' ? 'cantidad_entrante' : 'cantidad_saliente');
        $registro = array(
            'id_articulo' => $postData['detailIdItemValue'],
            'id_comprobante' => $postData['detailIdHeadValue'],
            'id_comprobante_tipo' => $this->getComprobanteTipo($postData['detailTable']),
            $movimiento => $postData['detailQuantityValue'],
        );
		
		
        $this->load->model('renglon_stock_model');
        $this->renglon_stock_model->movimiento($registro);
    }
/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
        Movimiento de stock
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
    function getComprobanteTipo($detailTable){
        switch ($detailTable) {
		    case 'renglon_presupuesto':
		        return TIPOS_COMPROBANTES::PRESUPUESTO;
		        break;
		    case 'renglon_nota_credito':
                return TIPOS_COMPROBANTES::NOTA_CREDITO;
		        break;
            case 'stock':
                return TIPOS_COMPROBANTES::STOCK;
                break;
		}
    }
/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
        Funcion para aplicar el filtro
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
	
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
			id_estado = ".ESTADOS::ALTA." 
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
			id_estado = ".ESTADOS::ALTA."  
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