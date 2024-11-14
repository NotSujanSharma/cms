@extends('../layouts.base')
@section('title', 'Profile')
@section('content')
        <!-- Main Content -->
         <div class="flex flex-row w-full">
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
            <div class="mb-8">
                <!-- image -->
                 <div class="flex flex-row items-center gap-3 mb-5">
                    <div class="w-32 h-32 rounded-full bg-gray-300 overflow-hidden">
                        @if(($user->image_path) &&($user->image_path != "null"))
                        <img src="{{ $user->image_path }}" alt="Profile Image" class="w-full h-full  object-cover">
                        @else
                        <img src="https://atg-prod-scalar.s3.amazonaws.com/studentpower/media/user%20avatar.png" alt="Profile Image" class="w-full h-full  object-cover">
                        @endif
                    </div>
                    <h2 class="text-3xl font-bold mb-4">{{$user->name}}</h2>
                </div>
                <a href="{{route('user.edit')}}" class="bg-blue-100 py-3 mx-3 p-3 rounded-lg hover:bg-blue-300 transition duration-300">
                    Edit Profile
                </a>
                
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Registered Clubs</h2>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($user->clubs as $club)
                        <a href="{{ route('club.show', $club->id) }}" >
                            
                        <div class="rounded-xl overflow-hidden shadow-md cursor-pointer" >
                            @if($club->image_path != "null")
                            <img src="{{ $club->image_path }}" alt="{{ $club->name }}" class="w-full h-40 object-cover">
                            @else
                            <img src="https://img.freepik.com/premium-vector/two-cute" alt="{{ $club->name }}" class="w-full h-40 object-cover">
                            @endif
                            <div class="p-2 bg-white">
                                <p class="text-sm">{{ $club->name }}</p>
                            </div>
                        </div>
                        </a>
                    @endforeach

                </div>
            </div>
                
        
        </div>

        <div class="w-64 p-6 bg-gray-100 overflow-auto">
            
            @if($user->events->count() > 0)
            <div class="mb- ">
                <h3 class="font-bold mb-4">Upcoming Events</h3>
                <div class="space-y-3">
                    @foreach($user->events as $event)
                    <div class="bg-blue-100 p-4 rounded-xl border flex flex-col gap-2 shadow-md">
                        <div class="font-bold mb-2">{{ $event->name }}</div>
                        <div class="text-sm">{{ $event->description }}</div>
                        <div class="text-sm text-gray-500">{{ $event->event_date }}</div>
                        <form action="{{ route('event.leave', $event->id) }}" method="POST">
                            @csrf
                            <button class="bg-red-300 px-4 py-2 rounded-full text-sm">Leave</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
        </div>
    </div>

@endsection