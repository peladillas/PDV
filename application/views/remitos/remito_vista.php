
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
					
				
  					$monto = $datos['monto'] - $datos['devolucion'];
				
					$datos['id_remito'];
					echo date('d-m-Y', strtotime($datos['fecha']));
					echo  $datos['nombre'];
					echo $datos['apellido'];
					
					
				?>
				<hr>
				<div class='row'>
  				<table class='table'>
  					<thead>
  						<tr>
						<th class='col-sm-2'><center>Nro</center></th>
						<!--<th class='col-sm-2'><center>Fecha</center></th>-->
						<th class='col-sm-2'><center>Monto</center></th>
						<th class='col-sm-2'><center>A cuenta</center></th>
						<th class='col-sm-2'><center>Pago</center></th>
						<th class='col-sm-2'><center>Estado</center></th>
						</tr>
					</thead>
					<tbody>
					<?php 
	    			if($remitos_detalle)
					{
		    			foreach ($remitos_detalle as $row) 
		    			{
		    				echo "<tr>";
								echo "<td width='15%'><center>".$row->nro."</center></td>";
								//echo "<td width='20%'><center>".$row->prefecha."</center></td>";
								echo "<td width='15%'><center>$ ".$row->premonto."</center></td>";
								echo "<td width='15%'><center>$ ".$row->prea_cuenta."</center></td>";
								echo "<td width='15%'><center>$ ".$row->monto."</center></td>";
								echo "<td width='20%'><center>".$row->estado."</center></td>";
		    				echo "</tr>";	
						}
					}

					if($remitos_dev)
					{
		    			foreach ($remitos_dev as $row) 
		    			{
		    				echo "<tr>";
								echo "<td colspan='3' width='45%'><center>Devolución del día ".date('d-m-Y', strtotime($row->fecha))."</center></td>";
								echo "<td width='15%'><center>$ ".$row->monto."</center></td>";
								echo "<td width='20%'><center>".$row->nota."</center></td>";
		    				echo "</tr>";	
						}
					}
					
					if($total > 0)
					{ ?>
					<tr>
						<td colspan="2"></td>
						<th>DEBE a la fecha <?php echo date('d/m/Y');?></th>
						<th><center>$ <?php echo $total ?></center></th>
					</tr>	
					<?php 
					} 
					?>
					
					</tbody>
				</table>
				<hr>
  			</div>
  			</div>
		</div>
    </div>
</div>    


