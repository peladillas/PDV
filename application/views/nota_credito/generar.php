<div class="container"> 
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo lang('empresa') ?></div>
		<div class="panel-body">
			<div id="form-heading">
				<div class="form-group">
    				<label for="nombre"><?php echo lang('nombre')?></label>
    				<input class="form-control" type='text' placeholder="Nombre, apellido o alias" name='nombre' id='nombre' autocomplete="off"/>
    				<input type='hidden'  name='id_cliente' id='id_cliente'/>
				</div>
  				<div class="form-group">
    				<label for="fecha"><?php echo lang('fecha')?></label>
    				<input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo date('d/m/Y')?>" disabled>
  				</div>
  				<button type="button" id="seleccionar" class="btn btn-default">Selecionar</button>
			</div>
			
			<hr>
			<div id="form-detail" class="hide">
				<div class="form-group">
    				<label for="nombre"><?php echo lang('articulo')?></label>
    				<input class="form-control" type='text' placeholder="Cod o Detalle" name='articulo' id='articulo' autocomplete="off"/>
    				<input type='hidden'  name='id_articulo' id='id_articulo'/>
    			</div>
    			<div class="form-group">
    				<label for="nombre"><?php echo lang('cantidad')?></label>
    				<input class="form-control" type='number' placeholder="Cantidad" name='cantidad' id='cantidad'/>
    			</div>
    			<div class="form-group">
    				<label for="nombre"><?php echo lang('precio')?></label>
    				<input class="form-control" type='text' placeholder="Precio" name='precio' id='precio'/>
    			</div>
    			<div class="form-group">
    				<label for="nombre"><?php echo lang('total')?></label>
    				<input class="form-control" type='text' disabled name='total' id='total'/>
    			</div>
    			<button type="button" id="agregar" class="btn btn-default">Agregar</button>
			</div>
			
			<div id="note-detail" class="hide">
			</div>
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
	       	$("#seleccionar").click();  	
		},
	    
		close: function( event, ui ) {
		}
	});	
	
	$("#seleccionar").click(function(){
		if($("#id_cliente").val() == ''){
			alert("Seleccione cliente");
			$("#nombre").val("").focus();
		}else{
			$("#form-detail").toggleClass('hide');
			$("#articulo").focus();
		}
		
	});
	
	$("#articulo").autocomplete({
	    source: "<?php echo base_url()?>index.php/articulos/getArticulos",
	    minLength: 2,
	    select: function(event,ui){
	        id_articulo	= ui.item.id;
	        porc_iva_art	= ui.item.iva;
	        item_elegido	= ui.item;
	        px_unitario		= ui.item.precio;
	        
	        $('#precio').val((px_unitario * ((porc_iva_art/100) + 1 )).toFixed(2));	
	       	$("#id_articulo").val(id_articulo);
	       	$("#cantidad").focus();  	
		},
	    
		close: function( event, ui ) {
		}
	});		
	
	$("#cantidad").keypress(function( event ) {
		if ( event.which == 13 ) {
			$("#precio").focus();  	
		}
	});
	
	$("#precio").focus(function( event ) {
		$('#total').val($('#cantidad').val() * $('#precio').val());	
	});
	
	$("#precio").keypress(function( event ) {
		if ( event.which == 13 ) {
			$("#agregar").click();  	
		}else{
			$('#total').val($('#cantidad').val() * $('#precio').val());	
		}
	});
	
	$("#agregar").click(function(){
		if($("#id_articulo").val() == ''){
			alert("Seleccione articulo");
			$("#articulo").val("").focus();
		}else{
			$("#note-detail").toggleClass('hide');
			$("#articulo").focus();
		}
	});
});
</script>
</body>
</html>
