@extends('../layouts.base')
@section('title')
{{$news->headline}}
@endsection

@section('content')
<div class="flex flex-row w-full overflow-auto" x-data="{ 
    showEditModal: false, 
    showDeleteModal: false, 
    newsId: null, 
    newsHeadline: '', 
    newsDescription: '', 
    newsDate: '02/02/2025',
    newsToDelete: null,
    
    updateNews() {
        document.getElementById('updateForm').action = `/subadmin/news/update/${this.newsId}`;
        document.getElementById('updateForm').submit();
    },
    
    deleteNews() {
       document.getElementById('deleteForm').action = `/subadmin/news/delete/${this.newsId}`;
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
                style="background-image: url('https://media.istockphoto.com/id/1086352374/photo/minimal-work-space-creative-flat-lay-photo-of-workspace-desk-top-view-office-desk-with-laptop.jpg?s=612x612&w=0&k=20&c=JYBNQsgeO13lU1rq3kUWfD-W0Xii3sFyYzijvsntplY='); background-size: cover; background-position: center;">

                <h1 class="text-3xl text-white font-bold">{{$news->headline}}</h1>
                <div class="text-white">
                    {{$news->club->name}}
                </div>

                <div class="flex flex-row justify-left gap-8 text-white mt-4">
                    <div class="flex flex-col">
                        <h1 class="font-bold text-xs">{{ \Carbon\Carbon::parse($news->date)->format('Y/m/d') }}</h1>
                    </div>

                </div>
            </div>
        </div>
        <div class="flex flex-row space-x-4">
            <div class="flex-1">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h1 class="font-bold text-2xl mb-4">{{$news->headline}}</h1>
                    <div class="space-y-4">
                        {{$news->description}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::user()->role == 'subadmin')
    <div class="w-64 p-6 bg-gray-100 overflow-auto">

        <div class="">
            <div class="flex flex-row justify-between">


                <button @click="showEditModal = true; 
                                                            newsId = '{{$news->id}}'; 
                                                            newsHeadline = '{{$news->headline}}'; 
                                                            newsDate = '{{ \Carbon\Carbon::parse($news->date)->format('Y-m-d') }}';
                                                            newsDescription = '{{$news->description}}';"
                    class="bg-blue-500 text-white p-2 rounded-lg block text-center mb-4">
                    Edit News
                </button>
                <button @click="showDeleteModal = true; 
                                                                        newsId = '{{$news->id}}'; 
                                                                        newsHeadline = '{{$news->headline}}'; 
                                                                        newsDate = '{{ \Carbon\Carbon::parse($news->date)->format('Y-m-d') }}';
                                                                        newsDescription = '{{$news->description}}';"
                    class="bg-red-500 text-white p-2 rounded-lg block text-center mb-4">
                    Delete News
                </button>
            </div>

        </div>

    </div>
    @endif
    <div x-cloak x-on:keydown.escape.prevent.stop="showEditModal = false" class="relative z-50" x-show="showEditModal">
    
        <div x-show="showEditModal" x-cloak class="fixed inset-0 bg-black/50" aria-hidden="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md" @click.away="showEditModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Edit News</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
    
                    <form method="POST" action="" @submit.prevent="updateNews()" id="updateForm">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" x-model="newsId">
                        <div class="space-y-4">
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
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea x-model="newsDescription" name="description"
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
    
    <div x-cloak x-on:keydown.escape.prevent.stop="showDeleteModal = false" class="relative z-50" x-show="showDeleteModal">
    
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
    
                    <p class="text-gray-600 mb-6">Are you sure you want to delete this News? This action cannot be undone.
                    </p>
    
                    <div class="flex justify-end space-x-3">
                        <button @click="showDeleteModal = false"
                            class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">
                            Cancel
                        </button>
                        <form method="post" action="" @submit.prevent="deleteNews()" id="deleteForm" class="inline">
                            @csrf
                            @method('post')
                            <input type="hidden" name="id" x-model="newsToDelete">
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