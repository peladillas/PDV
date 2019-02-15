<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}
	
	
		
	public function _example_output($output = null)
	{
		$this->load->view('crud.php',$output);
	}	
	
	
/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD ALUMNO
 * 
 * ********************************************************************************
 **********************************************************************************/


	public function usuario_crud()
	{
		$crud = new grocery_CRUD();
		
		$crud->set_table('usuario');
		
		$output = $crud->render();

		$this->_example_output($output);
		
  
 
 
 
 
 /*









		$crud->columns('alias','nombre', 'apellido', 'telefono', 'celular');
		$crud->display_as('direccion','Dirección')
			 ->display_as('id_condicion_iva','Condición Iva')
			 ->display_as('id_estado','Estado');
		$crud->set_subject('cliente');
		$crud->required_fields(
					'nombre',
					'apellido',
					'alias',
					'cuil/cuit' );
		$crud->set_relation('id_estado','estado','estado');
		$crud->set_relation('id_condicion_iva','condicion_iva','descripcion');
		$crud->fields(
					'nombre',
					'apellido',
					'alias',
					'cuil/cuit',
					'direccion',
					'telefono',
					'celular',
					'nextel',
					'id_condicion_iva',
					'comentario'
				);
			
		$_COOKIE['tabla']='cliente';
		$_COOKIE['id']='id_cliente';	
			
		$crud->callback_before_insert(array($this, 'control_insert_cliente'));
		$crud->callback_after_insert(array($this, 'insert_log'));
		$crud->callback_after_update(array($this, 'update_log'));
		$crud->callback_delete(array($this,'delete_log'));	

		$this->permisos_model->getPermisos_CRUD('permiso_cliente', $crud);
		*/	
	}

}