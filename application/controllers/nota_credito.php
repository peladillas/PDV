<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nota_credito extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('nota_credito_model');
	}
	
	
/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD Nota Credito
 * 
 * ********************************************************************************
 **********************************************************************************/


	public function index(){
	    $db = [];
		$this->view($db, 'nota_credito/generar.php');
	}

    public function addRegistro(){
	    $nota_credito = [
            'id_cliente' => $this->input->post('id_cliente'),
            'fecha' => $this->input->post('fecha'),
            'monto' => $this->input->post('total_nota_credito'),
        ];

        $id_nota_credito = $this->nota_credito_model->insert($nota_credito);

        $nota_credito_renglon = [
            'id_nota_credito' => $id_nota_credito,
            'id_articulo' => $this->input->post('id_cliente'),
            'cantidad' => $this->input->post('id_cliente'),
            'monto total' => $this->input->post('id_cliente'),
        ];

        $this->nota_credito_renglon_model->insert($nota_credito_renglon);
    }
}