<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articulos extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		$this->load->model('articulos_model');
		$this->load->model('proveedores_model');
		$this->load->model('grupos_model');
		$this->load->model('categorias_model');
		$this->load->model('subcategorias_model');
		$this->load->model('actualizaciones_precion_model');
		
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		

	}

 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD CATEGORIA
 * 
 * ********************************************************************************
 **********************************************************************************/

	
	public function categoria_abm()
	{
			$crud = new grocery_CRUD();

			$crud->where('categoria.id_estado = 1');
			$crud->set_table('categoria');
			
			$crud->columns('descripcion');
			
			$crud->display_as('descripcion','Descripción')
				 ->display_as('id_estado','Estado');
				 
			$crud->set_subject('categoria');
			
			$crud->fields('descripcion');
			
			$crud->required_fields('descripcion','id_estado');
			$crud->set_relation('id_estado','estado','estado');
			
			$_COOKIE['tabla']='categoria';
			$_COOKIE['id']='id_categoria';	
			
			$crud->callback_after_insert(array($this, 'insert_log'));
			$crud->callback_after_update(array($this, 'update_log'));
			$crud->callback_delete(array($this,'delete_log'));	
			
			$this->permisos_model->getPermisos_CRUD('permiso_articulo', $crud);
			
			$output = $crud->render();

			$this->_example_output($output);
	}


/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD SUBCATEGORIA
 * 
 * ********************************************************************************
 **********************************************************************************/

	
	public function subcategoria_abm()
	{
			$crud = new grocery_CRUD();

			$crud->where('subcategoria.id_estado = 1');
			$crud->set_table('subcategoria');
			$crud->columns('descripcion', 'id_categoria_padre');
			$crud->display_as('descripcion','Descripción')
				 ->display_as('id_estado','Estado')
				 ->display_as('id_categoria_padre','Categoria padre');
			$crud->set_subject('subcategoria');
			$crud->required_fields('descripcion','id_estado','id_categoria_padre');
			$crud->set_relation('id_estado','estado','estado');
			$crud->set_relation('id_categoria_padre','categoria','descripcion', 'categoria.id_estado = 1');
			$crud->fields('descripcion');
			
			$_COOKIE['tabla']='subcategoria';
			$_COOKIE['id']='id_subcategoria';	
			
			$crud->callback_after_insert(array($this, 'insert_log'));
			$crud->callback_after_update(array($this, 'update_log'));
			$crud->callback_delete(array($this,'delete_log'));	
			
			$this->permisos_model->getPermisos_CRUD('permiso_articulo', $crud);
			
			$output = $crud->render();

			$this->_example_output($output);
	}

	
