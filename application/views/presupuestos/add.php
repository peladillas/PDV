<?php
$html = startContent(lang('empresa'));

// Comienzo del form
$html .= '<form class="form-inline">';
$html .= $documents->get_form();
$html .= '</form>';

$html .= endContent();

echo $html;
?>

<!--
<div>
	<div class="form-group">
		<label for="paymentOptions">Forma de pago</label>
		<select class="form-control" id="paymentOptions">
	        <option value="1">1</option>
	        <option value="2">2</option>
	        <option value="3">3</option>
	        <option value="4">4</option>
    	</select>
	</div>
    

    <div class="paymentData hide" id="divCheck">
    	<div class="form-group">
			<label for="inputCheck">Datos cheque</label>
			<input class="form-control" name="inputCheck" id="inputCheck">
		</div>
    </div>
    <div class="paymentData hide" id="divQuota">
    	<div class="form-group">
			<label for="inputCheck">Datos cheque</label>
	        <select class="form-control" id="quotaQuantity" name="quotaQuantity">
	            <option value="1">1</option>
	            <option value="2">3</option>
	            <option value="3">6</option>
	            <option value="9">9</option>
	            <option value="12">12</option>
	        </select>
	    </div>
	    <div class="form-group">
	    	<label for="quotaStart">Día comienzo</label>
	        <select class="form-control" name="quotaStart" id="quotaStart">
	        <?php
	        for ($i = 1; $i <= 31; $i++) {
	            echo '<option value="'.$i.'">'.$i.'</option>';
	        }
	        ?>
	        </select>
	    </div>
	    <div class="form-group">
	    	<label for="quotaEnd">Día final</label>
	        <select class="form-control" name="quotaEnd" id="quotaEnd">
	        	<?php
		        for ($i = 2; $i <= 31; $i++) {
		            echo '<option value="'.$i.'">'.$i.'</option>';
		        }
		        ?>
	        </select>
	    </div>
	    <div class="form-group">
	    	<label for="quotaInterest">Interes %</label>
	        <input class="form-control" name="quotaInterest" value="">
	    </div>
	    <div class="form-group">
	    	<label for="quotaAmount">Monto cuota</label>
	        <input class="form-control" name="quotaAmount" disabled>
	   	</div>
    </div>
</div>

<script>
    $('#paymentOptions').on("change", function(e) {
        a = $("#paymentOptions option:selected" ).val();

        $('.paymentData').addClass('hide');
        if(a == 2){
            $('#divCheck').removeClass('hide');
        }else if(a > 2) {
            $('#divQuota').removeClass('hide');
        }
    });

    $('#quotaStart').on("change", function(e) {
        start = $("#quotaStart option:selected" ).val();
        end = $("#quotaEnd option:selected" ).val();

        $('#quotaEnd').children('option').remove();

        for (i = start; i < 31; i++) {
            $('#quotaEnd').append($('<option>', {
                value: i,
                text : i
            }));
        }
        
		$('#quotaEnd').val(end)
    });

    $('#quotaEnd').on("change", function(e) {
        start = $("#quotaStart option:selected" ).val();
        end = $("#quotaEnd option:selected" ).val();

        $('#quotaStart').children('option').remove();

        for (i = end; i > 0; i--) {
            $('#quotaStart').append($('<option>', {
                value: i,
                text : i
            }));
        }
    
        $('#quotaStart').val(start);
     
    });
</script>
-->