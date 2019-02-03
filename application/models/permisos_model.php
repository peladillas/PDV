<?php 
class Permisos_model extends CI_Model {
	
	function getPermisos_CRUD($session, $crud){
		$session_data = $this->session->userdata('logged_in');
		
		$query = $this->db->query("SELECT $session as session 
									FROM rol 
									INNER JOIN usuario ON(rol.id_rol=usuario.id_rol)
									WHERE usuario.id_estado='$session_data[id_usuario]'");
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$id_permiso=$row->session;
			}
			
			$query2 = $this->db->query("SELECT id_permiso 
									FROM permiso 
									WHERE permiso.id_permiso='$id_permiso'");
		
			if($query2->num_rows() > 0){
				foreach ($query2->result() as $fila) {
					$id_permiso=$fila->id_permiso;
				}
				if($id_permiso==1){				//ver
					$crud->unset_add();
					$crud->unset_edit();
					$crud->unset_delete();	
				}else if($id_permiso==2){		//ver, añadir
					$crud->unset_edit();
					$crud->unset_delete();	
				}if($id_permiso==3){			//ver, modificar
					$crud->unset_add();
					$crud->unset_delete();	
				}if($id_permiso==4){			//ver, añadir modificar
					$crud->unset_delete();	
				}if($id_permiso==5){			//ver, añadir, modificar, eleminar
	
				}if($id_permiso==6){			//Ninguno
					$crud->unset_read();
					$crud->unset_add();
					$crud->unset_edit();
					$crud->unset_delete();	
					$crud->unset_print();
					$crud->unset_export();	
				}
				
				
				return $crud;
				
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
		
		
	}
	
} 
?>
