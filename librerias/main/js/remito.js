/*****************************************************************************
 *****************************************************************************
 *      Control Input Remito
 *****************************************************************************
 ****************************************************************************/
function ci_remito(id, monto, a_cuenta)  {
    var resta = monto - a_cuenta;
    var valor = $('#'+id).val();

    //Falta analizar que sea un valor numerico
    if(valor < 0) {
        alert('El valor no puede ser negativo');
        $('#'+id).val(0) ;
    } else if(resta < valor) {
        alert('El valor supera el monto a pagar');
        $('#'+id).val(resta) ;
    }

    calcular_total();
}

function ci_sel_on(id,monto,a_cuenta, tipo) {
    var resta = monto-a_cuenta;
    var valor = $('#'+id).val();

    if(tipo==1) {
        $('#'+id).val(resta);

        $('#off'+id).removeClass('hide');
        $('#off'+id).addClass('show');
        $('#on'+id).removeClass('show');
        $('#on'+id).addClass('hide');
        calcular_total();
    } else {
        $('#'+id).val(0);

        $('#on'+id).removeClass('hide');
        $('#on'+id).addClass('show');
        $('#off'+id).removeClass('show');
        $('#off'+id).addClass('hide');
        calcular_total();
    }
}

function check(){
    var total_apagar	= parseFloat($('#total_apagar').val());
    var total			= parseFloat($('#total').val());
    var total_hidden	= parseFloat($('#total_hidden').val());

    if(total == 0) {
        alert('El total no puede ser 0');
        return false;
    } else if(total < 0) {
        alert('El monto no puede ser negativo');
        $('#total').val(0);
        return false;
    } else if(total_apagar < total) {
        alert('El monto supera el total a pagar');
        $('#total').val(total_apagar);
        return false;
    } else if(total_hidden != total) {
        if(confirm('El total del pago no coincide con la suma de los remitos, desea hacerlo automaticamente')) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function calcular_total() {
    importe_total = 0;

    $(".importe_linea").each(
        function(index, value) {
            if(typeof eval($(this).val()) === 'number') {
                importe_total = importe_total + parseFloat($(this).val());
            }
        }
    );

    $("#total").val(importe_total);
    $("#total_hidden").val(importe_total);
}

function nueva_linea() {
    $("#lineas").append('<input type="text" class="importe_linea" value="0"/><br/>');
}

function soloNumeros(e)  {
    var key = window.Event ? e.which : e.keyCode;
    return ((key >= 48 && key <= 57) || (key==8) || (key==46));
}
