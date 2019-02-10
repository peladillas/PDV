<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nota_credito extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->model('nota_credito_model');
		$this->load->model('clientes_model');
	}
	
	
/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD Nota Credito
 * 
 * ********************************************************************************
 **********************************************************************************/


	public function index(){
		$db['clientes'] = $this->clientes_model->getRegistros();
		
		$this->armarVista($db, 'nota_credito/generar.php');
	}
}