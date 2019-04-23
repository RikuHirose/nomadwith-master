<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chat_id',
        'user_id',
    ];

    // Relations
    public function chat()
    {
      return $this->belongsTo(\App\Models\Chat::class, 'chat_id', 'id');
    }

    public function user()
    {
      return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
