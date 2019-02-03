<?php
$mes = array(
	'ene' => 0,
	'feb' => 0,
	'mar' => 0,
	'abr' => 0,
	'may' => 0,
	'jun' => 0,
	'jul' => 0,
	'ago' => 0,
	'sep' => 0,
	'oct' => 0,
	'nov' => 0,
	'dic' => 0
);

$contado = array(
	'ene' => 0,
	'feb' => 0,
	'mar' => 0,
	'abr' => 0,
	'may' => 0,
	'jun' => 0,
	'jul' => 0,
	'ago' => 0,
	'sep' => 0,
	'oct' => 0,
	'nov' => 0,
	'dic' => 0
);

$ctacte = array(
	'ene' => 0,
	'feb' => 0,
	'mar' => 0,
	'abr' => 0,
	'may' => 0,
	'jun' => 0,
	'jul' => 0,
	'ago' => 0,
	'sep' => 0,
	'oct' => 0,
	'nov' => 0,
	'dic' => 0
);

$remito = array(
	'ene' => 0,
	'feb' => 0,
	'mar' => 0,
	'abr' => 0,
	'may' => 0,
	'jun' => 0,
	'jul' => 0,
	'ago' => 0,
	'sep' => 0,
	'oct' => 0,
	'nov' => 0,
	'dic' => 0
);

$anulacion = array(
	'ene' => 0,
	'feb' => 0,
	'mar' => 0,
	'abr' => 0,
	'may' => 0,
	'jun' => 0,
	'jul' => 0,
	'ago' => 0,
	'sep' => 0,
	'oct' => 0,
	'nov' => 0,
	'dic' => 0
);

$devolucion = array(
	'ene' => 0,
	'feb' => 0,
	'mar' => 0,
	'abr' => 0,
	'may' => 0,
	'jun' => 0,
	'jul' => 0,
	'ago' => 0,
	'sep' => 0,
	'oct' => 0,
	'nov' => 0,
	'dic' => 0
);



$cant_ctacte = 0;
$cant_contado = 0;
$cant_anulacion = 0;

if($presupuestos)
{
	foreach ($presupuestos as $row)
	{
		$mes_fecha = date('m', strtotime($row->fecha));
		
		if($mes_fecha == 1){ $texto = 'ene'; }
		else if($mes_fecha == 2) { $texto = 'feb' ; }
		else if($mes_fecha == 3) { $texto = 'mar' ; }
		else if($mes_fecha == 4) { $texto = 'abr' ; }
		else if($mes_fecha == 5) { $texto = 'may' ; }
		else if($mes_fecha == 6) { $texto = 'jun' ; }
		else if($mes_fecha == 7) { $texto = 'jul' ; }
		else if($mes_fecha == 8) { $texto = 'ago' ; }
		else if($mes_fecha == 9) { $texto = 'sep' ; }
		else if($mes_fecha == 10) { $texto = 'oct' ; }
		else if($mes_fecha == 11) { $texto = 'nov' ; }
		else if($mes_fecha == 12) { $texto = 'dic' ; }	
		
		$mes[$texto] = $mes[$texto] + $row->monto;
			if($row->tipo == 2)
			{
				$ctacte[$texto] = $ctacte[$texto] + $row->monto;
				$cant_ctacte = $cant_ctacte + 1; 
			} 
			else
			{
				$contado[$texto] = $contado[$texto] + $row->monto;
				$cant_contado = $cant_contado + 1;
			}
	}
}


