<?php
$dias_mes = 31;

for ($i=1; $i <= $dias_mes; $i++) 
{ 
	$mes[$i]		= 0;
	$contado[$i]	= 0;
	$ctacte[$i]		= 0;
	$remito[$i]		= 0;
	$devolucion[$i]	= 0;
	$anulacion[$i]	= 0;
}

$cant_ctacte = 0;
$cant_contado = 0;
$cant_devoluciones = 0;
$cant_anulaciones = 0;
$cant_articulos = 0;
$cant_clientes = 0;
$cant_remitos = 0;

if($remitos)
{
	$cant_remitos = count($remitos);
}

if($articulos)
{
	$cant_articulos = count($articulos);
}

if($clientes)
{
	$cant_clientes = count($clientes);
}


if($presupuestos_cant)
{
	$cant_presupuestos = count($presupuestos_cant);
}
	
if($presupuestos)
{
	foreach ($presupuestos as $row)
	{
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
		
		$mes[$mes_fecha] = $mes[$mes_fecha] + $row->monto;
			if($row->tipo == 2)
			{
				$ctacte[$mes_fecha] = $ctacte[$mes_fecha] + $row->monto;
				$cant_ctacte = $cant_ctacte + 1; 
			} 
			else
			{
				$contado[$mes_fecha] = $contado[$mes_fecha] + $row->monto;
				$cant_contado = $cant_contado + 1;
			}
	}	
}

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-3 emphasis">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>
						<?php echo $cant_presupuestos ?>
					</h3>
					<p style="color:#fff;">Presupuestos</p>
                    <div class="icon">                
					<i class="icon icon-shopping-cart"></i>
					</div>
				</div>
				
				<a href="<?php echo base_url()?>index.php/ventas/presupuesto_abm" class="small-box-footer">
					Ver más <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		
		
		<div class="col-xs-12 col-sm-3 emphasis">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>
						<?php echo $cant_articulos ?>
					</h3>
					<p style="color:#fff;">Artículos</p>
                    <div class="icon">                
					<i class="icon icon-clipboardalt"></i>
					</div>
				</div>
				
				<a href="<?php echo base_url()?>index.php/articulos/articulo_abm" class="small-box-footer">
					Ver más <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		
		
		<div class="col-xs-12 col-sm-3 emphasis">
			<div class="small-box bg-orange">
				<div class="inner">
					<h3>
						<?php echo $cant_clientes ?>
					</h3>
					<p style="color:#fff;">Clientes</p>
                    <div class="icon">                
					<i class="icon icon-user"></i>
					</div>
				</div>
				
				<a href="<?php echo base_url()?>index.php/clientes/cliente_abm" class="small-box-footer">
					Ver más <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		
		
		<div class="col-xs-12 col-sm-3 emphasis">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>
						<?php echo $cant_remitos ?>
					</h3>
					<p style="color:#fff;">Remitos</p>
                    <div class="icon">                
					<i class="icon icon-analytics-piechart"></i>
					</div>
				</div>
				
				<a href="<?php echo base_url()?>index.php/ventas/remitos_abm" class="small-box-footer">
					Ver más <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
							
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<p class="pull-right">Últimos 10 artículos vendidos</p>
					
					<?php
					if($presupuestos_detalle)
					{
						echo "<table class='table table-hover' style='font-size:12px'>";
							echo "<tr class='success'>";
							echo "<td>Cantidad</td>";
							echo "<td>Descripción</td>";
							echo "<td>Precio</td>";
							echo "<tr>";
							
						foreach ($presupuestos_detalle as $row)
						{
							echo "<tr>";
							echo "<td>".$row->cantidad."</td>";
							echo "<td>".$row->descripcion."</td>";
							echo "<td>".$row->precio."</td>";
							echo "<tr>";
						}
						echo "</table>";
					}
					?>
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
					<div id="grafico" style="min-width: 310px; height: 400px; margin-bottom: 35px;"></div>
				</div>
			</div>		
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="tipos" style="min-width: 310px; height: 405px; max-width: 600px; margin: 0 auto"></div>	
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="condiciones" style="min-width: 310px; height: 405px; max-width: 600px; margin: 0 auto"></div>	
				</div>
			</div>		
		</div>
		
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<p class="pull-right">Cantidad de articulos por proveedor</p>
					
					<?php
					if($proveedores)
					{
						echo "<table class='table table-hover' style='font-size:14px'>";
					
						echo "<tr class='success'>";
						echo "<td>Cantidad</td>";
						echo "<td></td>";
						echo "<td>Porcentaje</td>";
						echo "<td>Proveedor</td>";
						echo "</tr>";	
					
						foreach ($proveedores as $row) 
						{
							$porcentaje = $row->suma * 100 / $cant_articulos;
							echo "<tr>";
							echo "<td><span class='badge bg-green'>".$row->suma."</span></td>";
							echo "<td><span class='badge bg-blue'>".round($porcentaje,2)." %</span></td>";
							echo '<td><div class="progress xs progress-striped active">
	                                  <div class="progress-bar progress-bar-primary" style="width: '.round($porcentaje).'%"></div>
	                              </div></td>';
							echo "<td>".$row->descripcion."</td>";
							echo "</tr>";	
						}
						echo "</table>";
					}
					?>	
				</div>
			</div>		
		</div>
		
		<div class="col-md-6">
					
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
            	if($tipos)
            	{
            		foreach ($tipos as $row) 
	            	{
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
            	if($condiciones){
	            	foreach ($condiciones as $row) 
	            	{
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

<script src="<?php echo base_url().'librerias/Highcharts-4.1.4/js/highcharts.js'?>"></script>
<script src="<?php echo base_url().'librerias/Highcharts-4.1.4/js/modules/exporting.js'?>"></script>