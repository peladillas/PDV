<script>
$(document).ready(function() {
    $('#table_presupuestos').dataTable();
	$('#table_remitos').dataTable();
	$('#table_devoluciones').dataTable();
	
} );
</script>

<?php
$total_p_contado = 0;
$total_p_tarjeta = 0;
$total_p_ctacte = 0;
$total_p_cuenta = 0;

// Presupuestos
if($presupuestos) {
    $cabecera = [
        lang('nro'),
        lang('fecha'),
        lang('monto'),
        lang('a_cuenta'),
        lang('tipo'),
        lang('estado'),
    ];

    $tablePresupuestos = startTable($cabecera, 'table_presupuestos');

    foreach ($presupuestos as $row) {

        if($row->id_tipo == 1) {
            $row->a_cuenta = $row->monto;
            $total_p_contado += $row->monto;
        } else if($row->id_tipo == 2) {
            $total_p_ctacte += $row->monto;
            $total_p_cuenta += $row->a_cuenta;
        } else {
            $total_p_tarjeta += $row->monto;
        }

        $registro = [
            $row->id_presupuesto,
            dateFormat($row->fecha),
            moneyFormat($row->monto),
            moneyFormat($row->a_cuenta),
            $row->tipo,
            $row->estado,
        ];

        $tablePresupuestos .= setTableContent($registro);
    }

    $tablePresupuestos .= endTable();
} else {
    $tablePresupuestos = '';
}

// Remitos
if($remitos) {
    $total_r_resta = 0;
    $total_r_monto = 0;
    $total_r_cuenta = 0;

    $cabecera = [
        lang('nro'),
        lang('fecha'),
        lang('monto'),
        lang('devolucion'),
    ];

    $tableRemitos = startTable($cabecera, 'table_remitos');

    foreach ($remitos as $row) {
        $resta = $row->monto - $row->devolucion;
        $total_r_resta += $resta;
        $total_r_monto += $row->monto;
        $total_r_cuenta += $row->devolucion;

        $registro = [
            $row->id_remito,
            dateFormat($row->fecha),
            moneyFormat($row->monto),
            moneyFormat($row->devolucion),
        ];

        $tableRemitos .= setTableContent($registro);
    }

    $tableRemitos .= endTable();
} else {
    $tableRemitos = '';
}

// Devoluciones
if($devoluciones) {
    $total_d_resta = 0;
    $total_d_monto = 0;
    $total_d_cuenta = 0;

    $cabecera = [
        lang('nro'),
        lang('pre'),
        lang('fecha'),
        lang('monto'),
        lang('a_cuenta'),
        lang('nota'),
        lang('estado'),
    ];

    $tableDevoluciones = startTable($cabecera, 'table_presupuestos');

    foreach ($devoluciones as $row) {
        $resta = $row->monto - $row->a_cuenta;

        $total_d_resta += $resta;
        $total_d_monto += $row->monto;
        $total_d_cuenta += $row->a_cuenta;

        $registro = [
            $row->id_devolucion,
            $row->id_presupuesto,
            dateFormat($row->fecha),
            moneyFormat($row->monto),
            moneyFormat($row->a_cuenta),
            $row->nota,
        ];

        $tableDevoluciones .= setTableContent($registro);
    }

    $tableDevoluciones .= endTable();
} else {
    $tableDevoluciones = '';
}

$title = '<ul class="nav nav-tabs"><li class="active"><a href="#tabClientes" data-toggle="tab">'.lang('clientes').'</a></li>';
$title .= '<li class="active"><a href="#tabPresupuestos" data-toggle="tab">'.lang('presupuestos').'</a></li>';
$title .= '<li class="active"><a href="#tabRemitos" data-toggle="tab">'.lang('remitos').'</a></li>';
$title .= '<li class="active"><a href="#tabDevoluciones" data-toggle="tab">'.lang('devoluciones').'</a></li></ul>';

echo startContent($title);
?>
    <div class="tab-content">
        <div class="tab-pane" id="tabPresupuestos"><?php echo $tablePresupuestos; ?></div>
        <div class="tab-pane" id="tabRemitos"><?php echo $tableRemitos; ?></div>
        <div class="tab-pane" id="tabDevoluciones"><?php echo $tableDevoluciones; ?></div>
        <div class="tab-pane active" id="tabClientes">
            <?php
            if($clientes) {
                $total_vendido = $total_p_contado + $total_p_tarjeta + $total_p_ctacte;
                $total_cobrado = $total_p_contado + $total_p_tarjeta + $total_p_cuenta;
                $deuda = $total_vendido - $total_cobrado;

                foreach ($clientes as $row) {
            ?>
            <div class="col-md-12 well">
                <div class="profile">
                    <div class="col-sm-12">
                        <h2><?php echo $row->nombre.' '.$row->apellido.' - '.$row->alias ?></h2>
                    </div>
                    <div class="col-sm-6">
                        <p><b><?php echo lang('direccion')?></b><?php echo $row->direccion ?></p>
                        <p><b><?php echo lang('telefono')?></b><?php echo $row->telefono ?></p>
                        <p><b><?php echo lang('celular')?></b><?php echo $row->celular ?></p>
                        <p><b><?php echo lang('nextel')?> </b><?php echo $row->nextel ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><b><?php echo lang('cuil')?></b><?php echo $row->cuil ?></p>
                        <p><b><?php echo lang('condicion')?></b><?php echo $row->id_condicion_iva ?></p>
                        <p><b><?php echo lang('nota')?></b><?php echo $row->comentario ?></p>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 divider text-center">
                <?php echo setEmphasis('aqua', moneyFormat($total_vendido), lang('vendidio')) ?>
                <?php echo setEmphasis('green', moneyFormat($total_cobrado), lang('cobrado')) ?>
                <?php echo setEmphasis('red', moneyFormat($deuda), lang('deuda')) ?>
            </div>

            <div class="col-xs-12 divider text-center">
                <?php echo setEmphasis('blue', moneyFormat($total_p_contado), lang('contado')) ?>
                <?php echo setEmphasis('maroon', moneyFormat($total_p_tarjeta), lang('tarjeta')) ?>
                <?php echo setEmphasis('olive', moneyFormat($total_p_ctacte), lang('cuenta_corriente')) ?>
                <?php echo setEmphasis('orange', moneyFormat($total_p_ctacte), lang('anulado')) ?>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
<?php echo endContent();?>