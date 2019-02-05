<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->model('stock_model');
	}
	
	
/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD CLIENTE
 * 
 * ********************************************************************************
 **********************************************************************************/


	public function movimiento(){
		$registro = array(
			'id_articulo' => 1,
			'id_comprobante' => 1,
			'id_comprobante_tipo' => 1,
			'cantidad_entrante' => 1,
		);
		$this->stock_model->movimiento($registro);
	}
}