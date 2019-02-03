<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	   	
		$this->load->model('remitos_model');
		$this->load->model('articulos_model');
		$this->load->model('calendarios_model');
		$this->load->model('presupuestos_model');
		$this->load->model('clientes_model');
		$this->load->model('renglon_presupuesto_model');
		$this->load->model('proveedores_model');
		
		$this->load->library('grocery_CRUD');  
		$this->load->helper('url');
	
	}
	
	
	function index()
	{
		if($this->session->userdata('logged_in')){
			$ano	= date('Y');
			$mes	= date('m');
			
			$inicio	= date('01-'.$mes.'-'.$ano);
			
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
			
			$db['presupuestos']	= $this->presupuestos_model->suma_presupuesto($inicio, $final);
			$db['mes_actual']	= $mes;
			$db['ano_actual']	= $ano;
			$db['calendarios']	= $this->calendarios_model->getCalendarios();
			$db['articulos']	= $this->articulos_model->getRegistros();
			$db['clientes']		= $this->clientes_model->getRegistros();
			$db['remitos']		= $this->remitos_model->getRegistros();
			$db['presupuestos_cant']	= $this->presupuestos_model->getBusqueda('*');
			$db['presupuestos_detalle']	= $this->renglon_presupuesto_model->Ultimos(10);
			$db['tipos']		= $this->clientes_model->getSumas('tipos');
			$db['condiciones']	= $this->clientes_model->getSumas('condicion');
			$db['proveedores']	= $this->proveedores_model->getTotalArticulos();
				
			$this->load->view('head.php', $db);
			$this->load->view('menu.php');
			$this->load->view('home.php');
			$this->load->view('calendarios/config');
			$this->load->view('footer.php');
		}else{
			redirect('/','refresh');
		}
	}
	
	
	
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
