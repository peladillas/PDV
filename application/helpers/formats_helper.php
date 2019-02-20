<?php

/* -------------------------------------------------------------------------------
INDICE

- moneyFormat	       	Devuelve el formato de monedas
- dateFormat            Devuelve el formato de fechas

  -------------------------------------------------------------------------------*/

function moneyFormat($money = NULL) {
    $moneyFormat = ($money == NULL ?  "$ 0" : "$ ".round($money, 2));
    return $moneyFormat;
}

function dateFormat($date = NULL){
    $dateFormat = ($date == NULL ? date('d-m-Y') : date('d-m-Y', strtotime($date)));
    return $dateFormat;
}

?>