<?php
$meses = array(
    1 => 'ene',
    2 => 'feb',
    3 => 'mar',
    4 => 'abr',
    5 => 'may',
    6 => 'jun',
    7 => 'jul',
    8 => 'ago',
    9 => 'sep',
    10 => 'oct',
    11 => 'nov',
    12 => 'dic',
);

foreach ($meses as $_mes){
    $mes[$_mes] = 0;
    $contado[$_mes] = 0;
    $ctacte[$_mes] = 0;
    $remito[$_mes] = 0;
    $anulacion[$_mes] = 0;
    $devolucion[$_mes] = 0;
}

$cant_ctacte = 0;
$cant_contado = 0;
$cant_anulacion = 0;

if($presupuestos) {
	foreach ($presupuestos as $row) {
		$mes_fecha = date('m', strtotime($row->fecha));
        $texto = $meses[$mes_fecha];

		$mes[$texto] = $mes[$texto] + $row->monto;
        if($row->tipo == 2) {
            $ctacte[$texto] = $ctacte[$texto] + $row->monto;
            $cant_ctacte = $cant_ctacte + 1;
        } else {
            $contado[$texto] = $contado[$texto] + $row->monto;
            $cant_contado = $cant_contado + 1;
        }
	}
}


if($remitos) {
	foreach ($remitos as $row) {
		$mes_fecha = date('m', strtotime($row->fecha));
        $texto = $meses[$mes_fecha];
		
		$remito[$texto] = $remito[$texto] + $row->monto;
	}		
}


if($devoluciones) {
	foreach ($devoluciones as $row) {
		$mes_fecha = date('m', strtotime($row->fecha));
        $texto = $meses[$mes_fecha];
		
		$devolucion[$texto] = $devolucion[$texto] + $row->monto;
	}		
}


if($anulaciones) {
	foreach ($anulaciones as $row) {
		$mes_fecha = date('m', strtotime($row->fecha));
        $texto = $meses[$mes_fecha];
		
		$anulacion[$texto] = $anulacion[$texto] + $row->monto;
		
		$cant_anulacion = $cant_anulacion + 1;
	}		
}

echo startContent('Sumas totales de los montos de los presupuestos');
?>
<div id="grafico" style="min-width: 310px; height: 400px; margin-bottom: 35px;"></div>
</div>	</div>	</div>	</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Cantidad de ventas
            </div>

            <div class="panel-body">
                <div id="torta" style="min-width: 310px; height: 405px; max-width: 600px; margin: 0 auto"></div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Top 10 de los artículos más vendidos
            </div>

            <div class="panel-body">
                <?php
                if($articulos) {
                    $cabecera = [
                        lang('cant'),
                        lang('descripcion'),
                    ];

                    $html = startTable();

                    foreach ($articulos as $row) {
                        $registro = [
                            $row->cantidad,
                            "<a title='Ver detalle' href='".base_url()."index.php/articulos/articulo_abm/read/".$row->id_articulo."'>".$row->descripcion."</a>",
                        ];

                        $html .= setTableContent($registro);
                    }

                    $html .= endTable();

                    echo $html;
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Sumas totales de los montos de los presupuestos por tipo
            </div>

            <div class="panel-body">
                <div id="grafico2" style="min-width: 310px; height: 400px; margin-bottom: 35px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-danger">
            <div class="panel-heading">
                Sumas totales de las anulaciones y devoluciones
            </div>

            <div class="panel-body">
                <div id="grafico3" style="min-width: 310px; height: 400px; margin-bottom: 35px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-body">
                <form method="post">
                    <div class="col-md-4">
                        <label>Cambiar de periodo de tiempo</label>
                    </div>
                    <div class="col-md-2">
                    <select class="form-control" name="ano"/>
                        <?php
                        $comienzo = 2014;
                        for ($i=0; $i < 10 ; $i++) {
                        $comienzo = $comienzo + 1;
                        ?>
                            <option value="<?php echo $comienzo?>"/><?php echo $comienzo?></option>
                        <?php } ?>
                    </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-default form-control" name="buscar">
                            Cambiar
                        </button>
                    </div>
                </form>
            </div>
<?php echo endContent(); ?>



<script type="text/javascript">
$(function () {
    $('#grafico').highcharts({
    	title: {
            text: 'Sumas',
            x: -20 //center
        },
        subtitle: {
            text: 'Periodo : <?php echo $ano_actual?>',
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
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
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
    
    
    
    $('#grafico2').highcharts({
    	chart: {
            //type: 'bar'
            type: 'column'
        },
        title: {
            text: 'Sumas',
            x: -20 //center
        },
        subtitle: {
            text: 'Periodo : <?php echo $ano_actual?>',
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
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Contado',
            data: [
            <?php 
            foreach ($contado as $key => $value)
			{
				echo   $value.",";
            }
			?>
			]},{
            name: 'Cuenta Corriente',
            data: [
            <?php 
            foreach ($ctacte as $key => $value)
			{
				echo   $value.",";
            }
			?>
			]},
			{
	            name: 'Remito',
	            data: [
		            <?php 
		            foreach ($remito as $key => $value)
					{
						echo   $value.",";
		            }
					?>
				]
			}
        ]
    });
    
    
    
    
    $('#grafico3').highcharts({
    	chart: {
            //type: 'bar'
            type: 'column'
        },
        title: {
            text: 'Restas',
            x: -20 //center
        },
        subtitle: {
            text: 'Periodo : <?php echo $ano_actual?>',
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
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Devoluciones',
            data: [
            <?php 
            foreach ($devolucion as $key => $value)
			{
				echo   $value.",";
            }
			?>
			]},{
            name: 'Anulaciones',
            data: [
            <?php 
            foreach ($anulacion as $key => $value)
			{
				echo   $value.",";
            }
			?>
			]}
        ]
    });
    
    
    
    $('#torta').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Cantidad de ventas <?php echo $ano_actual?>'
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
                ['Anulaciones',       <?php echo $cant_anulacion ?>],
           ]
        }]
    });
});
</script>

<script src="<?php echo base_url().'librerias/highcharts/js/highcharts.js'?>"></script>
<script src="<?php echo base_url().'librerias/highcharts/js/modules/exporting.js'?>"></script>