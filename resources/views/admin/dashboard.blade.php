@extends('layouts.admin_base')
@section('title', 'Dashboard')
@section('content')
<div class="flex flex-1 flex-row" x-data="{ 
    showCreateModal: false, 
    showClubCreateModal: false,
    showUserCreationModal: false,
    eventName: '', 
    eventDescription: '', 
    eventDate: '02/02/2025',
    clubId: '',
    userId: '',
    userName: '',
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
    <div class="flex p-4 w-full flex-col">
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
        <div class="flex items-center mb-6">
            <h2 class="text-3xl font-bold">Dashboard</h2>

        </div>

        <div class="mb-8">
            <p class="text-gray-600 mb-4">In the last 30 days,</p>
            <div class="grid grid-cols-2 gap-4 max-w-xl">
                <div class="bg-gray-500 text-white p-5 rounded-lg">
                    <div class="text-3xl font-bold">{{$users['users']->count()}}</div>
                    <div>Total Member</div>
                </div>
                <div class="bg-gray-500 text-white p-5 rounded-lg">
                    <div class="text-3xl font-bold">{{$users['new_users']->count()}}</div>
                    <div>New Member Added</div>
                </div>
            </div>
            <button onClick="window.location.href='{{route('admin.users')}}'"
                class="bg-[#B4CD93] px-4 py-2 rounded-lg mt-4">View all Member</button>
                <button @click="showClubCreateModal = true;" class="bg-blue-200 px-4 py-2 rounded-lg mt-4">Create Club</button>
        </div>

        <!-- User Activity Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">User Activity</h3>

            </div>

            <!-- User Activity Table -->
            <div class="bg-white rounded-lg p-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2">User</th>
                            <th>Ratings</th>
                            <th>Clubs</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table rows would be dynamically generated -->
                        @foreach ($users['most_active_users'] as $user)
                            <tr class="border-t">
                                <td class="py-3 flex items-center space-x-2">
                                    <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full">
                                    <span>{{$user->name}}</span>
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 h-2 rounded-full">
                                            <div class="w-2/5 bg-gray-600 h-2 rounded-full"></div>
                                        </div>
                                        <span>{{ round(($user->clubs->count() / 5) * 100, 2) }}%</span>

                                    </div>
                                </td>
                                <td>{{$user->clubs->count()}}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="w-64 flex-2 p-6">
        <div class="flex flex-col items-center space-x-4 mb-6">
            <div class="flex flex-row gap-7 mb-6">
                <div class="flex items-center space-x-2 cursor-pointer"
                    onclick="window.location.href='{{route('admin.profile')}}'">
                    <img src="{{ auth()->user()->avatar_url }}" class="w-10 h-10 rounded-full">
                    <div>
                        <div class="font-semibold">{{Auth::user()->name}}</div>
                        <div class="text-sm text-gray-500">Admin</div>
                    </div>
                </div>
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
            <div class="flex flex-row gap-1">
                <button class="bg-[#B4CD93] w-max text-sm px-3 py-2 rounded-lg" @click="showCreateModal = true; ">Create
                    Event</button>
                <button class="bg-[#B4CD93] w-max text-sm px-3 py-2 rounded-lg"
                    @click="showUserCreationModal = true;">Create User</button>
            </div>
        </div>
        <div class="bg-white rounded-md shadow-md shadow-gray-500/30 p-4 mb-6">
            <h3 class="font-bold mb-4">Clubs</h3>
            <div class="space-y-3 overflow-auto h-[120px]">
                @foreach($all_clubs as $club)
                    <div class="flex items-center space-x-2">
                        <img src="{{ $club->picture_url }}" class="w-8 h-8 rounded-full">
                        <span>{{$club->name}}</span>
                    </div>
                @endforeach
            </div>
            <button onClick="window.location.href='{{route('admin.clubs')}}'"
                class="bg-[#B4CD93] w-full px-4 py-2 rounded-lg mt-4">View all Clubs</button>
        </div>

        <div class="bg-white rounded-md shadow-md shadow-gray-500/30 p-4">
            <h3 class="font-bold mb-4">Active events</h3>
            <!-- Event statistics would be dynamically generated -->
            <div class="space-y-3">

                <div class="flex justify-between">
                    <table class="w-full">
                        <thead>
                            <tr class="text-center text-gray-500 text-xs">
                                <th></th>
                                <th>Events</th>
                                <th>Members</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($active_clubs as $club)
                                <tr class="text-sm text-center">
                                    <td class="py-2 text-xs">{{$club->name}}</td>
                                    <td>{{$club->events->count()}}</td>
                                    <td>{{$club->users->count()}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <button onClick="window.location.href='{{route('admin.events')}}'"
                class="bg-[#B4CD93] w-full px-4 py-2 rounded-lg mt-4">View all Events</button>
        </div>
    </div>
    <div x-cloak x-on:keydown.escape.prevent.stop="showCreateModal = false" class="relative z-50"
        x-show="showCreateModal">

        <div x-show="showCreateModal" x-cloak class="fixed inset-0 bg-black/50" aria-hidden="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md" @click.away="showCreateModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Create Event</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" enctype="multipart/form-data"  action="" @submit.prevent="createEvent()" id="createEventForm">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="user_id" x-model="userId">

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
                                <label class="block text-sm font-medium text-gray-700">Event Name</label>
                                <input type="text" x-model="eventName" name="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea x-model="eventDescription" name="description"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Club</label>
                                <select name="club_id" x-model="clubId"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Club</option>
                                    @foreach($all_clubs as $club)
                                        <option value="{{$club->id}}">{{$club->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" x-model="eventDate" name="event_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showCreateModal = false"
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
    <div x-cloak x-on:keydown.escape.prevent.stop="show = false" class="relative z-50" x-show="showUserCreationModal">

        <div x-show="showUserCreationModal" x-cloak class="fixed inset-0 bg-black/50" aria-hidden="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div x-show="showUserCreationModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md"
                    @click.away="showUserCreationModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Create User</h3>
                        <button @click="showUserCreationModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST"  enctype="multipart/form-data" action="" @submit.prevent="createUser()" id="createUserForm">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="user_id" x-model="userId">
                        <div class="space-y-4">
                            <div class="flex-1">
                                <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-gray-500
                                                                                                  file:mr-4 file:py-2 file:px-4
                                                                                                  file:rounded-full file:border-0
                                                                                                  file:text-sm file:font-semibold
                                                                                                  file:bg-blue-50 file:text-blue-700
                                                                                                  hover:file:bg-blue-100">
                                @error('avatar')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" x-model="userName" name="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">email</label>
                                <input type="email" x-model="userEmail" name="email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" x-model="userRole"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="subadmin">Sub Admin</option>
                                    <option value="user">User</option>

                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" x-model="userPassword" name="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showUserCreationModal = false"
                                class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div x-cloak x-on:keydown.escape.prevent.stop="showClubCreateModal = false" class="relative z-50" x-show="showClubCreateModal">
    
        <div x-show="showClubCreateModal" x-cloak class="fixed inset-0 bg-black/50" aria-hidden="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    
        <div x-show="showClubCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md" @click.away="showClubCreateModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Create Club</h3>
                        <button @click="showClubCreateModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
    
                    <form method="POST" enctype="multipart/form-data" action="" @submit.prevent="createClub()"
                        id="createClubForm">
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
                                <label class="block text-sm font-medium text-gray-700">Club Name</label>
                                <input type="text" x-model="clubName" name="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sub Admin</label>
                                <select name="subadmin_id" x-model="clubSubAdmin"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Sub Admin</option>
                                    @foreach($subadmins as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showClubCreateModal = false"
                                class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Create Club
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection