<script>
$(document).ready(function() {

    $('#presupuestos').dataTable();
    $('#remitos').dataTable();
    $('#devoluciones').dataTable();
    $('#anulaciones').dataTable();

    $("#final_fecha").datepicker({
        maxDate: '0',
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        onClose: function( selectedDate ) {
            $( "#inicio_fecha" ).datepicker( "option", "maxDate", selectedDate );
        }
    });

    $("#inicio_fecha").datepicker({
        maxDate: '0',
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        onClose: function( selectedDate ) {
            $( "#final_fecha" ).datepicker( "option", "minDate", selectedDate );
        }
    });
});

function printDiv (divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

<?php echo startContent(lang('resumen'));

$monto_total	= 0;
$acuenta_total	= 0;
$remito_total = 0;
$devolucion_total = 0;
$devolucion_a_cuenta = 0;
$anulacion_total = 0;


// Tabla de presupuestos
if($presupuestos){
    $cabecera = [
        lang('nombre'),
        lang('alias'),
        lang('fecha'),
        lang('monto'),
        lang('a_cuenta'),
        lang('tipo'),
        lang('tipo'),
        lang('opciones'),
    ];

    $presupuestosTable = startTable($cabecera, 'presupuestos');

    foreach ($presupuestos as $row) {
        $acuenta = ($row->tipo == 'Contado' ? $row->monto : $row->a_cuenta);
        $monto_total	+= $row->monto;
        $acuenta_total	+= $acuenta;
        $opciones = "<a title='ver cliente' href='".base_url()."index.php/clientes/cliente_abm/read/".$row->id_cliente."' class='btn btn-info btn-xs'>".setIcon('user')."</a>";
        $opciones .= "<a title='ver presupuesto' href='".base_url()."index.php/presupuestos/detalle_presupuesto/".$row->id_presupuesto."' class='btn btn-primary btn-xs'>".setIcon('pencil')."</a>";

        $registro = [
            $row->apellido." ".$row->nombre,
            $row->alias,
            dateFormat($row->fecha),
            moneyFormat($row->monto),
            moneyFormat($acuenta),
            $row->tipo,
            $row->estado,
            $opciones,
        ];

        $presupuestosTable .= setTableContent($registro);
    }

    $presupuestosTable .= endTable();
} else {
    $presupuestosTable = '';
}

// Tabla de remitos
if ($remitos) {
    $cabecera = [
        lang('nombre'),
        lang('alias'),
        lang('fecha'),
        lang('monto'),
        lang('devolucion'),
        lang('opciones'),
    ];

    $remitosTable = startTable($cabecera, 'remitos');
	
    foreach ($remitos as $row) {
        $remito_total += $row->monto;
        $devolucion_total += $row->devolucion;
        $opciones = "<a title='ver cliente' href='".base_url()."index.php/clientes/cliente_abm/read/".$row->id_cliente."' class='btn btn-info btn-xs'>".setIcon('user')."</a>";
        $opciones .= "<a title='ver remito' href='".base_url()."index.php/presupuestos/remito_vista/".$row->id_remito."' class='btn btn-primary btn-xs'>".setIcon('pencil')."</a>";

        $registro = [
            $row->apellido." ".$row->nombre,
            $row->alias,
            dateFormat($row->fecha),
            moneyFormat($row->monto),
            moneyFormat($row->devolucion),
            $opciones,
        ];

        $remitosTable .= setTableContent($registro);
    }

    $remitosTable .= endTable();
} else {
    $remitosTable = '';
}

// Tabla de devoluciones
if($devoluciones){
    $cabecera = [
        lang('presupuesto'),
        lang('devolucion'),
        lang('nota'),
        lang('fecha'),
        lang('monto'),
        lang('a_cuenta'),
        lang('opciones'),
    ];

    $devolucionesTable = startTable($cabecera, 'devoluciones');

    foreach ($devoluciones as $row) {
        $devolucion_total += $row->monto;
        $devolucion_a_cuenta += $row->a_cuenta;
        $opciones = "<a title='ver devolución' href='".base_url()."index.php/devoluciones/devoluciones_abm/".$row->id_devolucion."' class='btn btn-primary btn-xs'>".setIcon('pencil')."</a>";

        $registro = [
            $row->id_presupuesto,
            $row->id_devolucion,
            $row->nota,
            dateFormat($row->fecha),
            moneyFormat($row->monto),
            moneyFormat($row->a_cuenta),
            $opciones
        ];

        $devolucionesTable .= setTableContent($registro);
    }

    $devolucionesTable .= endTable();
} else {
    $devolucionesTable = '';
}

// Tabla de devoluciones
if($anulaciones){
    $cabecera = [
        lang('presupuesto'),
        lang('nota'),
        lang('fecha'),
        lang('monto'),
        lang('opciones'),
    ];

    $anulacionesTable = startTable($cabecera, 'devoluciones');
    
    foreach ($anulaciones as $row) {
        $anulacion_total += $row->monto;
        $opciones = "<a title='ver anulación' href='".base_url()."index.php/presupuestos/detalle_presupuesto/".$row->id_presupuesto."' class='btn btn-primary btn-xs'>".setIcon('pencil')."</a><";

        $registro = [
            $row->id_presupuesto,
            $row->nota,
            dateFormat($row->fecha),
            moneyFormat($row->monto),
            $opciones
        ];

        $anulacionesTable .= setTableContent($registro);
    }

    $anulacionesTable .= endTable();
} else {
    $anulacionesTable = '';
}
?>


<form method="post">
    <div class="col-md-3">
        <label>Cambiar de periodo de tiempo</label>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <div class="input-group-addon"><?php echo setIcon('calendar')?>/div>
            <input type="text" class="form-control" id="inicio_fecha" name="inicio" placeholder="<?php echo lang('inicio')?>" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <div class="input-group-addon"><?php echo setIcon('calendar')?></div>
            <input type="text" class="form-control" id="final_fecha" name="final" placeholder="<?php echo lang('final')?>" required>
        </div>
    </div>
    <div class="col-md-3">
        <button class="btn btn-default form-control" name="buscar">
            <?php echo lang('cambiar')?>
        </button>
    </div>
    <div class="col-md-2">
        <button class="btn btn-default" type="button" onclick="printDiv('printableArea')"/>
            <?php echo setIcon('print').' '.lang('imprimir')?>
        </button>
    </div>
</form>
<?php echo endContent(); ?>



<div id="printableArea">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tabTotales" data-toggle="tab"><?php echo lang('totales')?></a></li>
						<li><a href="#tabPresupuestos" data-toggle="tab"><?php echo lang('presupuestos')?></a></li>
		    			<li><a href="#tabRemitos" data-toggle="tab"><?php echo lang('remitos')?></a></li>
		    			<li><a href="#tabDevoluciones" data-toggle="tab"><?php echo lang('devoluciones')?></a></li>
		    			<li><a href="#tabAnulaciones" data-toggle="tab"><?php echo lang('anulaciones')?></a></li>
					</ul>
				</div>
				
				<div class="panel-body">
					<div class="tab-content">
					    <div class="tab-pane" id="tabPresupuestos"><?php echo $presupuestosTable ?></div>
                        <div class="tab-pane" id="tabRemitos"><?php echo $remitosTable ?></div>
				        <div class="tab-pane" id="tabDevoluciones"><?php echo $devolucionesTable ?></div>
				        <div class="tab-pane" id="tabAnulaciones"><?php echo $anulacionesTable ?></div>
                        <div class="tab-pane active" id="tabTotales">
                            <h4>
                                <div class="pull-left"><?php echo lang('fecha_inicio').' '.$inicio?></div>
                                <div class="pull-right"><?php echo lang('fecha_final').' '.$final?></div>
                            </h4>
                            <br>
                            <hr>

                            <div class="col-xs-12 divider text-center">
                                <?php echo setEmphasis('blue', moneyFormat($monto_total), lang('presupuesto')) ?>
                                <?php echo setEmphasis('green', moneyFormat($acuenta_total), lang('a_cuenta').' '.lang('presupuesto')) ?>
                                <?php echo setEmphasis('red', moneyFormat($monto_total - $acuenta_total), lang('presupuesto').' - '.lang('a_cuenta')) ?>
                            </div>
                            <div class="col-xs-12 divider text-center">
                                <?php echo setEmphasis('blue', moneyFormat($remito_total), lang('remitos')) ?>
                                <?php echo setEmphasis('yellow', moneyFormat($devolucion_total), lang('devoluciones')) ?>
                                <?php echo setEmphasis('green', moneyFormat($remito_total - $devolucion_total), lang('remitos').' - '.lang('devoluciones').' =') ?>
                            </div>
				            <div class="col-xs-12 divider text-center">
                                <?php echo setEmphasis('light-blue', (isset($devolucion_a_cuenta) ? moneyFormat($devolucion_a_cuenta) : moneyFormat(0)), lang('devoluciones').' '.lang('asignadas')) ?>
                                <?php echo setEmphasis('yellow', (isset($devolucion_total) ? moneyFormat($devolucion_total) : moneyFormat(0)), lang('devoluciones').' - '.lang('devoluciones').' '.lang('asignadas')) ?>
                                <?php echo setEmphasis('red', (isset($anulacion_total) ? moneyFormat($anulacion_total) : moneyFormat(0)), lang('total').' '.lang('anulaciones')) ?>
				            </div>
				            <div class="col-xs-12 divider text-center"></div>
				        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>