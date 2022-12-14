<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    use HasPhoto;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'room_number',
        'current_subject',
        'user_id',
        'is_free',
        'photo_path',
    ];

    protected $appends = [
        'photo_url',
    ];
}
