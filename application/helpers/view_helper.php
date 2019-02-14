<?php
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

?>