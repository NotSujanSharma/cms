<?php
// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $page="notifications";
        if (Auth::user()->isAdmin()) {
            $layout="layouts.admin_base";
        } else {
            $layout= "layouts.base";
        }
        $user = auth()->user();
        $notifications = $user->notifications()->paginate(10);
        
        return view('notifications.index', compact('notifications','page','layout'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return redirect()->back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return redirect()->back();
    }
}