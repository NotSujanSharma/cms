@extends('../layouts.base')
@section('title', 'Edit Profile')
@section('content')
<div class="flex flex-row">
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
            <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
            <form method="POST" enctype="multipart/form-data" action="{{ route('user.update', $user->id) }}"
                class="space-y-6">
                @csrf
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" name="name"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Name" value="{{ $user->name }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Email" value="{{ $user->email }}">
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition duration-300">
                    Update
                </button>
            </form>
        </div>
    </div>
</div>


@endsection