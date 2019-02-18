<?php echo startContent(lang('empresa_titulo')); ?>
<div id="printableArea">
<?php
if ($presupuestos) {
    foreach ($presupuestos as $row) {
        if ($detalle_presupuesto) {
            $total=0;
            echo "<form action='".base_url()."index.php/devoluciones/insert/' method='post'>";

            echo "<input type='hidden' name='presupuesto' value='".$row->id_presupuesto."' >";

            $cabecera = [
                lang('articulo');
                lang('descripcion');
                lang('monto');
                lang('cantidad');
                lang('devolucion');
            ];

            $html = startTable($cabecera, 'table_presupuestos');

            foreach ($detalle_presupuesto as $row) {
                $precio = $row->precio/$row->cantidad;

                $registro = [
                    $row->cod_proveedor;
                    $row->descripcion;
                    "$ ".round($precio, 2);
                    $row->cantidad;
                    "<input name='".$row->id_renglon."' class='form-control' type='number' value='0' max='".$row->cantidad."' min='0' required>";
                ];

                $html .= setTableContent($registro);
            }

            $html .= "<tr>
                    <th>Nota</th>
                    <td colspan='4'><textarea name='nota' class='form-control' rows='6' required></textarea></td></tr>";

            $html .= endTable();

            echo $html;

            echo "<hr>";

            echo "<center><button class='btn btn-primary'>Guardar</button></center>";

            echo "</form>";
        } else {
            echo setMensaje('No se pueden generar devoluciones con este presupuesto', 'danger');
        }
    }
} else {
    echo setMensaje(lang('no_registro'), 'success');
}
?>
</div>
<?php echo endContent(); ?>
