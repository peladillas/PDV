<?php
$dias_mes = 31;

for ($i=1; $i <= $dias_mes; $i++) {
	$mes[$i]		= 0;
	$contado[$i]	= 0;
	$ctacte[$i]		= 0;
	$remito[$i]		= 0;
	$devolucion[$i]	= 0;
	$anulacion[$i]	= 0;
}


$cant_contado = 0;
$cant_ctacte = 0;
$cant_devoluciones = 0;
$cant_anulaciones = 0;

$cant_remitos = ($remitos ? count($remitos) : 0);
$cant_articulos = ($articulos ? count($articulos) : 0);
$cant_clientes = ($clientes ? count($clientes) : 0);
$cant_presupuestos = ($cant_presupuestos ? $cant_presupuestos : 0);

	
if($presupuestos) {
	foreach ($presupuestos as $row) {
		$mes_fecha = date('d', strtotime($row->fecha));
		
		if($mes_fecha == '01'){ $mes_fecha = 1; }
		if($mes_fecha == '02'){ $mes_fecha = 2; }
		if($mes_fecha == '03'){ $mes_fecha = 3; }
		if($mes_fecha == '04'){ $mes_fecha = 4; }
		if($mes_fecha == '05'){ $mes_fecha = 5; }
		if($mes_fecha == '06'){ $mes_fecha = 6; }
		if($mes_fecha == '07'){ $mes_fecha = 7; }
		if($mes_fecha == '08'){ $mes_fecha = 8; }
		if($mes_fecha == '09'){ $mes_fecha = 9; }
		
		$mes[$mes_fecha] += $row->monto;

        if($row->tipo == 2) {
            $ctacte[$mes_fecha] += $row->monto;
            $cant_ctacte ++;
        } else {
            $contado[$mes_fecha] += $row->monto;
            $cant_contado ++;
        }
	}	
}

if($presupuestos_detalle) {
    $cabecera = [
        lang('cantidad'),
        lang('descripcion'),
        lang('precio'),
    ];

    $tablePresupuestos = startTable($cabecera);

    foreach ($presupuestos_detalle as $row) {
        $registro = [
            $row->cantidad,
            $row->descripcion,
            $row->precio,
        ];

        $tablePresupuestos .= setTableContent($registro);
    }

    $tablePresupuestos .= endTable();
} else {
    $tablePresupuestos = '';
}


if($proveedores) {
    $cabecera = [
        lang('cantidad'),
        lang(''),
        lang('porcentaje'),
        lang('proveedor'),
    ];

    $tableProveedores = startTable($cabecera);

    foreach ($proveedores as $row) {
        $porcentaje = ($cant_articulos > 0 ? $row->suma * 100 / $cant_articulos : 0);

        $registro = [
            "<span class='badge bg-green'>".$row->suma."</span>",
            "<span class='badge bg-blue'>".round($porcentaje,2)." %</span>",
            '<div class="progress xs progress-striped active"> <div class="progress-bar progress-bar-primary" style="width: '.round($porcentaje).'%"></div>
                                </div>',
            $row->descripcion,
        ];

        $tableProveedores .= setTableContent($registro);
    }

    $tableProveedores .= endTable();
} else {
    $tableProveedores = '';
}

?>

<div class="container">
	<div class="row">
        <?php echo setBigEmphasis('aqua', $cant_presupuestos, lang('presupuestos'), setIcon('shopping-cart'), 'presupuestos/presupuesto_abm'); ?>
        <?php echo setBigEmphasis('green', $cant_articulos, lang('articulos'), setIcon('clipboard'), 'articulos/articulo_abm'); ?>
        <?php echo setBigEmphasis('orange', $cant_clientes, lang('clientes'), setIcon('user'), 'clientes/clientes_abm'); ?>
        <?php echo setBigEmphasis('red', $cant_remitos, lang('remitos'), setIcon('pie-chart'), 'remitos/remitos_abm'); ?>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<p class="pull-right">Últimos 10 artículos vendidos</p> <?php echo $tablePresupuestos; ?>
				</div>
			</div>	
		</div>
			 			
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="calendar"></div>
				</div>
			</div>
		</div>
	</div>
			
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="grafico" class="grafic-home"></div>
				</div>
			</div>		
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="tipos" class="div-home"></div>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="condiciones" class="div-home"></div>
				</div>
			</div>		
		</div>
		
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<p class="pull-right">Cantidad de articulos por proveedor</p> <?php echo $tableProveedores; ?>
				</div>
			</div>		
		</div>
	</div>
</div>

<script type="text/javascript">
$(function () {
    $('#grafico').highcharts({
    	title: {
            text: 'Sumas de los montos totales de los presupuestos',
            x: -20 //center
        },
        subtitle: {
            text: 'Periodo : <b><?php echo date('m')."-".date('Y')?></b>',
            x: -20
        },
        xAxis: {
            categories: [
            <?php
            foreach ($mes as $key => $value) {
				echo   "'".$key."',";
            }
			?>
            ]
        },
        yAxis: {
            title: {
                text: 'Cantidad'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' $'
        },
        series: [{
            name: 'Suma de montos',
            data: [
            <?php 
            foreach ($mes as $key => $value)
			{
				echo   $value.",";
            }
			?>
			]
        }]
    });
    
    $('#torta').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Cantidad de ventas <?php echo $mes_actual."-".$ano_actual?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Cantidad de ventas',
            data: [
                ['Contado',   <?php echo $cant_contado ?>],
                ['Cuenta Corriente',       <?php echo $cant_ctacte ?>],
                ['Anulaciones	',       <?php echo $cant_anulaciones ?>],
           ]
        }]
    });

    $('#tipos').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Tipos de Cliente'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Cantidad de ventas',
            data: [
            	<?php 
            	if($tipos) {
            		foreach ($tipos as $row) {
	            	?>
						['<?php echo $row->descripcion ?>',   <?php echo $row->suma ?>],
	                <?php	
					}	
            	}
            	?>
           ]
        }]
    });

    $('#condiciones').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Condiciones de Cliente'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Cantidad de ventas',
            data: [
            	<?php 
            	if($condiciones) {
	            	foreach ($condiciones as $row) {
	            	?>	
						['<?php echo $row->descripcion ?>',   <?php echo $row->suma ?>],
	                <?php	
					}
				}
				?>
           ]
        }]
    });
});
</script>

<?php
    echo setJs('highcharts/js/highcharts.js');
    echo setJs('highcharts/js/modules/exporting.js');
?>