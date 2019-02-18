<?php
echo startContent(lang('empresa_titulo'));

if($presupuestos) {
    echo "<table class='table table-hover'>";
    foreach ($presupuestos as $row) {
        foreach ($impresiones as $impresion) {
            $clientes	= $this->clientes_model->select($row->id_cliente);

            if($clientes) {
                foreach ($clientes as $row_cliente) {
                    $nombre = $row_cliente->nombre;
                    $apellido = $row_cliente->apellido;
                }
            }
            $cabecera = $impresion->cabecera;
            $cabecera = str_replace("#presupuesto_nro#", $row->id_presupuesto, $cabecera);
            $cabecera = str_replace("#presupuesto_descuento#", $row->descuento, $cabecera);
            $cabecera = str_replace("#presupuesto_fecha#", date('d-m-Y', strtotime($row->fecha)), $cabecera);
            $cabecera = str_replace("#presupuesto_monto#", $row->monto, $cabecera);

            if(isset($nombre)) {
                $cabecera = str_replace("#cliente_nombre#", $nombre, $cabecera);
            } else {
                $cabecera = str_replace("#cliente_nombre#", '', $cabecera);
            }

            if(isset($apellido)) {
                $cabecera = str_replace("#cliente_apellido#", $apellido, $cabecera);
            } else {
                $cabecera = str_replace("#cliente_apellido#", '', $cabecera);
            }

            $monto_presupuesto = $row->monto;

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
                    echo "<td>$ ".round($sub_total,2)."</td>";
                echo "</tr>";
            }
        }

        echo "<tr class='success'>";
            echo "<td colspan='4'>".lang('total')."</td>";
            echo "<th>$ ".round($total,2)."</th>";
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
			
<form method="post" action="<?php echo base_url().'index.php/presupuestos/anular/'?>">
    <label>Nota</label>
    <textarea name="nota" class="form-control" rows="6" required></textarea>
    <input name="id_presupuesto" value="<?php echo $id_presupuesto?>" type="hidden"/>
    <input name="monto" value="<?php echo $monto_presupuesto?>" type="hidden"/>
    <a href='<?php echo base_url()."/index.php/ventas/presupuesto_abm/"?>' class='btn btn-default'>Volver a la lista</a>
    <button class="btn btn-default"/>
        <i class="fa fa-trash-o"></i> Anular
    </button>
</form>

<?php echo endContent(); ?>
