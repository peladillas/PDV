<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadisticas extends My_Controller {

    protected $path = 'estadisticas/';

	function __construct() {
		parent::__construct($this->path);
	   	
        $this->load->model('presupuestos_model');  
		$this->load->model('remitos_model');  
		$this->load->model('devoluciones_model');
        $this->load->model('anulaciones_model');
        $this->load->model('vendedores_model');
        $this->load->model('config_model');

		$this->load->library('grocery_CRUD');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
  
        Ver mas
  
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	function verMas() {
		$config = $this->config_model->select(CONFIGURACIONES::DEFAULT);

    	if($config) {
    		foreach ($config as $fila) {
    			$cantidad = $fila->cantidad;
			}
		}

    	$db['articulos'] = $this->presupuestos_model->get_top($this->input->post('inicio'), $this->input->post('fin'), $cantidad);

		$this->view($db, $this->path.'get_top_cien');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
  
        Anual
  
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	function anual() {
		$ano = ($this->input->post('ano') ? $this->input->post('ano') : date('Y'));

        $db['ano_actual'] = $ano;
		$inicio	= date('01-01-'.$ano);
		$ano += 1;
		$final	= date('01-01-'.$ano);

		$db['presupuestos']	= $this->presupuestos_model->suma_presupuesto($inicio, $final);
		$db['remitos']		= $this->remitos_model->suma_remito($inicio, $final);
		$db['devoluciones']	= $this->devoluciones_model->suma_devolucion($inicio, $final);
		$db['anulaciones']	= $this->anulaciones_model->suma_anulacion($inicio, $final);
		$db['articulos']	= $this->presupuestos_model->get_top($inicio, $final);
		$db['vendedores']   = $this->vendedores_model->select();

		$this->view($db, $this->path.'anual');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
  
        Mensual
  
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	function mensual($id_vendedor = NULL) {
		$ano = ($this->input->post('ano') ? $this->input->post('ano') : date('Y'));
        $mes = ($this->input->post('mes') ? $this->input->post('mes') : date('m'));

		$inicio	= date('01-'.$mes.'-'.$ano);
		$db['mes_actual']	= $mes;
		$db['ano_actual']	= $ano;

		if($mes == 12) {
			$mes = 1;
			$ano += 1;
		} else {
			$mes += 1;
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
			$db['vendedor']  	= $this->vendedores_model->select();
			$db['presupuestos'] = $this->presupuestos_model->suma_presupuesto($inicio, $final, NULL, $id_vendedor);
		} else {
			$db['id_vendedor']  = FALSE;
			$db['vendedor']     = FALSE;
			$db['presupuestos'] = $this->presupuestos_model->suma_presupuesto($inicio, $final);
		}

		$this->view($db, $this->path.'mensual');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
  
        Resumen
  
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	function resumen() {
		if($this->input->post('inicio')) {
			$inicio		= date('d-m-Y', strtotime($this->input->post('inicio')));
			$final		= date('d-m-Y', strtotime($this->input->post('final')));
			$id_cliente	= $this->input->post('id_cliente');
		} else {
			$ano		= date('Y');
			$mes		= date('m');
			$id_cliente	= 0;
			$inicio	= date('01-'.$mes.'-'.$ano);
			$db['mes_actual']	= $mes;
			$db['ano_actual']	= $ano;

			if($mes == 12) {
				$mes = 1;
				$ano += 1;
			} else {
				$mes += 1;
			}

			$final	= date('01-'.$mes.'-'.$ano);
		}


        $db['inicio']		= date('d-m-Y', strtotime($inicio));
        $db['final']		= date('d-m-Y', strtotime($final));
		$db['presupuestos']	= $this->presupuestos_model->suma_presupuesto($inicio, $final, $id_cliente);
		$db['remitos']		= $this->remitos_model->suma_remito($inicio, $final, $id_cliente);
		$db['devoluciones']	= $this->devoluciones_model->suma_devolucion($inicio, $final, $id_cliente);
		$db['anulaciones']	= $this->anulaciones_model->suma_anulacion($inicio, $final, $id_cliente);

		$this->view($db, $this->path.'resumen');
	}
}
?>
