<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendedores extends My_Controller {

	public function __construct() {
		parent::__construct();

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

        $crud->columns('id_vendedor','vendedor', 'id_estado');

        $crud->display_as('id_vendedor','ID')
            ->display_as('vendedor','Vendedor')
            ->display_as('id_estado','Estado');

        $crud->set_subject('vendedor');

        $crud->fields('vendedor');

        $crud->required_fields('vendedor','vendedor');

        $crud->set_relation('id_estado','estado','estado');
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