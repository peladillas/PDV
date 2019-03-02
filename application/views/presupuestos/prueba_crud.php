<?php
$html = startContent(lang('empresa'));

// Comienzo del form
$html .= '<form class="form-inline">';
$html .= $documents->get_head();
$html .= '</form>';

$html .= endContent();

echo $html;
?>