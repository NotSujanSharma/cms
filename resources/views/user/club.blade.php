@extends('../layouts.base')
@section('title')
    {{ $club->name }}
@endsection
@section('content')
        <!-- if success display success , if error display error -->
        
        <div class="flex p-8 flex-col w-full overflow-auto">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
            @endif
            <!-- Popular Clubs -->
            <div class="mb-6 ">
                <h2 class="text-xl font-bold">{{$club->name}}</h2>
            </div>
            
            <div class="mb-8 shadow-md bg-gray-100 p-2 gap-3 flex items-center flex-col text-center">
                Welcome to {{ $club->name }}<br>
                @if($club->description)
                    <p>{{ $club->description }}</p>
                @endif
                @if($is_member)
                <p class="text-green-800">You are already a member of this club.</p>
                <form action="{{ route('club.leave', $club->id) }}" method="POST">
                    @csrf
                    <button class=" px-4 py-2 rounded-full font-bold text-white bg-red-800 w-40 text-sm" >Leave Club</button>
                </form>
                @else
                <form action="{{ route('club.join', $club->id) }}" method="POST">
                    @csrf
                    <button class=" px-4 py-2 rounded-full font-bold text-white bg-green-800 w-40 text-sm" >Join Now</button>
                </form>
                @endif
            </div>

           
        
             <div class="mb-6">
                <h2 class="text-xl font-bold">Upcoming Events</h2>
            </div>
            <div class="mb-6">
                <div class="flex space-y-4 flex-col overflow-y-auto">
                   
                        @if($club->events->count() > 0)
                            @foreach($club->events as $event)
                                <div class="bg-white p-4 rounded-xl border flex flex-col gap-2 shadow-md">
                                    <div class="font-bold mb-2">{{ $event->name }}</div>
                                    <img src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/social-club-brand-logo-modern-playful-square-design-template-d9931e99bf9a9c9b9ee9ee3b1f5c3193_screen.jpg" alt="{{ $club->name }}" class="w-full h-[300px] rounded-xl  object-cover">
                                    <div class="flex flex-row justify-between">
                                        <div>
                                            <div class="text-sm">{{ $event->description }}</div>
                                            <div class="text-sm text-gray-500">{{ $event->event_date }}</div>
                                        </div>
                                        <div>
                                            @if(in_array($event->id, $joined_events))
                                                <button class="bg-blue-200 px-4 py-2 rounded-full text-sm">Joined</button>
                                            @else
                                                <form action="{{ route('event.join', $event->id) }}" method="POST">
                                                    @csrf
                                                    <button class="bg-green-200 px-4 py-2 rounded-full text-sm">Join Now</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    
                </div>

        </div>

@endsection