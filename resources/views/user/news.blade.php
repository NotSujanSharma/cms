@extends('../layouts.base')
@section('title', 'News')
@section('content')
        <!-- Main Content -->
        <div class="flex-1 p-8 bg-gray-100 overflow-auto">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-2" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-2" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
            @endif
            <!-- Popular Clubs -->
            <div class="mb-3 shadow-md bg-white p-2 rounded-md">
                <h2 class="text-xl font-bold mb-4 ">Latest Clubs News</h2>
                
            </div>

            <!-- Weekly Schedule -->
            <div class="mb-8">
                <div class="flex space-x-4 overflow-x-auto">
                    @foreach($clubs as $club)
                        @if($club->news->count() > 0)
                            @foreach($club->news as $news)
                                <div class="bg-white w-[300px] p-4 m-2 rounded-xl border shadow-md flex-shrink-0">
                                    <div class="font-bold mb-2">{{ $news->headline }}</div>
                                    <img src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/social-club-brand-logo-modern-playful-square-design-template-d9931e99bf9a9c9b9ee9ee3b1f5c3193_screen.jpg" 
                                        alt="{{ $club->name }}" class="w-full h-40 rounded-xl object-cover">
                                    <p class="text-sm">{{$news->description}}</p>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
             <div class="mb-3 shadow-md bg-white p-2 rounded-md">
                <h2 class="text-xl font-bold mb-4">Upcoming Events</h2>
                
            </div>
            <div class="mb-8">
                <div class="flex space-y-4 flex-col overflow-y-auto">
                    @foreach($clubs as $club)
                        @if($club->events->count() > 0)
                            @foreach($club->events as $event)
                                <div class="bg-white p-4 rounded-xl border flex flex-col gap-2 shadow-md">
                                    <div class="font-bold mb-2">{{ $event->name }}</div>
                                    <img src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/social-club-brand-logo-modern-playful-square-design-template-d9931e99bf9a9c9b9ee9ee3b1f5c3193_screen.jpg" alt="{{ $club->name }}" class="w-full h-[300px] rounded-xl object-cover">
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
                    @endforeach
                </div>

        </div>

@endsection