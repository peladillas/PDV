<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
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
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a title="Administración" class="navbar-brand" href='<?php echo site_url('home')?>'><?php echo lang('admin')?></a>
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    $dropdownMenuCatalogos = [
                        setLinkMenu('articulos/articulo_abm', lang('articulos')),
                        setLinkMenu('proveedores/proveedor_abm', lang('proveedores')),
                        dividerMenu(),
                        setLinkMenu('articulos/grupo_abm', lang('grupo')),
                        setLinkMenu('articulos/categoria_abm', lang('categoria')),
                        setLinkMenu('articulos/subcategoria_abm', lang('sub_categoria')),
                        dividerMenu(),
                        setLinkMenu('articulos/actualizar_precios_lote', lang('actualizar_precios')),
                    ];

                    $dropdownMenuVentas = [
                        setLinkMenu('presupuestos/salida', lang('presupuesto')),
                        setLinkMenu('presupuestos/remito', lang('remito')),
                        dividerMenu(),
                        setLinkMenu('presupuestos/presupuesto_abm', lang('presupuestos')),
                        setLinkMenu('remitos/remitos_abm', lang('remitos')),
                        setLinkMenu('devoluciones/devoluciones_abm', lang('devoluciones')),
                        setLinkMenu('vendedores/vendedores_abm', lang('vendedores')),
                    ];

                    $dropdownMenuClientes = [
                        setLinkMenu('clientes/cliente_abm', lang('clientes')),
                        dividerMenu(),
                        setLinkMenu('clientes/tipo_abm', lang('tipo')),
                        setLinkMenu('clientes/condicion_iva_abm', lang('condicion_iva')),
                    ];

                    $dropdownMenuEstadisticas = [
                        setLinkMenu('estadisticas/mensual', lang('mensual')),
                        setLinkMenu('estadisticas/anual', lang('anual')),
                        etLinkMenu('estadisticas/resumen', lang('resumen')),
                    ];

                    $dropdownMenuConfig = [
                        setLinkMenu('usuarios/usuario_abm', lang('usuarios')),
                        setLinkMenu('usuarios/roles_abm', lang('roles')),
                        dividerMenu(),
                        setLinkMenu('configs/impresion_abm', lang('impresion')),
                        setLinkMenu('configs/backup', lang('backup')),
                        setLinkMenu('configs/config_abm/edit/1', lang('config')),
                    ];

                    echo dropdownMenu(lang('catalogos'), $dropdownMenuCatalogos);
                    echo dropdownMenu(lang('ventas'), $dropdownMenuVentas);
                    echo dropdownMenu(lang('clientes'), $dropdownMenuClientes);
                    echo dropdownMenu(lang('estadisticas'), $dropdownMenuEstadisticas);
                    echo dropdownMenu(lang('config'), $dropdownMenuConfig);
                    ?>
                    <li>
                        <a href="<?php echo site_url('home/logout')?>"><span class="icon-off"></span> <?php echo lang('salir')?></a>
                    </li>
                </ul>

                <li style="color:#b3b3b3;" class="pull-right">
                    <?php echo 'SERVER: '.date('d-m-y H:i:s'); ?>
                </li>
            </div>
        </div>
    </nav>