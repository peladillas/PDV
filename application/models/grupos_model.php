<?php 
class Grupos_model extends CI_Model {
	
	function getGrupos(){
		$query = $this->db->query("SELECT * FROM grupo WHERE grupo.id_estado=1 ORDER BY grupo.descripcion");
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return FALSE;
		}
	}

} 
?>
