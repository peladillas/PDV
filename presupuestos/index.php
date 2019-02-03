<?php
include_once('conexion.php');

$sql = "
SELECT 
    * 
FROM 
    vendedor 
WHERE 
    id_estado = 1";
$query_vendedores = mysql_query($sql) ;

$qstring = "
SELECT 
    cantidad_inicial 
FROM 
    config 
WHERE 
    id_config = 1";
$result = mysql_query($qstring) ;//query the database for entries containing the term

while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
{
    $cantidad_inicial = $row['cantidad_inicial'];
}
?>

<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type:application/json; charset=UTF-8" />
    <title>Bulones Sarmiento</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" /> 
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css" type="text/css" /> 
</head>
<body onload="inicializa()">


<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Primer Bloque
            
----------------------------------------------------------------------------------------------------    
--------------------------------------------------------------------------------------------------->    


<div class="container"> 
    <div class="panel panel-default">
        <div class="panel-heading">
            BULONES SARMIENTO 
            <button class="btn btn-default btn-xs show_hide">
                Cabecera
            </button>
            <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal">
                Comentario
            </button>
        </div>
        
<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Modal
            
----------------------------------------------------------------------------------------------------    
---------------------------------------------------------------------------------------------------> 
        
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
				<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="myModalLabel">Comentario</h4>
      			</div>
		      	<div class="modal-body">
		        	<textarea class="form-control" rows="3" id="comentario" name="comentario"></textarea>
		        	<div class="checkbox">
						<label>
							<input type="checkbox" value="" id="com_publico" name="com_publico">
					    	Publico
						</label>
					</div>
		      	</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal" id="cancel_comentario">Cancelar</button>
        			<button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
      			</div>
    		</div>
  		</div>
	</div>
        
<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Labels
            
----------------------------------------------------------------------------------------------------    
--------------------------------------------------------------------------------------------------->    

		 <div class="panel-body slidingDiv">
            <div class="row">
                <div class="form-group col-md-6 ">
                    <label for="email" class="control-label">Buscar</label>
                </div>
                
                <div class="form-group col-md-1">
                </div>
                        
                <div class="cont_rotulo_presupuesto form-group col-md-2">
                    <label class="col-sm-2 control-label">Fecha</label>
                </div>
                
                <div class="cont_rotulo_presupuesto form-group col-md-3">
                    <label class="col-sm-4 control-label">CONTADO</label>
                    <label class="col-sm-4 control-label">TARJETA</label>
                    <label class="col-sm-4 control-label">CTA CTE</label>
                </div>
            </div>  
        
        
<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Inputs
            
----------------------------------------------------------------------------------------------------    
--------------------------------------------------------------------------------------------------->    
        
        
            <div class="row" id="cont_datos_buscador">
                <div class="form-group col-md-6 ">
                    <input class="data_cliente form-control" type="text" id="carga_cliente" placeholder="Alias o Cuil/Cuit"/>
                </div>
                
                <!-- Aca esta el button que estabas necesitando -->
                <div class="form-group col-md-1">
                    <button onclick="limpia_cli()" class="btn btn-danger form-control" id="search" name="search">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                </div>
                        
                <div class="cont_rotulo_presupuesto form-group col-md-2">
                    <input class="data_presupuesto form-control" type="text" id="fecha_presupuesto" value=""/>
                </div>
                
                <div class="cont_rotulo_presupuesto form-group col-md-3">
                    <div class="col-md-4">
                        <input class='form-control' style="box-shadow:none; height: 27px;" type="radio" id="tipo_presupuesto_contado" name="tipo" value="1" checked>
                    </div>
                    <div class="col-md-4">
                        <input class='form-control' style="box-shadow:none; height: 27px;" type="radio" id="tipo_presupuesto_TARJETA" name="tipo" value="3">
                    </div>
                    <div class="col-md-4">
                        <input class='form-control' style="box-shadow:none; height: 27px;" type="radio" id="tipo_presupuesto_ctacte" name="tipo" value="2">
                    </div>
                    
                </div>
            </div>  
                
            <div class="row" id="cont_datos_presupuesto"><!-- Este me quedo vacio no lo borre por las dudas de que lo uses, revisa si no lo usas volalo -->
            </div>

        
