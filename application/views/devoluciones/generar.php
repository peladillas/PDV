<div class="container"> 
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo $texto['empresa_titulo'] ?></div>
		<div class="panel-body">
			
			<div id="printableArea">
			<?php 
			if($presupuestos)
			{
				foreach ($presupuestos as $row) 
				{
				
				if($detalle_presupuesto)
				{
					$total=0;
					echo "<form action='".base_url()."index.php/devoluciones/insert/' method='post'>";
					
					echo "<input type='hidden' name='presupuesto' value='".$row->id_presupuesto."' >";
						
					echo "<table class='table table-hover'>";
					echo "<tr>";
						echo "<th>".$texto['articulo']."</th>";
						echo "<th>Descripción</th>";
						echo "<th>".$texto['monto']."</th>";
						echo "<th>".$texto['cantidad']."</th>";
						echo "<th>Devolución</th>";
					echo "</tr>";
					
					foreach ($detalle_presupuesto as $row) 
					{
						echo "<tr>";	
							echo "<td>".$row->cod_proveedor."</td>";
							echo "<td>".$row->descripcion."</td>";
							$precio = $row->precio/$row->cantidad;
							echo "<td>$ ".round($precio, 2)."</td>";
							echo "<td>".$row->cantidad."</td>";
							echo "<td><input name='".$row->id_renglon."' class='form-control' type='number' value='0' max='".$row->cantidad."' min='0' required></td>";
						echo "</tr>";
					}
					
					echo "<tr>
							<th>Nota</th>
							<td colspan='4'><textarea name='nota' class='form-control' rows='6' required></textarea></td></tr>";
					
					echo "</table>";
				
					echo "<hr>";
					
					echo "<center><button class='btn btn-primary'>Guardar</button></center>";
					
					echo "</form>";
				}
				else
				{
					echo setMensaje('No se pueden generar devoluciones con este presupuesto', 'danger');
				}
				
				
				}
			}
			else
			{
				echo setMensaje($texto['no_registro'], 'success');
			}
			?>
			</div>
		</div>
		
	</div>
	
</div>
</div>
</body>
</html>
