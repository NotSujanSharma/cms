@extends('../layouts.base')
@section('title')
{{$event->name}}
@endsection

@section('content')
<div class="flex flex-row w-full overflow-auto" x-data="{ 
    showEditModal: false, 
    showDeleteModal: false, 
    eventId: null, 
    eventName: '', 
    eventDescription: '', 
    eventDate: '02/02/2025',
    eventToDelete: null,
    
    updateEvent() {
        document.getElementById('updateForm').action = `/subadmin/event/update/${this.eventId}`;
        document.getElementById('updateForm').submit();
    },
    
    deleteEvent() {
       document.getElementById('deleteForm').action = `/subadmin/event/delete/${this.eventId}`;
        document.getElementById('deleteForm').submit();
    }
}" x-cloak>
    <div class="flex-1 mx-3">
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
                style="background-image: url('{{ $event->picture_url }}'); background-size: cover; background-position: center;">

                <h1 class="text-3xl text-white font-bold">{{$event->name}}</h1>
                <div class="text-white">
                    {{$event->club->name}}
                </div>

                <!-- total members, events and news -->
                <div class="flex flex-row justify-left gap-8 text-white mt-4">
                    <div class="flex flex-col">
                        <h1 class="font-bold text-2xl">{{$event->participants->count()}}</h1>
                        <p>Participants</p>
                    </div>

                </div>
            </div>
        </div>
        <!-- section for events and news -->
        <div class="flex flex-row space-x-4">
            <div class="flex-1">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h1 class="font-bold text-2xl mb-4">{{$event->name}}</h1>
                    <div class="space-y-4">
                        {{$event->description}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-64 p-6 bg-gray-100 overflow-auto">
        <div class="">
            @if(Auth::user()->role == 'subadmin')
                <div class="flex flex-row justify-between">


                    <button @click="showEditModal = true; 
                                                    eventId = '{{$event->id}}'; 
                                                    eventName = '{{$event->name}}'; 
                                                    eventDate = '{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}';
                                                    eventClub = '{{$event->club_id}}';
                                                    eventDescription = '{{$event->description}}';"
                        class="bg-blue-500 text-white p-2 rounded-lg block text-center mb-4">
                        Edit Event
                    </button>
                    <button @click="showDeleteModal = true; 
                                                                eventId = '{{$event->id}}'; 
                                                                eventName = '{{$event->name}}'; 
                                                                eventDate = '{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}';
                                                                eventClub = '{{$event->club_id}}';
                                                                eventDescription = '{{$event->description}}';"
                        class="bg-red-500 text-white p-2 rounded-lg block text-center mb-4">
                        Delete Event
                    </button>
                </div>
            @endif
            <h1 class="font-bold text-2xl mb-4">Participants</h1>
            <div class="space-y-3 overflow-auto">
                @foreach ($event->participants as $user)
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

    <div x-cloak x-on:keydown.escape.prevent.stop="showEditModal = false" class="relative z-50" x-show="showEditModal">

        <div x-show="showEditModal" x-cloak class="fixed inset-0 bg-black/50" aria-hidden="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md" @click.away="showEditModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Edit Event</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="" enctype="multipart/form-data" @submit.prevent="updateEvent()"
                        id="updateForm">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="event_id" x-model="eventId">
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
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea x-model="eventDescription" name="description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showEditModal = false"
                                class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div x-cloak x-on:keydown.escape.prevent.stop="showDeleteModal = false" class="relative z-50"
        x-show="showDeleteModal">

        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 bg-black/50" aria-hidden="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md" @click.away="showDeleteModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Confirm Deletion</h3>
                        <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <p class="text-gray-600 mb-6">Are you sure you want to delete this event? This action cannot be
                        undone.
                    </p>

                    <div class="flex justify-end space-x-3">
                        <button @click="showDeleteModal = false"
                            class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                            Cancel
                        </button>
                        <form method="post" action="" @submit.prevent="deleteEvent()" id="deleteForm" class="inline">
                            @csrf
                            @method('post')
                            <input type="hidden" name="event_id" x-model="eventToDelete">
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection