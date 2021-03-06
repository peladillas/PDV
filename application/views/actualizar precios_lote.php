<script>
$(document).ready(function() {
    $('#table_actualizacion').dataTable();
});
</script>

<?php echo startContent(lang('actualizar_precios')); ?>

<!---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Formulario de busqueda

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------->

<?php echo form_open('articulos/actualizar_precios_lote');?>

    <div class="row">
        <div for="proveedor" class="col-sm-2 control-label"><?php echo lang('proveedor')?></div>
        <div class="col-sm-4">
            <select class="form-control chosen-select" name="proveedor" id="proveedor">
                <option value=""></option>
                <?php foreach ($proveedores as $proveedor) { ?>
                    <option value="<?php echo $proveedor->descripcion?>"><?php echo $proveedor->descripcion ?></option>
                <?php } ?>
            </select>
        </div>
        <div for="grupo" class="col-sm-2 control-label"><?php echo lang('grupo')?></div>
        <div class="col-sm-4">
            <select class="form-control chosen-select" name="grupo" id="grupo">
                <option value=""></option>
                <?php foreach ($grupos as $grupo) { ?>
                    <option value="<?php echo $grupo->descripcion?>"><?php echo $grupo->descripcion ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div for="categoria" class="col-sm-2 control-label"><?php echo lang('categoria')?></div>
        <div class="col-sm-4">
            <select class="form-control chosen-select" name="categoria" id="categoria">
                <option value=""></option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria->descripcion?>"><?php echo $categoria->descripcion ?></option>
                <?php } ?>
            </select>
        </div>

        <div for="sub-categoria" class="col-sm-2 control-label"><?php echo lang('sub_categoria')?></div>
        <div class="col-sm-4">
            <select class="form-control chosen-select" name="sub-categoria" id="sub-categoria">
                <option value=""></option>
                <?php foreach ($subcategorias as $subcategoria) { ?>
                    <option value="<?php echo $subcategoria->descripcion?>"><?php echo $subcategoria->descripcion ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div for="variacion" class="col-sm-2 control-label"><?php echo lang('variacion')?></div>
        <div class="col-sm-4">
            <input type="number" class="form-control" placeholder="Variación" name="variacion" min="-100" max="100" step="0.1" id="slider" onchange="Positivo(this)" required>
        </div>
        <div for="variacion" class="col-sm-2 control-label"></div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary form-control" title="Buscar" name="buscar" value="1" onsubmit="debeseleccionar()"><?php echo lang('buscar')?></button>
        </div>
        <div class="col-sm-2">
        </div>
    </div>

<?php echo form_close();?>
</div>
</div>

<?php if($this->input->post('buscar')){ ?>
    <div class="panel">
        <div class="panel-body">

            <!--------------------------------------------------------------------
            ----------------------------------------------------------------------
                        Tabla de articulos
            ----------------------------------------------------------------------
            --------------------------------------------------------------------->

            <?php if($this->input->post('confirmar')){?>
                <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $mensaje ?>
                </div>
            <?php }else{ ?>
                 <?php echo form_open('articulos/actualizar_precios_lote');?>
                     <input type="hidden" name="proveedor" value="<?php echo $this->input->post('proveedor');?>">
                     <input type="hidden" name="grupo" value="<?php echo $this->input->post('grupo');?>">
                     <input type="hidden" name="categoria" value="<?php echo $this->input->post('categoria');?>">
                     <input type="hidden" name="subcategoria" value="<?php echo $this->input->post('subcategoria');?>">
                     <input type="hidden" name="variacion" value="<?php echo $this->input->post('variacion');?>">
                     <input type="hidden" name="buscar" value="1">
                     <center>
                     <button type="submit" name="confirmar" value="1" title="Cambiara los precios que aparecen en esta lista" class="btn btn-info btn-lg">
                        Confirmar
                     </button>
                     <?php echo $mensaje ?>
                     </center>
                <?php echo form_close();?>
            <?php }
            if($articulos){
                $cabecera = [
                    lang('codigo'),
                    lang('descripcion'),
                    lang('venta'),
                    lang('sin_iva'),
                    lang('costo'),
                    lang('proveedor'),
                    lang('grupo'),
                    lang('categoria'),
                    lang('sub_categoria'),
                ];

                $html = startTable($cabecera, 'table_actualizacion');

                foreach ($articulos as $articulo) {
                    $registro = [
                        $articulo->cod_proveedor,
                        $articulo->descripcion,
                        (strlen($articulo->descripcion)>18 ? substr($articulo->descripcion,0,15)."..." : $articulo->descripcion),
                        number_format($articulo->precio_venta_iva, 2, ",", "."),
                        number_format($articulo->precio_venta_sin_iva, 2, ",", "."),
                        number_format($articulo->precio_costo, 2, ",", "."),
                        (strlen($articulo->proveedor)>8 ? substr($articulo->proveedor,0,5)."..." : $articulo->proveedor),
                        (strlen($articulo->grupo)>8 ? substr($articulo->grupo,0,5)."..." : $articulo->proveedor),
                        (strlen($articulo->categoria)>8 ? substr($articulo->categoria,0,5)."..." : $articulo->proveedor),
                        (strlen($articulo->subcategoria)>8 ? substr($articulo->subcategoria,0,5)."..." : $articulo->proveedor),
                    ];

                    $html .= $registro;
                }

                $html .= endTable();

                echo $html;
            }

            ?>
        </div>
    </div>
<?php
} else {
    if($actualizaciones)
    {
        echo '<div class="row">';
        echo '<div class="col-md-12">';
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">Acualizaciones realizadas</div>';
        echo '<div class="panel-body">';
            echo '<div id="calendar"></div>';
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
echo endContent();
?>