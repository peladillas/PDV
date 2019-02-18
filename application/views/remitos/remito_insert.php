
<script>
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<div class="container">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
  			<div class="panel-heading">
  				<i class="icon-document"></i> Remito
  			</div>
  			<div class="panel-body">
  				<a class="btn btn-default" href="<?php echo base_url().'index.php/ventas/remitos_abm/'?>"/>
  					<i class="fa fa-arrow-left"></i> Remitos
  				</a>
  				<a class="btn btn-default" href="<?php echo base_url().'index.php/presupuestos/remito/'?>"/>
  					<i class="fa fa-plus-square"></i> Generar nuevo
  				</a>
  				<button class="btn btn-default" type="button" onclick="printDiv('printableArea')"/>
  					<i class="fa fa-print"></i> Imprimir
  				</button>
  			<div id="printableArea">
  				
  				<?php 
  				foreach ($remitos as $row) 
  				{
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
				
				if($presupuestos)
				{
					foreach ($presupuestos as $row) 
	  				{
						$total =  $total + ( $row->monto - $row->a_cuenta );
					}
				}
					
				
  				foreach ($impresiones as $impresion) 
  				{
  					$monto = $datos['monto'] - $datos['devolucion'];
					$cabecera = $impresion->cabecera;
					$cabecera = str_replace("#remito_nro#", $datos['id_remito'], $cabecera);
					$cabecera = str_replace("#remito_fecha#", date('d-m-Y', strtotime($datos['fecha'])), $cabecera);
					$cabecera = str_replace("#remito_monto#", $monto, $cabecera);
					$cabecera = str_replace("#cliente_nombre#", $datos['nombre'], $cabecera);
					$cabecera = str_replace("#cliente_apellido#", $datos['apellido'], $cabecera);
					
					echo $cabecera;
				?>
				<hr>
				<div class='row'>
  				<table class='table'>
  					<thead>
  						<tr>
						<th class='col-sm-2'><center>Nro</center></th>
						<!--<th class='col-sm-2'><center>Fecha</center></th>-->
						<th class='col-sm-2'><center>Monto del presupuesto</center></th>
						<th class='col-sm-2'><center>Pago en el remito</center></th>
						<th class='col-sm-2'><center>Total pagos anteriores</center></th>
						<th class='col-sm-2'><center>Estado del presupuesto</center></th>
						<th class='col-sm-2'><center>Falta pagar de este presupuesto</center></th>
						</tr>
					</thead>
					<tbody>
					<?php 
	    			if($remitos_detalle)
					{
						$subtotal = 0;
		    			foreach ($remitos_detalle as $row) 
		    			{
		    				echo "<tr>";
								echo "<td width='15%'><center>".$row->nro."</center></td>";
								//echo "<td width='20%'><center>".$row->prefecha."</center></td>";
								echo "<td width='15%'><center>$ ".$row->premonto."</center></td>";
								echo "<td class='success'width='15%'><b><center>$ ".$row->monto."</center></b></td>";
								echo "<td width='15%'><center>$ ".$row->prea_cuenta."</center></td>";
								echo "<td width='20%'><center>".$row->estado."</center></td>";
								$subtotal = round($row->premonto, 2) - round($row->prea_cuenta, 2) -round( $row->monto, 2);
								echo "<td width='20%'><center>".round($subtotal, 2)."</center></td>";
		    				echo "</tr>";	
						}
					}

					if($remitos_dev)
					{
		    			foreach ($remitos_dev as $row) 
		    			{
		    				echo "<tr>";
								echo "<td colspan='2' width='45%'><center>Devolución del día ".date('d-m-Y', strtotime($row->fecha))."</center></td>";
								echo "<td width='15%'><center>$ ".$row->monto."</center></td>";
								echo "<td colspan='2'><center>".$row->nota."</center></td>";
								echo "<td width='20%'></td>";
		    				echo "</tr>";	
						}
					}
					?>
					
					</tbody>
				</table>
				<hr>
				<?php
					echo $impresion->pie;
				}//cierra foreach impresiones
				
				
				if($total > 0)
					{ ?>
					<hr>	
					<div class='row'>
						<div class="col-md-1"></div>
						<div class="col-md-5"><h4>DEBE a la fecha <?php echo date('d/m/Y');?></h4></div>
						<div class="col-md-5"><h4>$ <?php echo $total ?></h4></div>
					</div>	
					<?php 
					}
					?> 
  			</div>
  			</div>
		</div>
    </div>
</div>    


