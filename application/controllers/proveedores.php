<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('proveedores_model');
		$this->load->model('articulos_model');
		$this->load->library('grocery_CRUD');
	}

/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD PROVEEDORES
 * 
 * ********************************************************************************
 **********************************************************************************/

	public function proveedor_abm() {
        $crud = new grocery_CRUD();

        $crud->where('proveedor	.id_estado = 1');
        $crud->set_table('proveedor');
        $crud->columns('descripcion','margen','impuesto', 'descuento');
        $crud->display_as('descripcion','Descripción')
             ->display_as('descuento','Descuento %')
             ->display_as('id_estado','Estado');
        $crud->set_subject('proveedor');
        $crud->required_fields('descripcion','impuesto', 'margen','id_estado');
        $crud->fields('descripcion','margen', 'impuesto', 'descuento', 'descuento2');
        $crud->set_relation('id_estado','estado','estado');

        $_COOKIE['tabla'] ='proveedor';
        $_COOKIE['id'] ='id_proveedor';

        $crud->callback_after_insert(array($this, 'insert_log'));
        $crud->callback_after_update(array($this, 'actualizar_precios'));
        $crud->callback_delete(array($this,'delete_log'));

        $this->permisos_model->getPermisos_CRUD('permiso_proveedor', $crud);

        $output = $crud->render();

        $this->viewCrud($output);
	}

/**********************************************************************************
 **********************************************************************************
 * 
 * 				Actualizaciones de precios, ver como sacar el dato de variacion
 * 
 * ********************************************************************************
 **********************************************************************************/

    public function actualizar_precios($datos, $id){
        $articulos	= $this->proveedores_model->getProveedorArticulos($id);
        $newDatos['variacion'] = $variacion;
        $this->articulos_model->updatePrecios($articulos, $newDatos);

	    return true;
	}
}