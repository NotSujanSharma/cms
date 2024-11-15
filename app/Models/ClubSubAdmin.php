<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClubSubAdmin extends Model
{
    protected $fillable = [
        'club_id',
        'user_id',
    ];
    protected $table = 'club_subadmin';
}