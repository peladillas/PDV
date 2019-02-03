<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendarios extends My_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		$this->load->model('calendarios_model');
		
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		

	}

 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD CATEGORIA
 * 
 * ********************************************************************************
 **********************************************************************************/

	
	public function index()
	{
		if($this->session->userdata('logged_in')){
			$crud = new grocery_CRUD();
		
			$crud->where('calendario.id_estado = 1');
			$crud->set_table('calendario');
			$crud->columns('title', 'start', 'end');
			
			$crud->display_as('title','Descripción')
				 ->display_as('start','Comienzo')
				 ->display_as('end','Final')
				 ->display_as('id_color','Color');
			
			$crud->set_subject('calendario');
			
			$crud->required_fields('title','start', 'end', 'id_color');
			$crud->set_relation('id_color','color','color');
			$crud->callback_column('title',array($this,'_setcolor'));
			
			$crud->fields('title','start', 'end', 'id_color');
				
			$output = $crud->render();
			
			$db['calendarios'] = $this->calendarios_model->getCalendarios();
			
			$this->load->view('head', $db);
			$this->load->view('menu', $output);
			$this->load->view('calendarios/view');
			$this->load->view('calendarios/config');
			$this->load->view('footer');
		}else{
			redirect('/','refresh');
		}
	}
	
	function _setcolor($value, $row)
	{
		$query = $this->db->query("SELECT backgroundColor FROM color INNER JOIN calendario ON (color.id_color = calendario.id_color) WHERE id_calendario = '$row->id_calendario' ");
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $fila)
			{
				$backgroundColor = $fila->backgroundColor;
			}
		}
		
				
		return '<p style="background: #'.$backgroundColor.'; color: #fff;font-size: .75em;padding: 0 1px;border-radius:3px">'.$row->title.'</p>';
		
	}

}