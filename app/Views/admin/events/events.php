<!-- Page Header -->
<?php
displayHeader([
    'title' => 'Events',
    'btnText' => 'New +',
    'btnLink' => ADMURL . '/events/create_modal',
    'btnClass' => 'success d-modal',
    'btnDataAttributes' => 'data-title="New Event" data-submit="true"',
]);
?>

<div class="container-lg">
    <div id="calendar" class="rounded bg-white p-2"></div>
</div>

<?php
// Additional scripts to include in the footer
$additionalScripts = [
    APPURL . '/app/js/events.js',
];
?>