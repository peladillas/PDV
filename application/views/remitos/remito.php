<div class="container"> 
	<div class="panel panel-default">
	<div class="panel-heading">BULONES SARMIENTO</div>
		<div class="panel-body">
			<div class="form-group">
				<form method="post" action="<?php echo base_url().'index.php/presupuestos/remito'?>">
				<label for="clientes" class="col-sm-1 control-label"><?php echo $texto['alias']?></label>
				
				<div class="col-sm-4">
					<select name="cliente_alias" class="form-control chosen-select" style=" width: 100%">
						<option value="0"></option>
						<?php foreach($clientes as $cliente){ ?>
							<option value="<?php echo $cliente->id_cliente?>"
							<?php 
							if($this->input->post('cliente')!==NULL && $this->input->post('cliente')==$cliente->id_cliente)
							{
								echo 'selected';
							}
							?>
							>
							<?php echo $cliente->alias?>
							</option>
						<?php } ?>
					</select>
				</div>
				
				<label for="clientes" class="col-sm-1 control-label"><?php echo $texto['apellido']?></label>
				<div class="col-sm-4">
					<select name="cliente_apellido" class="form-control chosen-select" style=" width: 100%">
						<option value="0"></option>
						<?php foreach($clientes as $cliente){ ?>
							<option value="<?php echo $cliente->id_cliente?>"
							<?php 
							if($this->input->post('cliente')!==NULL && $this->input->post('cliente')==$cliente->id_cliente)
							{
								echo 'selected';
							}
							?>
							>
							<?php echo $cliente->nombre." ".$cliente->apellido?>
							</option>
						<?php } ?>
					</select>
				</div>
				
				<div class="col-sm-2">
					<button type="submit" class="btn btn-default form-control" name="buscar" value="1">
						<?php echo $texto['buscar']?>
					</button>
				</div>
				</form>
			</div>
			
			<?php
			if(isset($presupuestos))
			{
				foreach($clientes as $cliente)
				{
					if($cliente->id_cliente == $id_cliente)
					{
						$array_cliente = array(
							'alias'		=> $cliente->alias,
							'nombre'	=> $cliente->nombre,
							'apellido'	=> $cliente->apellido,
							'telefono'	=> $cliente->telefono,
							'celular'	=> $cliente->celular,
							'direccion'	=> $cliente->direccion,
							'nextel'	=> $cliente->nextel
						);					
					}
				}
			?>
			<br>
			<br>
			
			<form method="post" action="<?php echo base_url().'index.php/presupuestos/remito_insert'?>" onsubmit="return check();">
			
			<ul class="nav nav-tabs">
				<li><a href="#tab3" data-toggle="tab">Cliente: <b><?php echo $array_cliente['alias']?></b></a></li>
    			<li class="active"><a href="#tab1" data-toggle="tab">Presupuestos</a></li>
    			<li><a href="#tab2" data-toggle="tab">Devoluciones</a></li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">
				<div class="panel panel-default" style="box-shadow: none;">
				<div class="panel-body">
				<?php
				
				/**********************************************************************************
			 	***********************************************************************************
				* 
			 	* 				Tabla de presupuestos
				* 
				**********************************************************************************
				**********************************************************************************/
				
				echo "<div class='row' style='border-bottom: 1px solid #ccc;'>";	
					echo "<label class='col-sm-2 control-label'>".$texto['numero']."</label>";
					echo "<label class='col-sm-3 control-label'>".$texto['fecha']."</label>";
					echo "<label class='col-sm-2 control-label'>".$texto['monto']."</label>";
					echo "<label class='col-sm-2 control-label'>".$texto['a_cuenta']."</label>";
					echo "<label class='col-sm-2 control-label'>".$texto['pago']."</label>";
					echo "<label class='col-sm-1 control-label'>".$texto['seleccionar']."</label>";
				echo "</div>";
				
				echo "<br>";
				
				$total_apagar = 0;
								
				if($presupuestos)
				{
					foreach ($presupuestos as $presupuesto) 
					{
						echo "<div class='row'>";	
							echo "<div class='col-sm-2'>".$presupuesto->id_presupuesto."</div>";
							echo "<div class='col-sm-3'>".date('d-m-Y', strtotime($presupuesto->fecha))."</div>";
							echo "<div class='col-sm-2'>".$presupuesto->monto."</div>";
							echo "<div class='col-sm-2'>".$presupuesto->a_cuenta."</div>";
							$total_apagar = $total_apagar + $presupuesto->monto - $presupuesto->a_cuenta;
							echo "<div class='col-sm-2'><input id='$presupuesto->id_presupuesto' name='$presupuesto->id_presupuesto' value='0' type='text' class='form-control importe_linea' onKeyPress='return soloNumeros(event)' onfocusout='ci_remito($presupuesto->id_presupuesto, $presupuesto->monto, $presupuesto->a_cuenta)' style='width:100%'></div>";
							$off = 'off'.$presupuesto->id_presupuesto;
							$on = 'on'.$presupuesto->id_presupuesto;
							echo "	<div class='col-sm-1'>
										<button type='button' class='show btn btn-danger btn-xs' id='$on' onclick='ci_sel_on($presupuesto->id_presupuesto, $presupuesto->monto, $presupuesto->a_cuenta,1)'>Marcar</button>
										<button type='button' class='hide btn btn-success btn-xs' id='$off' onclick='ci_sel_on($presupuesto->id_presupuesto, $presupuesto->monto, $presupuesto->a_cuenta,2)'>Desmarcar</button>
									</div>";
						echo "</div>";
					}
				}
				else
				{
					echo setMensaje($texto['no_registros'], 'warning');
				}
				?>
				</div>
				</div>
				</div>
				
				<div class="tab-pane" id="tab2">
				<div class="panel panel-default" style="box-shadow: none;">
				<div class="panel-body">
				<?php
				
				/**********************************************************************************
				***********************************************************************************
				* 
				* 				Tabla de devoluciones
				* 
				**********************************************************************************
				**********************************************************************************/
				$total_dev = 0;
				
				if($devoluciones)
				{
					echo "<div class='row' style='border-bottom: 1px solid #ccc;'>";	
						echo "<label class='col-sm-1 control-label'>Devolución</label>";
						echo "<label class='col-sm-1 control-label'>Presupuesto</label>";
						echo "<label class='col-sm-1 control-label'>Fecha</label>";
						echo "<label class='col-sm-5 control-label'>Nota</label>";
						echo "<label class='col-sm-1 control-label'>Monto</label>";
						echo "<label class='col-sm-1 control-label'>A cuenta</label>";
						echo "<label class='col-sm-2 control-label'>Total</label>";
					echo "</div>";	
					
					echo "<br>";	
					
					foreach ($devoluciones as $dev) 
					{
						echo "<div class='row'>";	
							echo "<div class='col-sm-1'>".$dev->id_devolucion."</div>";
							echo "<div class='col-sm-1'>".$dev->id_presupuesto."</div>";
							echo "<div class='col-sm-1'>".date('d-m-Y', strtotime($dev->fecha))."</div>";
							echo "<div class='col-sm-5'>".$dev->nota."</div>";
							echo "<div class='col-sm-1'>".$dev->monto."</div>";
							echo "<div class='col-sm-1'>".$dev->a_cuenta."</div>";
							$sub_dev = $dev->monto - $dev->a_cuenta;
							$total_dev = $total_dev + $sub_dev;
							echo "<div class='col-sm-2'>$sub_dev</div>";
							echo "<input name='dev_$dev->id_devolucion' value='$sub_dev' type='hidden' >";
						echo "</div>";
					}
					
					echo "<br>";	
					
					echo "<div class='row' style='border-top: 1px solid #ccc;'>";	
						echo "<label class='col-sm-2 control-label'></label>";
						echo "<label class='col-sm-2 control-label'></label>";
						echo "<label class='col-sm-2 control-label'></label>";
						echo "<label class='col-sm-2 control-label'></label>";
						echo "<label class='col-sm-2 control-label'>Total</label>";
						echo "<label class='col-sm-2 control-label'>$total_dev</label>";
					echo "</div>";	
					
				}
				else
				{
					echo setMensaje('No hay devoluciones');
				}
				
				echo "<input name='total_dev' value='$total_dev' type='hidden' >";
				
				?>
				</div>
				</div>	
				</div>
								
				<div class="tab-pane" id="tab3">
				<div class="panel panel-default" style="box-shadow: none;">
				<div class="panel-body">
				<?php
				echo "<div class='row'>";	
					echo "<label class='col-sm-2 control-label'>Alias</label>";
					echo "<div class='col-sm-4'>".$array_cliente['alias']."</div>";
					echo "<label class='col-sm-2 control-label'>Nombre y apellido</label>";
					echo "<div class='col-sm-4'>".$array_cliente['nombre']." ".$array_cliente['apellido']."</div>";
				echo "</div>";
				echo "<div class='row'>";	
					echo "<label class='col-sm-2 control-label'>Tel.</label>";
					echo "<div class='col-sm-4'>".$array_cliente['telefono']."</div>";
					echo "<label class='col-sm-2 control-label'>Celular</label>";
					echo "<div class='col-sm-4'>".$array_cliente['celular']."</div>";
				echo "</div>";
				echo "<div class='row'>";	
					echo "<label class='col-sm-2 control-label'>nextel</label>";
					echo "<div class='col-sm-4'>".$array_cliente['nextel']."</div>";
					echo "<label class='col-sm-2 control-label'>Dirección</label>";
					echo "<div class='col-sm-4'>".$array_cliente['direccion']."</div>";
				echo "</div>";
				?>
				</div>
				</div>
				</div>	
			</div>
			
			<br>
			<input type='hidden' name='cliente' value="<?php echo $id_cliente?>">
				
	<?php
				
 /**********************************************************************************
 ***********************************************************************************
 * 
 * 				Tabla de totales
 * 
 **********************************************************************************
 **********************************************************************************/
								
				echo "<div class='row well'>";	
					echo "<label class='col-sm-2 control-label'><b>"."TOTAL A PAGAR"."</b></label>";
					echo "<div class='col-sm-2'>".$total_apagar."</div>";
					echo "<input type='hidden' id='total_apagar' value='$total_apagar'>";
					echo "<label class='col-sm-2 control-label'><b>"."TOTAL PAGO"."</b></label>";
					echo "<div class='col-sm-4'><input name='total' id='total' value='0' type='text' class='form-control' style='width:100%' onKeyPress='return soloNumeros(event)'></div>";
					echo "<input id='total_hidden' name='total_hidden' value='0' type='hidden'>";
					$button = 
							"<div class='col-sm-2'>
							<button type='submit' class='btn btn-primary form-control' style='width:100%' ";
					if($total_apagar == 0){
						$button .= 'disabled';
					}		
					$button .=
							">
								Confirmar pago
							</button>
						</div>";
					echo $button;
				echo "</div>";
				
				echo "</form>";
			}
			else
			{
				echo "</div>";
				echo setMensaje($texto['select_registro']);
			}
			?>
		</div>
	</div>	
</div>
</body>
</html>
