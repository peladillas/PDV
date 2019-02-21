$(function() {
    $("#cliente").focus();

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Busqueda de cliente

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    $("#cliente").autocomplete({
        source: BASE_URL+"clientes/getClientes",
        minLength: 2,
        select: function(event,ui){
            id_cliente	= ui.item.id;
            $("#id_cliente").val(id_cliente);
            $("#seleccionar").click();
        },

        close: function( event, ui ) {
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Cargar cliente

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    $("#seleccionar").click(function(){
        if($("#id_cliente").val() == ''){
            alert("Seleccione cliente");
            $("#cliente").val("").focus();
        }else{
            $("#form-detail").toggleClass('hide');
            $("#articulo").focus();
        }

    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Busqueda de articulo y cambio de foco cantidad

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    $("#articulo").autocomplete({
        source: BASE_URL+"articulos/getArticulos",
        minLength: 2,
        select: function(event,ui){
            id_articulo	= ui.item.id;
            porc_iva_art	= ui.item.iva;
            item_elegido	= ui.item;
            px_unitario		= ui.item.precio;

            $('#precio').val((px_unitario * ((porc_iva_art/100) + 1 )).toFixed(2));
            $("#id_articulo").val(id_articulo);
            $("#cantidad").focus();
        },

        close: function( event, ui ) {
        }
    });

    $("#cantidad").keypress(function( event ) {
        if ( event.which == 13 ) {
            $("#precio").focus();
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Precio, calculo de total

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    $("#precio").focus(function( event ) {
        $('#total').val($('#cantidad').val() * $('#precio').val());
    });

    $("#precio").keypress(function( event ) {
        if ( event.which == 13 ) {
            $("#agregar").click();
        }else{
            $('#total').val($('#cantidad').val() * $('#precio').val());
        }
    });

    /*---------------------------------------------------------------------------------
    -----------------------------------------------------------------------------------

            Agregar renglon de la nota de credito

    -----------------------------------------------------------------------------------
    ---------------------------------------------------------------------------------*/

    $("#agregar").click(function() {
        if ($("#id_articulo").val() == '') {
            alert("Seleccione articulo");
            $("#articulo").val("").focus();
        } else if($("#cantidad").val() == '') {
            alert("Seleccione cantidad");
            $("#cantidad").val("").focus();
        } else {
            $("#note-detail").removeClass('hide');
            var id_articulo = $("#id_articulo").val();
            if ($('#cont_borra'+id_articulo).length) {
                borra_reglon(id_articulo);
            } else {
                var largo	= $('#note-detail').height();
                largo	= largo + 30;
            }

            var texto = $("#articulo").val();
            var cantidad = $("#cantidad").val();
            var precio = $("#precio").val();
            var total = $("#total").val();
            var div_id = '#cont_borra'+id_articulo;

            $('#note-detail').height(largo);
            $('#note-detail').append('<div id="cont_borra'+id_articulo+'" class="cont_reglon_item_presup row" style="padding-left: 15px"></div>');

            $(div_id).append('<span class="col-md-5" id='+id_articulo+' >'+texto+'</span>');
            $(div_id).append('<input disabled class="col-md-1" id=detail_cantidad_'+id_articulo+' value='+cantidad+'>');
            $(div_id).append('<input disabled class="col-md-1" id="detail_precio_'+id_articulo+'" value='+precio+'>');
            $(div_id).append('<input disabled  class="col-md-1 detail_total" id="detail_total_'+id_articulo+'" value='+total+'>');
            $(div_id).append('<div class="col-md-1" id=cont_botones'+id_articulo+'>');

            $('#cont_botones'+id_articulo).append('<button title="Borrar linea" class="ico_borra btn btn-danger btn-xs pull-left" onclick="borra_reglon('+div_id+')" id="ico_borra'+id_articulo+'"></button>');
            $('#ico_borra'+id_articulo).append('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>');
            $(div_id).append('</div></div>');

            $("#id_articulo").val("");
            $("#articulo").val("");
            $("#cantidad").val("");
            $("#precio").val("");
            $("#total").val("");
            $("#articulo").focus();
            calcula_total();
        }
    });
});

/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Elimina renglon en el presupuesto

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function borra_reglon(div_id) {
    $(div_id).empty();
    $(div_id).remove();
    var nuevo_largo=$('#note-detail').height();
    nuevo_largo=nuevo_largo-30;
    $('#note-detail').height(nuevo_largo);
    calcula_total();
}

/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Calcula el total del presupuesto

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function calcula_total() {
    var total	= 0;
    var temp	= 0;

    $(".detail_total").each(function (index) {
        temp = $(this).val();
        total=parseFloat(total)+parseFloat(temp);
    });

    $('#total_nota_credito').val(total.toFixed(2));
}