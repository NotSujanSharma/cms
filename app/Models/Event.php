<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = [
        'name',
        'event_date',
        'club_id',
        'description',
        'picture',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function getPictureUrlAttribute()
    {
        if ($this->picture) {
            return Storage::url($this->picture);
        }

        // Return default avatar if none is uploaded
        return "https://media.istockphoto.com/id/1086352374/photo/minimal-work-space-creative-flat-lay-photo-of-workspace-desk-top-view-office-desk-with-laptop.jpg?s=612x612&w=0&k=20&c=JYBNQsgeO13lU1rq3kUWfD-W0Xii3sFyYzijvsntplY=";
    }

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