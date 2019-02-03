<link href="<?php echo base_url()?>librerias/admin_template/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url()?>librerias/admin_template/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        
<script type="text/javascript">
	$(function() {
		function ini_events(ele) {
                    ele.each(function() {

                        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                        // it doesn't need to have a start or end
                        var eventObject = {
                            title: $.trim($(this).text()) // use the element's text as the event title
                        };

                        // store the Event Object in the DOM element so we can get to it later
                        $(this).data('eventObject', eventObject);

                        // make the event draggable using jQuery UI
                        $(this).draggable({
                            zIndex: 1070,
                            revert: true, // will cause the event to go back to its
                            revertDuration: 0  //  original position after the drag
                        });

                    });
                }
                ini_events($('#external-events div.external-event'));

                /* initialize the calendar
                 -----------------------------------------------------------------*/
                //Date for the calendar events (dummy data)
                var date = new Date();
                var d = date.getDate(),
                        m = date.getMonth(),
                        y = date.getFullYear();
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    buttonText: {//This is to add icons to the visible buttons
                        prev: "<span class='fa fa-caret-left'></span>",
                        next: "<span class='fa fa-caret-right'></span>",
                        today: 'fecha actual',
                        month: 'mes',
                        week: 'semana',
                        day: 'dia'
                    },
					
					monthNames:["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"],
					monthNamesShort:["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"],
					dayNames:["domingo","lunes","martes","miércoles","jueves","viernes","sábado"],
					dayNamesShort:["dom","lun","mar","mié","jue","vie","sáb"],
					dayNamesMin:["D","L","M","X","J","V","S"],
					weekHeader:"Sm",
					
                    //Random default events
                    events: [
                        <?php 
                        if($actualizaciones)
						{
							foreach ($actualizaciones as $row) 
							{
								$title = '';
								
								if($row->proveedor != NULL)
								{
									$title .= 'pro: '.$row->proveedor.' '	; 
								}
								
								if($row->grupo != NULL)
								{
									$title .= 'gru: '.$row->grupo.' '; 
								}
								
								if($row->categoria != NULL)
								{
									$title .= 'cat: '.$row->categoria.' '; 
								}
								
								if($row->subcategoria != NULL)
								{
									$title .= 'sub: '.$row->subcategoria.' '; 
								}
								
								$title .= $row->variacion." %"; 
											
								$sa = date('Y', strtotime($row->date_upd));
								$sm = date('m', strtotime($row->date_upd));
								$sm = $sm - 1;
								$sd = date('d', strtotime($row->date_upd));
								
								echo "{";
								echo "title: '".$title."', ";
								echo "start: new Date(".$sa.", ".$sm.", ".$sd."), ";
								//echo "end: new Date(".$sa.", ".$sm.", ".$sd."), ";
								echo "backgroundColor: '#aaa', ";
								echo "borderColor: '#aaa', ";
								echo "},";	
							}
						}
						?>
                        {   
                            start: new Date(y, m, 1),
                            backgroundColor: "#fff", //red 
                            borderColor: "#fff" //red
                        }                    ],
                    editable: false,
                    droppable: true, // this allows things to be dropped onto the calendar !!!
                    drop: function(date, allDay) { // this function is called when something is dropped

                        // retrieve the dropped element's stored Event Object
                        var originalEventObject = $(this).data('eventObject');

                        // we need to copy it, so that multiple events don't have a reference to the same object
                        var copiedEventObject = $.extend({}, originalEventObject);

                        // assign it the date that was reported
                        copiedEventObject.start = date;
                        copiedEventObject.allDay = allDay;
                        copiedEventObject.backgroundColor = $(this).css("background-color");
                        copiedEventObject.borderColor = $(this).css("border-color");

                        // render the event on the calendar
                        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                        // is the "remove after drop" checkbox checked?
                        if ($('#drop-remove').is(':checked')) {
                            // if so, remove the element from the "Draggable Events" list
                            $(this).remove();
                        }

                    }
                });
            });
        </script>