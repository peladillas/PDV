<?php
$monto_total	= 0;
$acuenta_total	= 0;
?>

<script>
	$(document).ready(function() {
    $('#devoluciones').DataTable();
	$('#presupuestos').DataTable();
	$('#remitos').DataTable();
	$('#anulaciones').DataTable();
} );

	$(function() {
		$( "#final_fecha" ).datepicker({
			maxDate: '0',
			changeMonth: true,
      		changeYear: true,
			dateFormat: 'dd-mm-yy',
			onClose: function( selectedDate ) {
				$( "#inicio_fecha" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
	
	$(function() {
		$( "#inicio_fecha" ).datepicker({
			maxDate: '0',
			changeMonth: true,
      		changeYear: true,
			dateFormat: 'dd-mm-yy',
			onClose: function( selectedDate ) {
				$( "#final_fecha" ).datepicker( "option", "minDate", selectedDate );
			} 
		});
	});
</script>
<script>
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<?php echo startContent(lang('resumen')) ?>
<form method="post">
    <div class="col-md-3">
        <label>Cambiar de periodo de tiempo</label>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <input type="text" class="form-control" id="inicio_fecha" name="inicio" placeholder="ingrese inicio" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <input type="text" class="form-control" id="final_fecha" name="final" placeholder="ingrese final" required>
        </div>
    </div>
    <div class="col-md-3">
        <button class="btn btn-default form-control" name="buscar">
            Cambiar
        </button>
    </div>
    <div class="col-md-2">
        <button class="btn btn-default" type="button" onclick="printDiv('printableArea')"/>
            <i class="fa fa-print"></i> Imprimir
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
						<li class="active">
							<a href="#tab5" data-toggle="tab">Totales</a>
						</li>
						<li>
							<a href="#tab1" data-toggle="tab">Presupuestos</a>
						</li>
		    			<li>
		    				<a href="#tab2" data-toggle="tab">Remitos</a>
		    			</li>
		    			<li>
		    				<a href="#tab3" data-toggle="tab">Devoluciones</a>
		    			</li>
		    			<li>
		    				<a href="#tab4" data-toggle="tab">Anulaciones</a>
		    			</li>
					</ul>
				</div>
				
				<div class="panel-body">
					<div class="tab-content">
					    <div class="tab-pane" id="tab1">
			                <?php
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

                                $html = startTable($cabecera, 'presupuestos');
                                foreach ($presupuestos as $row) {
                                    $acuenta = ($row->tipo == 'Contado' ? $row->monto : $row->a_cuenta);
                                    $monto_total	= $monto_total + $row->monto;
                                    $acuenta_total	= $acuenta_total + $acuenta;
                                    $opciones = "<a title='ver cliente' href='".base_url()."index.php/clientes/cliente_abm/read/".$row->id_cliente."' class='btn btn-info btn-xs'>
                                            <span class='icon-user'></span>
                                            </a> 
                                            <a title='ver presupuesto' href='".base_url()."index.php/presupuestos/detalle_presupuesto/".$row->id_presupuesto."' class='btn btn-primary btn-xs'>
                                            <span class='icon-edit'></span>
                                            </a>";

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

                                    $html .= setTableContent($registro);
                                }

                                $html .= endTable();

                                echo $html;
                            }
                            ?>
				        </div>
                        <div class="tab-pane" id="tab2">
                            <table id="remitos" class="table table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th>Apellido y Nombre</th>
                                        <th>Alias</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                        <th>Devolución</th>
                                        <th>Opc.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($remitos){
                                $remito_total = 0;
                                $devolucion_total = 0;
                                foreach ($remitos as $row)
                                {
                                    echo "<tr>";
                                    echo "<td>".$row->apellido." ".$row->nombre."</td>";
                                    echo "<td>".$row->alias."</td>";
                                    echo "<td>".dateFormat($row->fecha)."</td>";
                                    echo "<td>".moneyFormat($row->monto)."</td>";
                                    echo "<td>".moneyFormat($row->devolucion)."</td>";

                                    $remito_total	= $remito_total + $row->monto;
                                    $devolucion_total	= $devolucion_total + $row->devolucion;

                                    echo "<td><a title='ver cliente' href='".base_url()."index.php/clientes/cliente_abm/read/".$row->id_cliente."' class='btn btn-info btn-xs'>
                                        <span class='icon-user'></span>
                                        </a> 
                                        <a title='ver remito' href='".base_url()."index.php/presupuestos/remito_vista/".$row->id_remito."' class='btn btn-primary btn-xs'>
                                        <span class='icon-edit'></span>
                                        </a> 
                                        </td>";
                                    echo "</tr>";
                                }}
                            ?>
                            </tbody>
                        </table>
                    </div>
				
				
				
				    <div class="tab-pane" id="tab3">
                        <table id="devoluciones" class="table table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th>Presupuesto</th>
                                    <th>Devolución</th>
                                    <th>Nota</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>A Cuenta</th>
                                    <th>Opc.</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($devoluciones){
                            $devolucion_total = 0;
                            $devolucion_a_cuenta = 0;
                            foreach ($devoluciones as $row)
                            {
                                echo "<tr>";
                                echo "<td>".$row->id_presupuesto."</td>";
                                echo "<td>".$row->id_devolucion."</td>";
                                echo "<td>".$row->nota."</td>";
                                echo "<td>".dateFormat($row->fecha)."</td>";
                                echo "<td>".moneyFormat($row->monto)."</td>";
                                echo "<td>".moneyFormat($row->a_cuenta)."</td>";

                                $devolucion_total	= $devolucion_total + $row->monto;
                                $devolucion_a_cuenta= $devolucion_a_cuenta + $row->a_cuenta;

                                echo "<td>
                                    <a title='ver devolución' href='".base_url()."index.php/devoluciones/devoluciones_abm/".$row->id_devolucion."' class='btn btn-primary btn-xs'>
                                    <span class='icon-edit'></span>
                                    </a> 
                                    </td>";
                                echo "</tr>";
                            }}
                            ?>
                            </tbody>
                        </table>
                    </div>
				
				
				
                    <div class="tab-pane" id="tab4">
                        <table id="anulaciones" class="table table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th>Presupuesto</th>
                                    <th>Nota</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Opc.</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($anulaciones){
                            $anulacion_total = 0;

                            foreach ($anulaciones as $row)
                            {
                                echo "<tr>";
                                echo "<td>".$row->id_presupuesto."</td>";
                                echo "<td>".$row->nota."</td>";
                                echo "<td>".dateFormat($row->fecha)."</td>";
                                echo "<td>".moneyFormat($row->monto)."</td>";

                                $anulacion_total	= $anulacion_total + $row->monto;

                                echo "<td>
                                    <a title='ver anulación' href='".base_url()."index.php/presupuestos/detalle_presupuesto/".$row->id_presupuesto."' class='btn btn-primary btn-xs'>
                                    <span class='icon-edit'></span>
                                    </a> 
                                    </td>";
                                echo "</tr>";
                            }}
                            ?>
                            </tbody>
                        </table>
                    </div>

				
				
				
				<div class="tab-pane active" id="tab5">
                    <h4>
                        <div class="pull-left">
                            Fecha Inicio : <?php echo $inicio?>
                        </div>
                        <div class="pull-right">
                            Fecha Final : <?php echo $final?>
                        </div>
                    </h4>
				
                    <br>
                    <hr>
				
					
                    <div class="col-xs-12 divider text-center">
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h4>
                                        <?php echo moneyFormat($monto_total); ?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                    PRESUPUESTO
                                </a>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-4 emphasis">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h4>
                                       <?php echo moneyFormat($acuenta_total);?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                   A CUENTA DE PRESUPUESTO
                                </a>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-4 emphasis">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h4>
                                        <?php echo ($monto_total-$acuenta_total)?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                   PRESUPUESTOS - A CUENTA =
                                </a>
                            </div>
                        </div>
                    </div>
					
                    <div class="col-xs-12 divider text-center">
                                <div class="col-xs-12 col-sm-4 emphasis">
                                    <div class="small-box bg-blue">
                                    <div class="inner">
                                        <h4>
                                           <?php echo moneyFormat($remito_total)?>
                                        </h4>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                       REMITOS
                                    </a>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 emphasis">
                                    <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h4>
                                           <?php echo moneyFormat($devolucion_total)?>
                                        </h4>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                       DEVOLUCIONES
                                    </a>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 emphasis">
                                    <div class="small-box bg-green">
                                    <div class="inner">
                                        <h4>
                                           <?php echo moneyFormat($remito_total-$devolucion_total)?>
                                        </h4>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                       REMITOS - DEVOLUCIONES =
                                    </a>
                                    </div>
                                </div>
                    </div>
				
				
				
				<div class="col-xs-12 divider text-center">
                			<div class="col-xs-12 col-sm-4 emphasis">
								<div class="small-box bg-light-blue">
                                <div class="inner">
                                    <h4>
                                    <?php
                                        echo (isset($devolucion_a_cuenta) ? moneyFormat($devolucion_a_cuenta) : moneyFormat(0));
                                    ?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                   DEVOLUCIONES ASIGNADAS
                                </a>
                            	</div>
							</div>
							
							<div class="col-xs-12 col-sm-4 emphasis">
								<div class="small-box bg-yellow">
                                <div class="inner">
                                    <h4>
                                    <?php
                                        echo (isset($devolucion_total) ? moneyFormat($devolucion_total) : moneyFormat(0));
                                    ?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                   DEVOLUCIONES - DEVOLUCIONES ASIGNADAS
                                </a>
                            	</div>
							</div>
							
							
							<div class="col-xs-12 col-sm-4 emphasis">
								<div class="small-box bg-red">
                                <div class="inner">
                                    <h4>
                                    <?php
                                        echo (isset($anulacion_total) ? moneyFormat($anulacion_total) : moneyFormat(0));
                                    ?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                   TOTAL DE ANULACIONES
                                </a>
                            	</div>
							</div>
							
				</div>
				
				
				
				<div class="col-xs-12 divider text-center">
                			
				</div>
				
				</div>
<?php echo endContent(); ?>