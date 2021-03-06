<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Type"  content="application/json; charset=UTF-8"/>
    <title><?php echo lang('empresa_titulo')?></title>
    <?php
    if(isset($css_files)){
        foreach($css_files as $file) {
            echo '<link type="text/css" rel="stylesheet" href="'.$file.'">';
        }
    }

    if(isset($js_files)){
        foreach($js_files as $file) {
            echo '<script src="'.$file.'"></script>';
        }
    }
    ?>
</head>
<body>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <?php echo setIcon('bars')?>
                    <?php echo setIcon('bar')?>
                    <?php echo setIcon('bar')?>
                </button>
                <!--<a title="Administración" class="navbar-brand" href='<?php //echo site_url('home')?>'><?php //echo lang('admin')?></a>-->
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    $dropdownMenuCatalogos = array(
                        setLinkMenu('articulos/articulo_abm', lang('articulos')),
                        setLinkMenu('proveedores/proveedor_abm', lang('proveedores')),
                        dividerMenu(),
                        setLinkMenu('articulos/grupo_abm', lang('grupo')),
                        setLinkMenu('articulos/categoria_abm', lang('categoria')),
                        setLinkMenu('articulos/subcategoria_abm', lang('sub_categoria')),
                        dividerMenu(),
                        setLinkMenu('articulos/actualizar_precios_lote', lang('actualizar_precios')),
                    );

                    $dropdownMenuVentas = array(
                        setLinkMenu('presupuestos/salida', lang('presupuesto')),
                        setLinkMenu('remito/remito', lang('remito')),
                        dividerMenu(),
                        setLinkMenu('presupuestos/presupuesto_abm', lang('presupuestos')),
                        setLinkMenu('remitos/remitos_abm', lang('remitos')),
                        setLinkMenu('devoluciones/devoluciones_abm', lang('devoluciones')),
                        setLinkMenu('vendedores/vendedores_abm', lang('vendedores')),
                    );

                    $dropdownMenuClientes = array(
                        setLinkMenu('clientes/cliente_abm', lang('clientes')),
                        dividerMenu(),
                        setLinkMenu('clientes/tipo_abm', lang('tipo')),
                        setLinkMenu('clientes/condicion_iva_abm', lang('condicion_iva')),
                    );

                    $dropdownMenuEstadisticas = array(
                        setLinkMenu('estadisticas/mensual', lang('mensual')),
                        //setLinkMenu('estadisticas/anual', lang('anual')),
                        //setLinkMenu('estadisticas/resumen', lang('resumen')),
                    );

                    $dropdownMenuConfig = array(
                        setLinkMenu('usuarios/usuario_abm', lang('usuarios')),
                        setLinkMenu('usuarios/roles_abm', lang('roles')),
                        dividerMenu(),
                        setLinkMenu('configs/impresion_abm', lang('impresion')),
                        setLinkMenu('configs/backup', lang('backup')),
                        setLinkMenu('configs/config_abm/edit/1', lang('config')),
                    );


                    $dropdownMenuSalir = array(
                        setLinkMenu('home/logout', lang('log_out')),
                    );




                    echo dropdownMenu(lang('catalogos'), $dropdownMenuCatalogos,'database');
                    echo dropdownMenu(lang('ventas'), $dropdownMenuVentas,'shopping-cart');
                    echo dropdownMenu(lang('clientes'), $dropdownMenuClientes,'address-book');
                    echo dropdownMenu(lang('estadisticas'), $dropdownMenuEstadisticas,'chart-pie');
                    echo dropdownMenu(lang('config'), $dropdownMenuConfig,'cogs');
                    echo dropdownMenu(lang('salir'), $dropdownMenuSalir,'sign-out-alt');

                    ?>

                </ul>

                <ul style="color:#b3b3b3;" class="pull-right nav navbar-nav">
                  <!--<li><i class="far fa-clock"></i> <span class"server-clock" id="server-clock"></a></li>-->
                  <?php  echo serverClock( date("d-m-y, H:i"), $dropdownMenuSalir,'clock');?>

                  <script charset="utf-8" type="text/javascript">


                      $(document).ready(function() {

                          function updateTime() {
                            $.ajax({
                             type: 'POST',
                             url: 'server/datetime',
                             timeout: 30000,
                             success: function(data) {
                                $("#serverClock").html(data);
                                window.setTimeout(updateTime(),30000);

                             }
                            });
                           }
                           updateTime();

                      });

                  </script>

                </ul>
            </div>
        </div>
    </nav>
