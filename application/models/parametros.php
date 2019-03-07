<?php 
abstract class TIPO_COMPROBANTE {
    const PRESUPUESTO = 1;
    const NOTA_CREDITO = 2;
    const STOCK = 3;
}

abstract class ESTADOS {
    const ALTA = 1;
    const BAJA = 2;
}

abstract class FUNCTION_LOG {
    const INSERT = 'insert_log';
    const UPDATE = 'update_log';
    const DELETE = 'delete_log';
}

?>
