<script>
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

<?php echo startContent(lang('remito')); ?>
    <a class="btn btn-default" href="<?php echo base_url().'index.php/ventas/remitos_abm/'?>"/>
        <i class="fa fa-arrow-left"></i> Remitos
    </a>

    <?php
    foreach ($remitos as $row) {
        $datos =  array(
            'id_remito'		=> $row->id_remito,
            'fecha'			=> $row->fecha,
            'monto'			=> $row->monto,
            'devolucion'	=> $row->devolucion,
            'nombre'		=> $row->nombre,
            'apellido'		=> $row->apellido
        );
    }

    $total = 0;

    if($presupuestos) {
        foreach ($presupuestos as $row) {
            $total =  $total + ( $row->monto - $row->a_cuenta );
        }
    }


    $monto = $datos['monto'] - $datos['devolucion'];

    $datos['id_remito'];
    echo date('d-m-Y', strtotime($datos['fecha']));
    echo  $datos['nombre'];
    echo $datos['apellido'];

    echo '<hr>';
    echo "<div class='row'>";

    $cabecera = [
        lang('nro'),
        lang('monto'),
        lang('a_cuenta'),
        lang('pago'),
        lang('estado'),
    ];

    $html = startTable($cabecera);
    if ($remitos_detalle) {
        foreach ($remitos_detalle as $row) {
            $registro = [
                $row->nro,
                "$ ".$row->premonto,
                "$ ".$row->prea_cuenta,
                "$ ".$row->monto,
                $row->estado,
            ];

            $html .= setTableContent($registro);
        }
    }

    if ($remitos_dev) {
        foreach ($remitos_dev as $row) {
            $registro = [
                "",
                "",
                "Devolución del día " . date('d-m-Y', strtotime($row->fecha)),
                "$ " . $row->monto,
                $row->nota,
            ];

            $html .= setTableContent($registro);
        }
    }

    if($total > 0) {
        $registro = [
            "",
            "",
            "DEBE a la fecha ".date('d/m/Y'),
            $total,
            "",
        ];

        $html .= setTableContent($registro);
    }

    $html .= endTable();

    echo $html

    echo '<hr>';
    echo '<div>';
    echo endContent();
?>