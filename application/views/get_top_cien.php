<script>
	$(document).ready(function() {
    $('#get100').DataTable();
	
	
} );
</script>
<div class="container">
	


	<div class="row">
		
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<!--
					<form method="post" action="<?php echo base_url().'index.php/home/verMas'?>">
						<input name="inicio" type="hidden" value="<?php echo $inicio;?>" />
						<input name="fin" type="hidden" value="<?php echo $fin;?>" />
						Top 10 de los artículos más vendidos 
						<button type="submit" class="btn btn-succes btn-xs">Ver mas</button>	
					</form>
					-->
				</div>
				
				<div class="panel-body">
					<table id="get100" class="table table-hover" style="font-size: 13px">
						<thead>
							<tr>
								<th>N°</th>
								<th>Cant</th>
								<th>Descripción</th>
							</tr>
						</thead>
						<tbody>
					<?php
					if($articulos)
					{$numero=1;
						foreach ($articulos as $row)
						{
							echo "<tr>";
							echo "<td>".$numero."</td>";
							echo "<td>".$row->cantidad."</td>";
							echo "<td><a title='Ver detalle' href='".base_url()."index.php/articulos/articulo_abm/read/".$row->id_articulo."'>";
							echo $row->descripcion."</a></td>";
							echo "</tr>";
							$numero++;
						} 
					}
					?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>		
			
			
