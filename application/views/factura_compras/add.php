<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 27/3/2019
 * Time: 19:10
 */

$html = startContent(lang('empresa'));

// Comienzo del form
$html .= '<form class="form-inline">';
$html .= $documents->get_form("factura_compra");
$html .= '</form>';

$html .= endContent();

echo $html;
?>