<script>
$(document).ready(function() {
    $('#table_actualizacion').DataTable();
});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
			<div class="panel-body">
				
			<!--------------------------------------------------------------------
			----------------------------------------------------------------------
						Formulario de busqueda
			----------------------------------------------------------------------			
			--------------------------------------------------------------------->

			<?php echo form_open('articulos/actualizar_precios_lote');?> 
				
				<div class="row">
    				<div for="proveedor" class="col-sm-2 control-label">Proveedor</div>
    				<div class="col-sm-4">
						<select class="form-control chosen-select" name="proveedor" id="proveedor">
							<option value=""></option>
							<?php foreach ($proveedores as $proveedor) { ?>
								<option value="<?php echo $proveedor->descripcion?>"><?php echo $proveedor->descripcion ?></option>
							<?php } ?>
						</select>
    				</div>
  				
    				<div for="grupo" class="col-sm-2 control-label">Grupo</div>
    				<div class="col-sm-4">
						<select class="form-control chosen-select" name="grupo" id="grupo">
							<option value=""></option>
							<?php foreach ($grupos as $grupo) { ?>
								<option value="<?php echo $grupo->descripcion?>"><?php echo $grupo->descripcion ?></option>
							<?php } ?>
						</select>
    				</div>
  				</div>
  				
  				<div class="row">
    				<div for="categoria" class="col-sm-2 control-label">Categoria</div>
    				<div class="col-sm-4">
						<select class="form-control chosen-select" name="categoria" id="categoria">
							<option value=""></option>
							<?php foreach ($categorias as $categoria) { ?>
								<option value="<?php echo $categoria->descripcion?>"><?php echo $categoria->descripcion ?></option>
							<?php } ?>
						</select>
    				</div>

    				<div for="sub-categoria" class="col-sm-2 control-label">Sub-categoria</div>
    				<div class="col-sm-4">
						<select class="form-control chosen-select" name="sub-categoria" id="sub-categoria">
							<option value=""></option>
							<?php foreach ($subcategorias as $subcategoria) { ?>
								<option value="<?php echo $subcategoria->descripcion?>"><?php echo $subcategoria->descripcion ?></option>
							<?php } ?>
						</select>
    				</div>
  				</div>
  				
  				<div class="row">
    				<div for="variacion" class="col-sm-2 control-label">Variación</div>
    				<div class="col-sm-4">
						<input type="number" class="form-control" placeholder="Variación" name="variacion" min="-100" max="100" step="0.1" id="slider" onchange="Positivo(this)" required>
					</div>
					<div for="variacion" class="col-sm-2 control-label"></div>
    				<div class="col-sm-2">
    					<button type="submit" class="btn btn-primary form-control" title="Buscar" name="buscar" value="1" onsubmit="debeseleccionar()">Buscar</button>
    				</div>
    				<div class="col-sm-2">
    				</div>
  				</div>
  				
  			<?php echo form_close();?>
  			</div>
  			</div> 
  			
  			<?php if($this->input->post('buscar')){?>
  			<div class="panel">
			<div class="panel-body">
				
				<!--------------------------------------------------------------------
				----------------------------------------------------------------------
							Tabla de articulos
				----------------------------------------------------------------------			
				--------------------------------------------------------------------->
				
				<?php if($this->input->post('confirmar')){?>
					<div class="alert alert-success alert-dismissible" role="alert">
				 	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				  		<?php echo $mensaje ?>
					</div>	
				<?php }else{ ?>
					 <?php echo form_open('articulos/actualizar_precios_lote');?> 
						 <input type="hidden" name="proveedor" value="<?php echo $this->input->post('proveedor');?>">
						 <input type="hidden" name="grupo" value="<?php echo $this->input->post('grupo');?>">
						 <input type="hidden" name="categoria" value="<?php echo $this->input->post('categoria');?>">
						 <input type="hidden" name="subcategoria" value="<?php echo $this->input->post('subcategoria');?>">
						 <input type="hidden" name="variacion" value="<?php echo $this->input->post('variacion');?>">
						 <input type="hidden" name="buscar" value="1">
						 <center>
						 <button type="submit" name="confirmar" value="1" title="Cambiara los precios que aparecen en esta lista" class="btn btn-info btn-lg">
						 	Confirmar
						 </button>
						 <?php echo $mensaje ?>
						 </center>
					<?php echo form_close();?>
				<?php } ?>
				<table class="table table-hover" id="table_actualizacion" style="font-size: 12px">
					<thead>
						<tr class="success">
							<td>Codigo</td>
							<td>Descripcion</td>
							<td>Venta</td>
							<td>s/iva</td>
							<td>Costo</td>
							<td>Proveedor</td>
							<td>Grupo</td>
							<td>Categoria</td>
							<td>SubCate</td>
						</tr>
					</thead>
					<tbody>
						<?php 
						if($articulos){
						foreach ($articulos as $articulo) { ?>
							<tr>
								<td><?php echo $articulo->cod_proveedor?></td>
								<td title="<?php echo $articulo->descripcion?>">
									<?php 
									if(strlen($articulo->descripcion)>18){
										echo substr($articulo->descripcion,0,15)."...";
									}else{
										echo $articulo->descripcion; 
									}?>
								</td>
								<td><?php echo number_format($articulo->precio_venta_iva, 2, ",", ".")?></td>
								<td><?php echo number_format($articulo->precio_venta_sin_iva, 2, ",", ".") ?></td>
								<td><?php echo number_format($articulo->precio_costo, 2, ",", ".") ?></td>
								<td title="<?php echo $articulo->proveedor?>">
									<?php 
									if(strlen($articulo->proveedor)>8){
										echo substr($articulo->proveedor,0,5)."...";
									}else{
										echo $articulo->proveedor; 
									}?>
								</td>
								<td title="<?php echo $articulo->grupo?>">
									<?php 
									if(strlen($articulo->grupo)>8){
										echo substr($articulo->grupo,0,5)."...";
									}else{
										echo $articulo->grupo; 
									}?>
								</td>
								<td title="<?php echo $articulo->categoria?>">
									<?php 
									if(strlen($articulo->categoria)>8){
										echo substr($articulo->categoria,0,5)."...";
									}else{
										echo $articulo->categoria; 
									}?>
								</td>
								<td title="<?php echo $articulo->subcategoria?>">
									<?php 
									if(strlen($articulo->subcategoria)>8){
										echo substr($articulo->subcategoria,0,5)."...";
									}else{
										echo $articulo->subcategoria; 
									}?>
								</td>
							</tr>
						<?php 
						}
						} ?>
					</tbody>
				</table>
			</div>
			</div>
			<?php 
			} 
			else
			{
				if($actualizaciones)
				{
					echo '<div class="row">';
					echo '<div class="col-md-12">';
					echo '<div class="panel panel-default">';
					echo '<div class="panel-heading">Acualizaciones realizadas</div>';
					echo '<div class="panel-body">';
						echo '<div id="calendar"></div>';
					echo "</div>";
					echo "</div>";
					echo "</div>";
					echo "</div>";
				}
			}	
			?>
		</div>
	</div>
</div>