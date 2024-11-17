@extends('../layouts.base')
@section('title', 'Error')

@section('content')
<div class="flex flex-row">
    <div class="flex-1 p-8 overflow-auto">
        @if($error)
            <div class="bg-green-100 border-l-4 border-red-500 text-red-700 p-4 mb-2" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ $error }}</p>
            </div>
        @endif
        
    </div>
</div>
@endsection
