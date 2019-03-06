<?php
$html = startContent(lang('empresa'));
$html .= setJs('main/js/nota_credito.js');
$html .= setJs('main/js/form_invoice_helpers.js');

// Comienzo del form
$html .= '<form class="form-inline">';

// Head de la nota de credito
$html .= '<div id="form-heading">';



$html .= '</div><hr>';

// Detail de la nota de credito
$html .= '<div id="form-detail" class="hide">';

$html .= setFormGroup('articulo', '', 'autocomplete="off"');
$html .= setFormGroup('cantidad');
$html .= setFormGroup('precio');
$html .= setFormGroup('total');
$html .= setButton(lang('agregar'), 'agregar');
$html .= setHiddenInput('id_articulo');

$html .= '</div>';
$html .= '</form>';

$html .= '<div id="note-detail" class="hide"></div>';
$html .= endContent();

echo $html;
?>