if($remitos)
{
	foreach ($remitos as $row)
	{
		$mes_fecha = date('m', strtotime($row->fecha));
		
		if($mes_fecha == 1){ $texto = 'ene'; }
		else if($mes_fecha == 2) { $texto = 'feb' ; }
		else if($mes_fecha == 3) { $texto = 'mar' ; }
		else if($mes_fecha == 4) { $texto = 'abr' ; }
		else if($mes_fecha == 5) { $texto = 'may' ; }
		else if($mes_fecha == 6) { $texto = 'jun' ; }
		else if($mes_fecha == 7) { $texto = 'jul' ; }
		else if($mes_fecha == 8) { $texto = 'ago' ; }
		else if($mes_fecha == 9) { $texto = 'sep' ; }
		else if($mes_fecha == 10) { $texto = 'oct' ; }
		else if($mes_fecha == 11) { $texto = 'nov' ; }
		else if($mes_fecha == 12) { $texto = 'dic' ; }	
		
		$remito[$texto] = $remito[$texto] + $row->monto;
	}		
}


if($devoluciones)
{
	foreach ($devoluciones as $row)
	{
		$mes_fecha = date('m', strtotime($row->fecha));
		
		if($mes_fecha == 1){ $texto = 'ene'; }
		else if($mes_fecha == 2) { $texto = 'feb' ; }
		else if($mes_fecha == 3) { $texto = 'mar' ; }
		else if($mes_fecha == 4) { $texto = 'abr' ; }
		else if($mes_fecha == 5) { $texto = 'may' ; }
		else if($mes_fecha == 6) { $texto = 'jun' ; }
		else if($mes_fecha == 7) { $texto = 'jul' ; }
		else if($mes_fecha == 8) { $texto = 'ago' ; }
		else if($mes_fecha == 9) { $texto = 'sep' ; }
		else if($mes_fecha == 10) { $texto = 'oct' ; }
		else if($mes_fecha == 11) { $texto = 'nov' ; }
		else if($mes_fecha == 12) { $texto = 'dic' ; }	
		
		$devolucion[$texto] = $devolucion[$texto] + $row->monto;
	}		
}


if($anulaciones)
{
	foreach ($anulaciones as $row)
	{
		$mes_fecha = date('m', strtotime($row->fecha));
		
		if($mes_fecha == 1){ $texto = 'ene'; }
		else if($mes_fecha == 2) { $texto = 'feb' ; }
		else if($mes_fecha == 3) { $texto = 'mar' ; }
		else if($mes_fecha == 4) { $texto = 'abr' ; }
		else if($mes_fecha == 5) { $texto = 'may' ; }
		else if($mes_fecha == 6) { $texto = 'jun' ; }
		else if($mes_fecha == 7) { $texto = 'jul' ; }
		else if($mes_fecha == 8) { $texto = 'ago' ; }
		else if($mes_fecha == 9) { $texto = 'sep' ; }
		else if($mes_fecha == 10) { $texto = 'oct' ; }
		else if($mes_fecha == 11) { $texto = 'nov' ; }
		else if($mes_fecha == 12) { $texto = 'dic' ; }	
		
		$anulacion[$texto] = $anulacion[$texto] + $row->monto;
		
		$cant_anulacion = $cant_anulacion + 1;
	}		
}

?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Sumas totales de los montos de los presupuestos
				</div>
				
				<div class="panel-body">
					<div id="grafico" style="min-width: 310px; height: 400px; margin-bottom: 35px;"></div>
				</div>
			</div>
		</div>
	</div>

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
					<table class="table table-hover" style="font-size: 13px">
						<thead>
							<tr>
								<th>Cant</th>
								<th>Descripción</th>
							</tr>
						</thead>
						<tbody>
					<?php
					if($articulos)
					{
						foreach ($articulos as $row)
						{
							echo "<tr>";
							echo "<td>".$row->cantidad."</td>";
							echo "<td><a title='Ver detalle' href='".base_url()."index.php/articulos/articulo_abm/read/".$row->id_articulo."'>";
							echo $row->descripcion."</a></td>";
							echo "</tr>";
						} 
					}
					?>
						</tbody>
					</table>
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
			</div>
		</div>
	</div>
	


	</div>


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

<script src="<?php echo base_url().'librerias/Highcharts-4.1.4/js/highcharts.js'?>"></script>
<script src="<?php echo base_url().'librerias/Highcharts-4.1.4/js/modules/exporting.js'?>"></script>