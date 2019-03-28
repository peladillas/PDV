<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends MY_Controller {

    protected $path = 'stock/';

	public function __construct() {
		parent::__construct($this->path);

		$this->load->model('renglon_stock_model');
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
        $db['documents']->set_table_detail('renglon_stock');

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
			'id_comprobante' => 5,
			'id_comprobante_tipo' => TIPOS_COMPROBANTES::PRESUPUESTO,
			'cantidad_saliente' => 5,
		);
		$this->renglon_stock_model->movimiento($registro);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Para probar las nuevas librerias

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/


    function add() {

        $this->load->library('documents_CRUD');

        $db['documents'] = new documents_CRUD();
        $db['documents']->set_table_head('stock', 'id_stock');
        $db['documents']->set_entity('id_proveedor', 'proveedor');

        $db['documents']->notMethodPayment();

        $db['documents']->set_table_detail('renglon_stock');
        $db['documents']->set_stock('in');

        $this->view($db, $this->path.'add');
    }
}