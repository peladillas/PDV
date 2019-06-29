<?php

$html = '';
$html .= setJs('jquery.js');

/*--------------------------------------------------------------------------------
    Bootstrap
--------------------------------------------------------------------------------*/

$html .= setJs('bootstrap/js/bootstrap.js');
$html .= setCss('bootstrap/css/bootstrap_back.css');

/*--------------------------------------------------------------------------------
    Icons
--------------------------------------------------------------------------------*/

//$html .= setCss('font/css/font-awesome.css');
$html .= setCss('font2/css/whhg.css');
$html .= setCss('font5/css/all.css');

/*--------------------------------------------------------------------------------
    Main
--------------------------------------------------------------------------------*/

$html .= setJs('main/js/main.js');
$html .= setCss('main/css/main.css');
$html .= setCss('main/css/form.css');

/*--------------------------------------------------------------------------------
    Jquery UI
--------------------------------------------------------------------------------*/

$html .= setJs('ui/jquery-ui.js');
$html .= setCss('ui/jquery-ui.css');

/*--------------------------------------------------------------------------------
    Bootstrap-switch
--------------------------------------------------------------------------------*/

$html .= setJs('bootstrap/js/bootstrap-switch.js');
$html .= setJs('bootstrap/js/index.js');
$html .= setCss('bootstrap/css/bootstrap-switch.css');

/*--------------------------------------------------------------------------------
    DataTables
--------------------------------------------------------------------------------*/

$html .= setJs('datatables/media/js/jquery.dataTables.min.js');
$html .= setCss('datatables/media/css/jquery.dataTables.css');

/*--------------------------------------------------------------------------------
    Chosen
--------------------------------------------------------------------------------*/

$html .= setCss('chosen/chosen.css');
$html .= '<style type="text/css" media="all">.chosen-rtl .chosen-drop { left: -9000px; }</style>';

$html .= "<script>var BASE_URL = '".base_url()."index.php';</script>";

echo $html;
?>
