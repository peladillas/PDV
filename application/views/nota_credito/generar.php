<div class="container"> 
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo lang('empresa') ?></div>
		<div class="panel-body">
			<form class="form-inline">
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
  				<div class="form-group">
    				<label for="total_nota_credito"><?php echo lang('total').' '.lang('nota_credito')?></label>
    				<input type="text" class="form-control" name="total_nota_credito" id="total_nota_credito" value="0" disabled>
  				</div>
			</div>
			
			<hr>
			<div id="form-detail" class="hide">
				<div class="form-group">
    				<label for="id_articulo"><?php echo lang('articulo')?></label>
    				<input class="form-control" type='text' placeholder="Cod o Detalle" name='articulo' id='articulo' autocomplete="off"/>
    				<input type='hidden'  name='id_articulo' id='id_articulo'/>
    			</div>
    			<div class="form-group">
    				<label for="cantidad"><?php echo lang('cantidad')?></label>
    				<input class="form-control" type='number' placeholder="Cantidad" name='cantidad' id='cantidad'/>
    			</div>
    			<div class="form-group">
    				<label for="precio"><?php echo lang('precio')?></label>
    				<input class="form-control" type='text' placeholder="Precio" name='precio' id='precio'/>
    			</div>
    			<div class="form-group">
    				<label for="total"><?php echo lang('total')?></label>
    				<input class="form-control" type='text' disabled name='total' id='total'/>
    			</div>
    			<button type="button" id="agregar" class="btn btn-default">Agregar</button>
			</div>
			</form>
			<div id="note-detail" class="hide">
			</div>
		</div>
	</div>
</div>
</div>

<script>
	
$(function() {
	$("#nombre").focus();
	
/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Busqueda de cliente

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/	

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
	
/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Cargar cliente

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/	
	
	$("#seleccionar").click(function(){
		if($("#id_cliente").val() == ''){
			alert("Seleccione cliente");
			$("#nombre").val("").focus();
		}else{
			$("#form-detail").toggleClass('hide');
			$("#articulo").focus();
		}
		
	});
	
/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Busqueda de articulo y cambio de foco cantidad

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/	
	
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
	
/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Precio, calculo de total

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/	
	
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
	
/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Agregar renglon de la nota de credito

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/	
	
	$("#agregar").click(function(){
		if($("#id_articulo").val() == ''){
			alert("Seleccione articulo");
			$("#articulo").val("").focus();
		} else if($("#cantidad").val() == ''){
			alert("Seleccione cantidad");
			$("#cantidad").val("").focus();
		} else{
			$("#note-detail").removeClass('hide');
			var id_articulo = $("#id_articulo").val();
			if($('#cont_borra'+id_articulo).length){
				borra_reglon(id_articulo);
			} else {
				var largo	= $('#note-detail').height();
				largo	= largo + 30;
			}
			
			
			var texto = $("#articulo").val();
			var cantidad = $("#cantidad").val();
			var precio = $("#precio").val();
			var total = $("#total").val();
			
			
			$('#note-detail').height(largo);
			$('#note-detail').append('<div id="cont_borra'+id_articulo+'" class="cont_reglon_item_presup row" style="padding-left: 15px"></div>');
			$('#cont_borra'+id_articulo).append('<span class="item_reglon col-md-5" id='+id_articulo+' >'+texto+'</span>');
			$('#cont_borra'+id_articulo).append('<input  disabled class="cant_item_reglon col-md-1" id=detail_cantidad_'+id_articulo+' value='+cantidad+'>');
			$('#cont_borra'+id_articulo).append('<input disabled  class="px_item_reglon col-md-1" id="detail_precio_'+id_articulo+'" value='+precio+'>');
			
			$('#cont_borra'+id_articulo).append('<input disabled  class="detail_total col-md-1" id="detail_total_'+id_articulo+'" value='+total+'>');
			$('#cont_borra'+id_articulo).append('<div class="col-md-1" id=cont_botones'+id_articulo+'>');
			$('#cont_botones'+id_articulo).append('<button title="Borrar linea" class="ico_borra btn btn-danger btn-xs pull-left" onclick="borra_reglon('+id_articulo+')" id="ico_borra'+id_articulo+'"></button>');
			$('#ico_borra'+id_articulo).append('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>');
			$('#cont_borra'+id_articulo).append('</div></div>');
	
			$("#id_articulo").val("");
			$("#articulo").val("");
			$("#cantidad").val("");
			$("#precio").val("");
			$("#total").val("");
			$("#articulo").focus();
			calcula_total();
		}
	});
});

/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Elimina renglon en el presupuesto

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/	

function borra_reglon(a){	
	$('#cont_borra'+a).empty();
	$('#cont_borra'+a).remove();
	var nuevo_largo=$('#note-detail').height();
	nuevo_largo=nuevo_largo-30;
	$('#note-detail').height(nuevo_largo);
	calcula_total();
}

/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Calcula el total del presupuesto

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/	

function calcula_total(iva) {
	var total	= 0;
	var temp	= 0;
	
	$(".detail_total").each(function (index) {
		temp = $(this).val();
		total=parseFloat(total)+parseFloat(temp);
	});
	
	$('#total_nota_credito').val(total.toFixed(2));
}

</script>
</body>
</html>
