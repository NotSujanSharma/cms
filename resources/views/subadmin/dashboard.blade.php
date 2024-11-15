@extends('../layouts.base')
@section('title', 'Manage Club')

@section('content')
<div class="flex flex-row w-full">
    <div class="flex-1 mx-3 overflow-auto">
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
            <img src="https://media.istockphoto.com/id/1086352374/photo/minimal-work-space-creative-flat-lay-photo-of-workspace-desk-top-view-office-desk-with-laptop.jpg?s=612x612&w=0&k=20&c=JYBNQsgeO13lU1rq3kUWfD-W0Xii3sFyYzijvsntplY=" alt="Club Image" class="w-full rounded-lg h-full bg-gray-300 overflow-hidden">
         </div>
    </div>
    <div class="w-64 p-6 bg-gray-100 overflow-auto">
    
            <div class="mb- ">
                <h1 class="font-bold text-2xl mb-4">Users</h1>
                <div class="space-y-3">
                    
                </div>
            </div>
    
    </div>
</div>

@endsection