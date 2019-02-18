<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD ALUMNO, revisar si se llama de algun lado, si no se vuela este controlador
 * 
 * ********************************************************************************
 **********************************************************************************/

	public function usuario_crud() {
		$crud = new grocery_CRUD();
		
		$crud->set_table('usuario');
		
		$output = $crud->render();

		$this->viewCrud($output);
	}

}