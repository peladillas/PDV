<?php 
class Grupos_model extends My_Model {

    public function __construct(){
        parent::construct(
        'grupo',
        'id_grupo',
        'descripcion'
        );
    }
} 
?>
