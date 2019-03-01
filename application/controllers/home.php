<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends My_Controller {

    protected $path = 'home/';

	function __construct() {
		parent::__construct($this->path);
	   	
		$this->load->model('remitos_model');
		$this->load->model('articulos_model');
		$this->load->model('calendarios_model');
		$this->load->model('presupuestos_model');
		$this->load->model('clientes_model');
		$this->load->model('renglon_presupuesto_model');
		$this->load->model('proveedores_model');
		
		$this->load->library('grocery_CRUD');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Pantalla inicial

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	function index() {
		$ano = date('Y');
		$mes = date('m');

		$inicio	= date('01-'.$mes.'-'.$ano);

		if($mes == 12) {
			$mes = 1;
			$ano +=  1;
		} else {
			$mes += 1;
		}
		$final = date('01-'.$mes.'-'.$ano);

		$db['presupuestos']	= $this->presupuestos_model->suma_presupuesto($inicio, $final);
		$db['mes_actual']	= $mes;
		$db['ano_actual']	= $ano;
		$db['calendarios']	= $this->calendarios_model->getCalendarios();
		$db['articulos']	= $this->articulos_model->select();
		$db['clientes']		= $this->clientes_model->select();
		$db['remitos']		= $this->remitos_model->select();
		$db['presupuestos_cant']	= $this->presupuestos_model->select();
		$db['presupuestos_detalle']	= $this->renglon_presupuesto_model->Ultimos(10);
		$db['tipos']		= $this->clientes_model->getSumas('tipos');
		$db['condiciones']	= $this->clientes_model->getSumas('condicion');
		$db['proveedores']	= $this->proveedores_model->getTotalArticulos();

		$this->view($db, 'calendarios/config');
	}
}
?>