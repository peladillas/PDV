<!doctype html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type:application/json; charset=UTF-8" />
  <title>Bulones Sarmiento</title>
  <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" /> 
  <!--
  <link rel="stylesheet" href="css/fac.css" type="text/css" />
  -->
  
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css" type="text/css" />
  <!--<script src="librerias/bootstrap/js/bootstrap.js"></script>-->

</head>
<body onload="inicializa()">



	
	


<div class="container"> 
	<div class="panel panel-default">
	<div class="panel-heading">BULONES SARMIENTO <button class="btn btn-default btn-xs show_hide">Cabecera</button></div>
	<div class="panel-body slidingDiv">
	<div class="row" id="cont_datos_presupuesto">
			<div class="cont_rotulo_presupuesto  col-md-12">
				<label class="col-md-12 control-label">Presupuesto</label>
				
			</div>
			
			<div class="cont_rotulo_presupuesto  col-md-8">
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Fecha</label>
					<input class="data_presupuesto form-control" type="text" id="fecha_presupuesto" value=""/>
				</div>
			</div>
			<div class="cont_rotulo_presupuesto  col-md-4">
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Tipo</label>
					<input type="radio" id="tipo_presupuesto_contado" name="tipo" value="1" checked>PAGO
					<input type="radio" id="tipo_presupuesto_ctacte" name="tipo" value="2"> CTA CTE
				</div>
			</div>
			
	</div>
	<div class="row" id="cont_datos_buscador">
			
				<div class="form-group col-md-4 ">
					<label for="email" class="control-label">Buscar</label>
					<input class="data_cliente form-control" type="text" id="carga_cliente" placeholder="Alias o Cuil/Cuit"/>
				</div>
	</div>
	<div class="row" id="cont_datos_cliente">
			
			<div class="cont_rotulo_cliente col-md-3">
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Nombre</label>
					<input class="data_cliente form-control" disabled type="text" id="nombre_cliente" value=""/>
				</div>
				
			</div>
			
			<div class="cont_rotulo_cliente col-md-3">
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Apellido</label>
					<input class="data_cliente form-control" disabled type="text" id="apellido_cliente" value=""/>
				</div>
			</div>
			
			
			<div class="cont_rotulo_cliente col-md-3">
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Domicilio</label>
					<input class="data_cliente form-control" disabled type="text" id="domicilio_cliente" value=""/>
				</div>
			</div>
			<div class="cont_rotulo_cliente col-md-3">
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Cuil/Cuit</label>
					<input class="data_cliente form-control" type="text" disabled id="cuit_cliente" value=""/>
				</div>
			</div>
			<input hidden="hidden" type="text"  id="id_cliente" value="0"/>
	</div>
	
	
	
	</div>
	</div>
	
	<div class="panel panel-default">
	<div class="panel-body">
	<div id="cont_busqueda_articulo">	
		<div id="cont_busca">
		<form  action='' method='post'>
			<div class="row">
				<p>
					<div class="col-md-8">
						<div class="form-group">
							<label class="col-sm-2 control-label">BUSCAR:</label>
							<input class="form-control" type='text' placeholder="Cod o Detalle" name='country' value='' id='quickfind'/>
							<!--<input class="form-control" type='text' placeholder="Busqueda x Codigo" name='country' value='' id='quickfind_cod'/>
						--></div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="col-sm-2 control-label">Precio</label>
							<input class="form-control" id="px_unitario_rapido" readonly="true"/>
						</div>
					</div>	
					<div class="col-md-2">
						<div class="form-group">
							<label class="col-sm-2 control-label">Cantidad:</label>
							<input class="form-control" type='number' name='cantidad' value='1' id='cantidad'/>
							<p><input onclick="carga(item_elegido)" type='button' id="carga_articulo" hidden="hidden"/></p>
						</div>
					</div>
				</p>
			</div>  
		</form>
		</div>
	</div>
	</div>
	</div>
	<div id="menu_presupuesto">
	<div id="cont_boton" onclick="carga_presupuesto()" hidden="true" class="btn btn-primary">carga presupuesto</div>
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
			<div id="totales_de_factura" class="row">
				
				<label for="inputEmail3" class="col-sm-1 control-label">TOTAL</label>
				<div id="cont_fac" class="col-sm-5">
					<input type='number' class='form-control' disabled value='0' id='total_presupuesto'style="background-color: #5cb85c; color: #fff;"/>
				</div>
				<label for="inputEmail3" class="col-sm-1 control-label">Total iva</label>
				<div class="col-sm-3">
					<input type='number'  disabled value='0' id='total_iva' class='form-control'/>
				</div>
				<label for="inputEmail3" class="col-sm-1 control-label">%Desc.</label>
				<div class="col-sm-1">
					<input onchange="descuento()" type='number' autocomplete="off" value='0' disabled="disabled" id='descuento' min="0" max="100" class='form-control'/>
				</div>
				
				<hr>
			</div>	
			<div id="reglon_factura" class="row">	
				<span class="titulo_item_reglon col-sm-5"><b>DETALLE</b></span>
				<span class="titulo_cant_item_reglon col-sm-1"><b>CANT</b></span>
				<span class="titulo_px_item_reglon col-sm-1"><b>P.U </b></span>
				<span class="titulo_px_item_reglon col-sm-1"><b>IVA</b></span>
				<span class="col-sm-1"><b>% IVA</b></span>
				<span class="titulo_px_reglon col-sm-1"><b>SUBTOTAL</b></span>
				<span class="col-sm-1"></span>
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>