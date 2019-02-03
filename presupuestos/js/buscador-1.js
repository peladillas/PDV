var codigo_r=[];
var cantidad_r=[];
var precio_r=[];

var item_elegido;
var items_reglon=Array();
var px_unitario;
var nuevo=true;
$("#cantidad").attr('disabled','disabled');
$("#quickfind").focus();
$('#carga_presupuesto').hide();
$('#cancela_presupuesto').hide();
function carga_presupuesto(){
	
	bandera_tipo_pago=$("input[name='tipo']:checked").val();
	
	if(bandera_tipo_pago!=1){
	
		if(confirm('¿Seguro que desea asignar a cuenta corriente?')){
		
			guarda_detalle(),fin_presupuesto();
		
		} else {
		
		
			$('#tipo_presupuesto').focus();
		
		}
	
	} else{
	
	
		guarda_detalle(),fin_presupuesto();
	
	
	}

}

function fin_presupuesto(){

	atotal=$("#total_presupuesto").val();
	acliente=$("#id_cliente").val();
	atipo=$("input[name='tipo']:checked").val(); 
	aestado=1;
	
	
	
	 $.ajax({
      url : 'carga_presupuesto.php',
      type: 'POST',
      data : {total:atotal,cliente:acliente,tipo:atipo,estado:aestado,codigos_art:codigo_r,cantidades:cantidad_r,precios:precio_r}
    }).done( function( data )
             {
                //console.log(data);
             });
	
	  location.reload();
}


/* POR CODIGO */

$("#quickfind_cod").autocomplete({
    source: "search_articulo_cod.php",
    minLength: 2,//search after two characters
    select: function(event,ui){
        
        item_elegido=ui.item;
        este=ui.item.id;
		px_unitario=ui.item.precio;
        $('#px_unitario_rapido').val(px_unitario);
		pos=items_reglon.indexOf(este);
    	

		$("#cantidad").removeAttr('disabled');
		$('#cantidad').focus();
		$('#cantidad').select();
		 
		 
        //console.log(px_unitario);
        
		if(pos!=-1){    
            
          nuevo=false; 
           
            //console.log("modifica:",este);
            cant_cargada=$('#cant_'+este).val();
            //console.log(cant_cargada);
            $('#cantidad').val(cant_cargada);
			$('#cantidad').select();
      
		} 
		
	},
    
	close: function( event, ui ) {
		
		$("#quickfind_cod").val('');
	}
		
});		



/* FIN POR CODIGO */

$(function() {

    
	
	
	
	$("#quickfind").autocomplete({
    source: "search_articulo.php",
    minLength: 2,//search after two characters
    select: function(event,ui){
        
        item_elegido=ui.item;
        este=ui.item.id;
		px_unitario=ui.item.precio;
		px_unitario=px_unitario.toFixed(2);
        $('#px_unitario_rapido').val(px_unitario*1.21);
		pos=items_reglon.indexOf(este);
    	

		$("#cantidad").removeAttr('disabled');
		$('#cantidad').focus();
		$('#cantidad').select();
		 
		 
        //console.log(px_unitario);
        
		if(pos!=-1){    
            
          nuevo=false; 
           
            //console.log("modifica:",este);
            cant_cargada=$('#cant_'+este).val();
            //console.log(cant_cargada);
            $('#cantidad').val(cant_cargada);
			$('#cantidad').select();
      
		} 
		
	},
    
	close: function( event, ui ) {
		
	}
		
});		

});


        
$("#cantidad").keypress(function( event ) {
		  
		  if ( event.which == 13 ) {
			$("#carga_articulo").click();
			
			$("#cantidad").attr('disabled','disabled');
		  }
		//console.log('paso por aca:'+event.which);
		
    
});		

	


function carga(elem){


    
    if($("#quickfind").val().length>=1){
        este=elem.id
        cantidad=$('#cantidad').val();
        
        agrega_a_reglon(este,elem.value,cantidad, nuevo,px_unitario);
    	items_reglon.push(este);
        reset_item();
		
    } else {
		
		
		reset_item(); 
		
        
    }
    

}
/*
function mod_cant(a){
	cadena=a.id;
	//console.log(cadena);
	nueva_cant=$('#'+a.id).val();
	nueva_cadena=cadena.slice(5);
	cant=$('#cant_'+nueva_cadena).val();	
	precio_u=$('#px_'+nueva_cadena).val();
	$('#px_x_cant'+nueva_cadena).val(precio_u*cant);
	calcula_total();
}

*/

function agrega_a_reglon(este,texto,cantidad, bandera){
    
	
	iva=px_unitario*0.21*cantidad;
	iva=iva.toFixed(2);
	px_reglon=cantidad*px_unitario*1.21;
    px_reglon=px_reglon.toFixed(2);
	
	
	
	
	if(bandera){
	
		largo=$('#reglon_factura').height();
		console.log("largo antes:"+largo);
		largo=largo+30;
		//console.log("largo despúes:"+largo);
		
		$('#reglon_factura').height(largo);
		
		$('#reglon_factura').append('<div id="cont_borra'+este+'" class="cont_reglon_item_presup row" style="padding-left: 15px"><span disabled class="item_reglon col-md-6" id='+este+' >'+texto+'</span>		<input disabled class="cant_item_reglon col-md-1" id=cant_'+este+' value='+cantidad+'>		<input disabled class="px_item_reglon col-md-1" id=px_'+este+' value='+px_unitario+'> <input disabled id=iva_cont'+este+' class="col-md-1"  value='+iva+'> 		<input disabled class="px_reglon col-md-2" id=px_x_cant'+este+' value='+px_reglon+'> <div  class="col-md-1"><button title="Borrar linea" class="ico_borra btn btn-danger btn-xs pull-left" onclick="borra_reglon('+este+')" id="ico_borra'+este+'"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></div>');
		
		reset_item();
    
	} else {
        
    $('#cant_'+este).val(cantidad);
	$('#px_x_cant'+este).val(px_reglon);    	
    $('#iva_cont'+este).val(iva);
	nuevo=true; 
    reset_item();   
    
	} 

	
	calcula_total();
	

}
function borra_reglon(a){

	$('#cont_borra'+a).remove();
	calcula_total();
}
function calcula_total(){
var total=0;
	var temp=0;
	$('.px_reglon').each(function (index) {
     
		  temp=$(this).val();
		  
		  total=parseFloat(total)+parseFloat(temp);
		
	})
	$('#iva_factura').val(total.toFixed(2));
	$('#precio_sin_iva').val(total.toFixed(2));
	$('#total_presupuesto').val(total.toFixed(2));
	
	if(total>=0.1){
	
		$('#cont_boton').show();
	
	}else{
	
		$('#cont_boton').hide();
	
	}
	
	
	
}

function guarda_detalle(){


	var temp=0;
	
	$('.px_reglon').each(function (index) {
     
		  precio_r.push($(this).val());
		  
	})
	$('.cant_item_reglon').each(function (index) {
		
		//console.log("cant_item_reglon"+$(this).val());	
		  cantidad_r.push(parseInt($(this).val()));
		  temp_id=this.id;
		  cod_prod=parseInt(temp_id.slice(5));
		  codigo_r.push(cod_prod);
	})
	
	//console.log("codigo"+codigo_r);
	
}

function muestra(este){
	console.log(este.id);
}

function reset_item(){
    $('#px_unitario_rapido').val('');
    $("#quickfind").val('');
	$("#quickfind_cod").val('');
    $("#quickfind").focus();
    $('#cantidad').val(1);
    
}