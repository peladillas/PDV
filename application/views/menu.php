<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php if(isset($css_files)){ ?>
<?php foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>	
<?php } ?>

<?php if(isset($js_files)){ ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<?php } ?>
</head>
<body>
<nav class="navbar navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a title="Administración" class="navbar-brand" href='<?php echo site_url('home')?>'>Admin.</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav">
        
        <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-clipboardalt"></i>  Catalogo<b class="caret"></b></a>
			<ul class="dropdown-menu">
            	<li><a  href='<?php echo site_url('articulos/articulo_abm')?>'>Articulos</a></li>
            	<li><a  href='<?php echo site_url('proveedores/proveedor_abm')?>'>Proveedores</a></li>
            	<li class="divider"></li>
            	<li><a  href='<?php echo site_url('articulos/grupo_abm')?>'>Grupo</a></li>
            	<li><a  href='<?php echo site_url('articulos/categoria_abm')?>'>Categoria</a></li>
            	<li><a  href='<?php echo site_url('articulos/subcategoria_abm')?>'>Sub categoria</a></li>
            	<li class="divider"></li>
            	<li><a  href='<?php echo site_url('articulos/actualizar_precios_lote')?>'>Actualizar precios</a></li>
          	</ul>
        </li>
        
        
        
        <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-shopping-cart"></i> Ventas<b class="caret"></b></a>
			<ul class="dropdown-menu">
            	<li><a  href='<?php echo site_url('presupuestos/salida')?>'>Presupuesto</a></li>
            	<li><a  href='<?php echo site_url('presupuestos/remito')?>'>Remito</a></li>
            	<li class="divider"></li>
            	<li><a  href='<?php echo site_url('ventas/presupuesto_abm')?>'>Ver presupuestos</a></li>
            	<li><a  href='<?php echo site_url('ventas/remitos_abm')?>'>Ver remitos</a></li>
            	<li><a  href='<?php echo site_url('devoluciones/devoluciones_abm')?>'>Ver devoluciones</a></li>
            	<li><a  href='<?php echo site_url('ventas/vendedores_abm')?>'>Vendedores</a></li>
          	</ul>
        </li>
        
        <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>  Clientes<b class="caret"></b></a>
			<ul class="dropdown-menu">
            	<li><a  href='<?php echo site_url('clientes/cliente_abm')?>'>Clientes</a></li>
            	<li class="divider"></li>
            	<li><a  href='<?php echo site_url('clientes/tipo_abm')?>'>Tipo</a></li>
            	<li><a  href='<?php echo site_url('clientes/condicion_iva_abm')?>'>Condicion Iva</a></li>
            </ul>
        </li>
        
        <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-calendar"></i>  Calendario<b class="caret"></b></a>
			<ul class="dropdown-menu">
            	<li><a  href='<?php echo site_url('calendarios')?>'>Calendario</a></li>
          	</ul>
        </li>
        
         <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-barchartasc"></i>  Estadisticas<b class="caret"></b></a>
			<ul class="dropdown-menu">
            	<li><a  href='<?php echo site_url('estadisticas/mensual')?>'>Mensual</a></li>
            	<li><a  href='<?php echo site_url('estadisticas/anual')?>'>Anual</a></li>
            	<li><a  href='<?php echo site_url('estadisticas/resumen')?>'>Resumen</a></li>
          	</ul>
        </li>
        
        
        <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-tools"></i>  Config<b class="caret"></b></a>
			<ul class="dropdown-menu">
            	<li><a  href='<?php echo site_url('usuarios/usuario_abm')?>'>Usuarios</a></li>
            	<!--<li><a  href='<?php echo site_url('usuarios/roles_abm')?>'>Roles</a></li>-->
          		<li class="divider"></li>
            	<li><a  href='<?php echo site_url('configs/impresion_abm')?>'>Impresión</a></li>
            	<li><a  href='<?php echo site_url('configs/backup/')?>'>Backup</a></li>
            	<li><a  href='<?php echo site_url('configs/config_abm/edit/1')?>'>Config</a></li>
            	
            </ul>
        </li>
        
        
        <li>
        	<a href="<?php echo site_url('home/logout')?>"><span class="icon-off"></span> Salir</a>
        </li>
       </ul>
        
        <li style="color:#b3b3b3;" class="pull-right">
        	<?php echo 'SERVER: '.date('d-m-y H:i:s'); ?>
        </li>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>