/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Para trabajar con las Cookies

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

function setCookie(cname,cvalue,exdays) {
	var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname+"="+cvalue+"; "+expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("idioma");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
       user = prompt("Please enter your name:","");
       if (user != "" && user != null) {
           setCookie("idioma", user, 30);
       }
    }
}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Para ir arriba

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

$(document).ready(function(){
	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});

	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});
});

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Inicio del frontend

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

$(document).ready(function() {
	$('.container').fadeIn( 1000 );
});

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Mostrar y ocultar div

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

$(document).ready(function() {
	$(".slidingDiv").hide();
    $(".show_hide").show();
 
    $('.show_hide').click(function() {
    	$(".slidingDiv").slideToggle();
    });
});

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Validador de formularios

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

$(document).ready(function() {
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup change', function() {
		var $form = $(this).closest('form'),
            $group = $(this).closest('.input-group'),
			//$addon = $group.find('.input-group-addon'),
			$addon = $group.find('.input-group-addon'),
			$icon = $addon.find('span'),
			state = false;
            
    	if (!$group.data('validate')) {
			state = $(this).val() ? true : false;
		}else if ($group.data('validate') == "email") {
			state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
		}else if($group.data('validate') == 'phone') {
			state = /^[(]{0,1}[0-9]{0,4}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
		}else if($group.data('validate') == 'pin') {
			state = /^\d{3}[0-9]?$/.test($(this).val())
		}else if($group.data('validate') == 'tarjeta') {
			state = /^\d{4}-?\d{4}-?\d{4}-?\d{3}[0-9]?$/.test($(this).val())
		}else if ($group.data('validate') == "length") {
			state = $(this).val().length >= $group.data('length') ? true : false;
		}else if ($group.data('validate') == "number") {
			state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
		}

		if (state) {
				$addon.removeClass('danger');
				$addon.addClass('success');
				$icon.attr('class', 'glyphicon glyphicon-ok');
		}else{
				$addon.removeClass('success');
				$addon.addClass('danger');
				$icon.attr('class', 'glyphicon glyphicon-remove');
		}
        
        if ($form.find('.input-group-addon.danger').length == 0) {
            $form.find('[type="submit"]').prop('disabled', false);
        }else{
            $form.find('[type="submit"]').prop('disabled', true);
        }
	});
    
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');
});

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

		Cambio de idioma en el seleccionar de fechas

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

$(function($){
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
});