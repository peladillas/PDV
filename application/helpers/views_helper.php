<?php

/* -------------------------------------------------------------------------------
INDICE

- setJs	       	        Arma el html para las js
- setCss                Arma el html para las css
- setMensaje	       	Mensaje de alerta
- startContent     		Start del body
- endContent 			End del body
- startTable            Comienza las tablas
- endTable              Finaliza las tablas
- setTableContent       Para agregar lineas en la tabla
- setDatatables			Carga las opciones del datatables, traduccion.
- setFormGroup          Carga los elementos del formulario
- setLinkMenu           Carga un item de menu
- dividerMenu           Carga divisor para menus
- dropdownMenu          Conjunto de itemes para el menu
- setIcon               Para cargar html de un icon
- setEmphasis           Block de items para estadisticas
- setBigEmphasis        Block grande de items para estadisticas
- setButton             Carga de button
- setHiddenInput        Input hidden

  -------------------------------------------------------------------------------*/

function setJs($js) {
    $src = base_url().'libraries/'.$js;

    return '<script src="'.$src.'" charset="utf-8" type="text/javascript"></script> ';
}

function setCss($css){
    $href = base_url().'libraries/'.$css;

    return '<link href="'.$href.'" rel="stylesheet"> ';
}

function setMensaje($mensaje, $tipo=NULL) {
    $tipo = ($tipo == NULL ? 'info' : $tipo);

    $return = "<div class='alert alert-$tipo alert-dismissible' role='alert'>";
    $return .= "<button type='button' class='close' data-dismiss='alert'>";
    $return .= "<span aria-hidden='true'>&times;</span><span class='sr-only'>";
    $return .= lang('cerrar');
    $return .= "</span>";
    $return .= "</button>";
    $return .= $mensaje;
    $return .= "</div>";

    return $return;
}


function startContent($title, $size = NULL) {
    $size = ($size == NULL ? 12 : $size);

	$html = '<div class="container">';
    $html .= '<div class="col-md-'.$size.'">';
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
    $id_table = ($id_table == NULL ? 'table_registros' : $id_table) ;

    $table = '<table class="table table-hover table-responsive dataTable '.$class.'" id="'.$id_table.'">';

    if($cabeceras !== NULL) {
        $table .=
            '<thead> <tr class="success">';
        foreach ($cabeceras as $cabecera) {
            if (is_array($cabecera)) {
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
    $content = ($class != NULL ? '<tr class="'.$class.'">' : '<tr>');

    foreach ($registros as $registro) {
        if (is_array($registro)) {
            foreach ($registro as $key => $value) {
                $content .= '<td title="'.$key.'">'.$value.'</td>';
            }
        } else {
            $content .= '<td>'.$registro.'</td>';
        }
    }

    $content .= '</tr>';

    return $content;
}


function setDatatables($id_table = NULL, $order = NULL, $url = NULL) {
    $id_table = ($id_table == NULL ? 'table_registros' : $id_table);

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
    $value = ($value == NULL ? '' : $value);

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


function setSelectGroup($name, $values, $selected = NULL){
    $html = '<div class="form-group">';
    $html .= '<label for="'.$name.'">'.lang($name).'</label>';
    $html .= '<select class="form-control" name="'.$name.'" id="'.$name.'">';
    foreach ($values as $key => $value){
        $html .= '<option value="'.$key.'"  '.($selected == $key ? 'selected' : '').'>'.$value.'</option>';
    }
    $html .= '</select>';
    $html .= '</div>';

    return $html;
}

function setLinkMenu($link, $menu){
    return '<li><a  href="'.site_url($link).'" >'.$menu.'</a></li>';
}

function dividerMenu(){
    return '<li class="divider"></li>';
}

function dropdownMenu($menu, $dropdownMenu, $icon){
    $html = '<li class="dropdown">';
    $html .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown"> '.setIcon($icon).' '.strtoupper($menu).'</a>';
    $html .= '<ul class="dropdown-menu">';
    foreach ($dropdownMenu as $linkMenu){
        $html .= $linkMenu;
    }
    $html .= '</ul>';
    $html .= '</li>';

    return $html;
}
function serverClock($menu, $dropdownMenu, $icon){
    $html = '<li class="dropdown">';
    $html .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.setIcon($icon."  ").' <span id="serverClock"> '.strtoupper($menu).'</span></a>';
    $html .= '<ul class="dropdown-menu">';
    foreach ($dropdownMenu as $linkMenu){
        $html .= strtoupper($linkMenu);
    }
    $html .= '</ul>';
    $html .= '</li>';

    return $html;
}
function setIcon($icon){
    return '<i class="fa fa-'.$icon.'"></i>';
}

function setEmphasis($class, $value, $title){
    $html = '<div class="col-xs-12 col-sm-4 emphasis">';
    $html .= '<div class="small-box bg-'.$class.'">';
    $html .= '<div class="inner"><h4>'.$value.'</h4></div>';
    $html .= '<a href="#" class="small-box-footer">'.$title.'</a>';
    $html .= '</div></div>';

    return $html;
}

function setBigEmphasis($class, $value, $title, $icon, $link){
    $html = '<div class="col-xs-12 col-sm-3 emphasis">';
    $html .= '<div class="small-box bg-'.$class.'">';
    $html .= '<div class="inner"><h3>'.$value.'</h3></div>';
    $html .= '<div class="inner">';
    $html .= '<h3>'.$value.'</h3>';
    $html .= '<p class="color-white">'.$title.'</p>';
    $html .= '<div class="icon">'.$icon.'</div>';
    $html .= '<a href="'.base_url().'index.php/'.$link.'" class="small-box-footer">';
    $html .= lang('ver_mas').' '.setIcon('arrow-circle-right');
    $html .= '</a>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

function setButton($value, $id, $class = NULL){
    if($class == NULL){
        $class = 'default';
    }

    $html = '<button type="button" id="'.$id.'" name="'.$id.'" class="btn btn-'.$class.'">'.$value.'</button>';

    return $html;
}

function setHiddenInput($id, $value = NULL){
    $html = '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'"/>';

    return $html;
}
?>
