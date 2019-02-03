<?php

	$this->set_css($this->default_theme_path.'/flexigrid/css/flexigrid.css');
	$this->set_js_lib($this->default_theme_path.'/flexigrid/js/jquery.form.js');
	$this->set_js_config($this->default_theme_path.'/flexigrid/js/flexigrid-add.js');

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
?>
<div class="flexigrid crud-form" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
	<div class="row">
		<div class="col-md-12">
			<div class='ftitle-left'>
				<?php echo $this->l('form_add'); ?> <?php echo $subject?>
			</div>
			<div class='clear'></div>
		</div>
		<div title="<?php echo $this->l('minimize_maximize');?>" class="ptogtitle">
			<span></span>
		</div>
	</div>
<div class='main-table-box'>
	<?php echo form_open( $insert_url, 'method="post" id="crudForm" autocomplete="off" enctype="multipart/form-data" class="form-horizontal"'); ?>
			<?php
			$counter = 0;
				foreach($fields as $field)
				{
					$even_odd = $counter % 2 == 0 ? 'odd' : 'even';
					$counter++;
			?>
			<div class='form-group <?php echo $even_odd?>' id="<?php echo $field->field_name; ?>_field_box">
				<div class='col-sm-2 control-label' id="<?php echo $field->field_name; ?>_display_as_box">
					<?php echo $input_fields[$field->field_name]->display_as; ?><?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""; ?> :
				</div>
				<div class="col-sm-5">
					<div id="<?php echo $field->field_name; ?>_input_box">
						<?php echo $input_fields[$field->field_name]->input?>
					</div>
				</div>
			</div>
			<?php }?>
			<!-- Start of hidden inputs -->
				<?php
					foreach($hidden_fields as $hidden_field){
						echo $hidden_field->input;
					}
				?>
			<!-- End of hidden inputs -->
			<?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>
			
			
			<div id='report-error' class='report-div error'></div>
			<div id='report-success' class='report-div success'></div>
		<div class="row">
		<div class="col-md-12">
			<input id="form-button-save" class="btn btn-default" type='submit' value='<?php echo $this->l('form_save'); ?>'  class="btn btn-large"/>
<?php 	if(!$this->unset_back_to_list) { ?>
			<input type='button' value='<?php echo $this->l('form_save_and_go_back'); ?>' class='btn btn-default' id="save-and-go-back-button"/>
			<input type='button' value='<?php echo $this->l('form_cancel'); ?>' class='btn btn-default' id="cancel-button" />
<?php }else{ ?>
			<input type='button' onclick="window.history.back()" value="Volver" class='btn btn-default'/>			
<?php } ?>
			<div class='small-loading' id='FormLoading'><?php echo $this->l('form_insert_loading'); ?></div>
			<div class='clear'></div>
		</div>
		</div>
	<?php echo form_close(); ?>
</div>
</div>
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_add_form = "<?php echo $this->l('alert_add_form')?>";
	var message_insert_error = "<?php echo $this->l('insert_error')?>";
</script>