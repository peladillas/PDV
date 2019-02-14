<?php 
class Grupos_model extends CI_Model {

    public function __construct(){

        parent::construct(
            'grupo',
            'id_grupo',
            'descripcion', //ver si esto esta bien
            'descripcion'
        );
    }
} 
?>
