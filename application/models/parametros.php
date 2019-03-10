<?php 
class PARAMETROS {

}

abstract class TIPOS_COMPROBANTES {
    const PRESUPUESTO = 1;
    const NOTA_CREDITO = 2;
    const STOCK = 3;
}

abstract class ESTADOS {
    const ALTA = 1;
    const BAJA = 2;
}

abstract class ESTADOS_COMPROBANTES{
    const IMPAGA = 1;
    const PAGA = 2;
    const VENCIDA = 3;
    const ANULADA = 4;
    const EMITIDA = 5;
}

abstract class FORMAS_PAGOS {
    const EFECTIVO = 1;
    const CHEQUE = 2;
    const TARJETA = 3;
    const CTA_CTE = 4;
}

abstract class ACCIONES{
    const INSERT = 1;
    const UPDATE = 2;
    const DELETE = 3;
}

abstract class CONFIGURACIONES {
    const CDEFAULT = 1;
}


abstract class FUNCTION_LOG {
    const INSERT = 'insert_log';
    const UPDATE = 'update_log';
    const DELETE = 'delete_log';
}
?>
