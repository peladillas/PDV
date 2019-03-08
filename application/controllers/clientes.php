<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends MY_Controller {

    protected $path = 'clientes/';

	public function __construct() {
		parent::__construct($this->path);

		$this->load->model('clientes_model');
		$this->load->model('presupuestos_model');
		$this->load->model('devoluciones_model');
		$this->load->model('remitos_model');
		
		$this->load->library('grocery_CRUD');
	}

/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD CLIENTE
 * 
 * ********************************************************************************
 **********************************************************************************/

	public function cliente_abm() {
		$crud = new grocery_CRUD();

		$crud->where('cliente.id_estado = '.ESTADOS::ALTA);
		$crud->set_table('cliente');
		$crud->columns('alias','nombre', 'apellido', 'telefono', 'celular');
		$crud->display_as('direccion','Dirección')
			 ->display_as('id_condicion_iva','Condición Iva')
			 ->display_as('id_tipo','Tipo')
			 ->display_as('id_estado','Estado');
		$crud->set_subject('cliente');
		$crud->required_fields(
            'nombre',
            'apellido',
            'alias',
            'cuil'
        );
		
		$crud->set_relation('id_condicion_iva','condicion_iva','descripcion');
		$crud->set_relation('id_tipo','tipo_cliente','tipo');
		
		$crud->fields(
            'nombre',
            'apellido',
            'alias',
            'cuil',
            'direccion',
            'telefono',
            'celular',
            'nextel',
            'id_condicion_iva',
            'id_tipo',
            'comentario'
        );
				
		$crud->add_action('Detalle', '', '','icon-exit', array($this, 'detalle'));
			
		$_COOKIE['tabla']='cliente';
		$_COOKIE['id']='id_cliente';	
			
		$crud->callback_before_insert(array($this, 'control_insert_cliente'));
		$crud->callback_after_insert(array($this, FUNCTION_LOG::INSERT));
		$crud->callback_after_update(array($this, FUNCTION_LOG::UPDATE));
		$crud->callback_delete(array($this, FUNCTION_LOG::DELETE));

		$this->permisos_model->getPermisosCRUD('permiso_cliente', $crud);
			
		$output = $crud->render();

		$this->viewCrud($output);
	}

	function detalle($id) {
		return site_url($this->path.'resumen/').$id;
	}

	function resumen($id_cliente) {
		$datos = array(
			'id_cliente'=> $id_cliente,
		);
		
		$db['clientes']			= $this->clientes_model->select($id_cliente);
		$db['presupuestos']		= $this->presupuestos_model->getCliente($id_cliente);
		$db['remitos']			= $this->remitos_model->select($datos);
		$db['devoluciones']		= $this->devoluciones_model->getCliente($id_cliente, 'all');// Arreglar esta chamchada

        $this->view($db, $this->path.'resumen');

	}

/**********************************************************************************
 **********************************************************************************
 *
 * 				sacar la consulta
 *
 * ********************************************************************************
 **********************************************************************************/


	function control_insert_cliente($post_array) {
		$registro = array(
            'cuil' => $post_array['cuil'],
        );

		$cliente = $this->clientes_model->select($registro);

		$return = ($cliente > 0 ? FALSE : $post_array);

		return $return;
	}

/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD CONDICION IVA
 * 
 * ********************************************************************************
 **********************************************************************************/

	public function condicion_iva_abm() {
        $crud = new grocery_CRUD();

        $crud->set_table('condicion_iva');
        $crud->columns('descripcion');
        $crud->display_as('descripcion','Descripción');
        $crud->unset_delete();
        $crud->unset_add();
        $crud->set_subject('Condición Iva');

        $_COOKIE['tabla']='condicion_iva_abm';
        $_COOKIE['id']='id_condicion_iva_abm';

        $crud->callback_after_insert(array($this, FUNCTION_LOG::INSERT));
        $crud->callback_after_update(array($this, FUNCTION_LOG::UPDATE));
        $crud->callback_delete(array($this, FUNCTION_LOG::DELETE));

        $this->permisos_model->getPermisosCRUD('permiso_cliente', $crud);

        $output = $crud->render();

        $this->viewCrud($output);
	}

    function select($id_cliente) {
        $datos = array(
            'id_cliente'=> $id_cliente,
        );

        $db['clientes']			= $this->clientes_model->select($id_cliente);
        $db['presupuestos']		= $this->presupuestos_model->getCliente($id_cliente);
        $db['remitos']			= $this->remitos_model->select($datos);
        $db['devoluciones']		= $this->devoluciones_model->getCliente($id_cliente, 'all');// Arreglar esta chamchada

        $this->view($db, $this->path.'resumen');

    }
	
	
/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD TIPO
 * 
 * ********************************************************************************
 **********************************************************************************/

	public function tipo_abm() {
        $crud = new grocery_CRUD();

        $crud->set_table('tipo_cliente');
        $crud->columns('tipo');

        $crud->set_subject('Tipo Cliente');

        $output = $crud->render();

        $this->viewCrud($output);
	}	
}