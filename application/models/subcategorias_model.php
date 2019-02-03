<?php 
class Subcategorias_model extends CI_Model {
	
	function getSubcategorias(){
		$query = $this->db->query("SELECT * FROM subcategoria WHERE subcategoria.id_estado=1 ORDER BY subcategoria.descripcion");
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
