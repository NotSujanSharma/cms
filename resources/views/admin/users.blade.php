@extends('layouts.admin_base')
@section('title', 'Users')
@section('content')
<div class="w-full">
    <div class="flex flex-col">
        <h1 class="text-3xl font-bold mb-8">All Users</h1>
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
    <div class="bg-white rounded-lg p-4">
        <table class="w-full">
            <thead>
                <tr class="text-left">
                    <th class="py-2">User</th>
                    <th>Roles</th>
                    <th>Ratings</th>
                    <th>Joined Clubs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                 @foreach($users as $user)
                <tr class="border-t">
                    <td class="py-3 flex items-center space-x-2">
                        <img src="https://via.placeholder.com/32" class="w-8 h-8 rounded-full">
                        <span>{{$user->name}}</span>
                    </td>
                    <td>
                        <div class="flex space-x-2">
                            @if($user->isAdmin())
                            <span class="bg-green-200 text-green-700 px-2 py-1 rounded-full">Admin</span>
                            @endif
                            @if($user->isSubAdmin())
                            <span class="bg-yellow-200 text-yellow-700 px-2 py-1 rounded-full">Sub Admin</span>
                            @endif
                            @if($user->isUser())
                            <span class="bg-blue-200 text-blue-700 px-2 py-1 rounded-full">User</span>
                            @endif
                        </div>
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
                    <td>
                        {{$user->clubs->count()}}
                    </td>
                    <td>
                        <button class="text-blue-500">Edit</button>
                        <button class="text-red-500">Delete</button>
                    </td>
                </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
</div>

@endsection