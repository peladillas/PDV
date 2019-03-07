<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendarios extends My_Controller {

    protected $path = 'calendarios/';

	public function __construct() {
		parent::__construct($this->path);

		$this->load->model('calendarios_model');
        $this->load->model('colores_model');

		$this->load->library('grocery_CRUD');
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Calendarios CRUD

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function index() {
        $crud = new grocery_CRUD();

        $crud->where('calendario.id_estado = '.ESTADOS::ALTA);
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

        $db['output'] = $crud->render();
        $db['calendarios'] = $this->calendarios_model->getCalendarios();

        $views = array(
            $this->path.'view',
            $this->path.'config',
        );

        $this->view($db, $views);
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Color de fondo en el calendario

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	function _setcolor($value, $row) {
		$rows = $this->colores_model->getColores($row->id_calendario);
		
		if($rows) {
			foreach ($rows as $fila) {
				$backgroundColor = $fila->backgroundColor;
			}
		}
				
		return '<p style="background: #'.$backgroundColor.'; color: #fff;font-size: .75em;padding: 0 1px;border-radius:3px">'.$row->title.'</p>';
	}
}