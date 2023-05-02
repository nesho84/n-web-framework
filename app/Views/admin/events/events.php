<!-- Page Header -->
<?php
displayHeader([
    'title' => 'Events',
    'btnText' => 'New Event +',
    'btnLink' => ADMURL . '/events/create_modal',
    'btnClass' => 'success d-modal',
    'btnDataAttributes' => 'data-title="Create Event" data-submit="true"',
]);
?>

<div class="container-lg">
    <div id="calendar" class="rounded bg-white p-2"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: "auto",
        });

        calendar.render();
    });
</script>