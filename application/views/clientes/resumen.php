<script>
$(document).ready(function() {
    $('#table_presupuestos').DataTable();
	$('#table_remitos').DataTable();
	$('#table_devoluciones').DataTable();
	
} );
</script>
<?php

$title = '<ul class="nav nav-tabs"><li class="active"><a href="#tab1" data-toggle="tab">'.lang('clientes).'</a></li>';
$title .= '<li class="active"><a href="#tab1" data-toggle="tab">'.lang('presupuestos).'</a></li>';
$title .= '<li class="active"><a href="#tab1" data-toggle="tab">'.lang('remitos).'</a></li>';
$title .= '<li class="active"><a href="#tab1" data-toggle="tab">'.lang('devoluciones).'</a></li></ul>';

echo startContent($title);
?>
    <div class="tab-content">
        <div class="tab-pane" id="tab2">
            <?php

            $total_p_contado = 0;
            $total_p_tarjeta = 0;
            $total_p_ctacte = 0;
            $total_p_cuenta = 0;

            if($presupuestos) {
                $cabecera = [
                    lang('nro');
                    lang('fecha');
                    lang('monto');
                    lang('a_cuenta');
                    lang('tipo');
                    lang('estado');
                ];

                $html = startTable($cabecera, 'table_presupuestos');

                foreach ($presupuestos as $row) {
                    if($row->id_tipo == 1) {
                        $row->a_cuenta = $row->monto;
                        $total_p_contado = $total_p_contado + $row->monto;
                    } else if($row->id_tipo == 2) {
                        $total_p_ctacte = $total_p_ctacte + $row->monto;
                        $total_p_cuenta = $total_p_cuenta + $row->a_cuenta;
                    } else {
                        $total_p_tarjeta = $total_p_tarjeta + $row->monto;
                    }

                    $registro = [
                        $row->id_presupuesto,
                        date('d-m-Y', strtotime($row->fecha)),
                        '$ '.round($row->monto, 2),
                        '$ '.round($row->a_cuenta,2),
                        $row->tipo,
                        $row->estado,
                    ];

                    $html .= setTableContent($registro);
                }

                $html .= endTable();

                echo $html;
            }
            ?>
        </div>
        <div class="tab-pane" id="tab3">
            <?php
            if($remitos) {
                $total_r_resta = 0;
                $total_r_monto = 0;
                $total_r_cuenta = 0;

                $cabecera = [
                    lang('nro');
                    lang('fecha');
                    lang('monto');
                    lang('devolucion');
                ];

                $html = startTable($cabecera, 'table_remitos');

                foreach ($remitos as $row) {
                    $registro = [
                        $row->id_remito,
                        date('d-m-Y', strtotime($row->fecha)),
                        '$ '.round($row->monto, 2),
                        '$ '.round($row->devolucion, 2),
                    ];

                    $resta = $row->monto - $row->devolucion;

                    $total_r_resta = $total_r_resta + $resta;
                    $total_r_monto = $total_r_monto + $row->monto;
                    $total_r_cuenta = $total_r_cuenta + $row->devolucion;

                    $html .= setTableContent($registro);
                }

                $html .= endTable();
            }
            ?>
        </div>
        <div class="tab-pane" id="tab4">
            <?php
            if($devoluciones) {
                $total_d_resta = 0;
                $total_d_monto = 0;
                $total_d_cuenta = 0;

                $cabecera = [
                    lang('nro');
                    lang('pre');
                    lang('fecha');
                    lang('monto');
                    lang('a_cuenta');
                    lang('nota');
                    lang('estado');
                ];

                $html = startTable($cabecera, 'table_presupuestos');

                foreach ($devoluciones as $row) {
                    $registro = [
                        $row->id_devolucion,
                        $row->id_presupuesto,
                        date('d-m-Y', strtotime($row->fecha)),
                        '$ '.round($row->monto, 2),
                        '$ '.round($row->a_cuenta, 2),
                        $row->nota,
                    ];

                    $resta = $row->monto - $row->a_cuenta;

                    $total_d_resta = $total_d_resta + $resta;
                    $total_d_monto = $total_d_monto + $row->monto;
                    $total_d_cuenta = $total_d_cuenta + $row->a_cuenta;

                    $html .= setTableContent($registro);
                }

                $html .= endTable();
            }
            ?>
        </div>
        <div class="tab-pane active" id="tab1">
            <?php
            if($clientes)
            {
                $total_vendido = $total_p_contado + $total_p_tarjeta + $total_p_ctacte;
                $total_cobrado = $total_p_contado + $total_p_tarjeta + $total_p_cuenta;
                $deuda = $total_vendido - $total_cobrado;

                foreach ($clientes as $row)
                {

            ?>
            <div class="col-md-12 well">
                <div class="profile">
                    <div class="col-sm-12">
                    <h2><?php echo $row->nombre.' '.$row->apellido.' - '.$row->alias ?></h2>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Dirección: </strong><?php echo $row->direccion ?></p>
                        <p><strong>Teléfono: </strong><?php echo $row->telefono ?></p>
                        <p><strong>Celular: </strong><?php echo $row->celular ?></p>
                        <p><strong>Nextel: </strong><?php echo $row->nextel ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Cuil: </strong><?php echo $row->cuil ?></p>
                        <p><strong>Condición: </strong><?php echo $row->id_condicion_iva ?></p>
                        <p><strong>Nota: </strong><?php echo $row->comentario ?></p>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 divider text-center">
                <div class="col-xs-12 col-sm-4 emphasis">
                    <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            $ <?php echo $total_vendido ?>
                        </h3>
                    </div>
                    <a href="#" class="small-box-footer">
                       VENDIDO
                    </a>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 emphasis">
                    <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            $ <?php echo $total_cobrado ?>
                        </h3>
                    </div>
                    <a href="#" class="small-box-footer">
                       COBRADO
                    </a>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 emphasis">
                    <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            $ <?php echo $deuda ?>
                        </h3>
                    </div>
                    <a href="#" class="small-box-footer">
                       DEUDA
                    </a>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 divider text-center">
                <div class="col-xs-12 col-sm-3 emphasis">
                    <div class="small-box bg-blue">
                    <div class="inner">
                        <h4>
                            $ <?php echo $total_p_contado ?>
                        </h4>
                    </div>
                    <a href="#" class="small-box-footer">
                       CONTADO
                    </a>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-3 emphasis">
                    <div class="small-box bg-maroon">
                    <div class="inner">
                        <h4>
                            $ <?php echo $total_p_tarjeta ?>
                        </h4>
                    </div>
                    <a href="#" class="small-box-footer">
                       TARJETA
                    </a>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-3 emphasis">
                    <div class="small-box bg-olive">
                    <div class="inner">
                        <h4>
                            $ <?php echo $total_p_ctacte ?>
                        </h4>
                    </div>
                    <a href="#" class="small-box-footer">
                       CUENTA CORRIENTE
                    </a>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-3 emphasis">
                    <div class="small-box bg-orange">
                    <div class="inner">
                        <h4>
                            $ <?php echo $total_p_ctacte ?>
                        </h4>
                    </div>
                    <a href="#" class="small-box-footer">
                        ANULADO
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
}
echo endContent();
?>