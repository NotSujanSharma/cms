@extends('../layouts.base')
@section('title', 'Home')
@section('content')
        <!-- Main Content -->

        <div class="flex">
            <div class="flex-1 p-8 overflow-auto">
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
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Popular Clubs</h2>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($clubs as $club)
                        <a href="{{ route('club.show', $club->id) }}" >
                            
                        <div class="rounded-xl overflow-hidden shadow-md cursor-pointer" >
                            @if($club->image_path != "null")
                            <img src="{{ $club->image_path }}" alt="{{ $club->name }}" class="w-full h-40 object-cover">
                            @else
                            <img src="https://img.freepik.com/premium-vector/two-cute-boys-playing-football-park-vector-illustration_680433-293.jpg" alt="{{ $club->name }}" class="w-full h-40 object-cover">
                            @endif
                        <div class="p-2 bg-white">
                            <p class="text-sm">{{ $club->name }}</p>
                        </div>
                        </div>
                        </a>
                    @endforeach
                    
                </div>
            </div>

            <!-- Weekly Schedule -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Weekly Schedule</h2>
                <div class="space-y-3">
                    @foreach($clubs as $club)
                        <!-- display first event of club -->
                                @if($club->events->count() > 0)
                                @php
                                    $event = $club->events->first();
                                @endphp
                                <div class="bg-blue-100 p-4 rounded-xl flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-center">
                                            <div class="font-bold">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</div>
                                            <div class="text-sm">{{ \Carbon\Carbon::parse($event->date)->format('D') }}</div>
                                        </div>
                                        <div>

                                            <div class="font-bold">{{ $club->name }}</div>
                                            <div>{{ $event->name }}</div>
                                        </div>
                                    </div>
                                    @if(in_array($club->id, $joined_clubs))
                                    <form action="{{ route('club.leave', $club->id) }}" method="POST">
                                        @csrf
                                    <button class="bg-red-200 px-4 py-2 rounded-full text-sm">Leave Now</button>
                                    </form>
                                    @else
                                    <form action="{{ route('club.join', $club->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-green-200 px-4 py-2 rounded-full text-sm">Join Now</button>
                                    </form>
                                    @endif
                                </div>
                            @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="w-64 p-6 bg-gray-100 overflow-auto">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-2">
                    <i class="fab fa-snapchat text-xl"></i>
                    <i class="fas fa-comment text-xl"></i>
                </div>
                <div class="font-bold">{{ Auth::user()->name }}</div>
            </div>
            
            <div class="mb-6">
                <h3 class="font-bold mb-4">Latest Activity</h3>
                <div class="space-y-4">
                     @if($club->news->count() > 0)
                     @foreach($club->news as $news)
                    <div class="bg-white p-4 rounded-xl shadow-md">
                        <div class="font-bold mb-2">{{$news->headline}}</div>
                        <img src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/social-club-brand-logo-modern-playful-square-design-template-d9931e99bf9a9c9b9ee9ee3b1f5c3193_screen.jpg?ts=1590184618" alt="{{ $club->name }}" class="w-full h-40 rounded-xl object-cover">
                        <p class="text-sm">
                            {{$news->description}}
                        </p>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
</div>

@endsection