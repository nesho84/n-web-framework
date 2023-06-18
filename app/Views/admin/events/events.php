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
    let calendar = null;

    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: "auto",
            events: "<?php echo ADMURL . '/events/eventsJson'; ?>",
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
                    // Add Event
                    addEvent(start, end, formValues);
                }
            },
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
                    if (result.isConfirmed) {
                        // Delete event
                        deleteEvent(info.event.id);
                    } else if (result.isDenied) {
                        // Edit and update event
                        editEvent(info.event);
                    } else {
                        Swal.close();
                    }
                });
            },
        });

        // Show Full Calendar
        calendar.render();
    });

    //------------------------------------------------------------
    function fetchRequest(url, method, body)
    //------------------------------------------------------------
    {
        const baseUrl = "<?php echo ADMURL; ?>";
        return fetch(baseUrl + url, {
                method: method,
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(body),
            })
            .then(response => response.json())
            .catch(error => {
                console.error(error);
                throw error;
            });
    }

    //------------------------------------------------------------
    function addEvent(start, end, eventData)
    //------------------------------------------------------------
    {
        const requestUrl = '/events/insertJson';
        const requestBody = {
            request_type: 'addEvent',
            start: start.startStr,
            end: start.endStr,
            event_data: eventData
        };
        fetchRequest(requestUrl, 'POST', requestBody)
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

    //------------------------------------------------------------
    function deleteEvent(eventId)
    //------------------------------------------------------------
    {
        const requestUrl = `/events/deleteJson/${eventId}`;
        const requestBody = {
            request_type: 'deleteEvent',
            event_id: eventId
        };
        fetchRequest(requestUrl, 'POST', requestBody)
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

    //------------------------------------------------------------
    function editEvent(event)
    //------------------------------------------------------------
    {
        Swal.fire({
            title: 'Edit Event',
            confirmButtonText: 'Save',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: true,
            html: `<input id="swalEvtTitle_edit" class="form-control mb-3" placeholder="Enter Title" value="${event.title}">
           <textarea id="swalEvtDesc_edit" class="form-control mb-3" placeholder="Enter Description">${event.extendedProps.description}</textarea>
           <input id="swalEvtURL_edit" class="form-control mb-3" placeholder="Enter URL" value="${event.url}">`,
            preConfirm: () => {
                return [
                    document.getElementById('swalEvtTitle_edit').value,
                    document.getElementById('swalEvtDesc_edit').value,
                    document.getElementById('swalEvtURL_edit').value
                ];
            }
        }).then((result) => {
            if (result.value) {
                const requestUrl = `/events/updateJson/${event.id}`;
                const requestBody = {
                    request_type: 'editEvent',
                    event_id: event.id,
                    start: event.startStr,
                    end: event.endStr,
                    event_data: result.value
                };
                fetchRequest(requestUrl, 'POST', requestBody)
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
    }
</script>