<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Datos del cliente
            
----------------------------------------------------------------------------------------------------    
--------------------------------------------------------------------------------------------------->    
        
        
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
    </div> <!-- panel panel-default-->
    
    
<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Segundo bloque carga de articulos
            
----------------------------------------------------------------------------------------------------    
--------------------------------------------------------------------------------------------------->    

    
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
                                    <input class="form-control" type='number' name='cantidad' value='<?php echo $cantidad_inicial?>' id='cantidad'/>
                                    <p><input onclick="carga(item_elegido)" type='button' id="carga_articulo" hidden="hidden"/></p>
                                </div>
                            </div>
                        </p>
                    </div>  
                </form>
                </div>
            </div>
        </div>
    </div> <!-- panel panel-default-->
    
    
<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Segundo bloque carga de articulos
            
----------------------------------------------------------------------------------------------------    
--------------------------------------------------------------------------------------------------->    


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="row">
                        <label for="inputEmail3" class="col-sm-3 control-label">TOTAL</label>
                        <label for="inputEmail3" class="col-sm-2 control-label">Total iva</label>
                        <label for="inputEmail3" class="col-sm-2 control-label">%Desc.</label>
                        <label for="inputEmail3" class="col-sm-2 control-label">Vendedor</label>
                    </div>  
                    <div id="totales_de_factura" class="row">
                        <div id="cont_fac" class="col-sm-3">
                            <input type='number' class='form-control' disabled value='0' id='total_presupuesto'style="background-color: #5cb85c; color: #fff;"/>
                        </div>
                        <div class="col-sm-2">
                            <input type='number'  disabled value='0' id='total_iva' class='form-control'/>
                        </div>
                        <div class="col-sm-2">
                            <input onchange="descuento()" type='number' autocomplete="off" value='0' disabled="disabled" id='descuento' min="0" max="100" class='form-control'/>
                        </div>
                        
                        <div class="col-sm-2">
                            <select name="vendedor" id="vendedor" class="form-control" autocomplete onchange="$('#quickfind').focus()">
                            <?php
                            if($query_vendedores){
                                while ($row_vendedor = mysql_fetch_array($query_vendedores,MYSQL_ASSOC))//loop through the retrieved values
                                {
                                    echo "<option value=".$row_vendedor['id_vendedor']."> ".$row_vendedor['vendedor']."</option>";
                                }
                            }
                            ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button id="cont_boton" onclick="carga_presupuesto()" hidden="true" class="btn btn-primary form-control">CARGAR PRESUPUESTO</button>
                        </div>                    
                    </div>
                    <hr>
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
    </div> <!-- class="row" -->
</div> <!-- class="container" -->

  
<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Carga de librerias
            
----------------------------------------------------------------------------------------------------    
--------------------------------------------------------------------------------------------------->    


<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>      
<script type="text/javascript" src="js/buscador.js"></script> 
<script type="text/javascript" src="librerias/bootstrap/js/bootstrap.js"></script>   

<script>
$(document).ready(function(){
    $(".slidingDiv").hide();
    $(".show_hide").show();
 
    $('.show_hide').click(function(){
        $(".slidingDiv").slideToggle();
    });
});

$(document).ready(function(){
	 $("#cancel_comentario").click(function() {
  		 $('#comentario').val('');
	});
});

</script>
  
  
<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Carga devoluciones ?
            
----------------------------------------------------------------------------------------------------    
--------------------------------------------------------------------------------------------------->    


    <div id="devoluciones" style="display:none">
        <div class="row cabecera">
            <div class="col-xs-12 cabecera">
                <span class="col-xs-1">Devolucion</span>
                <span class="col-xs-2">Fecha</span>
                <span class="col-xs-1">Monto</span>
                <span class="col-xs-1">A cuenta</span>
                <span class="col-xs-4">Nota</span>
                <span class="col-xs-3">Accion</span>
            </div>
            <div id="reglon_devoluciones" class="col-xs-12">
            </div>
        </div>
    </div>  
</body>
</html>