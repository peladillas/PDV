<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends MY_Controller {

    protected $path = 'stock/';

	public function __construct() {
		parent::__construct($this->path);

		$this->load->model('stock_detail_model');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Para probar las nuevas librerias

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    function index() {
        $this->load->library('documents_CRUD');

        $db['documents'] = new documents_CRUD();
        $db['documents']->set_table_head('stock', 'id_stock');
        $db['documents']->set_not_entity();
        $db['documents']->set_table_detail('stock_detail');

        $this->view($db, $this->path.'add');
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
		$this->stock_detail_model->movimiento($registro);
	}
}