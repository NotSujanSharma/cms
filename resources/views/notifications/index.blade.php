@extends($layout)
@section('title', 'Notifications')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Notifications</h2>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notification)
            <div class="bg-white p-4 rounded-lg shadow {{ $notification->read_at ? 'opacity-75' : '' }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-gray-800">
                            {{ $notification->data['message'] }}
                        </p>
                        <span class="text-sm text-gray-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                    @if(!$notification->read_at)
                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-blue-500 hover:text-blue-700">
                                Mark as read
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500">
                No notifications found
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection