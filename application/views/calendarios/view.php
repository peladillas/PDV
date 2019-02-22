<?php
$html = startContent(lang('evetos'), 6);
$html .= $output;
$html .= '</div></div></div>';

$html .= '<div class="col-md-6">';
$html .= '<div class="panel panel-default">';
$html .= '<div class="panel-heading">';
$html .= lang("calendario");
$html .= '<div><div class="panel-body"><div id="calendar"></div></div></div></div>';

$html .= endContent();

echo $html;
?>