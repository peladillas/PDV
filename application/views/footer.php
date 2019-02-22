<div class="flotante">
<a href="#" class="scrollup btn btn-default btn-lg" >
    <?php echo setIcon('arrow-up'); ?>
</a>
</div>
<?php
    echo setJs('chosen/chosen.jquery.js');
?>

<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
</script>