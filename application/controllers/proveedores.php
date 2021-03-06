<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores extends MY_Controller {

    protected $path = 'proveedores/';

	public function __construct(){
		parent::__construct($this->path);

		$this->load->model('proveedores_model');
		$this->load->model('articulos_model');

		$this->load->library('grocery_CRUD');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Proveedores Crud

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function proveedor_abm() {
        $crud = new grocery_CRUD();

        $crud->where('proveedor	.id_estado = '.ESTADOS::ALTA);
        $crud->set_table('proveedor');
        $crud->columns('descripcion','margen','impuesto', 'descuento');
        $crud->display_as('descripcion','Descripción')
             ->display_as('descuento','Descuento %')
             ->display_as('id_estado','Estado');
        $crud->set_subject('proveedor');
        $crud->required_fields('descripcion','impuesto', 'margen','id_estado');
        $crud->fields('descripcion','margen', 'impuesto', 'descuento', 'descuento2');

        $_COOKIE['tabla'] ='proveedor';
        $_COOKIE['id'] ='id_proveedor';

        $crud->callback_after_insert(array($this, FUNCTION_LOG::INSERT));
        $crud->callback_after_update(array($this, 'actualizar_precios'));
        $crud->callback_delete(array($this, FUNCTION_LOG::DELETE));

        $this->permisos_model->getPermisosCRUD('permiso_proveedor', $crud);

        $output = $crud->render();

        $this->viewCrud($output);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Actualizaciones de precios, ver como sacar el dato de variacion

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    public function actualizar_precios($datos, $id){
        $articulos	= $this->proveedores_model->getProveedorArticulos($id);
        $this->articulos_model->updatePrecios($articulos);

	    return true;
	}
}