<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ventas extends My_Controller {

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
		$this->load->model('anulaciones_model');
		$this->load->model('intereses_model');
        $this->load->model('vendedores_model');
		
		
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		
	}

 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD Remitos
 * 
 * ********************************************************************************
 **********************************************************************************/

	
	public function remitos_abm()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('remito');
			
		$crud->order_by('id_remito','desc');
			 
		$crud->columns('id_remito','fecha', 'monto','id_cliente');
			
		$crud->display_as('id_cliente','Descripción')
			 ->display_as('id_remito','Número')
			 ->display_as('id_estado','Estado');
			 
		$crud->set_subject('remiro');
		/*
		$crud->required_fields('descripcion','id_estado');
		 */ 
		$crud->set_relation('id_cliente','cliente','{alias} - {nombre} {apellido}');
		$crud->set_relation('id_estado','estado','estado');
			
		$_COOKIE['tabla']='remito';
		$_COOKIE['id']='id_remito';	
			
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_delete();
		
		$crud->callback_after_insert(array($this, 'insert_log'));
		
		$crud->callback_after_insert(array($this, 'insert_log'));
		$crud->callback_after_update(array($this, 'update_log'));
		$crud->callback_delete(array($this,'delete_log'));	
		$crud->add_action('Detalle', '', '','icon-exit', array($this, 'buscar_articulos'));
			
		$output = $crud->render();

		$this->_example_output($output);
	}

	function buscar_articulos($id)
	{
		return site_url('/presupuestos/remito_vista').'/'.$id;	
	}


 /**********************************************************************************
 **********************************************************************************
 * 
 * 				VER Remitos
 * 
 * ********************************************************************************
 **********************************************************************************/
	
	function ver_remito($id){
		$db['remitos'] = $this->remitos_detalle_model->getRemitos($id);
		
		$this->load->view('head.php', $db);
		$this->load->view('menu.php');
		$this->load->view('presupuestos/detalle_remito.php');
		$this->load->view('footer.php');
	}
	

 /**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD Presupuestos
 * 
 * ********************************************************************************
 **********************************************************************************/

	
	public function presupuesto_abm()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('presupuesto');
			
		$crud->order_by('id_presupuesto','desc');
			
		$crud->columns('id_presupuesto', 'fecha', 'monto', 'descuento','id_cliente', 'tipo', 'estado', 'id_vendedor');
			
		$crud->display_as('id_cliente','Cliente')
			 ->display_as('id_presupuesto','Número')
			 ->display_as('id_estado','Estado')
             ->display_as('id_vendedor','Vendedor');
			 
		$crud->set_subject('remiro');
		/*
		$crud->required_fields('descripcion','id_estado');
		 */ 
		$crud->set_relation('id_cliente','cliente','{alias} - {nombre} {apellido}');
		$crud->set_relation('estado','estado_presupuesto','estado');
		$crud->set_relation('tipo','tipo','tipo');
        $crud->set_relation('id_vendedor','vendedor','vendedor');
			
		$_COOKIE['tabla']='remito';
		$_COOKIE['id']='id_remito';	
			
		$crud->unset_read();
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
			
		$crud->callback_after_insert(array($this, 'insert_log'));
		$crud->callback_after_update(array($this, 'update_log'));
		$crud->callback_delete(array($this,'delete_log'));	
		$crud->callback_column('fecha',array($this,'_calcularatraso'));
		$crud->add_action('Detalle', '', '','icon-exit', array($this, 'buscar_presupuestos'));
			
		$output = $crud->render();

		$this->_example_output($output);
	}


	function _calcularatraso($value, $row)
	{
		$query = $this->db->query("SELECT dias_pago FROM config WHERE id_config = 1 ");
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $fila)
			{
				$dias_pago = $fila->dias_pago;
			}
		}
		
		$fecha = date('Y-m-d', strtotime($row->fecha));
		$nuevafecha = strtotime ( '+'.$dias_pago.' day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		
		
		if($nuevafecha < date('Y-m-d') && $row->estado == 1)
		{
			$datetime1 = date_create($fecha);
			$datetime2 = date_create(date('Y-m-d'));
			$interval = date_diff($datetime1, $datetime2);
			
			return '<label class="label label-danger">'.date('d-m-Y', strtotime($row->fecha)).'</label> <span class="badge">'.$interval->format('%R%a días').'</span>';
		}
		else
		{
			return date('d-m-Y', strtotime($row->fecha));
		}
	}


	function buscar_presupuestos($id)
	{
		return site_url('/ventas/detalle_presupuesto').'/'.$id;	
	}


 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Muestra el detalle del presupuesto
 * 
 * ********************************************************************************
 **********************************************************************************/


	function detalle_presupuesto($id, $llamada = NULL)
	{
		if($this->session->userdata('logged_in'))
		{
			$_presupuesto = $this->presupuestos_model->getRegistro($id);
			if($_presupuesto){
				if($this->input->post('interes_tipo')){
				
					foreach ($_presupuesto as $_row) {
						$presupuesto_monto = $_row->monto;
					}
					
					if($this->input->post('interes_tipo') == 'porcentaje'){
						$interes_monto = $presupuesto_monto * $this->input->post('interse_monto') / 100 ;
					}else{
						$interes_monto = $this->input->post('interse_monto');
					}
					
					if($this->input->post('descripcion_monto') == ""){
						$descripcion = date('d-m-Y').' Intereses generados por atraso';
					}else{
						$descripcion = date('d-m-Y').' '.$this->input->post('descripcion_monto');
					}
					
					$interes = array(
						'id_presupuesto'	=> $id,
						'id_tipo'			=> 1,
						'monto'				=> $interes_monto,
						'descripcion'		=> $descripcion,
						'fecha'				=> date('Y-m-d H:i:s'),
						'id_usuario'		=> 1, //agregar nombre de usuario
					);
						
					$this->intereses_model->insert($interes);
						
					$_presupuesto = array(
						'monto'				=> $presupuesto_monto + $interes_monto,
					);
						
					$this->presupuestos_model->update($_presupuesto, $id);
				}
			
				$condicion = array(
					'id_presupuesto' => $id
				);			
				
				$db['texto']				= getTexto();			
				$db['presupuestos']			= $this->presupuestos_model->getRegistro($id);
				$db['detalle_presupuesto']	= $this->renglon_presupuesto_model->getDetalle($id);
				$db['interes_presupuesto']	= $this->intereses_model->getInteres($id);
				$db['impresiones']			= $this->config_impresion_model->getRegistro(2);
				$db['devoluciones']			= $this->devoluciones_model->getBusqueda($condicion);
				$db['anulaciones']			= $this->anulaciones_model->getAnulaciones($id);
				
				if($llamada == NULL)
				{
					$db['llamada'] = FALSE;
					$this->load->view('head.php',$db);
					$this->load->view('menu.php');
					$this->load->view('presupuestos/detalle_presupuestos.php');
					$this->load->view('footer.php');
				}else
				{
					$db['llamada'] = TRUE;
					$this->load->view('head.php',$db);
					$this->load->view('presupuestos/detalle_presupuestos.php');
				}
				
			}else{
				redirect('/','refresh');
			}
		}else{
			redirect('/','refresh');
		}
	}



 /**********************************************************************************
 **********************************************************************************
 * 
 *              CRUD Vendedores
 * 
 * ********************************************************************************
 **********************************************************************************/

    
    public function vendedores_abm()
    {
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

        $this->_example_output($output);
    }
    
    function detalle_vendedor($id){
        return site_url('/estadisticas/mensual').'/'.$id; 
    }

}