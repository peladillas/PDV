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
                title: $.trim($(this).text()) // use the element's text as the event title
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
    var d = date.getDate(),
    var m = date.getMonth(),
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        buttonText: {//This is to add icons to the visible buttons
            prev: "<?php echo setIcon('caret-left')?>",
            next: "<?php echo setIcon('caret-right')?>",
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

        events: [
            <?php
            if($actualizaciones) {
                foreach ($actualizaciones as $row) {
                    $title = '';

                    $title .= ($row->proveedor != NULL ? 'pro: '.$row->proveedor.' ' : '');
                    $title .= ($row->grupo != NULL ? 'gru: '.$row->grupo.' ' : '');
                    $title .= ($row->categoria != NULL ? 'cat: '.$row->categoria.' ' : '');
                    $title .= ($row->subcategoria != NULL ? 'sub: '.$row->subcategoria.' ' : '');

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
                $(this).remove();
            }
        }
    });
});
</script>