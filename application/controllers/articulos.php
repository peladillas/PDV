<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articulos extends My_Controller {

    protected $path = 'articulos/';

	public function __construct() {
		parent::__construct();

		$this->load->model('articulos_model');
		$this->load->model('proveedores_model');
		$this->load->model('grupos_model');
		$this->load->model('categorias_model');
		$this->load->model('subcategorias_model');
		$this->load->model('actualizaciones_precion_model');

		$this->load->library('grocery_CRUD');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Categoria CRUD

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    public function categoria_abm() {
        $crud = new grocery_CRUD();

        $crud->where('categoria.id_estado = 1');
        $crud->set_table('categoria');

        $crud->columns('descripcion');

        $crud->display_as('descripcion','Descripción')
             ->display_as('id_estado','Estado');

        $crud->set_subject('categoria');

        $crud->fields('descripcion');

        $crud->required_fields('descripcion','id_estado');
        $crud->set_relation('id_estado','estado','estado');

        $_COOKIE['tabla']='categoria';
        $_COOKIE['id']='id_categoria';

        $crud->callback_after_insert(array($this, 'insert_log'));
        $crud->callback_after_update(array($this, 'update_log'));
        $crud->callback_delete(array($this,'delete_log'));

        $this->permisos_model->getPermisosCRUD('permiso_articulo', $crud);

        $output = $crud->render();

        $this->viewCrud($output);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Sub Categoria CRUD

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function subcategoria_abm() {
        $crud = new grocery_CRUD();

        $crud->where('subcategoria.id_estado = 1');
        $crud->set_table('subcategoria');
        $crud->columns('descripcion', 'id_categoria_padre');
        $crud->display_as('descripcion','Descripción')
             ->display_as('id_estado','Estado')
             ->display_as('id_categoria_padre','Categoria padre');
        $crud->set_subject('subcategoria');
        $crud->required_fields('descripcion','id_estado','id_categoria_padre');
        $crud->set_relation('id_estado','estado','estado');
        $crud->set_relation('id_categoria_padre','categoria','descripcion', 'categoria.id_estado = 1');
        $crud->fields('descripcion');

        $_COOKIE['tabla']='subcategoria';
        $_COOKIE['id']='id_subcategoria';

        $crud->callback_after_insert(array($this, 'insert_log'));
        $crud->callback_after_update(array($this, 'update_log'));
        $crud->callback_delete(array($this,'delete_log'));

        $this->permisos_model->getPermisosCRUD('permiso_articulo', $crud);

        $output = $crud->render();

        $this->viewCrud($output);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Grupo CRUD

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function grupo_abm() {
        $crud = new grocery_CRUD();

        $crud->where('grupo.id_estado = 1');
        $crud->set_table('grupo');
        $crud->columns('descripcion');
        $crud->display_as('descripcion','Descripción')
             ->display_as('id_estado','Estado');
        $crud->set_subject('grupo');
        $crud->required_fields('descripcion','id_estado');
        $crud->set_relation('id_estado','estado','estado');

        $crud->fields('descripcion');

        $_COOKIE['tabla']='grupo';
        $_COOKIE['id']='id_grupo';

        $crud->callback_after_insert(array($this, 'insert_log'));
        $crud->callback_after_update(array($this, 'update_log'));
        $crud->callback_delete(array($this,'delete_log'));

        $this->permisos_model->getPermisosCRUD('permiso_articulo', $crud);

        $output = $crud->render();

        $this->viewCrud($output);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Articulo CRUD

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function articulo_abm() {
        $crud = new grocery_CRUD();

        $crud->where('articulo.id_estado = 1');

        $crud->set_table('articulo');
        $crud->columns('cod_proveedor','descripcion','precio_costo','precio_venta_iva');
        $crud->display_as('descripcion','Descripción')
             ->display_as('id_proveedor','Proveedor')
             ->display_as('id_grupo','Grupo')
             ->display_as('id_proveedor','Proveedor')
             ->display_as('id_categoria','Categoria')
             ->display_as('id_subcategoria','Subcategoria')
             ->display_as('id_estado','Estado');
        $crud->fields(	'cod_proveedor',
                        'descripcion',
                        'precio_costo',
                        'margen',
                        'iva',
                        'impuesto',
                        'id_proveedor',
                        'id_grupo',
                        'id_categoria',
                        'id_subcategoria');
        $crud->required_fields(	'cod_proveedor',
                        'descripcion',
                        'precio_costo',
                        'margen',
                        'iva',
                        'impuesto',
                        'id_proveedor',
                        'id_grupo',
                        'id_categoria',
                        'id_subcategoria');

        $crud->set_subject('articulo');
        $crud->set_relation('id_proveedor','proveedor','{descripcion}', 'proveedor.id_estado = 1');
        $crud->set_relation('id_grupo','grupo','descripcion', 'grupo.id_estado = 1');
        $crud->set_relation('id_categoria','categoria','descripcion', 'categoria.id_estado = 1');
        $crud->set_relation('id_subcategoria','subcategoria','descripcion', 'subcategoria.id_estado = 1');
        $crud->set_relation('id_estado','estado','estado');

        $_COOKIE['tabla']='articulo';
        $_COOKIE['id']='id_articulo';

        $crud->callback_after_insert(array($this, 'insert_log'));
        $crud->callback_after_insert(array($this, 'actualizar_precios'));
        $crud->callback_after_update(array($this, 'update_log'));
        $crud->callback_after_update(array($this, 'actualizar_precios'));
        $crud->callback_delete(array($this,'delete_log'));

        $this->permisos_model->getPermisosCRUD('permiso_articulo', $crud);

        $output = $crud->render();

        $this->viewCrud($output);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Actualizar precios, ver como sacar variacion

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function actualizar_precios($datos, $id) {
        $articulo = getArticulosWhitDetail($id);
        $this->articulo_model->updatePrecios($articulo);

	    return true;
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Actualizar precios Lote

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

 	public function actualizar_precios_lote() {

        $db['proveedores']	= $this->proveedores_model->select();
        $db['grupos']		= $this->grupos_model->select();
        $db['categorias']	= $this->categorias_model->select();
        $db['subcategorias']= $this->subcategorias_model->select();

        if($this->input->post('buscar')) {
            $datos = array(
                'proveedor'		=> $this->input->post('proveedor'),
                'grupo'			=> $this->input->post('grupo'),
                'categoria'		=> $this->input->post('categoria'),
                'subcategoria'	=> $this->input->post('subcategoria'),
                'variacion'		=> $this->input->post('variacion'),
                'id_estado'		=> 1,
                'date_upd'		=> date('Y:m:d H:i:s')
            );

            $db['articulos']	= $this->articulos_model->getArticulosWhitDetail($datos);
            $db['mensaje']		= "Cantidad de articulos a actualizar: ".count($db['articulos']);
            $db['class']		= "hide";

            if($this->input->post('confirmar')) {
                $this->actualizaciones_precion_model->insert($datos);

                $this->articulos_model->updatePrecios($db['articulos'], $datos);

                $db['articulos']	= $this->articulos_model->getArticulosWhitDetail($datos);
                $db['mensaje']		= "Los articulos se han actualizado";
            }
        } else {
            $db['class']		= "show";
            $db['actualizaciones']=$this->actualizaciones_precion_model->select();
        }

        $views = array(
            'actualizar precios_lote',
            'calendarios/config_actualizar');

        $this->view($db, $views);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Trae todos los ariculos y los formatea en json

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function getArticulos() {
		$filtro = $this->input->get('term', TRUE);
		
		$db['articulos'] = $this->articulos_model->getArticulos($filtro);
		
		$row_set = array();
		if($db['articulos']){
			foreach ($db['articulos'] as $articulo) {
				$row['value']	= stripslashes(utf8_encode($articulo->descripcion));
				$row['id']		= (int)$articulo->id_articulo;
				$row['iva']		= (float)$articulo->iva;
				$row['precio']	= (float)$articulo->precio_venta_sin_iva_con_imp;
				$row_set[]		= $row;
			}
		}
		

		echo json_encode($row_set);
	}
}