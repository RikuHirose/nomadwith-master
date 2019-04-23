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
        'send_from',
        'chat_id',
        'message',
    ];

    // Relations
    public function sendFrom()
    {
      return $this->belongsTo(\App\Models\User::class, 'send_from', 'id');
    }

    public function chat()
    {
      return $this->belongsTo(\App\Models\Chat::class, 'chat_id', 'id');
    }
}
