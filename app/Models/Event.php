<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    protected $fillable = [
        'name',
        'event_date',
        'club_id',
        'description',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->withTimestamps();
    }
}