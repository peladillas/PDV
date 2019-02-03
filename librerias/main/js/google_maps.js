	var directionDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;

	function initialize(latitud, longitud) {
		//punto de partida, crea el mapa
		directionsDisplay = new google.maps.DirectionsRenderer();
        var argentina = new google.maps.LatLng(latitud, longitud);
        
		// Create the autocomplete object, restricting the search
  		// to geographical location types.
  		autocomplete = new google.maps.places.Autocomplete(
      	/** @type {HTMLInputElement} */(document.getElementById('start')),
      	{ types: ['geocode'] });
  		// When the user selects an address from the dropdown,
  		// populate the address fields in the form.
  		google.maps.event.addListener(autocomplete, 'place_changed', function() {
    		fillInAddress();
		});
  
		var mapOptions = {
			zoom: 18,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: argentina
		}
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        directionsDisplay.setMap(map);
		directionsDisplay.setPanel(document.getElementById('directions-panel'));//agregado
		
		var control = document.getElementById('control');//agregado
		control.style.display = 'block';//agregado
		map.controls[google.maps.ControlPosition.TOP_CENTER].push(control);//agregado
    }
		
	function calcRoute() {
        var start = document.getElementById('start').value;
        var end = document.getElementById('end').value;
        var waypts = [];
			//cargo en el arraw los puntos intermedios
			/*
			if(document.getElementById('waypoints1').value.length>1){
            waypts.push({
                location:document.getElementById('waypoints1').value,
                stopover:true});
				}
			if(document.getElementById('waypoints2').value.length>1){
			waypts.push({
                location:document.getElementById('waypoints2').value,
                stopover:true});
				}
			if(document.getElementById('waypoints3').value.length>1){
			waypts.push({
                location:document.getElementById('waypoints3').value,
                stopover:true});	
				}
			*/
		//armado de ruta
        var request = {
			origin: start,											//punto de partida
            destination: end,										//punto de llegada
            waypoints: waypts,										//puntos intermedios
            optimizeWaypoints: true,								//puntos intermedios, permisos.
            travelMode: google.maps.DirectionsTravelMode.DRIVING,	//medio de transporte
			avoidTolls: true,										//indica que la ruta calculada debe evitar los peajes de carretera y de puentes.
			region: "ES",											//idioma
			unitSystem: google.maps.DirectionsUnitSystem.METRIC		//sistema metrico
        };
		directionsService.route(request, function(result, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(result);
			}
		});
		
		
		
		
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
			var distanciatotal = 0;
			var preciototal = 0;
            var summaryPanel = document.getElementById('directions_panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
			
				summaryPanel.innerHTML += '<b>Ruta Segmento: ' + routeSegment + '</b><br>';
				summaryPanel.innerHTML += '<b>Desde: <b>';
				summaryPanel.innerHTML += route.legs[i].start_address + '<br>';
				summaryPanel.innerHTML += '<b>Hasta: <b>';
				summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
				summaryPanel.innerHTML += '<b>Distancia: <b>';
				summaryPanel.innerHTML += (route.legs[i].distance.value/1000).toFixed(2) + ' KM<br>';
				/*			 
			  	summaryPanel.innerHTML += '<b>Consumo: <b>$ ';
              	summaryPanel.innerHTML += ((route.legs[i].distance.value/1000)/100*document.getElementById('consumo').value*document.getElementById('combustible').value).toFixed(2) + '<br>';
			  	summaryPanel.innerHTML += '<b>Tiempo: <b>';
              	summaryPanel.innerHTML += route.legs[i].duration.text + '<br><br>';
              	*/
            }	
			}
        });


      }
      
      
      
      
      
      
      
      
      
      
      
      var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};



// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = new google.maps.LatLng(
          position.coords.latitude, position.coords.longitude);
      autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
          geolocation));
    });
  }
}
// [END region_geolocation]
	