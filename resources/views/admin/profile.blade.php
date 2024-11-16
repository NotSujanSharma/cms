@extends('layouts.admin_base')
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
                <a href="{{route('admin.edit')}}" class="bg-blue-100 py-3 mx-3 p-3 rounded-lg hover:bg-blue-300 transition duration-300">
                    Edit Profile
                </a>
                
</div>
                
        
        </div>

    </div>

@endsection