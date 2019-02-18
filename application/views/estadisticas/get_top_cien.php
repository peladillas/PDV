<?php
$html = startContent('top');

$cabeceras = [
   lang('nro'),
   lang('cantidad'),
   lang('descripcion'),
];

$html .= startTable($cabeceras, 'get100');

$numero = 1;

if ($articulos) {
    foreach ($articulos as $row) {
        $registro = [
            $numero,
            $row->cantidad,
            "<a title='Ver detalle' href='".base_url()."index.php/articulos/articulo_abm/read/".$row->id_articulo."'>".$row->descripcion."</a>",
        ];

        $html .= setTableContent($cabeceras);
    }
}

$html .= endTable();

$html .= endContent();
$html .= setDatatables('get100');

echo $html;

?>