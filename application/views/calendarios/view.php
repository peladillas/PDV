<?php
$html = startContent(lang('evetos'), 6);
$html .= $output;
$html .= '</div></div></div>';

$html .= '<div class="col-md-6"><div class="panel panel-default"><div class="panel-heading">';
$html .= lang("calendario");
$html .= '<div><div class="panel-body"><div id="calendar"></div></div></div></div>';

$html .= endContent();

echo $html;
?>