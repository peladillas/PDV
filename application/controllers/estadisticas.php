<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Estadisticas extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	   	
        $this->load->model('presupuestos_model');  
		$this->load->model('remitos_model');  
		$this->load->model('devoluciones_model');
        $this->load->model('anulaciones_model');
        $this->load->model('vendedores_model');
			
        $this->load->database();
		$this->load->library('grocery_CRUD');  
		$this->load->helper('url');
	}


/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
  
        Ver mas
  
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    
	function verMas()
	{
		if($this->session->userdata('logged_in')) {
			$query = $this->db->query("SELECT cantidad FROM config WHERE id_config = 1 ");
    		
    		if($query->num_rows() > 0) {
    			foreach ($query->result() as $fila) {
    				$cantidad = $fila->cantidad;
    			}
    		}	
    			
    		$db['articulos']	= $this->presupuestos_model->get_top($this->input->post('inicio'), $this->input->post('fin'), $cantidad);
    		
    		$this->load->view('head.php', $db);
    		$this->load->view('menu.php');
    		$this->load->view('get_top_cien.php');
    		$this->load->view('footer.php');
		} else {
			redirect('/','refresh');
		}
	}


/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
  
        Anual
  
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	
	function anual()
	{
		if($this->session->userdata('logged_in')){
			$db['texto']	= getTexto();
			
			if($this->input->post('ano')) {
				$ano	= $this->input->post('ano');
			} else {
				$ano	= date('Y');
			}
            
			$db['ano_actual']	= $ano;
			
			$inicio	= date('01-01-'.$ano);
			$ano = $ano + 1;
			$final	= date('01-01-'.$ano);
			
			$db['presupuestos']	= $this->presupuestos_model->suma_presupuesto($inicio, $final);
			$db['remitos']		= $this->remitos_model->suma_remito($inicio, $final);
			$db['devoluciones']	= $this->devoluciones_model->suma_devolucion($inicio, $final);
			$db['anulaciones']	= $this->anulaciones_model->suma_anulacion($inicio, $final);
			$db['articulos']	= $this->presupuestos_model->get_top($inicio, $final);
            $db['vendedores']   = $this->vendedores_model->getRegistros();
			$this->load->view('head.php', $db);
			$this->load->view('menu.php');
			$this->load->view('estadisticas/anual.php');
			$this->load->view('footer.php');
		}else{
			redirect('/','refresh');
		}
	}
    

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
  
        Mensual
  
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
    
	
	function mensual($id_vendedor = NULL)
	{
	    if($this->session->userdata('logged_in')){
		
			$db['texto']	= getTexto();
			
			if($this->input->post('mes')) {
				$ano	= $this->input->post('ano');
				$mes	= $this->input->post('mes');
			} else {
				$ano	= date('Y');
				$mes	= date('m');
			}
            
			$inicio	= date('01-'.$mes.'-'.$ano);
			
			$db['mes_actual']	= $mes;
			$db['ano_actual']	= $ano;
			
			if($mes == 12) {
				$mes = 1;
				$ano = $ano + 1;
			} else {
				$mes = $mes + 1;
			}
			$final	= date('01-'.$mes.'-'.$ano);
			
			$db['remitos']		= $this->remitos_model->suma_remito($inicio, $final);
			$db['devoluciones']	= $this->devoluciones_model->suma_devolucion($inicio, $final);
			$db['anulaciones']	= $this->anulaciones_model->suma_anulacion($inicio, $final);
			$db['articulos']	= $this->presupuestos_model->get_top($inicio, $final);
			$db['inicio']		= $inicio;
			$db['fin']			= $final;
            if($id_vendedor != NULL){
                $db['id_vendedor']  = $id_vendedor;    
                $db['vendedor']  = $this->vendedores_model->getRegistros();
                $db['presupuestos'] = $this->presupuestos_model->suma_presupuesto($inicio, $final, NULL, $id_vendedor);
            } else {
                $db['id_vendedor']  = FALSE;  
                $db['vendedor']     = FALSE;  
                $db['presupuestos'] = $this->presupuestos_model->suma_presupuesto($inicio, $final);
            }
			
			$this->load->view('head.php', $db);
			$this->load->view('menu.php');
			$this->load->view('estadisticas/mensual.php');
			$this->load->view('footer.php');
		}else{
			redirect('/','refresh');
		}
	}


/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
  
        Resumen
  
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	
	function resumen()
	{
		if($this->session->userdata('logged_in')){
			$db['texto']	= getTexto();
			
			if($this->input->post('inicio'))
			{
				$inicio		= date('d-m-Y', strtotime($this->input->post('inicio')));
				$final		= date('d-m-Y', strtotime($this->input->post('final')));
				$id_cliente	= $this->input->post('id_cliente');
				
				$db['inicio']		= date('d-m-Y', strtotime($inicio));
				$db['final']		= date('d-m-Y', strtotime($final));
			}
			else
			{
				$ano		= date('Y');
				$mes		= date('m');
				$id_cliente	= 0;
				$inicio	= date('01-'.$mes.'-'.$ano);
				$db['mes_actual']	= $mes;
				$db['ano_actual']	= $ano;
				
				if($mes == 12)
				{
					$mes = 1;
					$ano = $ano + 1;
				}
				else
				{
					$mes = $mes + 1;
				}
				
				$final	= date('01-'.$mes.'-'.$ano);
				
				$db['inicio']		= date('m-Y', strtotime($inicio));
				$db['final']		= date('m-Y', strtotime($final));
			}
			
			$db['presupuestos']	= $this->presupuestos_model->suma_presupuesto($inicio, $final, $id_cliente);
			$db['remitos']		= $this->remitos_model->suma_remito($inicio, $final, $id_cliente);
			$db['devoluciones']	= $this->devoluciones_model->suma_devolucion($inicio, $final, $id_cliente);
			$db['anulaciones']	= $this->anulaciones_model->suma_anulacion($inicio, $final, $id_cliente);
			
			$this->load->view('head.php', $db);
			$this->load->view('menu.php');
			$this->load->view('estadisticas/resumen.php');
			$this->load->view('footer.php');
		}else{
			redirect('/','refresh');
		}
	}


/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
  
        Logout?
  
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
	
	
	function logout()
	{
		$this->session->unset_userdata('logged_in');
	  	session_destroy();
	  	// $this->load->helper(array('form'));
		$this->load->view('head');
	   	$this->load->view('login_view');
	 }

}

?>
