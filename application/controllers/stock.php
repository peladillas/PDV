<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends MY_Controller {

    protected $path = 'stock/';

	public function __construct() {
		parent::__construct($this->path);

		$this->load->model('stock_model');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Movimientos de Stock

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function movimiento(){
		$registro = array(
			'id_articulo' => 9,
			'id_comprobante' => 1,
			'id_comprobante_tipo' => 1,
			'cantidad_saliente' => 5,
		);
		$this->stock_model->movimiento($registro);
	}
}