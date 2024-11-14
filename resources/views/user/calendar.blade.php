@extends('../layouts.base')
@section('title', 'Calendar')

@section('extra_head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css" integrity="sha512-1P/SRFqI1do4eNtBsGIAqIZIlnmOQkaY7ESI2vkl+q+hl9HSXmdPqotN0McmeZVyR4AWV+NvkP6pKOiVdY/V5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.js" integrity="sha512-VyGX7HXwa9yMgIfDPYcj7+XFjtSEzqY7LTf2Tvn2FAf4O6MkD5UzNkrlkMHyLQMbdYfor8SNYKyyeBhTazNgPw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endsection
@section('content')
<div class="flex flex-row w-full justify-center items-center">
    <div class="flex p-8 flex-col overflow-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-3">Your Schedule</h>
        </div>

        <div class="bg-gray-100 rounded-lg shadow-md p-6 mb-8">
            <div id="calendar" class="text-gray-900"></div>
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
                    title: '{{ $event->name }}',
                    start: '{{ $event->event_date }}',
                    end: '{{ $event->event_date }}',
                    
                },
                @endforeach
            ],
            eventContent: function(event) {
                return {
                    html: '<div class="fc-content overflow-hidden cursor-pointer ">' +
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