<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
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

	
	public function proveedor_abm()
	{
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
			//$crud->callback_after_update(array($this, 'update_log'));
			$crud->callback_delete(array($this,'delete_log'));	

			$this->permisos_model->getPermisos_CRUD('permiso_proveedor', $crud);
			
			$output = $crud->render();

			$this->_example_output($output);
	}


/**********************************************************************************
 **********************************************************************************
 * 
 * 				Actualizaciones de precios
 * 
 * ********************************************************************************
 **********************************************************************************/


public function actualizar_precios($datos, $id){
		$proveedor	= $this->proveedores_model->getProveedor_precio($id);

		foreach ($proveedor as $row) {
			
			$precio_viejo		= $row->precio_costo ;// solo para depurar
			
			$precio_costo		= $row->precio_costo + ($row->precio_costo * ($variacion/100));// FUNCIONA PARA AUMENTOS Y DECREMENTOS POR LA MULTIP(+ * + = +     Y    + * -  = - )
			
			$costo_descuento1	= $precio_costo - ($precio_costo * ($row->descuento /100));
			
			$costo_descuento	= $costo_descuento1-($costo_descuento1*($row->descuento2 /100)); // APLICACION DE 2DO DESC ESCALONADO
			
			//02 - Precio con ganancia
			$precio_venta_sin_iva = $costo_descuento+($costo_descuento*($row->margen /100));
			
			//2.5 - Precio con IMPUESTO 6%
			
			$precio_venta_sin_iva_con_imp = $precio_venta_sin_iva + ( $precio_venta_sin_iva * ( $row->impuesto /100));
			
			//03 - Precio con iva
			$iva		= $row->iva ;
			$margen		= $row->margen ;
			$impuesto	= $row->impuesto ;
			
			$precio_venta_sin_iva_sin_imp=$precio_venta_sin_iva;
			
			$precio_venta_con_iva_con_imp=$precio_venta_sin_iva_con_imp+($precio_venta_sin_iva_sin_imp*($iva/100));// precio c/dto1 c/dto2 s/iva s/imp c/margen +  %iva + %imp(p) 
			
			$id_articulo= $row->id_articulo ;	
			
			$datos=array(
						'precio_costo'			=> $precio_costo,
						'costo_descuento'		=> $costo_descuento,
						'precio_venta_sin_iva'	=> $precio_venta_sin_iva,
						'precio_venta_sin_iva_con_imp'=> $precio_venta_sin_iva_con_imp,
						'precio_venta_iva'		=> $precio_venta_con_iva_con_imp,
						'margen'				=> $margen,
						'impuesto'				=> $impuesto
						);
			$this->articulos_model->update_Articulo($datos, $id_articulo);
			
		}
					
	 
	    return true;
	}
}