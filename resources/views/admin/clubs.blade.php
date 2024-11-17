@extends('layouts.admin_base')
@section('title', 'Clubs')
@section('content')
<div class="w-full" x-data="{ 
    showEditModal: false, 
    showDeleteModal: false, 
    clubId: null, 
    clubName: '', 
    clubSubAdmin: '',
    userEmail: '', 
    userRole: '',
    clubToDelete: null,
    
    updateClub() {
        document.getElementById('updateForm').action = `/club/update/${this.clubId}`;
        document.getElementById('updateForm').submit();
    },
    
    deleteClub() {
       document.getElementById('deleteForm').action = `/club/delete/${this.clubToDelete}`;
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
        <h1 class="text-3xl font-bold mb-8">All Clubs</h1>

    </div>
    <div class="bg-white rounded-lg p-4">
        <table class="w-full">
            <thead>
                <tr class="text-left">
                    <th class="py-2">Clubs</th>
                    <th>Members</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clubs as $club)
                    <tr class="border-t">
                        <td class="py-3 flex items-center space-x-2">
                            <img src="{{ $club->picture_url }}" class="w-8 h-8 rounded-full">
                            <span>{{$club->name}}</span>
                        </td>
                     
                        
                        <td>
                            {{$club->users->count()}}
                        </td>
                        <td class="space-x-2">
                            <button @click="showEditModal = true;
                                    clubId = '{{$club->id}}';
                                    clubName = '{{$club->name}}';
                                    clubSubAdmin = '{{$club->subadmin_id}}';" class="text-blue-500 hover:text-blue-700">


                                Edit
                            </button>
                            <button @click="showDeleteModal = true; clubToDelete = '{{$club->id}}'"
                                class="text-red-500 hover:text-red-700">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                        <h3 class="text-lg font-medium">Edit User</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="" @submit.prevent="updateClub()" id="updateForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" x-model="clubId">
                        <div class="space-y-4">

                            <div class="flex-1">
                                <input type="file" name="image_url" id="image_url" accept="image/*" class="block w-full text-sm text-gray-500
                                                                      file:mr-4 file:py-2 file:px-4
                                                                      file:rounded-full file:border-0
                                                                      file:text-sm file:font-semibold
                                                                      file:bg-blue-50 file:text-blue-700
                                                                      hover:file:bg-blue-100">
                                @error('image_url')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Club Name</label>
                                <input type="text" x-model="clubName" name="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sub Admin</label>
                                <select name="subadmin_id" x-model="clubSubAdmin"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                    <option value="">Select Sub Admin</option>
                                    @foreach($subadmins as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
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

                    <p class="text-gray-600 mb-6">Are you sure you want to delete this club? This action cannot be
                        undone.</p>

                    <div class="flex justify-end space-x-3">
                        <button @click="showDeleteModal = false"
                            class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                            Cancel
                        </button>
                        <form method="post" action="" @submit.prevent="deleteClub()" id="deleteForm" class="inline">
                            @csrf
                            @method('post')
                            <input type="hidden" name="id" x-model="clubToDelete">
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