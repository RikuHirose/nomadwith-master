<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'match_id'
    ];

    // Relations
    public function match()
    {
        return $this->belongsTo(\App\Models\Match::class, 'match_id', 'id');
    }

    public function chatUser()
    {
        return $this->hasMany(\App\Models\ChatUser::class, 'chat_id', 'id');
    }
}