/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD GRUPO
 * 
 * ********************************************************************************
 **********************************************************************************/

	
	public function grupo_abm()
	{
			$crud = new grocery_CRUD();
	
			$crud->where('grupo.id_estado = 1');
			$crud->set_table('grupo');
			$crud->columns('descripcion');
			$crud->display_as('descripcion','Descripción')
				 ->display_as('id_estado','Estado');
			$crud->set_subject('grupo');
			$crud->required_fields('descripcion','id_estado');
			$crud->set_relation('id_estado','estado','estado');
			
			$crud->fields('descripcion');
			
			$_COOKIE['tabla']='grupo';
			$_COOKIE['id']='id_grupo';	
			
			$crud->callback_after_insert(array($this, 'insert_log'));
			$crud->callback_after_update(array($this, 'update_log'));
			$crud->callback_delete(array($this,'delete_log'));	

			$this->permisos_model->getPermisos_CRUD('permiso_articulo', $crud);
			
			$output = $crud->render();

			$this->_example_output($output);
	}
	

 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD ARTICULO
 * 
 * ********************************************************************************
 **********************************************************************************/


	public function articulo_abm()
	{
			$crud = new grocery_CRUD();

			$crud->where('articulo.id_estado = 1');
			
			$crud->set_table('articulo');
			$crud->columns('cod_proveedor','descripcion','precio_costo','precio_venta_iva');
			$crud->display_as('descripcion','Descripción')
				 ->display_as('id_proveedor','Proveedor')
				 ->display_as('id_grupo','Grupo')
				 ->display_as('id_proveedor','Proveedor')
				 ->display_as('id_categoria','Categoria')	
				 ->display_as('id_subcategoria','Subcategoria')			
				 ->display_as('id_estado','Estado');
			$crud->fields(	'cod_proveedor',
							'descripcion',
							'precio_costo',
							'margen',
							'iva',
							'impuesto',
							'id_proveedor',
							'id_grupo',
							'id_categoria',
							'id_subcategoria');
			$crud->required_fields(	'cod_proveedor',
							'descripcion',
							'precio_costo',
							'margen',
							'iva',
							'impuesto',
							'id_proveedor',
							'id_grupo',
							'id_categoria',
							'id_subcategoria');
			
			$crud->set_subject('articulo');
			$crud->set_relation('id_proveedor','proveedor','{descripcion}', 'proveedor.id_estado = 1');
			$crud->set_relation('id_grupo','grupo','descripcion', 'grupo.id_estado = 1');
			$crud->set_relation('id_categoria','categoria','descripcion', 'categoria.id_estado = 1');
			$crud->set_relation('id_subcategoria','subcategoria','descripcion', 'subcategoria.id_estado = 1');
			$crud->set_relation('id_estado','estado','estado');
			
			$_COOKIE['tabla']='articulo';
			$_COOKIE['id']='id_articulo';	
			
			$crud->callback_after_insert(array($this, 'insert_log'));
			$crud->callback_after_insert(array($this, 'actualizar_precios'));
			$crud->callback_after_update(array($this, 'update_log'));
			$crud->callback_after_update(array($this, 'actualizar_precios'));
			$crud->callback_delete(array($this,'delete_log'));	
			
			$this->permisos_model->getPermisos_CRUD('permiso_articulo', $crud);

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function actualizar_precios($datos, $id)
	{
		$query	= $this->db->query("SELECT 	
				articulo.id_articulo,
				articulo.cod_proveedor,
				articulo.descripcion as descripcion,
				articulo.precio_costo,
				articulo.precio_venta_iva,
				articulo.precio_venta_sin_iva,
				articulo.iva as iva,
				proveedor.descripcion as proveedor,
				proveedor.descuento as descuento,
				proveedor.descuento2 as descuento2,
				proveedor.margen as margen,
				proveedor.impuesto as impuesto	
		FROM `articulo` 
		INNER JOIN proveedor
		ON(articulo.id_proveedor=proveedor.id_proveedor)
		WHERE articulo.id_articulo = $id");

		foreach ($query->result() as $row) {
			
			$precio_viejo		= $row->precio_costo ;// solo para depurar
			
			$precio_costo		= $row->precio_costo + ($row->precio_costo * ($variacion/100));// FUNCIONA PARA AUMENTOS Y DECREMENTOS POR LA MULTIP(+ * + = +     Y    + * -  = - )
			
			$costo_descuento1	= $precio_costo - ($precio_costo * ($row->descuento /100));
			
			$costo_descuento	= $costo_descuento1-($costo_descuento1*($row->descuento2 /100)); // APLICACION DE 2DO DESC ESCALONADO
			
			//02 - Precio con ganancia
			$precio_venta_sin_iva = $costo_descuento+($costo_descuento*($row->margen /100));
			
			//2.5 - Precio con IMPUESTO 6%
			
			$precio_venta_sin_iva_con_imp = $precio_venta_sin_iva + ( $precio_venta_sin_iva * ( $row->impuesto /100));
			
			//03 - Precio con iva
			$iva		= $row->iva ;
			$margen		= $row->margen ;
			$impuesto	= $row->impuesto ;
			
			$precio_venta_sin_iva_sin_imp=$precio_venta_sin_iva;
			
			$precio_venta_con_iva_con_imp=$precio_venta_sin_iva_con_imp+($precio_venta_sin_iva_sin_imp*($iva/100));// precio c/dto1 c/dto2 s/iva s/imp c/margen +  %iva + %imp(p) 
			
			$id_articulo= $row->id_articulo ;	
			
			$datos = array(
						'precio_costo'			=> $precio_costo,
						'costo_descuento'		=> $costo_descuento,
						'precio_venta_sin_iva'	=> $precio_venta_sin_iva,
						'precio_venta_sin_iva_con_imp'=> $precio_venta_sin_iva_con_imp,
						'precio_venta_iva'		=> $precio_venta_con_iva_con_imp,
						'margen'				=> $margen,
						'impuesto'				=> $impuesto
						);
			$this->articulos_model->update_Articulo($datos, $id);
			
		}
					
	 
	    return true;
	}




/**********************************************************************************
 **********************************************************************************
 * 
 * 				Actualizar precios Lote
 * 
 * ********************************************************************************
 **********************************************************************************/
 
 
 	public function actualizar_precios_lote()
 	{
		if($this->session->userdata('logged_in')){
			$db['proveedores']	= $this->proveedores_model->getProveedores();
			$db['grupos']		= $this->grupos_model->getGrupos();
			$db['categorias']	= $this->categorias_model->getCategorias();
			$db['subcategorias']= $this->subcategorias_model->getSubcategorias();
			
			if($this->input->post('buscar'))
			{
				$datos = array(
						'proveedor'		=> $this->input->post('proveedor'),
						'grupo'			=> $this->input->post('grupo'),
						'categoria'		=> $this->input->post('categoria'),
						'subcategoria'	=> $this->input->post('subcategoria'),
						'variacion'		=> $this->input->post('variacion'),
						'id_estado'		=> 1,
						'date_upd'		=> date('Y:m:d H:i:s')
				);
				
				$db['articulos']	= $this->articulos_model->getArticulos_variacion($datos);
				$db['mensaje']		= "Cantidad de articulos a actualizar: ".count($db['articulos']);
				$db['class']		= "hide";		
				
				if($this->input->post('confirmar'))
				{	
					$this->actualizaciones_precion_model->insert($datos);
		
					$this->articulos_model->updatePrecios($db['articulos'], $datos);
					
					$db['articulos']	= $this->articulos_model->getArticulos_variacion($datos);
					$db['mensaje']		= "Los articulos se han actualizado";
				}
			}else{
				$db['class']		= "show";
				$db['actualizaciones']=$this->actualizaciones_precion_model->select();
			}
			
			$this->load->view('head', $db);
			$this->load->view('menu');
			$this->load->view('actualizar precios_lote');
			$this->load->view('calendarios/config_actualizar');
			$this->load->view('footer');
		}else{
			redirect('/','refresh');
		}
	}

/**********************************************************************************
 **********************************************************************************
 * 
 * 				Trae todos los ariculos y los formatea en json
 * 
 * ********************************************************************************
 **********************************************************************************/

	
	public function getArticulos()
	{
		$filtro = $this->input->get('term', TRUE);
		
		$db['articulos'] = $this->articulos_model->getArticulos($filtro);
		
		$row_set = array();
		foreach ($db['articulos'] as $articulo) {
			$row['value']	= stripslashes(utf8_encode($articulo->descripcion));
			$row['id']		= (int)$articulo->id_articulo;
			$row['iva']		= (float)$articulo->iva;
			$row['precio']	= (float)$articulo->precio_venta_sin_iva_con_imp;
			$row_set[]		= $row;
		}

		echo json_encode($row_set);
	}


}