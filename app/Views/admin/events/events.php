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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: "auto",
            events: "<?php echo ADMURL . '/events/fetchEvents'; ?>",

            // --- Add Event START --- //
            selectable: true,
            select: async function(start, end, allDay) {
                const {
                    value: formValues
                } = await Swal.fire({
                    title: 'Add Event',
                    confirmButtonText: 'Save',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: true,
                    html: `<input id="swalEvtTitle" class="form-control mb-3" placeholder="Enter Title">
                    <textarea id="swalEvtDesc" class="form-control mb-3" placeholder="Enter Description"></textarea>
                    <input id="swalEvtURL" class="form-control mb-3" placeholder="Enter URL">`,
                    preConfirm: () => {
                        return [
                            document.getElementById('swalEvtTitle').value,
                            document.getElementById('swalEvtDesc').value,
                            document.getElementById('swalEvtURL').value
                        ]
                    }
                });
                if (formValues) {
                    fetch("<?php echo ADMURL . '/events/insertJson'; ?>", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                request_type: 'addEvent',
                                start: start.startStr,
                                end: start.endStr,
                                event_data: formValues
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === "success") {
                                Swal.fire(data.message, '', 'success');
                            } else {
                                Swal.fire(data.message, '', 'error');
                            }

                            // Refetch events from all sources and rerender
                            calendar.refetchEvents();
                        })
                        .catch(console.error);
                }
            }, // --- Add Event END --- //

            // --- Show/Edit/Delete Event START --- //
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                info.el.style.borderColor = 'red';

                Swal.fire({
                    title: info.event.title,
                    icon: 'info',
                    showCloseButton: true,
                    showCancelButton: true,
                    showDenyButton: true,
                    cancelButtonText: 'Close',
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#d33',
                    denyButtonText: 'Edit',
                    denyButtonColor: '#3085d6',
                    html: `<p>${info.event.extendedProps.description}</p><a href="${info.event.url}">Visit event page</a>`,
                }).then((result) => {
                    // Delete event
                    if (result.isConfirmed) {
                        fetch(`<?php echo ADMURL . '/events/deleteJson'; ?>/${info.event.id}`, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    request_type: 'deleteEvent',
                                    event_id: info.event.id
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === "success") {
                                    Swal.fire(data.message, '', 'success');
                                } else {
                                    Swal.fire(data.message, '', 'error');
                                }
                                // Refetch events from all sources and rerender
                                calendar.refetchEvents();
                            })
                            .catch(console.error);
                    }
                    // Edit and update event
                    else if (result.isDenied) {
                        Swal.fire({
                            title: 'Edit Event',
                            confirmButtonText: 'Save',
                            showCloseButton: true,
                            showCancelButton: true,
                            focusConfirm: true,
                            html: `<input id="swalEvtTitle_edit" class="form-control mb-3" placeholder="Enter Title" value="${info.event.title}">
                            <textarea id="swalEvtDesc_edit" class="form-control mb-3" placeholder="Enter Description">${info.event.extendedProps.description}</textarea>
                            <input id="swalEvtURL_edit" class="form-control mb-3" placeholder="Enter URL" value="${info.event.url}">`,
                            preConfirm: () => {
                                return [
                                    document.getElementById('swalEvtTitle_edit').value,
                                    document.getElementById('swalEvtDesc_edit').value,
                                    document.getElementById('swalEvtURL_edit').value
                                ]
                            }
                        }).then((result) => {
                            if (result.value) {
                                fetch(`<?php echo ADMURL . '/events/updateJson'; ?>/${info.event.id}`, {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                        },
                                        body: JSON.stringify({
                                            request_type: 'editEvent',
                                            event_id: info.event.id,
                                            start: info.event.startStr,
                                            end: info.event.endStr,
                                            event_data: result.value
                                        }),
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.status === "success") {
                                            Swal.fire(data.message, '', 'success');
                                        } else if (data.status === "warning") {
                                            Swal.fire(data.message, '', 'warning');
                                        } else {
                                            Swal.fire(data.message, '', 'error');
                                        }
                                        // Refetch events from all sources and rerender
                                        calendar.refetchEvents();
                                    })
                                    .catch(console.error);
                            }
                        });
                    } else {
                        Swal.close();
                    }
                });
            }, // --- Show/Edit/Delete Event END --- //
        });

        // Show Full Calendar
        calendar.render();
    });
</script>