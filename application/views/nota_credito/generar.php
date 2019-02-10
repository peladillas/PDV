<div class="container"> 
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo lang('empresa') ?></div>
		<div class="panel-body">
			<form class="form-inline">
			<div class="form-heading">
				<div class="form-group">
    				<label for="nombre"><?php echo lang('nombre')?></label>
    				<input class="form-control" type='text' placeholder="Nombre, apellido o alias" name='nombre' id='nombre'/>
    				<input type='hidden'  name='id_cliente' id='id_cliente'/>
				</div>
  				<div class="form-group">
    				<label for="fecha"><?php echo lang('fecha')?></label>
    				<input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo date('d/m/Y')?>" disabled>
  				</div>
  				<button type="submit" id="seleccionar" class="btn btn-default">Selecionar</button>
			</div>
			
			<hr>
			<div class="form-detail">
				<div class="form-group">
    				<label for="nombre"><?php echo lang('articulo')?></label>
    				<input class="form-control" type='text' placeholder="Cod o Detalle" name='articulo' id='articulo'/>
    			</div>
    			<div class="form-group">
    				<label for="nombre"><?php echo lang('cantidad')?></label>
    				<input class="form-control" type='number' placeholder="Cantidad" name='cantidad' id='cantidad'/>
    			</div>
    			<div class="form-group">
    				<label for="nombre"><?php echo lang('precio')?></label>
    				<input class="form-control" type='text' placeholder="Precio" name='precio' id='precio'/>
    			</div>
			</div>
			
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
	        id_cliente	= ui.item.id;
	       	$("#id_cliente").val(id_cliente);
	       	$("#articulo").focus();  	
		},
	    
		close: function( event, ui ) {
		}
	});	
	
	$("#articulo").autocomplete({
	    source: "<?php echo base_url()?>index.php/articulos/getArticulos",
	    minLength: 2,
	    select: function(event,ui){
	        id_cliente	= ui.item.id;
	       	$("#id_cliente").val(id_cliente);
	       	$("#cantidad").focus();  	
		},
	    
		close: function( event, ui ) {
		}
	});		
	
	$("#cantidad").keypress(function( event ) {
		if ( event.which == 13 ) {
			event.preventDefault();
		}
		xTriggered++;
		var msg = "Handler for .keypress() called " + xTriggered + " time(s).";
		$.print( msg, "html" );
		$.print( event );
	});
});
</script>
</body>
</html>
