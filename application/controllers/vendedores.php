<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendedores extends My_Controller {

    protected $path = 'vendedores/';

	public function __construct() {
		parent::__construct($this->path);

        $this->load->model('vendedores_model');

		$this->load->library('grocery_CRUD');
	}

/**********************************************************************************
 **********************************************************************************
 *
 *              CRUD Vendedores
 *
 * ********************************************************************************
 **********************************************************************************/

    public function vendedores_abm() {
        $crud = new grocery_CRUD();

        $crud->set_table('vendedor');

        $crud->columns('id_vendedor','vendedor');

        $crud->display_as('id_vendedor','ID')
            ->display_as('vendedor','Vendedor');

        $crud->set_subject('vendedor');

        $crud->fields('vendedor');

        $crud->required_fields('vendedor','vendedor');
		
        $crud->add_action('Estadistica', '', '','icon-awstats', array($this, 'detalle_vendedor'));

        $_COOKIE['tabla']='vendedor';
        $_COOKIE['id']='id_vendedor';

        $output = $crud->render();

        $this->viewCrud($output);
    }

    function detalle_vendedor($id) {
        return site_url('/estadisticas/mensual').'/'.$id;
    }
}