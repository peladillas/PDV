<?php 
class Permisos_model extends CI_Model {
	
	function getPermisosCRUD ($session, $crud) {
		$session_data = $this->session->userdata('logged_in');
		
		$rolQuery = $this->db->query("
		SELECT 
			$session as session 
		FROM 
			rol 
		INNER JOIN 
			usuario ON(rol.id_rol=usuario.id_rol)
		WHERE 
			usuario.id_estado='$session_data[id_usuario]'");

		if($rolQuery->num_rows() > 0) {
			foreach ($rolQuery->result() as $rolRow) {
				$id_permiso = $rolRow->session;
			}
			
			$permisoQuery = $this->db->query("
				SELECT 
					id_permiso 
				FROM 
					permiso 
				WHERE 
				permiso.id_permiso='$id_permiso'");
		
			if($permisoQuery->num_rows() > 0){
				foreach ($permisoQuery->result() as $permisoRow) {
					$id_permiso = $permisoRow->id_permiso;
				}

                switch ($id_permiso) {
                    case 1:	//ver
                        $crud->unset_add();
                        $crud->unset_edit();
                        $crud->unset_delete();
                        break;
                    case 2: //ver, añadir
                        $crud->unset_edit();
                        $crud->unset_delete();
                        break;
                    case 3: //ver, modificar
                        $crud->unset_add();
                        $crud->unset_delete();
                        break;
                    case 4: //ver, añadir modificar
                        $crud->unset_delete();
                        break;
                    case 5: //ver, añadir, modificar, eleminar

                        break;
                    case 6: //Ninguno
                        $crud->unset_read();
                        $crud->unset_add();
                        $crud->unset_edit();
                        $crud->unset_delete();
                        $crud->unset_print();
                        $crud->unset_export();
                        break;
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
