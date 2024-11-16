@extends($layout)
@section('title', 'Notifications')

@section('content')
<div class="container mx-auto px-4">
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
                        @if($notification->data['type'] == 'event_leave')
                            <div class="mt-2 flex gap-3">
                                <!-- button to approve and deny -->
                                <form action="{{route('subadmin.event.approveLeave')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                                    <input type="hidden" name="user_id" value="{{ $notification->data['user_id'] }}">
                                    <input type="hidden" name="event_id" value="{{ $notification->data['event_id'] }}">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{route('subadmin.event.denyLeave')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                                    <input type="hidden" name="user_id" value="{{ $notification->data['user_id'] }}">
                                    <input type="hidden" name="event_id" value="{{ $notification->data['event_id'] }}">
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                                        Deny
                                    </button>
                                </form>
                            </div>
                        @endif

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