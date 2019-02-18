<?php

// Mensaje de alerta
function setMensaje($mensaje, $tipo=NULL) {
    if($tipo==NULL) {
        $tipo='info';
    }

    $return =	"<div class='alert alert-$tipo alert-dismissible' role='alert'>
				 		<button type='button' class='close' data-dismiss='alert'>
					 		<span aria-hidden='true'>&times;</span><span class='sr-only'>
					 			Cerrar
					 		</span>
					 	</button>
				  		$mensaje
					</div>";

    return $return;
}

// start del body
function startContent($title, $size = NULL) {
    if($size == NULL){
		$size = 12;
	}

	$html = '<div class="container">';
    $html .= '<div class="col-md-12">';
    $html .= '<div class="panel panel-primary">';
	$html .= '<div class="panel-heading">'.$title.'</div>';
    $html .= '<div class="panel-body">';

    return $html;
}

// end del body
function endContent(){
    $html = '</div></div></div></div>';

    return $html;
}

?>