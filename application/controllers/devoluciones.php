<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Devoluciones extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		$this->load->model('articulos_model');
		$this->load->model('devoluciones_model');
		$this->load->model('devoluciones_detalle_model');
		$this->load->model('clientes_model');
		$this->load->model('proveedores_model');
		$this->load->model('grupos_model');
		$this->load->model('categorias_model');
		$this->load->model('subcategorias_model');
		$this->load->model('presupuestos_model');
		$this->load->model('remitos_model');
		$this->load->model('remitos_detalle_model');
		$this->load->model('renglon_presupuesto_model');
		$this->load->model('config_impresion_model');
		
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		
	}

 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Generar las devoluciones
 * 
 * ********************************************************************************
 **********************************************************************************/

	function devoluciones_abm()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('devolucion');
			
		$crud->order_by('id_devolucion','desc');
			
		$crud->columns('id_devolucion', 'fecha', 'monto', 'id_presupuesto', 'nota','id_estado');
			
		$crud->display_as('id_devolucion','ID')
			 ->display_as('id_presupuesto','Presupuesto')
			 ->display_as('id_estado','Estado');
			 
		$crud->set_subject('devolución');
		/*
		$crud->required_fields('descripcion','id_estado');
		 */ 
		//$crud->set_relation('id_cliente','presupuesto','{nombre} {apellido}');
		$crud->set_relation('id_estado','estado_devolucion','estado');
		//$crud->set_relation('tipo','tipo','tipo');
			
		$_COOKIE['tabla']='devolucion';
		$_COOKIE['id']='id_devolucion';	
			
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
			
		$crud->callback_after_insert(array($this, 'insert_log'));
		$crud->callback_after_update(array($this, 'update_log'));
		$crud->callback_delete(array($this,'delete_log'));	
		//$crud->add_action('Detalle', '', '','icon-exit', array($this, 'buscar_presupuestos'));
			
			
		$output = $crud->render();

		$this->_example_output($output);
	}
 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Generar las devoluciones
 * 
 * ********************************************************************************
 **********************************************************************************/

	function generar($id)
	{
		if($this->session->userdata('logged_in')){
			$db['texto']				= getTexto();			
			$db['presupuestos']			= $this->presupuestos_model->getRegistro($id);
			
			$condicion = array(
				'id_presupuesto'	=> $id,
				'estado'			=> 1
			);
			$db['detalle_presupuesto']	= $this->renglon_presupuesto_model->getDetalle_where($condicion, 'AND');
			
			$this->load->view('head.php',$db);
			$this->load->view('menu.php');
			$this->load->view('devoluciones/generar.php');
			$this->load->view('footer.php');
		}else{
			redirect('/','refresh');
		}
	}

 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Insert las devoluciones
 * 
 * ********************************************************************************
 **********************************************************************************/

	function insert()
	{
		$id_presupuesto = $this->input->post('presupuesto');
				
		$detalle_presupuesto = $this->renglon_presupuesto_model->getDetalle($id_presupuesto);
		
		$session_data = $this->session->userdata('logged_in');
		
		$registro = array(
			'id_presupuesto'	=> $id_presupuesto,
			'fecha'				=> date('Y/m/d H:i:s'),
			'a_cuenta'			=> 0,
			'nota'				=> $this->input->post('nota'), 
			'id_usuario'		=> $session_data['id_usuario'],
			'id_estado'			=> 1
		);
		
		$id_devolucion = $this->devoluciones_model->insert($registro);
		
		$monto_devolucion = 0;	
		foreach ($detalle_presupuesto as $row)
		{
			if($this->input->post($row->id_renglon) > 0)
			{
				$precio = $row->precio / $row->cantidad;
				$monto = $this->input->post($row->id_renglon) * $precio;
				
				$registro = array(
					'id_devolucion'		=> $id_devolucion,
					'id_articulo'		=> $row->id_articulo,
					'cantidad'			=> $this->input->post($row->id_renglon),
					'monto'				=> $monto
				);
				
				$monto_devolucion = $monto_devolucion + $monto;
				
				$this->devoluciones_detalle_model->insert($registro);
				
				$registro = array(
					'estado'	=> 2
				);
				
				$this->renglon_presupuesto_model->update($registro, $row->id_renglon);
			}	
		}
		$registro = array(
			'monto'		=> $monto_devolucion
		);
		
		$this->devoluciones_model->update($registro, $id_devolucion);
		
		redirect('/devoluciones/devoluciones_abm/','refresh');
		
	}

}