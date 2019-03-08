<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nota_creditos extends MY_Controller {

    protected $path = 'nota_credito/';

	public function __construct() {
		parent::__construct($this->path);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Para probar las nuevas librerias

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    function add() {
        $this->load->library('documents_CRUD');

        $db['documents'] = new documents_CRUD();
        $db['documents']->set_table_head('nota_credito', 'id_nota_credito');
        $db['documents']->set_entity('id_cliente', 'cliente');

        $db['documents']->set_table_detail('renglon_nota_credito');
        $db['documents']->set_stock('in');

        $this->view($db, $this->path.'add');
    }
}