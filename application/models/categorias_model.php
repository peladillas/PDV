<?php 
class Categorias_model extends CI_Model {
	
	function getCategorias(){
		$query = $this->db->query("SELECT * FROM categoria WHERE categoria.id_estado = 1 ORDER BY categoria.descripcion");
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
