<?php

/* -------------------------------------------------------------------------------
INDICE

- setMensaje	       	Mensaje de alerta
- startContent     		Start del body
- endContent 			End del body
- startTable            Comienza las tablas
- endTable              Finaliza las tablas
- setTableContent       Para agregar lineas en la tabla
- setDatatables			Carga las opciones del datatables, traduccion.
- setFormGroup          Carga los elementos del formulario

  -------------------------------------------------------------------------------*/

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


function endContent(){
    $html = '</div></div></div></div>';

    return $html;
}


function startTable($cabeceras = NULL, $id_table = NULL, $class = NULL) {
    if ($id_table == NULL) {
        $id_table = 'table_registros';
    }

    $table =
        '<table class="table table-hover table-responsive dataTable '.$class.'" id="'.$id_table.'">';

    if($cabeceras !== NULL) {
        $table .=
            '<thead> <tr class="success">';
        foreach ($cabeceras as $cabecera) {
            if(is_array($cabecera)){
                foreach ($cabecera as $key => $value) {
                    $table .= '<th title="'.$key.'">'.$value.'</th>';
                }
            }else{
                $table .= '<th>'.$cabecera.'</th>';
            }
        }
        $table .= '</tr> </thead>';
    }

    $table .= '<tbody>';

    return $table;
}


function endTable($cabeceras = NULL) {
    $table = '';

    if ($cabeceras != NULL) {
        $table .= '<tfoot> <tr>';
        foreach ($cabeceras as $cabecera) {
            if(is_array($cabecera)){
                foreach ($cabecera as $key => $value) {
                    $table .= '<th title="'.$key.'">'.$value.'</th>';
                }
            }else{
                $table .= '<th>'.$cabecera.'</th>';
            }
        }
        $table .= '</tr> </tfoot>';
    }

    $table .= '</tbody> </table>';

    return $table;
}


function setTableContent($registros, $class = NULL) {
    if($class != NULL) {
        $content = '<tr class="'.$class.'">';
    } else {
        $content = '<tr>';
    }

    foreach ($registros as $registro) {
        if (is_array($registro)) {
            foreach ($registro as $key => $value) {
                $content .= '<td title="'.$key.'">'.$value.'</td>';
            }
        }else{
            $content .= '<td>'.$registro.'</td>';
        }
    }

    $content .= '</tr>';

    return $content;
}


function setDatatables($id_table = NULL, $order = NULL, $url = NULL)
{
    if($id_table == NULL){
        $id_table = 'table_registros';
    }

    $cor = '"';

    $filtro = " $('#".$id_table." tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input class=".$cor."form-control input-sm search-column".$cor." type=".$cor."text".$cor." placeholder=".$cor."'+title+'".$cor." style=".$cor."width: 75%".$cor.";/>' );
    } );; ";

    $data = '';
    $data .=
        '<script>
		$(function () {
			'.$filtro.'
			 
        	var table = $("#'.$id_table.'").DataTable({';

    if($url != NULL){ // Carga de datos en ajax
        $data .=
            'ajax: {
	            url: "'.$url.'",
	            type: "POST"
	        }, ';
    }

    $data .= '	
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        	"language": {
		        "sProcessing":    "Procesando...",
		        "sLengthMenu":    "Mostrar _MENU_ registros",
		        "sZeroRecords":   "No se encontraron resultados",
		        "sEmptyTable":    "Ningún dato disponible en esta tabla",
		        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
		        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
		        "sInfoPostFix":   "",
		        "sSearch":        "Buscar:",
		        "sUrl":           "",
		        "sInfoThousands":  ",",
		        "sLoadingRecords": "Cargando...",
		        "oPaginate": {
		            "sFirst":   "Primero",
		            "sLast":    "Último",
		            "sNext":    "Siguiente",
		            "sPrevious":"Anterior"
		        },
		        "oAria": {
		            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		        }
   	 		}'; // Opciones de la libreria, contenido en español

    if($order != NULL){ // Orden inicial de la tabla
        if(is_array($order)){
            if(isset($order[1]) && $order[1] != 'asc'){
                $data .= ', "order": [[ '.$order[0].', "desc" ]]';
            }else{
                $data .= ', "order": [[ '.$order[0].', "asc"  ]]';
            }
        }else{
            $data .= ', "order": [[ '.$order.' , "asc" ]]';
        }

    }
    $data .= '});';

    $data .= 'window.getTable = function() { return table; };';

    $data .=  "table.columns().every( function () {
	        var that = this;
	 
	        $( 'input.search-column', this.footer() ).on( 'keyup change', function () {
	            if ( that.search() !== this.value ) {
	                that
	                    .search( this.value )
	                    .draw();
	            }
	        } );
	    } );
	} );"; // filtros en footer de la tabla


    $data .= '</script>';
    return $data;
}

function setFormGroup($name, $value = NULL, $tags = NULL){
    if ($value == NULL) {
       $value = '';
    }


    if(is_array($tags)) {
        $htmlTags = '';
        foreach ($tags as $tag) {
            $htmlTags .= ' '.$tag;
        }
    } else {
        $htmlTags = $tags;
    }

    $html = '<div class="form-group">';
    $html .= '<label for="'.$name.'">'.lang($name).'</label>';
    $html .= '<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.$value.'" '.$htmlTags.'>';
    $html .= '</div>';

    return $html;
}

?>