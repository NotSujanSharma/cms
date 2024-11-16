@extends('layouts.admin_base')
@section('title', 'Users')
@section('content')
<div class="w-full" x-data="{ 
    showEditModal: false, 
    showDeleteModal: false, 
    userId: null, 
    userName: '', 
    userEmail: '', 
    userRole: '',
    userToDelete: null,
    
    updateUser() {
        document.getElementById('updateForm').action = `/user/update/${this.userId}`;
        document.getElementById('updateForm').submit();
    },
    
    deleteUser() {
       document.getElementById('deleteForm').action = `/user/delete/${this.userToDelete}`;
        document.getElementById('deleteForm').submit();
    }
}" x-cloak>
    <div class="flex flex-col">
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
        <h1 class="text-3xl font-bold mb-8">All Users</h1>
        
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
                        <img src="https://i.pinimg.com/236x/77/c1/3f/77c13ffc9207a326d281265a2f04e019.jpg" class="w-8 h-8 rounded-full">
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
                    <td class="space-x-2">
                        <button @click="showEditModal = true; 
                                    userId = '{{$user->id}}'; 
                                    userName = '{{$user->name}}'; 
                                    userEmail = '{{$user->email}}'; 
                                    userRole = '{{$user->role}}'" 
                                class="text-blue-500 hover:text-blue-700">
                            Edit
                        </button>
                        <button @click="showDeleteModal = true; userToDelete = '{{$user->id}}'" 
                                class="text-red-500 hover:text-red-700">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
    <div x-cloak
         x-on:keydown.escape.prevent.stop="showEditModal = false"
         class="relative z-50"
         x-show="showEditModal">
        
        <div x-show="showEditModal" 
             x-cloak
             class="fixed inset-0 bg-black/50" 
             aria-hidden="true"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>
    
        <div x-show="showEditModal" 
            x-cloak
             class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md"
                     @click.away="showEditModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Edit User</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form  method="POST" action=""  @submit.prevent="updateUser()" id="updateForm">
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
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" x-model="userEmail" name="email" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <select x-model="userRole" name="role" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="subadmin">Sub Admin</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showEditModal = false" 
                                    class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div x-cloak
         x-on:keydown.escape.prevent.stop="showDeleteModal = false"
         class="relative z-50"
         x-show="showDeleteModal">
        
        <div x-show="showDeleteModal"
             x-cloak 
             class="fixed inset-0 bg-black/50" 
             aria-hidden="true"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>
    
        <div x-show="showDeleteModal" 
                x-cloak
             class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md"
                     @click.away="showDeleteModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Confirm Deletion</h3>
                        <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <p class="text-gray-600 mb-6">Are you sure you want to delete this user? This action cannot be undone.</p>
                    
                    <div class="flex justify-end space-x-3">
                        <button @click="showDeleteModal = false" 
                                class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                            Cancel
                        </button>
                        <form method="post" action="" @submit.prevent="deleteUser()" id="deleteForm" class="inline">
                            @csrf
                            @method('post')
                            <input type="hidden" name="user_id" x-model="userToDelete">
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
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