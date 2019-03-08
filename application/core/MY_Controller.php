<?php
class MY_Controller extends CI_Controller {

    private $controller;

	public function __construct($_controller) {
	    $this->controller = $_controller;

		parent::__construct();
	}


/**********************************************************************************
 **********************************************************************************
 *
 * 				Vista comun
 *
 * ********************************************************************************
 **********************************************************************************/
	
	public function view($db, $views) {
		if($this->session->userdata('logged_in')) {
			$this->load->view('head.php',$db);
			$this->load->view('menu.php');
			if (is_array($views)) {
			    foreach ($views as $view) {
                    $this->load->view($view);
                }
            } else {
                $this->load->view($views);
            }
			$this->load->view('footer.php');
		} else {
			redirect('/','refresh');
		}
	}

/**********************************************************************************
 **********************************************************************************
 *
 * 				Vista crud
 *
 * ********************************************************************************
 **********************************************************************************/
	
	
	public function viewCrud($output = null){
		if ($this->session->userdata('logged_in')) {
			$this->load->view('head.php', $output);
			$this->load->view('menu.php');
			$this->load->view('body.php');
			$this->load->view('footer.php');
		} else {
			redirect('/','refresh');
		}
	}

/**********************************************************************************
 **********************************************************************************
 *
 * 				Logout
 *
 * ********************************************************************************
 **********************************************************************************/

    function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();

        $this->load->view('head');
        $this->load->view('login_view');
    }

/**********************************************************************************
 **********************************************************************************
 * 
 * 				Funciones logs
 * 
 * ********************************************************************************
 **********************************************************************************/
	

	function insert_log($datos, $id) {
		$session_data = $this->session->userdata('logged_in');
		
	    $registro = array(
	        "tabla"		=> $_COOKIE['tabla'],
	        "id_tabla"	=> $id,
	        "id_accion"	=> ACCIONES::INSERT,
	        "fecha"		=> date('Y-m-d H:i:s'),
	        "id_usuario"=> $session_data['id_usuario']
	    );
	 
	    $this->db->insert('logs',$registro);
		
		$registro =  array(
			"id_estado"=> ESTADOS::ALTA
		);
		
		$this->db->update($_COOKIE['tabla'], $registro, array($_COOKIE['id'] => $id));
	 
	    return true;
	}
	
	
	function update_log($datos, $id) {
		$session_data = $this->session->userdata('logged_in');
		
    	$registro = array(
	        "tabla"		=> $_COOKIE['tabla'],
	        "id_tabla"	=> $id,
	        "id_accion"	=> ACCIONES::UPDATE,
	        "fecha"		=> date('Y-m-d H:i:s'),
	        "id_usuario"=> $session_data['id_usuario']
	    );
 
    	$this->db->insert('logs',$registro);
 
    	return true;
	}
	
	
	public function delete_log($id) {
    	$session_data = $this->session->userdata('logged_in');
		
		$registro = array(
	        "tabla"		=> $_COOKIE['tabla'],
	        "id_tabla"	=> $id,
	        "id_accion"	=> ACCIONES::DELETE,
	        "fecha"		=> date('Y-m-d H:i:s'),
	        "id_usuario"=> $session_data['id_usuario']
	    );
 
    	$this->db->insert('logs',$registro);
			
    	return $this->db->update($_COOKIE['tabla'], array('id_estado' => ESTADOS::BAJA), array($_COOKIE['id'] => $id));
	}

/*---------------------------------------------------------------------------------
 ----------------------------------------------------------------------------------
 
  				Funciones para filtros 
 
 ----------------------------------------------------------------------------------
 ---------------------------------------------------------------------------------*/

    public function getFilters() {
        $filtro = $this->input->get('term', TRUE);

        $this->load->model('documents_CRUD_Model');
		$registros = $this->documents_CRUD_Model->getFilters($this->controller, $filtro);
        
        echo json_encode($registros);
    }
	
/*---------------------------------------------------------------------------------
 ----------------------------------------------------------------------------------
 
  				Funciones para filtros 
 
 ----------------------------------------------------------------------------------
 ---------------------------------------------------------------------------------*/

    public function insert() {
        $postData = $this->input->post();
		
		$this->load->model('documents_CRUD_Model');
		$registros = $this->documents_CRUD_Model->insert($postData);
		
		echo json_encode($registros);
    }

}
