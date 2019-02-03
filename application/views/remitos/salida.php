<div class="container"> 
	<div class="panel panel-default">
	<div class="panel-heading">BULONES SARMIENTO <button class="btn btn-default btn-xs show_hide">Cabecera</button></div>
	<div class="panel-body slidingDiv">
	<div class="row" id="cont_datos_cliente">
			<div class="cont_rotulo_cliente col-md-4">
				<div class="form-group">
					<label for="email" class="control-label">Nombre</label>
					<input class="data_cliente form-control input-cien" type="text" id="carga_cliente" value="ANONIMO"/>
				</div>
			</div>
			<div class="cont_rotulo_cliente col-md-4">
				<div class="form-group">
					<label for="email" class="control-label">Domicilio</label>
					<input class="data_cliente form-control input-cien" type="text" id="direccion_cliente" value="XXX"/>
				</div>
			</div>
			<div class="cont_rotulo_cliente col-md-4">
				<div class="form-group">
					<label for="email" class="control-label">Telefono</label>
					<input class="data_cliente form-control input-cien" type="text" id="telefono_cliente" value="XXX"/>
				</div>
			</div>
			<input hidden="hidden" type="text" id="id_cliente" value="0000"/>
	</div>
	
	<div class="row" id="cont_datos_presupuesto">
			<div class="cont_rotulo_presupuesto col-md-4">
				<div class="form-group">
					<label for="email" class="control-label">Nro presupuesto</label>
					<input class="data_presupuesto form-control input-cien" type="text" id="num_presupuesto" value="juan perez"/>
				</div>
			</div>
			<div class="cont_rotulo_presupuesto col-md-4">
				<div class="form-group">
					<label for="email" class="control-label">Fecha</label>
					<input class="data_presupuesto form-control input-cien" type="text" id="fecha_presupuesto" value="<?php echo date("d/m/Y"); ?>"/>
				</div>
			</div>
			<div class="cont_rotulo_presupuesto col-md-4">
				<div class="form-group">
					<label for="email" class="control-label">Tipo</label>
					<input type="radio" id="tipo_presupuesto" name="tipo" value="1" checked>PAGO
					<input type="radio" id="tipo_presupuesto" name="tipo" value="2"> CTA CTE
				</div>
			</div>
			
	</div>
	
	</div>
	</div>
	
	<div class="panel panel-default">
	<div class="panel-body">
	<div id="cont_busqueda_articulo">	
		<div id="cont_busca">
		<form action='' method='post'>
			<div class="row">
				<p>
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label">BUSCAR:</label>
							<input class="form-control" type='text' placeholder="ingresar codigo o descripcion" name='country' value='' id='quickfind' style="width: 100%"/>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Precio</label>
							<input class="form-control input-cien" id="px_unitario_rapido" readonly="true"/>
						</div>
					</div>	
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Cantidad:</label>
							<input class="form-control" type='number' name='cantidad' value='1' id='cantidad' style="width: 100%"/>
							<p><input onclick="carga(item_elegido)" type='button' id="carga_articulo" hidden="hidden" /></p>
						</div>
					</div>
				</p>
			</div>  
		</form>
		</div>
	</div>
	</div>
	</div>
	
	
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>		
<script type="text/javascript" src="js/buscador.js"></script>	

<script>
	$(document).ready(function(){
        $(".slidingDiv").hide();
        $(".show_hide").show();
 
    $('.show_hide').click(function(){
    $(".slidingDiv").slideToggle();
    });
 
});
</script>
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-success">
		<div class="panel-body">
			<div id="reglon_factura" class="row">
				<div id="cont_fac" class="col-md-8 col-md-offset-2">
					<button id="cont_boton" onclick="carga_presupuesto()" hidden="true" class="btn btn-primary pull-right">Carga presupuesto</button>
					<input type='text'  value='0' id='total_presupuesto' class="form-control"/>
					<hr>
				</div>
				<span class="titulo_item_reglon col-sm-7"><b>DETALLE</b></span>
				<span class="titulo_cant_item_reglon col-sm-1"><b>CANT</b></span>
				<span class="titulo_px_item_reglon col-sm-1"><b>P.U</b></span>
				<span class="titulo_px_reglon col-sm-2"><b>SUBTOTAL</b></span>
				<span class="col-sm1"></span>
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>
