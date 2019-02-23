<?php
    echo setCss('fullcalendar/fullcalendar.css');
	echo setJs('fullcalendar/lib/moment.min.js');
    echo setJs('fullcalendar/fullcalendar.js');
?>

<script type="text/javascript">
$(function() {
    function ini_events(ele) {
        ele.each(function() {
            var eventObject = {
                title: $.trim($(this).text())
            };

            $(this).data('eventObject', eventObject);

            $(this).draggable({
                zIndex: 1070,
                revert: true,
                revertDuration: 0
            });
        });
    }

    ini_events($('#external-events div.external-event'));

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {

            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },

        monthNames:["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"],
        monthNamesShort:["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"],
        dayNames:["domingo","lunes","martes","miércoles","jueves","viernes","sábado"],
        dayNamesShort:["dom","lun","mar","mié","jue","vie","sáb"],
        dayNamesMin:["D","L","M","X","J","V","S"],weekHeader:"Sm",

        buttonText: {
            prev: '<?php echo setIcon('caret-left')?>',
            next: '<?php echo setIcon('caret-right')?>',
            today: 'fecha actual',
            month: 'mes',
            week: 'semana',
            day: 'dia'
        },

        events: [
            <?php
            if($calendarios) {
                foreach ($calendarios as $row) {
                    $sa = date('Y', strtotime($row->start));
                    $sm = date('m', strtotime($row->start));
                    $sm = $sm - 1;
                    $sd = date('d', strtotime($row->start));

                    $ea = date('Y', strtotime($row->end));
                    $em = date('m', strtotime($row->end));
                    $em = $em - 1;
                    $ed = date('d', strtotime($row->end));


                    echo "{";
                    echo "title: '".$row->title."', ";
                    echo "start: new Date(".$sa.", ".$sm.", ".$sd."), ";
                    echo "end: new Date(".$ea.", ".$em.", ".$ed."), ";
                    echo "backgroundColor: '".$row->backgroundColor."', ";
                    echo "borderColor: '".$row->borderColor."', ";
                    echo "},";
                }
            }
            ?>
            {
                start: new Date(y, m, 1),
                backgroundColor: "#fff", //red
                borderColor: "#fff" //red
            }
        ],
        editable: false,
        droppable: true,
        drop: function(date, allDay) {

            var originalEventObject = $(this).data('eventObject');
            var copiedEventObject = $.extend({}, originalEventObject);

            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            copiedEventObject.backgroundColor = $(this).css("background-color");
            copiedEventObject.borderColor = $(this).css("border-color");

            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }

        }
    });
});
</script>