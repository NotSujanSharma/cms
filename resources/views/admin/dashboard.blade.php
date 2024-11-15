@extends('layouts.admin_base')
@section('title', 'Dashboard')
@section('content')
<div class="flex flex-1 flex-row" x-data="{ 
    showCreateModal: false, 
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
    createUser() {
        document.getElementById('createUserForm').action = `/user/create`;
        document.getElementById('createUserForm').submit();
    },
    
    createEvent() {
        document.getElementById('createEventForm').action = `/create-event`;
        document.getElementById('createEventForm').submit();
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
        </div>

        <!-- User Activity Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">User Activity</h3>
                <div class="flex space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search users" class="pl-8 pr-4 py-2 rounded-lg border">
                        <i class="fas fa-search absolute left-2 top-3 text-gray-400"></i>
                    </div>
                    <button class="flex items-center space-x-2 border px-4 py-2 rounded-lg">
                        <i class="fas fa-filter"></i>
                        <span>Filter</span>
                    </button>
                </div>
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
                        <tr class="border-t">
                            <td class="py-3 flex items-center space-x-2">
                                <img src="https://via.placeholder.com/32" class="w-8 h-8 rounded-full">
                                <span>Bluenose</span>
                            </td>
                            <td>
                                <div class="flex items-center space-x-2">
                                    <div class="w-24 bg-gray-200 h-2 rounded-full">
                                        <div class="w-2/5 bg-gray-600 h-2 rounded-full"></div>
                                    </div>
                                    <span>40%</span>
                                    <span class="text-green-500">↑4%</span>
                                </div>
                            </td>
                            <td>Coding</td>
                        </tr>
                        <tr class="border-t">
                            <td class="py-3 flex items-center space-x-2">
                                <img src="https://via.placeholder.com/32" class="w-8 h-8 rounded-full">
                                <span>Bluenose</span>
                            </td>
                            <td>
                                <div class="flex items-center space-x-2">
                                    <div class="w-24 bg-gray-200 h-2 rounded-full">
                                        <div class="w-2/5 bg-gray-600 h-2 rounded-full"></div>
                                    </div>
                                    <span>40%</span>
                                    <span class="text-green-500">↑4%</span>
                                </div>
                            </td>
                            <td>Coding</td>
                        </tr>
                        <tr class="border-t">
                            <td class="py-3 flex items-center space-x-2">
                                <img src="https://via.placeholder.com/32" class="w-8 h-8 rounded-full">
                                <span>Bluenose</span>
                            </td>
                            <td>
                                <div class="flex items-center space-x-2">
                                    <div class="w-24 bg-gray-200 h-2 rounded-full">
                                        <div class="w-2/5 bg-gray-600 h-2 rounded-full"></div>
                                    </div>
                                    <span>40%</span>
                                    <span class="text-green-500">↑4%</span>
                                </div>
                            </td>
                            <td>Coding</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-4">
                    <button class="text-gray-600">Previous page</button>
                    <div class="flex space-x-2">
                        <button class="w-8 h-8 rounded-full bg-gray-200">1</button>
                        <button class="w-8 h-8 rounded-full">2</button>
                        <!-- Add more page numbers -->
                    </div>
                    <button class="text-gray-600">Next page</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="w-64 flex-2 p-6">
        <div class="flex flex-col items-center space-x-4 mb-6">
            <div class="flex flex-row gap-7 mb-6">
                <div class="flex items-center space-x-2">
                    <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full">
                    <div>
                        <div class="font-semibold">{{Auth::user()->name}}</div>
                        <div class="text-sm text-gray-500">Admin</div>
                    </div>
                </div>
                <i class="fas fa-bell text-xl"></i>
            </div>
            <div class="flex flex-row gap-1">
                <button class="bg-[#B4CD93] w-max text-sm px-3 py-2 rounded-lg" @click="showCreateModal = true; ">Create
                    Event</button>
                <button class="bg-[#B4CD93] w-max text-sm px-3 py-2 rounded-lg"
                    @click="showUserCreationModal = true;">Create User</button>
            </div>
        </div>
        <div class="bg-white rounded-md shadow-md shadow-gray-500/30 p-4 mb-6">
            <h3 class="font-bold mb-4">Most Active Users</h3>
            <div class="space-y-3 overflow-auto h-[120px]">
                @foreach($users['most_active_users'] as $user)
                    <div class="flex items-center space-x-2">
                        @if(($user->profile_photo_path) && ($user->profile_photo_path != 'null'))
                            <img src="{{asset('storage/' . $user->profile_photo_path)}}" class="w-8 h-8 rounded-full">
                        @else
                            <img src="https://via.placeholder.com/32" class="w-8 h-8 rounded-full">
                        @endif
                        <span>{{$user->name}}</span>
                    </div>
                @endforeach
            </div>
            <button onClick="window.location.href='{{route('admin.users')}}'"
                class="bg-[#B4CD93] w-full px-4 py-2 rounded-lg mt-4">View all users</button>
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

                    <form method="POST" action="" @submit.prevent="createEvent()" id="createEventForm">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="user_id" x-model="userId">
                        <div class="space-y-4">
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
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md" @click.away="showUserCreationModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Create User</h3>
                        <button @click="showUserCreationModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
    
                    <form method="POST" action="" @submit.prevent="createUser()" id="createUserForm">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="user_id" x-model="userId">
                        <div class="space-y-4">
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
</div>
@endsection