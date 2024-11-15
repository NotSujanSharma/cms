<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Models\ClubSubAdmin;

class Club extends Model
{
    protected $fillable = [
        'name',
        'image_path',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'club_user')
            ->withTimestamps();
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
    public function subAdmin(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            ClubSubAdmin::class,
            'club_id',      // Foreign key on `club_subadmin` table
            'id',           // Foreign key on `users` table
            'id',           // Local key on `clubs` table
            'user_id'       // Local key on `club_subadmin` table
        );
    }

}