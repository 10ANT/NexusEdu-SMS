@extends('layouts.app')

@section('content')
<style>
    .card-stats {
        padding: 1.5rem;
        border: none;
        transition: transform 0.2s ease-in-out;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
    }
    
    .card-stats:nth-child(1) {
        background: linear-gradient(135deg, #00b09b, #3d5ec9);
    }
    
    .card-stats:nth-child(2) {
        background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    }
    
    .card-stats:nth-child(3) {
        background: linear-gradient(135deg, #f7b733, #fc4a1a);
    }
    
    .card-stats:nth-child(4) {
        background: linear-gradient(135deg, #7f7fd5, #86a8e7);
    }
    
    .calendar-card {
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: none;
    }
</style>

@if(Qs::userIsTeamSA())
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card card-stats">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0 text-white">{{ $users->where('user_type', 'student')->count() }}</h3>
                        <span class="text-uppercase font-size-xs text-white-50">Total Students</span>
                    </div>
                    <div class="ml-3 align-self-center">
                        <i class="icon-users4 icon-3x text-white opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-stats">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0 text-white">{{ $users->where('user_type', 'teacher')->count() }}</h3>
                        <span class="text-uppercase font-size-xs text-white-50">Total Teachers</span>
                    </div>
                    <div class="ml-3 align-self-center">
                        <i class="icon-users2 icon-3x text-white opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-stats">
                <div class="media">
                    <div class="mr-3 align-self-center">
                        <i class="icon-pointer icon-3x text-white opacity-75"></i>
                    </div>
                    <div class="media-body text-right">
                        <h3 class="mb-0 text-white">{{ $users->where('user_type', 'admin')->count() }}</h3>
                        <span class="text-uppercase font-size-xs text-white-50">Total Administrators</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-stats">
                <div class="media">
                    <div class="mr-3 align-self-center">
                        <i class="icon-user icon-3x text-white opacity-75"></i>
                    </div>
                    <div class="media-body text-right">
                        <h3 class="mb-0 text-white">{{ $users->where('user_type', 'parent')->count() }}</h3>
                        <span class="text-uppercase font-size-xs text-white-50">Total Parents</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card calendar-card">
                <div class="card-header">
                    <h3 class="card-title">Event Calendar</h3>
                    @if(in_array(auth()->user()->user_type, ['admin', 'super_admin']))
                    <button id="newEventBtn" class="btn btn-primary float-end">
                        Add New Event
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <input type="hidden" id="eventId">
                    <div class="mb-3">
                        <label for="title" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="title" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start" class="form-label">Start Date/Time</label>
                            <input type="datetime-local" class="form-control" id="start" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end" class="form-label">End Date/Time</label>
                            <input type="datetime-local" class="form-control" id="end" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Event Color</label>
                        <input type="color" class="form-control form-control-color" id="color" value="#3788d8">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="deleteEvent" class="btn btn-danger me-auto" style="display:none;">Delete Event</button>
                <button type="button" id="saveEvent" class="btn btn-primary">Save Event</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        editable: {{ in_array(auth()->user()->user_type, ['admin', 'super_admin']) ? 'true' : 'false' }},
        selectable: {{ in_array(auth()->user()->user_type, ['admin', 'super_admin']) ? 'true' : 'false' }},
        events: function(fetchInfo, successCallback, failureCallback) {
            axios.get('/calendar')
                .then(function(response) {
                    successCallback(response.data);
                })
                .catch(function(error) {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
        },
        select: function(info) {
            @if(in_array(auth()->user()->user_type, ['admin', 'super_admin']))
            openEventModal(null, info.start, info.end);
            @endif
        },
        eventClick: function(info) {
            @if(in_array(auth()->user()->user_type, ['admin', 'super_admin']))
            openEventModal(info.event);
            @else
            showEventDetails(info.event);
            @endif
        },
        eventDrop: function(info) {
            @if(in_array(auth()->user()->user_type, ['admin', 'super_admin']))
            updateEvent(info.event);
            @else
            info.revert();
            @endif
        },
        eventResize: function(info) {
            @if(in_array(auth()->user()->user_type, ['admin', 'super_admin']))
            updateEvent(info.event);
            @else
            info.revert();
            @endif
        }
    });
    calendar.render();

    @if(in_array(auth()->user()->user_type, ['admin', 'super_admin']))
    document.getElementById('newEventBtn')?.addEventListener('click', function() {
        openEventModal();
    });
    @endif

    document.getElementById('saveEvent')?.addEventListener('click', function() {
        var eventData = {
            id: document.getElementById('eventId').value,
            title: document.getElementById('title').value,
            start: document.getElementById('start').value,
            end: document.getElementById('end').value,
            description: document.getElementById('description').value,
            color: document.getElementById('color').value
        };

        var url = eventData.id ? `/events/${eventData.id}` : '/events';
        var method = eventData.id ? 'put' : 'post';

        axios({
            method: method,
            url: url,
            data: eventData
        })
        .then(function(response) {
            if (eventData.id) {
                var existingEvent = calendar.getEventById(response.data.id);
                if (existingEvent) {
                    existingEvent.remove();
                }
            }
            
            calendar.addEvent(response.data);
            eventModal.hide();
        })
        .catch(function(error) {
            console.error('Error:', error);
            alert('Error saving event: ' + (error.response?.data?.message || 'Unknown error'));
        });
    });

    document.getElementById('deleteEvent')?.addEventListener('click', function() {
    const eventId = document.getElementById('eventId').value;
    
    if (!eventId) {
        alert('No event selected');
        return;
    }

    if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
        axios.delete(`/events/${eventId}`)
            .then(function(response) {
                // Remove event from calendar
                const existingEvent = calendar.getEventById(eventId);
                if (existingEvent) {
                    existingEvent.remove();
                }
                
                // Close modal and show success message
                eventModal.hide();
                alert(response.data.message || 'Event deleted successfully');
            })
            .catch(function(error) {
                console.error('Error deleting event:', error);
                
                if (error.response) {
                    switch (error.response.status) {
                        case 403:
                            alert('You are not authorized to delete this event.');
                            break;
                        case 404:
                            alert('Event not found. It may have already been deleted.');
                            // Remove from calendar if it exists
                            const existingEvent = calendar.getEventById(eventId);
                            if (existingEvent) {
                                existingEvent.remove();
                            }
                            eventModal.hide();
                            break;
                        default:
                            alert('Error deleting event: ' + (error.response.data.message || 'Unknown error'));
                    }
                } else if (error.request) {
                    alert('No response received from server. Please check your connection.');
                } else {
                    alert('Error: ' + error.message);
                }
            });
    }
});

    function openEventModal(event = null, start = null, end = null) {
        document.getElementById('eventForm').reset();
        
        const deleteBtn = document.getElementById('deleteEvent');
        if (deleteBtn) {
            deleteBtn.style.display = event ? 'block' : 'none';
        }
        
        if (event) {
            document.getElementById('eventId').value = event.id;
            document.getElementById('title').value = event.title;
            document.getElementById('start').value = event.start ? formatDateTime(event.start) : '';
            document.getElementById('end').value = event.end ? formatDateTime(event.end) : '';
            document.getElementById('description').value = event.extendedProps.description || '';
            document.getElementById('color').value = event.backgroundColor || '#3788d8';
        } else if (start && end) {
            document.getElementById('start').value = formatDateTime(start);
            document.getElementById('end').value = formatDateTime(end);
        }

        eventModal.show();
    }

    function formatDateTime(date) {
        return new Date(date).toISOString().slice(0, 16);
    }

    function showEventDetails(event) {
        var details = `Event Details:\n
Title: ${event.title}
Start: ${event.start.toLocaleString()}
End: ${event.end ? event.end.toLocaleString() : 'No end time'}
Description: ${event.extendedProps.description || 'No description'}`;
        
        alert(details);
    }

    function updateEvent(event) {
        var eventData = {
            id: event.id,
            title: event.title,
            start: event.start.toISOString(),
            end: event.end ? event.end.toISOString() : null,
            description: event.extendedProps.description,
            color: event.backgroundColor
        };

        axios.put(`/events/${eventData.id}`, eventData)
            .catch(function(error) {
                console.error('Error updating event:', error);
                event.revert();
                alert('Error updating event: ' + (error.response?.data?.message || 'Unknown error'));
            });
    }
});
</script>
@endsection