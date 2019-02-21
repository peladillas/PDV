var articulos=new Array(new Array(2));

$(function() {
	
	$("#quickfind").autocomplete({
    source: "search.php",
    minLength: 2,//search after two characters
    select: function(event,ui){
        carga(ui.item);
		
		
	},
	close: function( event, ui ) {
		
		$("#quickfind").val('');
	}
		
});		

});




function carga(elem){
	este=elem.id
  pos=articulos.indexOf(este);
	
	if(pos!=-1){
	
		articulos[[pos],[0]]++;
	
	} else {
		agrega_a_reglon(este,elem.value);
		articulos.push(este);
		articulos[[pos],[1]]++;
	} 
console.log(articulos);
}
function agrega_a_reglon(este,texto){

$('#reglon_factura').append('<span class="item_reglon" id='+este+' onclick="muestra(this)">'+texto+'</span>');
}
function muestra(este){
	console.log(este.id);
}
/*
function(event,ui){
        var ede=this.text().val();
		console.log(ede);
		position = $(".scroll-content-item:contains("+ui.item.value+")").position();//search for a div containing the selected description and read its position
		
        /*var topValue = -(position.top);//content top is just the negative of the top position
		
	if (topValue>0) topValue = 0;//stop the content scrolling down too much
	if (Math.abs(topValue)>difference) topValue = (-1)*difference;//stop the content scrolling up too much

	sliderVal = (100+(topValue*100/difference));//calculate the slider position from the content position
	$("#slider-vertical").slider("value",top);//set the slider position */