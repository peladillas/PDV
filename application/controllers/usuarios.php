<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends MY_Controller {

	public function __construct() {
		parent::__construct();

        $this->load->model('usuarios_model');

		$this->load->library('grocery_CRUD');
	}

/**********************************************************************************
 **********************************************************************************
 *
 * 				Login usuarios
 *
 * ********************************************************************************
 **********************************************************************************/

    function index() {
        $this->load->helper(array('form'));
        $this->load->view('head');
        $this->load->view('usuarios/login');
    }

/**********************************************************************************
 **********************************************************************************
 *
 * 				Verifica que el login este ok
 *
 * ********************************************************************************
 **********************************************************************************/

    function verifyLogin(){
        //This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

        if($this->form_validation->run() == FALSE){
            //Field validation failed.  User redirected to login page
            $this->load->view('head.php');
            $this->load->view('usuarios/login');
        }else{
            //Go to private area
            redirect('/home/','refresh');
        }
    }

/**********************************************************************************
 **********************************************************************************
 *
 * 				Verifica que el login este ok
 *
 * ********************************************************************************
 **********************************************************************************/


    function check_database($password){
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');
        //query the database
        $result = $this->usuarios_model->login($username, $password);

        if($result) {
            $sess_array = array();
            $ci = & get_instance();
            foreach($result as $row)
            {
                $sess_array = array(
                    'id_usuario' => $row->id_usuario,
                    'usuario' => $row->descripcion
                );
            }

            $this->session->unset_userdata('logged_in');
            $this->session->set_userdata('logged_in', $sess_array);

            return TRUE;
        }else{
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD USUARIO
 * 
 * ********************************************************************************
 **********************************************************************************/

	public function usuario_abm() {
		$crud = new grocery_CRUD();

		$crud->where('usuario.id_estado = 1');
		$crud->set_table('usuario');
		$crud->columns('descripcion','id_rol');
		$crud->display_as('descripcion','Descripción')
			 ->display_as('id_rol','Rol')
			 ->display_as('id_estado','Estado');
		$crud->set_subject('usuario');
		$crud->required_fields('descripcion','pass', 'id_rol');
		$crud->fields('descripcion','pass', 'id_rol');
		$crud->set_relation('id_rol','rol','descripcion', 'rol.id_estado = 1');
		$crud->set_relation('id_estado','estado','estado');
			
		$_COOKIE['tabla']= 'usuario';
		$_COOKIE['id']='id_usuario';	
			
		$crud->callback_after_insert(array($this, 'insert_log'));
		$crud->callback_before_insert(array($this,'encrypt_password_insert'));
		$crud->callback_before_update(array($this,'encrypt_password_update'));
		$crud->callback_after_update(array($this, 'update_log'));
		$crud->callback_delete(array($this,'delete_log'));	
		$crud->callback_edit_field('pass',array($this,'edit_field_callback_1'));
			
		$output = $crud->render();

		$this->viewCrud($output);
	}
	
	function encrypt_password_insert($post_array) {
  		$post_array['pass'] = md5($post_array['pass']);
 
		return $post_array;
	}

	function encrypt_password_update($post_array, $primary_key) {
		$post_array['pass'] = md5($post_array['pass']);
 
		return $post_array;
	}

	function edit_field_callback_1($value, $primary_key) {
	    return '<input id="field-pass" name="pass" type="text" value="" maxlength="128" class="form-control">';
	}

/**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD ROLES
 * 
 * ********************************************************************************
 **********************************************************************************/

	public function roles_abm() {
		$crud = new grocery_CRUD();
			
		$crud->where('rol.id_estado = 1');
		$crud->set_table('rol');
		$crud->columns('descripcion');
		$crud->display_as('descripcion','Descripción')
			 ->display_as('id_estado','Estado');
		$crud->set_subject('rol');
		$crud->required_fields('descripcion','permiso_articulo', 'permiso_proveedor', 'permiso_cliente', 'permiso_presupuesto', 'permiso_ctacte');
		$crud->fields('descripcion','permiso_articulo', 'permiso_proveedor', 'permiso_cliente', 'permiso_presupuesto', 'permiso_ctacte');
		$crud->set_relation('permiso_articulo','permiso','descripcion');
		$crud->set_relation('permiso_proveedor','permiso','descripcion');
		$crud->set_relation('permiso_cliente','permiso','descripcion');
		$crud->set_relation('permiso_presupuesto','permiso','descripcion');
		$crud->set_relation('permiso_ctacte','permiso','descripcion');
		$crud->set_relation('id_estado','estado','estado');
			
		$_COOKIE['tabla']='rol';
		$_COOKIE['id']='id_rol';	
			
		$crud->callback_after_insert(array($this, 'insert_log'));
		$crud->callback_after_update(array($this, 'update_log'));
		$crud->callback_delete(array($this,'delete_log'));	
						
		$output = $crud->render();

		$this->viewCrud($output);
	}

}