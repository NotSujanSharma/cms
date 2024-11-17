@extends('../layouts.base')
@section('title', 'Manage Club')

@section('content')
<div class="flex flex-row w-full" x-data="{ 
    showEventCreateModal: false, 
    showNewsPostModal: false, 
    eventId: null, 
    eventName: '', 
    newsHeadline: '',
    newsDate: '02/02/2025',

    newsDescription: '',
    eventDescription: '', 
    eventDate: '02/02/2025',
    newsToDelete: null,
    
    createEvent() {
        document.getElementById('createEventForm').action = `/subadmin/event/create`;
        document.getElementById('createEventForm').submit();
    },
    
    postNews() {
       document.getElementById('postNewsForm').action = `/subadmin/news/create`;
        document.getElementById('postNewsForm').submit();
    }
}" x-cloak>
    <div class="flex-1 mx-3 overflow-auto">
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

        <!-- your club-->
        <div class="mb-8">
            <div class="w-full p-6 bg rounded-lg h-50 bg-gray-300 overflow-hidden"
                style="background-image: url('https://media.istockphoto.com/id/1086352374/photo/minimal-work-space-creative-flat-lay-photo-of-workspace-desk-top-view-office-desk-with-laptop.jpg?s=612x612&w=0&k=20&c=JYBNQsgeO13lU1rq3kUWfD-W0Xii3sFyYzijvsntplY='); background-size: cover; background-position: center;">

                <h1 class="text-3xl text-white font-bold">{{$club->name}}</h1>
                <div class="text-white">
                    | Club {{$club->id}}
                </div>

                <!-- total members, events and news -->
                <div class="flex flex-row justify-left gap-8 text-white mt-4">
                    <div class="flex flex-col">
                        <h1 class="font-bold text-2xl">{{$club->users->count()}}</h1>
                        <p>Members</p>
                    </div>
                    <div class="flex flex-col">
                        <h1 class="font-bold text-2xl">{{$club->events->count()}}</h1>
                        <p>Events</p>
                    </div>
                    <div class="flex flex-col">
                        <h1 class="font-bold text-2xl">{{$club->news->count()}}</h1>
                        <p>News</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- section for events and news -->
        <div class="flex flex-row space-x-4">
            <div class="flex-1">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h1 class="font-bold text-2xl mb-4">Events</h1>
                    <div class="space-y-4">
                        @foreach ($events as $event)
                            <div class="bg-gray-100 p-4 rounded-lg cursor-pointer"
                                onclick="window.location.href='{{route('event.show', $event->id)}}'">
                                <div>
                                    <div class="font-bold">
                                        {{$event->name}}
                                    </div>
                                    <div class="text-sm text-gray-500">

                                        {{ \Carbon\Carbon::parse($event->event_date)->format('Y/m/d') }}
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500">{{$event->description}}</p>
                                <p class="text-sm text-gray-500">{{$event->date}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex-1 overflow-auto">
                <div class="bg-white p-6 rounded-lg shadow ">
                    <h1 class="font-bold text-2xl mb-4">News</h1>
                    <div class="space-y-4">
                        @foreach ($news as $new)
                            <div class="bg-gray-100 p-4 rounded-lg cursor-pointer"
                                onclick="window.location.href='{{route('news.show', $new->id)}}'">
                                <div>
                                    <div class="font-bold">
                                        {{$new->headline}}
                                    </div>
                                    <div class="text-sm text-gray-500">

                                        {{ \Carbon\Carbon::parse($new->date)->format('Y/m/d') }}
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500">{{$new->description}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="w-64 p-6 bg-gray-100">

        <div class=" ">
            <!-- create event an post news buttons -->
            <div class="flex flex-row justify-between">


                <button @click="showEventCreateModal = true;"
                    class="bg-blue-500 text-white p-2 rounded-lg block text-center mb-4">
                    Create Event
                </button>
                <button @click="showNewsPostModal = true; "
                    class="bg-red-500 text-white p-2 rounded-lg block text-center mb-4">
                    Post News
                </button>
            </div>


            <h1 class="font-bold text-2xl mb-4">Members</h1>
            <div class="space-y-3 overflow-auto">
                @foreach ($club->users as $user)
                    <div class="flex items
                                    -center justify-between bg-white p-3 rounded-lg shadow">
                        <div>
                            <h1 class="font-bold">{{$user->name}}</h1>
                            <p class="text-sm text-gray-500">{{$user->email}}</p>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

    </div>
    <div x-cloak x-on:keydown.escape.prevent.stop="showEventCreateModal = false" class="relative z-50"
        x-show="showEventCreateModal">

        <div x-show="showEventCreateModal" x-cloak class="fixed inset-0 bg-black/50" aria-hidden="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div x-show="showEventCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md"
                    @click.away="showEventCreateModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Create Event</h3>
                        <button @click="showEventCreateModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" enctype="multipart/form-data" action="" @submit.prevent="createEvent()"
                        id="createEventForm">
                        @csrf
                        @method('POST')
                        <div class="space-y-4">
                            <div class="flex-1">
                                <input type="file" name="picture" id="picture" accept="image/*" class="block w-full text-sm text-gray-500
                                                                                          file:mr-4 file:py-2 file:px-4
                                                                                          file:rounded-full file:border-0
                                                                                          file:text-sm file:font-semibold
                                                                                          file:bg-blue-50 file:text-blue-700
                                                                                          hover:file:bg-blue-100">
                                @error('picture')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" x-model="eventName" name="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" x-model="eventDate" name="event_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <input type="hidden" name="club_id" value="{{$club->id}}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea x-model="eventDescription" name="description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showEventCreateModal = false"
                                class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Create Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div x-cloak x-on:keydown.escape.prevent.stop="showNewsPostModal = false" class="relative z-50"
        x-show="showNewsPostModal">

        <div x-show="showNewsPostModal" x-cloak class="fixed inset-0 bg-black/50" aria-hidden="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div x-show="showNewsPostModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md" @click.away="showNewsPostModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Post News</h3>
                        <button @click="showNewsPostModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" enctype="multipart/form-data"  action="" @submit.prevent="postNews()" id="postNewsForm">
                        @csrf
                        @method('POST')
                        <div class="space-y-4">
                            
                        <div class="flex-1">
                            <input type="file" name="picture" id="picture" accept="image/*"
                                class="block w-full text-sm text-gray-500
                                                                                                                                              file:mr-4 file:py-2 file:px-4
                                                                                                                                              file:rounded-full file:border-0
                                                                                                                                              file:text-sm file:font-semibold
                                                                                                                                              file:bg-blue-50 file:text-blue-700
                                                                                                                                              hover:file:bg-blue-100">
                            @error('picture')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                            <div>

                                <label class="block text-sm font-medium text-gray-700">Headline</label>
                                <input type="text" x-model="newsHeadline" name="headline"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" x-model="newsDate" name="date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <input type="hidden" name="club_id" value="{{$club->id}}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea x-model="newsDescription" name="description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showNewsPostModal = false"
                                class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection