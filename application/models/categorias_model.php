<?php 
class Categorias_model extends MY_Model {

    public function __construct(){
        parent::construct(
        'categoria',
        'id_categoria',
        'descripcion'
        );
    }
} 
?>
