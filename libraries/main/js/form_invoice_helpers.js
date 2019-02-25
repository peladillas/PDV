$(function () {

    inputCliente.focus();

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Busqueda de cliente

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    inputCliente.autocomplete({
        source: BASE_URL + "/clientes/getClientes",
        minLength: 2,
        select: function (event, ui) {
            var id_cliente = ui.item.id;
            inputIdCliente.val(id_cliente);
            btnSeleccionar.click();
        },

        close: function (event, ui) {
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Cargar cliente

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    btnSeleccionar.click(function () {
        if (inputIdCliente.val() == '') {
            alert("Seleccione cliente");
            inputCliente.val("").focus();
        } else {
            $("#form-detail").toggleClass('hide');
            inputArticulo.focus();
        }

    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Busqueda de articulo y cambio de foco cantidad

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    inputArticulo.autocomplete({
        source: BASE_URL + "/articulos/getArticulos",
        minLength: 2,
        select: function (event, ui) {
            id_articulo = ui.item.id;
            porc_iva_art = ui.item.iva;
            item_elegido = ui.item;
            px_unitario = ui.item.precio;

            inputPrecio.val((px_unitario * ((porc_iva_art / 100) + 1)).toFixed(2));
            inputIdArticulo.val(id_articulo);
            inputCantidad.focus();
        },

        close: function (event, ui) {
        }
    });

    inputCantidad.keypress(function (event) {
        if (event.which == 13) {
            inputPrecio.focus();
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Precio, calculo de total

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    inputPrecio.focus(function (event) {
        inputTotalLine.val(inputCantidad.val() * inputPrecio.val());
    });

    inputPrecio.keypress(function (event) {
        if (event.which == 13) {
            btnSeleccionarLine.click();
        } else {
            inputTotalLine.val(inputCantidad.val() * inputPrecio.val());
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Agregar renglon al comprobante

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    btnSeleccionarLine.click(function () {
        if (inputIdArticulo.val() == '') {
            alert("Seleccione articulo");
            inputArticulo.val("").focus();
        } else if (inputCantidad.val() == '') {
            alert("Seleccione cantidad");
            inputCantidad.val("").focus();
        } else {
            divDetail.removeClass('hide');
            var id_articulo = inputIdArticulo.val();
            if ($('#cont_borra' + id_articulo).length) {
                borra_reglon(id_articulo);
            } else {
                var largo = divDetail.height();
                largo = largo + 30;
            }

            var texto = inputArticulo.val();
            var cantidad = inputCantidad.val();
            var precio = inputPrecio.val();
            var total = inputTotalLine.val();
            var div_id = '#cont_borra' + id_articulo;

            divDetail.height(largo);
            divDetail.append('<div class="reglon_item_comprobante row" id="cont_borra' + id_articulo + '"></div>');

            $(div_id).append('<span class="col-md-5" id=' + id_articulo + ' >' + texto + '</span>');
            $(div_id).append('<input disabled class="col-md-1" id="detail_cantidad_' + id_articulo + '" value=' + cantidad + '>');
            $(div_id).append('<input disabled class="col-md-1" id="detail_precio_' + id_articulo + '" value=' + precio + '>');
            $(div_id).append('<input disabled class="col-md-1 detail_total" id="detail_total_' + id_articulo + '" value=' + total + '>');
            $(div_id).append('<div class="col-md-1" id=cont_botones' + id_articulo + '>');

            $('#cont_botones' + id_articulo).append('<button title="Borrar linea" class="ico_borra btn btn-danger btn-xs pull-left" onclick="borra_reglon(' + div_id + ')" id="ico_borra' + id_articulo + '"></button>');
            $('#ico_borra' + id_articulo).append('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>');
            $(div_id).append('</div></div>');

            inputIdArticulo.val("");
            inputArticulo.val("");
            inputCantidad.val("");
            inputPrecio.val("");
            inputTotalLine.val("");
            inputArticulo.focus();
            calcula_total();
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

           Guardar comprobante

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    btnSave.click(function () {
        var head;
        var items = [];
        var url = BASE_URL + functionInsert;

        $(".reglon_item_comprobante").each(function (index) {
            console.log(index);
            var id = index.attr('id');
            var detail;

            detail.id = $("#" + id).val();
            detail.cantidad = $("#detail_cantidad_" + id).val();
            detail.precio = $("#detail_precio_" + id).val();

            items.push(detail);
        });

        head.client = inputCliente.val();
        head.date = inputFecha.val();
        head.total = inputTotal.val();

        console.log(head);
        console.log(items);

        $.ajax({
            "url": url,
            "data": [
                {"head": head, "items": items}
            ],
            "type": "POST",
            "dataType": "json",
            "success": function (result) {
                console.log(result);
            },
            "error": function (xhr) {
                alert("Error: " + xhr.status + " " + xhr.statusText);
            }
        });

    });
})

/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Elimina renglon en el detalle

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function borra_reglon(div_id) {
    $(div_id).empty();
    $(div_id).remove();
    var nuevo_largo = divDetail.height();
    nuevo_largo = nuevo_largo - 30;
    divDetail.height(nuevo_largo);
    calcula_total();
}

/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Calcula el total del comprobante

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function calcula_total() {
    var total	= 0;
    var temp	= 0;

    $(".detail_total").each(function (index) {
        temp = $(this).val();
        total = parseFloat(total) + parseFloat(temp);
    });

    inputTotal.val(total.toFixed(2));
}