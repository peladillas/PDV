$(function () {

    inputHeadEntity.focus();

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Busqueda de Entity

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    inputHeadEntity.autocomplete({
        source: BASE_URL + "/"+Entity+"/getFilters",
        minLength: 2,
        select: function (event, ui) {
            var id_entity = ui.item.id;
            inputHeadIdEntity.val(id_entity);
            btnSelect.click();
        },

        close: function (event, ui) {
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Cargar Entity

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    btnSelect.click(function () {
        if (inputHeadIdEntity.val() == '') {
            alert("Seleccione "+Entity);
            inputHeadEntity.val("").focus();
        } else {
            $("#form-detail").toggleClass('hide');
            inputDetailItem.focus();
        }

    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Busqueda de Detail y cambio de foco cantidad

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    inputDetailItem.autocomplete({
        source: BASE_URL + "/"+Detail+"/getFilters",
        minLength: 2,
        select: function (event, ui) {
            id_detail = ui.item.id;
            porc_iva_art = ui.item.iva;
            item_elegido = ui.item;
            px_unitario = ui.item.precio;

            inputPrice.val((px_unitario * ((porc_iva_art / 100) + 1)).toFixed(2));
            inputIdDetail.val(id_detail);
            inputDetailQuantity.focus();
        },

        close: function (event, ui) {
        }
    });

    inputDetailQuantity.keypress(function (event) {
        if (event.which == 13) {
            inputPrice.focus();
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Precio, calculo de total

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    inputPrice.focus(function (event) {
        inputTotalLine.val(inputDetailQuantity.val() * inputPrice.val());
    });

    inputPrice.keypress(function (event) {
        if (event.which == 13) {
            btnSelecctLine.click();
        } else {
            inputTotalLine.val(inputDetailQuantity.val() * inputPrice.val());
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Agregar renglon al comprobante

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    btnSelecctLine.click(function () {
    	
        if (inputIdDetail.val() == '') {
            alert("Seleccione "+Detail);
            inputDetailItem.val("").focus();
        } else if (inputDetailQuantity.val() == '') {
            alert("Seleccione cantidad");
            inputDetailQuantity.val("").focus();
        } else {
            divDetail.removeClass('hide');
            var id_detail = inputIdDetail.val();
            if ($('#cont_borra' + id_detail).length) {
                borra_reglon(id_detail);
            } else {
                var largo = divDetail.height();
                largo = largo + 30;
            }

            var texto = inputDetailItem.val();
            var cantidad = inputDetailQuantity.val();
            var precio = inputPrice.val();
            var total = inputTotalLine.val();
            var div_id = '#cont_borra' + id_detail;

            divDetail.height(largo);
            divDetail.append('<div class="reglon_item_comprobante row" id="cont_borra' + id_detail + '"></div>');

            $(div_id).append('<span class="col-md-5" id=' + id_detail + ' >' + texto + '</span>');
            $(div_id).append('<input disabled class="col-md-1" id="detail_cantidad_' + id_detail + '" value=' + cantidad + '>');
            $(div_id).append('<input disabled class="col-md-1" id="detail_precio_' + id_detail + '" value=' + precio + '>');
            $(div_id).append('<input disabled class="col-md-1 detail_total" id="detail_total_' + id_detail + '" value=' + total + '>');
            $(div_id).append('<div class="col-md-1" id=cont_botones' + id_detail + '>');

          	$('#cont_botones' + id_detail).append('<button type="button" id="ico_borra' + id_detail + '" class="ico_borra btn btn-danger btn-xs pull-left" onclick="borra_reglon(' + id_detail + ')" ></button>');
            $('#ico_borra' + id_detail).append('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>');
            $(div_id).append('</div></div>');

            inputIdDetail.val("");
            inputDetailItem.val("");
            inputDetailQuantity.val("");
            inputPrice.val("");
            inputTotalLine.val("");
            inputDetailItem.focus();
            calcula_total();
        }
        
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

           Guardar comprobante

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    btnSave.click(function () {
        var head = [];
        var items = [];
        var url = BASE_URL + functionInsert;

        $(".reglon_item_comprobante").each(function (div) {
            console.log(div);
           /*
            var id = index.attr('id');
            var detail;

            detail.id = $("#" + id).val();
            detail.cantidad = $("#detail_cantidad_" + id).val();
            detail.precio = $("#detail_precio_" + id).val();

            items.push(detail);
            */
        });

		head.IdEntityField = HeadIdEntity;
        head.IdEntityValue = inputHeadIdEntity.val();
        head.DateField = HeadDate;
        head.DateValue = inputHeadDate.val();
        head.TotalField = HeadTotal;
        head.TotalValue = inputHeadTotal.val();
        head.headTable = HeadTable;

        console.log(head);
        console.log(items);

        $.ajax({
            "url": url,
            data: {
            	IdEntityField: head.IdEntityField, 
				IdEntityValue: head.IdEntityValue, 
				DateField: head.DateField, 
				DateValue: head.DateValue, 
				TotalField: head.TotalField, 
				TotalValue: head.TotalValue, 
				HeadTable: head.headTable, 
			},
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
    
});

/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Elimina renglon en el detalle

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function borra_reglon(id) {
    $('#cont_borra'+id).empty();
    $('#cont_borra'+id).remove();
    var nuevo_largo = divDetail.height();
    nuevo_largo = nuevo_largo - 30;
    divDetail.height(nuevo_largo);
    inputDetailItem.focus();
    calcula_total();
};

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

    inputHeadTotal.val(total.toFixed(2));
};