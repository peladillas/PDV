<div class="container"> 
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo lang('empresa') ?></div>
		<div class="panel-body">
			<form class="form-inline">
  				<div class="form-group">
    				<label for="nombre"><?php echo lang('nombre')?></label>
    				<input class="form-control" type='text' placeholder="Nombre, apellido o alias" name='nombre' value='' id='nombre'/>
				</div>
  				<div class="form-group">
    				<label for="fecha"><?php echo lang('fecha')?></label>
    				<input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo date('d/m/Y')?>" disabled>
  				</div>
  				<button type="submit" id="seleccionar" class="btn btn-default">Selecionar</button>
			</form>
		</div>
	</div>
</div>
</div>

<script>
	

$(function() {
	$("#nombre").focus();
	$("#nombre").autocomplete({
	    source: "<?php echo base_url()?>index.php/clientes/getClientes",
	    minLength: 2,
	    select: function(event,ui){
	        //porc_iva_art	= ui.item.iva;
	       	$('#seleccionar').click();
		},
	    
		close: function( event, ui ) {
		}
	});		
});
</script>
</body>
</html>
