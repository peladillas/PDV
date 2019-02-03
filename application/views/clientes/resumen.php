<script>
$(document).ready(function() {
    $('#table_presupuestos').DataTable();
	$('#table_remitos').DataTable();
	$('#table_devoluciones').DataTable();
	
} );
</script>
<div class="container"> 
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab1" data-toggle="tab">Clientes</a>
					</li>
	    			<li>
	    				<a href="#tab2" data-toggle="tab">Presupuestos</a>
	    			</li>
	    			<li>
	    				<a href="#tab3" data-toggle="tab">Remitos</a>
	    			</li>
	    			<li>
	    				<a href="#tab4" data-toggle="tab">Devoluciones</a>
	    			</li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane" id="tab2">
						<?php
						
						$total_p_contado = 0;
						$total_p_tarjeta = 0;
						$total_p_ctacte = 0;
						$total_p_cuenta = 0;
							 
						if($presupuestos)
						{
							
							echo '<table class="table table-hover" id="table_presupuestos">';
							echo '<thead>';
							echo '<tr>';
								echo '<th>Nro</th>';
								echo '<th>Fecha</th>';
								echo '<th>Monto</th>';
								echo '<th>A Cuenta</th>';
								echo '<th>Tipo</th>';
								echo '<th>Estado</th>';
							echo '</tr>';			
							echo '</thead>';
							echo '<tbody>';
							
							foreach ($presupuestos as $row) 
							{
								if($row->id_tipo == 1)
								{
									$row->a_cuenta = $row->monto;
									$total_p_contado = $total_p_contado + $row->monto;
								}
								else
								if($row->id_tipo == 2)
								{
									$total_p_ctacte = $total_p_ctacte + $row->monto;
									$total_p_cuenta = $total_p_cuenta + $row->a_cuenta;
								}
								else
								{
									$total_p_tarjeta = $total_p_tarjeta + $row->monto;
								}
								
								echo '<tr>';
								echo '<td>'.$row->id_presupuesto.'</td>';
								echo '<td>'.date('d-m-Y', strtotime($row->fecha)).'</td>';
								echo '<td class="success">$ '.round($row->monto, 2).'</td>';
								echo '<td>$ '.round($row->a_cuenta,2).'</td>';
								echo '<td>'.$row->tipo.'</td>';
								echo '<td>'.$row->estado.'</td>';
								echo '</tr>';
							}
							
							echo '<tbody>';
							echo '</table>';
							
						}
						?>
					</div>
					<div class="tab-pane" id="tab3">
						<?php 
						if($remitos)
						{
							$total_r_resta = 0;
							$total_r_monto = 0;
							$total_r_cuenta = 0;
								
							echo '<table class="table table-hover" id="table_remitos">';
							echo '<thead>';
							echo '<tr>';
								echo '<th>Nro</th>';
								echo '<th>Fecha</th>';
								echo '<th>Monto</th>';
								echo '<th>Devolución</th>';
							echo '</tr>';			
							echo '</thead>';
							echo '<tbody>';
						
							foreach ($remitos as $row) 
							{
								echo '<tr>';
									echo '<td>'.$row->id_remito.'</td>';
									echo '<td>'.date('d-m-Y', strtotime($row->fecha)).'</td>';
									echo '<td class="success">$ '.round($row->monto, 2).'</td>';
									echo '<td>$ '.round($row->devolucion, 2).'</td>';
								echo '</tr>';			
							
								$resta = $row->monto - $row->devolucion;
								
								$total_r_resta = $total_r_resta + $resta;
								$total_r_monto = $total_r_monto + $row->monto;
								$total_r_cuenta = $total_r_cuenta + $row->devolucion;												
							}
							
							echo '<tbody>';
							echo '</table>';
						}
						?>
					</div>
					<div class="tab-pane" id="tab4">
						<?php 
						if($devoluciones)
						{
							$total_d_resta = 0;
							$total_d_monto = 0;
							$total_d_cuenta = 0;
								
							echo '<table class="table table-hover" id="table_devoluciones">';
							echo '<thead>';
							echo '<tr>';
								echo '<th>Nro</th>';
								echo '<th>Pre.</th>';
								echo '<th>Fecha</th>';
								echo '<th>Monto</th>';
								echo '<th>A cuenta</th>';
								echo '<th>Nota</th>';
							echo '</tr>';			
							echo '</thead>';
							echo '<tbody>';
						
							foreach ($devoluciones as $row) 
							{
								echo '<tr>';
									echo '<td>'.$row->id_devolucion.'</td>';
									echo '<td>'.$row->id_presupuesto.'</td>';
									echo '<td>'.date('d-m-Y', strtotime($row->fecha)).'</td>';
									echo '<td class="success">$ '.round($row->monto, 2).'</td>';
									echo '<td>$ '.round($row->a_cuenta, 2).'</td>';
									echo '<td>'.$row->nota.'</td>';
								echo '</tr>';			
							
								$resta = $row->monto - $row->a_cuenta;
								
								$total_d_resta = $total_d_resta + $resta;
								$total_d_monto = $total_d_monto + $row->monto;
								$total_d_cuenta = $total_d_cuenta + $row->a_cuenta;												
							}
							
							echo '<tbody>';
							echo '</table>';
						}
						?>
					</div>
					<div class="tab-pane active" id="tab1">
						<?php 
						if($clientes)
						{
							$total_vendido = $total_p_contado + $total_p_tarjeta + $total_p_ctacte;
							$total_cobrado = $total_p_contado + $total_p_tarjeta + $total_p_cuenta;
							$deuda = $total_vendido - $total_cobrado;
						
							foreach ($clientes as $row) 
							{
			
						?>
						<div class="col-md-12 well">
    	 					<div class="profile">
            					<div class="col-sm-12">
            					<h2><?php echo $row->nombre.' '.$row->apellido.' - '.$row->alias ?></h2>
                    			</div>	
                				<div class="col-sm-6">
                    				<p><strong>Dirección: </strong><?php echo $row->direccion ?></p>
                    				<p><strong>Teléfono: </strong><?php echo $row->telefono ?></p>
				                    <p><strong>Celular: </strong><?php echo $row->celular ?></p>
				                	<p><strong>Nextel: </strong><?php echo $row->nextel ?></p>
                    			</div>             
                				<div class="col-sm-6">
                    				<p><strong>Cuil: </strong><?php echo $row->cuil ?></p>
                    				<p><strong>Condición: </strong><?php echo $row->id_condicion_iva ?></p>
				                    <p><strong>Nota: </strong><?php echo $row->comentario ?></p>
				                </div>
            				</div>
						</div>            
						
						<div class="col-xs-12 divider text-center">            
							<div class="col-xs-12 col-sm-4 emphasis">
								<div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        $ <?php echo $total_vendido ?>
                                    </h3>
                                </div>
                                <a href="#" class="small-box-footer">
                                   VENDIDO
                                </a>
                            	</div>
							</div>
							
							<div class="col-xs-12 col-sm-4 emphasis">
								<div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        $ <?php echo $total_cobrado ?>
                                    </h3>
                                </div>
                                <a href="#" class="small-box-footer">
                                   COBRADO
                                </a>
                            	</div>
							</div>
	 
							<div class="col-xs-12 col-sm-4 emphasis">
								<div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        $ <?php echo $deuda ?>
                                    </h3>
                                </div>
                                <a href="#" class="small-box-footer">
                                   DEUDA
                                </a>
                            	</div>
							</div>
            			</div>
            			
            			<div class="col-xs-12 divider text-center">
                			<div class="col-xs-12 col-sm-3 emphasis">
								<div class="small-box bg-blue">
                                <div class="inner">
                                    <h4>
                                        $ <?php echo $total_p_contado ?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                   CONTADO
                                </a>
                            	</div>
							</div>
							
							<div class="col-xs-12 col-sm-3 emphasis">
								<div class="small-box bg-maroon">
                                <div class="inner">
                                    <h4>
                                        $ <?php echo $total_p_tarjeta ?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                   TARJETA
                                </a>
                            	</div>
							</div>
	 
							<div class="col-xs-12 col-sm-3 emphasis">
								<div class="small-box bg-olive">
                                <div class="inner">
                                    <h4>
                                        $ <?php echo $total_p_ctacte ?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                   CUENTA CORRIENTE
                                </a>
                            	</div>
							</div>
							
							<div class="col-xs-12 col-sm-3 emphasis">
								<div class="small-box bg-orange">
                                <div class="inner">
                                    <h4>
                                        $ <?php echo $total_p_ctacte ?>
                                    </h4>
                                </div>
                                <a href="#" class="small-box-footer">
                                	ANULADO
                                </a>
                            	</div>
							</div>
            			</div>
    	 			</div>                 
				</div>
			</div>
			<?php	
				}
			}
			?>		
			</div>
		</div>
	</div>
</div>