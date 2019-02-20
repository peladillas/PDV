<?php echo startContent(lang('empresa') ) ?>
<script src="<?php echo base_url().'librerias/main/js/nota_credito.js'?>"></script>

<form class="form-inline">
    <div id="form-heading">
        <?php
            echo setFormGroup('cliente', '', 'autocomplete="off"');
            echo setFormGroup('fecha', dateFormat(), 'disabled');
            echo '<button type="button" id="seleccionar" class="btn btn-default">Selecionar</button>';
            echo '<input type=\'hidden\' name=\'id_cliente\' id=\'id_cliente\'/>';
            echo setFormGroup('total_nota_credito', 0, 'disabled');
        ?>
    </div>
    <hr>
    <div id="form-detail" class="hide">
        <?php
            echo setFormGroup('id_articulo', '', 'autocomplete="off"');
            echo setFormGroup('cantidad');
            echo setFormGroup('precio');
            echo setFormGroup('total');
            echo '<button type="button" id="agregar" class="btn btn-default">Agregar</button>';
            echo '<input type=\'hidden\'  name=\'id_articulo\' id=\'id_articulo\'/>';
        ?>
    </div>
</form>
<div id="note-detail" class="hide"> </div>
<?php echo endContent(); ?>