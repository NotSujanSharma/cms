@extends('../layouts.base')
@section('title', 'Calendar')

@section('extra_head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css" integrity="sha512-1P/SRFqI1do4eNtBsGIAqIZIlnmOQkaY7ESI2vkl+q+hl9HSXmdPqotN0McmeZVyR4AWV+NvkP6pKOiVdY/V5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.js" integrity="sha512-VyGX7HXwa9yMgIfDPYcj7+XFjtSEzqY7LTf2Tvn2FAf4O6MkD5UzNkrlkMHyLQMbdYfor8SNYKyyeBhTazNgPw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endsection
@section('content')
<div class="flex flex-row w-full justify-center items-center"  x-data="{ 
    showCreateModal: false, 
    showClubCreateModal: false,
    showUserCreationModal: false,
    eventDate: '', 
    eventDescription: '', 
    eventDate: '02/02/2025',
    eventId: '',
    eventDate: '',
    eventTitle: '',
    userEmail: '',
    userRole: '',
    userPassword: '',
    clubName: '',
    clubSubAdmin: '',
    createUser() {
        document.getElementById('createUserForm').action = `/user/create`;
        document.getElementById('createUserForm').submit();
    },
    
    createEvent() {
        document.getElementById('createEventForm').action = `/create-event`;
        document.getElementById('createEventForm').submit();
    },
    createClub() {
        document.getElementById('createClubForm').action = `/create-club`;
        document.getElementById('createClubForm').submit();
    },
    
    
}" x-cloak>
    <div class="flex p-8 flex-col overflow-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-3">Your Schedule</h>
        </div>

        <div class="bg-gray-100 rounded-lg shadow-md p-6 mb-8">
            <div id="calendar" class="text-gray-900"></div>
        </div>
    </div>
    <div x-cloak x-on:keydown.escape.prevent.stop="showClubCreateModal = false" class="relative z-50"
        x-show="showClubCreateModal">
    
        <div x-show="showClubCreateModal" x-cloak class="fixed inset-0 bg-black/50" aria-hidden="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    
        <div x-show="showClubCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md" @click.away="showClubCreateModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium"><span x-text="eventTitle"></span></h3>
                        <button @click="showClubCreateModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
    
<!-- show event id -->
                    <div x-show="eventId" class="mb-4">
                        

                        <div class="mt-4">
                            <label for="event_title" class="block text-sm font-medium text-gray-700">Event</label>
                            <div id="event_title" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <span x-text="eventTitle"></span>
                            </div>
                        </div>

                            <div class="mt-4">
                                <label for="event_date" class="block text-sm font-medium text-gray-700">Starting At</label>
                                <div id="event_date" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <span x-text="eventDate"></span>
                                </div>
                            </div>

                            

                            
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            events: [
                @foreach($user_events as $event)
                {
                    id: '{{ $event->id }}',
                    title: '{{ $event->name }}',
                    start: '{{ $event->event_date }}',
                    end: '{{ $event->event_date }}',
                    description : '{{ $event->description }}',

                    
                },
                @endforeach
            ],
            eventContent: function(event) {
                return {
                    html: `<div class="fc-content overflow-hidden cursor-pointer" @click="showClubCreateModal = true; eventId= '${event.event.id}' ; eventTitle = '${event.event.title}'; eventDate='${event.event.start}'; eventDescription='${event.event.description}'">` +
                        // '<span class="fc-time">' + event.event.end + ' </span>' +
                        '<span class="fc-title font-bold">' + event.event.title + '</span>' +
                        '</div>'
                };
            },
             
            eventDisplay: 'block',
            eventBackgroundColor: '#3e68ff',
            eventTextColor: '#fff',
            eventTimeFormat: { hour: 'numeric', minute: '2-digit', hour12: true },
        });
        calendar.render();
    });
</script>

@endsection