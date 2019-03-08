<?php
$html = startContent(lang('empresa'));

// Comienzo del form
$html .= '<form class="form-inline">';
$html .= $documents->get_form();
$html .= '</form>';

$html .= endContent();

echo $html;
?>

<div>
    <select class="form-control" id="testSelect">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>

    <div class="testInput hide" id="input_1">
        <input class="form-control" name="cheque_data">
    </div>
    <div class="testInput hide" id="input_2">
        <select class="form-control" id="testSelect" name="cuota_cantidad">
            <option value="1">1</option>
            <option value="2">3</option>
            <option value="3">6</option>
            <option value="9">9</option>
            <option value="12">12</option>
        </select>
        <select class="form-control" name="cuota_inicio" id="cuota_inicio">
        <?php
        for ($i = 1; $i <= 31; $i++) {
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
        ?>
        </select>
        <select class="form-control" name="cuota_vencimiento" id="cuota_vencimiento">
        <?php
        for ($i = 1; $i <= 31; $i++) {
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
        ?>
        </select>
        <input class="form-control" name="cuota_interes" value="">
        <input class="form-control" name="cuota_monto" disabled>
    </div>
</div>

<script>
    $('#testSelect').on("change", function(e) {
        a = $("#testSelect option:selected" ).val();

        $('.testInput').addClass('hide');
        if(a == 2){
            $('#input_1').removeClass('hide');
        }else if(a > 2) {
            $('#input_2').removeClass('hide');
        }
    });

    $('#cuota_inicio').on("change", function(e) {
        inicio = $("#cuota_inicio option:selected" ).val();
        vencimiento = $("#cuota_vencimiento option:selected" ).val();

        if(inicio > vencimiento){
            $('#cuota_vencimiento').val('')
        }

        $('#cuota_vencimiento').each(function() {
            if ( $(this).val() < inicio ) {
                $(this).remove();
            }
        });
    });

    $('#cuota_vencimiento').on("change", function(e) {
        inicio = $("#cuota_inicio option:selected" ).val();
        vencimiento = $("#cuota_vencimiento option:selected" ).val();

        if(inicio > vencimiento){
            $('#cuota_inicio').val('')
        }

        $('#cuota_inicio').each(function() {
            if ( $(this).val() > vencimiento ) {
                $(this).remove();
            }
        });
    });
</script>
