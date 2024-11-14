   @extends('layouts.admin_base')
   @section('title', 'Dashboard')
    @section('content')
   <div class="flex flex-1 flex-row">
        <!-- Main Content -->
        <div class="flex p-4 w-full flex-col">
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
                <button onClick="window.location.href='{{route('admin.users')}}'" class="bg-[#B4CD93] px-4 py-2 rounded-lg mt-4">View all Member</button>
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
                <div class="flex flex-row gap-1" >
                    <button class="bg-[#B4CD93] w-max text-sm px-3 py-2 rounded-lg">Create Events</button>
                    <button class="bg-[#B4CD93] w-max text-sm px-3 py-2 rounded-lg">Manage Users</button>
                </div>
            </div>
            <div class="bg-white rounded-md shadow-md shadow-gray-500/30 p-4 mb-6">   
                <h3 class="font-bold mb-4">Most Active Users</h3>
                <div class="space-y-3 overflow-auto h-[120px]">
                    @foreach($users['most_active_users'] as $user)
                    <div class="flex items-center space-x-2">
                        @if(($user->profile_photo_path)&&($user->profile_photo_path!='null'))
                        <img src="{{asset('storage/'.$user->profile_photo_path)}}" class="w-8 h-8 rounded-full">
                        @else
                        <img src="https://via.placeholder.com/32" class="w-8 h-8 rounded-full">
                        @endif
                        <span>{{$user->name}}</span>
                    </div>
                    @endforeach
                </div>
                <button class="bg-[#B4CD93] w-full px-4 py-2 rounded-lg mt-4">View all users</button>
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
                <button class="bg-[#B4CD93] w-full px-4 py-2 rounded-lg mt-4">View all projects</button>
            </div>
        </div>
    </div>
    @endsection

