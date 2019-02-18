<?php echo startContent(lang('empresa_titulo')); ?>
<div id="printableArea">
<?php
if($presupuestos) {
    foreach ($presupuestos as $row) {
        if($detalle_presupuesto) {
            $total=0;
            echo "<form action='".base_url()."index.php/devoluciones/insert/' method='post'>";

            echo "<input type='hidden' name='presupuesto' value='".$row->id_presupuesto."' >";

            echo "<table class='table table-hover'>";
            echo "<tr>";
                echo "<th>".lang('articulo')."</th>";
                echo "<th>".lang('descripcion')."</th>";
                echo "<th>".lang('monto')."</th>";
                echo "<th>".lang('cantidad')."</th>";
                echo "<th>".lang('devolucion')."</th>";
            echo "</tr>";

            foreach ($detalle_presupuesto as $row) {
                echo "<tr>";
                    echo "<td>".$row->cod_proveedor."</td>";
                    echo "<td>".$row->descripcion."</td>";
                    $precio = $row->precio/$row->cantidad;
                    echo "<td>$ ".round($precio, 2)."</td>";
                    echo "<td>".$row->cantidad."</td>";
                    echo "<td><input name='".$row->id_renglon."' class='form-control' type='number' value='0' max='".$row->cantidad."' min='0' required></td>";
                echo "</tr>";
            }

            echo "<tr>
                    <th>Nota</th>
                    <td colspan='4'><textarea name='nota' class='form-control' rows='6' required></textarea></td></tr>";

            echo "</table>";

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
