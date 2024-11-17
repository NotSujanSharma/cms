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

                            <img src="{{ $club->picture_url }}" alt="{{ $club->name }}" class="w-full h-40 object-cover">

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
                    <div class="relative">
                        <a href="{{ route('notifications.index') }}" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>
                <div>
                    <div class="font-bold">
                        {{ Auth::user()->name }}
                    </div>
                    @if(auth()->user()->isSubAdmin())
                    <div class="text-xs">
                        Sub Admin
                    </div>
                    @endif

                </div>
            </div>
            
            <div class="mb-6">
                <h3 class="font-bold mb-4">Latest Activity</h3>
                <div class="space-y-4">
                     @if($club->news->count() > 0)
                         @foreach($club->news as $news)
                            <div class="bg-white p-4 rounded-xl shadow-md cursor-pointer" onclick="window.location.href='{{route('news.show', $news->id)}}'">
                                <div class="font-bold mb-2">{{$news->headline}}</div>
                                <img src="{{ $news->picture_url }}" alt="{{ $club->name }}" class="w-full h-40 rounded-xl object-cover">
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