var detailArray = [];

$(function () {

    startForm();

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Busqueda de Entity

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    inputHeadEntity.autocomplete({
        source: BASE_URL + "/"+entity+"/getFilters",
        minLength: 2,
        select: function (event, ui) {
            var idEntity = ui.item.id;
            inputHeadIdEntity.val(idEntity);
            btnSave.removeClass('hide');
            $('#form-payment').removeClass('hide');
            inputHeadTotal.removeClass('hide').parent().removeClass('hide');
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
            alert("Seleccione "+entity);
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
        source: BASE_URL + "/"+detail+"/getFilters",
        minLength: 2,
        select: function (event, ui) {
            idDetail = ui.item.id;
            porc_iva_art = ui.item.iva;
            px_unitario = ui.item.precio;
            price = (px_unitario * ((porc_iva_art / 100) + 1)).toFixed(2);

            inputDetailPrice.val(price);
            inputIdDetail.val(idDetail);
            inputDetailQuantity.focus();
        },

        close: function (event, ui) {
        }
    });

    inputDetailQuantity.keypress(function (event) {
        if (event.which == 13) {
            inputDetailPrice.focus();
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Precio, calculo de total

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    inputDetailPrice.focus(function (event) {
        inputDetailTotal.val(inputDetailQuantity.val() * inputDetailPrice.val());
    });

    inputDetailPrice.keypress(function (event) {
        if (event.which == 13) {
            btnSelecctDetail.click();
        } else {
            inputDetailTotal.val(inputDetailQuantity.val() * inputDetailPrice.val());
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Agregar renglon al comprobante

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    btnSelecctDetail.click(function () {
        if (inputIdDetail.val() == '') {
            alert("Seleccione "+detail);
            inputDetailItem.val("").focus();
        } else if (inputDetailQuantity.val() == '') {
            alert("Seleccione cantidad");
            inputDetailQuantity.val("").focus();
        } else {
            divDetail.removeClass('hide');
            var idDetail = inputIdDetail.val();
            if ($('#cont_borra' + idDetail).length) {
                borra_renglon(idDetail);
            } else {
                var largo = divDetail.height();
                largo = largo + 30;
            }

            var divId = '#cont_borra' + idDetail;

            divDetail.height(largo);
            divDetail.append('<div class="renglon_item_comprobante row" id="cont_borra' + idDetail + '"></div>');

            $(divId).append('<span class="col-md-5" id=' + idDetail + ' >' + inputDetailItem.val() + '</span>');
            $(divId).append('<input disabled class="col-md-1" id="detailQuantity' + idDetail + '" value=' + inputDetailQuantity.val() + '>');
            $(divId).append('<input disabled class="col-md-1" id="detailPrice' + idDetail + '" value=' + inputDetailPrice.val() + '>');
            $(divId).append('<input disabled class="col-md-1 detailTotal" id="detailTotal' + idDetail + '" value=' + inputDetailTotal.val() + '>');
            $(divId).append('<div class="col-md-1" id=cont_botones' + idDetail + '>');

          	$('#cont_botones' + idDetail).append('<button type="button" id="ico_borra' + idDetail + '" class="ico_borra btn btn-danger btn-xs pull-left" onclick="borra_renglon(' + idDetail + ')" ></button>');
            $('#ico_borra' + idDetail).append('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>');
            $(divId).append('</div></div>');

 			
            calcula_total();
            setElement(idDetail, inputDetailPrice.val(), inputDetailQuantity.val());
            clearDetailForm();
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

           Guardar comprobante

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    btnSave.click(function () {
    	var url = BASE_URL + functionInsert;

        if (inputHeadIdEntity.val() == '') {
            alert("Seleccione " + entity);
            inputHeadEntity.val("").focus();
        }else if (inputHeadTotal.val() == '') {
            alert("Seleccione "+detail);
            inputDetailItem.val("").focus();
        } else {

            $.ajax({
                "url": url,
                data: {
                    IdEntityField: headIdEntity,
                    IdEntityValue: inputHeadIdEntity.val(),
                    DateField: headDate,
                    DateValue: inputHeadDate.val(),
                    TotalField: headTotal,
                    TotalValue: inputHeadTotal.val(),
                    HeadTable: headTable,
                    type: 'head',
                    setMethodPayment: setMethodPayment,
                    methodPaymentField: headMethodPayment,
                    methodPaymentValue: $("#headMethodPayment").val(),
                },
                "type": "POST",
                "dataType": "json",
                "success": function (result) {
                    if(result > 0){
                        $.each(detailArray, function( key, value ) {
                            if(key > 0){
                                // Guardamos detalle
                                $.ajax({
                                    "url": url,
                                    data: {
                                        detailTable: detailTable,
                                        detailIdHeadField: headIdTable,
                                        detailIdHeadValue: result,
                                        detailIdItemField: detailIdItem,
                                        detailIdItemValue: key,
                                        detailQuantityField: detailQuantity,
                                        detailQuantityValue: value.quantity,
                                        detailPriceField: detailPrice,
                                        detailPriceValue: value.price,
                                        stockInOut: stockInOut,
                                        type: 'detail',
                                    },
                                    "type": "POST",
                                    "dataType": "json",
                                    "success": function (result) {
                                        alert( key + ": " + value.price+ " "+ value.quantity );
                                    }	,
                                    "error": function (xhr) {
                                        alert("Error: " + xhr.status + " " + xhr.statusText);
                                    }
                                });
                            }
                        });

                        clearDetailArray();
                    }


                },
                "error": function (xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                }
            });

            clearHeadForm();
            clearDetailForm();
            alert("Presupuesto generado con exito");
            startForm();
        }
    });


    $('#headMethodPayment').on("change", function(e) {
        a = $("#headMethodPayment option:selected" ).val();

        $('.paymentData').addClass('hide');
        if(a == 2){
            $('#divCheck').removeClass('hide');
        }else if(a > 2) {
            $('#divQuota').removeClass('hide');
        }
    });

    $('#quotaStart').on("change", function(e) {
        start = $("#quotaStart option:selected" ).val();
        end = $("#quotaEnd option:selected" ).val();

        $('#quotaEnd').children('option').remove();

        for (i = start; i < 31; i++) {
            $('#quotaEnd').append($('<option>', {
                value: i,
                text : i
            }));
        }

        $('#quotaEnd').val(end)
    });

    $('#quotaEnd').on("change", function(e) {
        start = $("#quotaStart option:selected" ).val();
        end = $("#quotaEnd option:selected" ).val();

        $('#quotaStart').children('option').remove();

        for (i = end; i > 0; i--) {
            $('#quotaStart').append($('<option>', {
                value: i,
                text : i
            }));
        }

        $('#quotaStart').val(start);
    });
    
    $("#quotaInterest").keyup(function (event) {
        calcula_total();
    });

	$("#quotaQuantity").on("change", function(e) {
        calcula_total();
    });

    $("#headMethodPayment").on("change", function(e) {
        calcula_total();
    });

});

/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Elimina renglon en el detalle

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function borra_renglon(id) {
    $('#cont_borra'+id).empty();
    var nuevo_largo = divDetail.height();
    nuevo_largo = nuevo_largo - 30;
    divDetail.height(nuevo_largo);
    inputDetailItem.focus();
    detailArray.splice(id, 1);
	calcula_total();
};

/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Calcula el total dasdfel comprobante

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function calcula_total() {
    var total	= 0;
    var temp	= 0;

    $(".detailTotal").each(function (index) {
        temp = $(this).val();
        total = parseFloat(total) + parseFloat(temp);
    });

    var headMethodPayment = $('#headMethodPayment').val();

    
    total = total.toFixed(2);
    
    var quotaInterest = $("#quotaInterest").val();
    var total_cuota = parseFloat(total) + parseFloat(total * quotaInterest / 100);
    total_cuota = parseFloat(total_cuota)  / parseFloat($("#quotaQuantity").val());
    var total_head = parseFloat(total_cuota)  * parseFloat($("#quotaQuantity").val());
    $("#quotaAmount").val(total_cuota.toFixed(2));

    if(headMethodPayment == 3 || headMethodPayment == 4){
        inputHeadTotal.val(total_head.toFixed(2));
    } else {
        inputHeadTotal.val(total);
    }
    
};

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Agrega un elemtento al array

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function setElement(id, price, quantity){

	var ITEMDetail = [];
            
    ITEMDetail.price = price;
    ITEMDetail.quantity = quantity;
    
    detailArray[id] = ITEMDetail;
}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Limpia el formulario para cargar el detalle

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function clearDetailForm(){
    inputIdDetail.val("");
    inputDetailItem.val("");
    inputDetailQuantity.val("");
    inputDetailPrice.val("");
    inputDetailTotal.val("");
    inputDetailItem.focus();
}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Limpia el formulario para cargar el head

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function clearHeadForm(){
    inputHeadEntity.val("");
    inputHeadIdEntity.val("");
    inputHeadTotal.val("");
}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Limpia el elemento del array

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function clearDetailArray(){
    $.each( detailArray, function( key, value ) {
        borra_renglon(key);
    });
}


function startForm(){
    inputHeadEntity.focus();
    inputHeadTotal.addClass('hide').parent().addClass('hide');
    btnSave.addClass('hide');
    $("#form-detail").addClass('hide');
    $("#form-payment").addClass('hide');
    $("#headMethodPayment").val(1);
    $('.paymentData').addClass('hide');
}