<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;

//Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isSubAdmin() || $user->isUser()) {
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');
});
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

Route::middleware(['auth', 'role:subadmin'])->group(function () {
    Route::get('/subadmin', [SubAdminController::class, 'index'])->name('subadmin.dashboard');
    Route::post('/subadmin/event/update/{event}', [SubAdminController::class, 'updateEvent'])->name('subadmin.event.update');
    Route::post('/subadmin/event/delete/{event}', [SubAdminController::class, 'destroyEvent'])->name('subadmin.event.destroy');
    Route::post('/subadmin/news/update/{news}', [SubAdminController::class, 'updateNews'])->name('subadmin.news.update');
    Route::post('/subadmin/news/delete/{news}', [SubAdminController::class, 'destroyNews'])->name('subadmin.news.destroy');
    Route::post('/subadmin/event/create', [SubAdminController::class, 'createEvent'])->name('subadmin.event.create');
    Route::post('/subadmin/news/create', [SubAdminController::class, 'createNews'])->name('subadmin.news.create');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/edit-profile', [AdminController::class, 'edit'])->name('admin.edit');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/events', [AdminController::class, 'events'])->name('admin.events');
    Route::post('/user/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/user/update/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::post('/user/delete/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::post('/event/update/{event}', [AdminController::class, 'updateEvent'])->name('event.update');
    Route::post('/event/delete/{event}', [AdminController::class, 'destroyEvent'])->name('event.destroy');
    Route::post('/create-event', [AdminController::class, 'createEvent'])->name('event.create');


});

Route::middleware(['auth', 'role:subadmin,user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('news', [UserController::class, 'news'])->name('user.news');
    Route::get('/news/{news_id}', [UserController::class, 'showNews'])->name('news.show');
    Route::get('/events/{event_id}', [UserController::class, 'event'])->name('event.show');
    Route::get('/clubs/{club_id}', [UserController::class, 'club'])->name('club.show');
    Route::get('/calendar', [UserController::class, 'calendar'])->name('user.calendar');
    
    Route::post('/clubs/{club}/join', [UserController::class, 'joinClub'])->name('club.join');
    Route::post('/clubs/{club}/leave', [UserController::class, 'leaveClub'])->name('club.leave');
    Route::post('/events/{event}/join', [UserController::class, 'joinEvent'])->name('event.join');
    Route::post('/events/{event}/leave', [UserController::class, 'leaveEvent'])->name('event.leave');
    Route::get('/edit-profile', [UserController::class, 'editProfile'])->name('user.edit');
    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('user.update');
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Redirect to the login page after logout
})->name('logout');

Route::get('/', function () {
    return view('welcome');
});
