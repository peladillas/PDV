<?php
echo startContent(lang('empresa_titulo'));

if($presupuestos) {
    echo "<table class='table table-hover'>";
    foreach ($presupuestos as $row) {
        foreach ($impresiones as $impresion) {
            $clientes	= $this->clientes_model->select($row->id_cliente);
            foreach ($clientes as $row_cliente) {
                $nombre = $row_cliente->nombre;
                $apellido = $row_cliente->apellido;
            }

            $cabecera = $impresion->cabecera;
            $cabecera = str_replace("#presupuesto_nro#", $row->id_presupuesto, $cabecera);
            $cabecera = str_replace("#presupuesto_descuento#", $row->descuento, $cabecera);
            $cabecera = str_replace("#presupuesto_fecha#", dateFormat($row->fecha), $cabecera);
            $cabecera = str_replace("#presupuesto_monto#", $row->monto, $cabecera);
            $cabecera = str_replace("#cliente_nombre#", $nombre, $cabecera);
            $cabecera = str_replace("#cliente_apellido#", $apellido, $cabecera);

            $pie = $impresion->pie;
            echo $cabecera;

            $id_presupuesto = $row->id_presupuesto;
        }

        echo "<hr>";

        $total=0;

        echo "<table class='table table-hover'>";
        echo "<tr>";
            echo "<th>".lang('articulo')."</th>";
            echo "<th>".lang('descripcion')."</th>";
            echo "<th>".lang('cantidad')."</th>";
            echo "<th>".lang('monto')."</th>";
            echo "<th>".lang('total')."</th>";
        echo "</tr>";

        if($detalle_presupuesto) {
            foreach ($detalle_presupuesto as $row) {
                echo "<tr>";
                    echo "<td><a title='ver Articulo' class='btn btn-default btn-xs' href='".base_url()."index.php/articulos/articulo_abm/read/".$row->id_articulo."'>".$row->cod_proveedor."</a></td>";
                    echo "<td>".$row->descripcion."</td>";
                    echo "<td>".$row->cantidad."</td>";
                    $precio = $row->precio/$row->cantidad;
                    echo "<td>".$precio."</td>";
                    $sub_total = $row->cantidad * $precio;
                    $total = $total + $sub_total;
                    echo "<td>".moneyFormat($sub_total)."</td>";
                echo "</tr>";
            }
        }

        echo "<tr class='success'>";
            echo "<td colspan='4'>".lang('total')."</td>";
            echo "<th>".moneyFormat($total)."</th>";
        echo "</tr>";

        echo "</table>";

        echo "<hr>";
        echo $pie;
    }

    if($devoluciones) {
        $mensaje = lang('si_devolucion')." <a class='btn btn-warning'>Ver devolución</a>";
        echo setMensaje($mensaje, 'warning');
    }


} else {
    echo setMensaje(lang('no_registro'), 'success');
}

?>

    <a href="<?php echo base_url().'index.php/presupuestos/anular/'.$id_presupuesto?>" class="btn btn-default"/>
    <i class="fa fa-trash-o"></i> Anular
</a>

<?php echo endContent(); ?>