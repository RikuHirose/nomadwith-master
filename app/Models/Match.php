<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_user_id',
        'target_user_id',
        'matched_flag',
    ];

    protected $casts = [
        'matched_flag' => 'boolean'
    ];

    // Relations
    public function requestUser()
    {
      return $this->belongsTo(\App\Models\User::class, 'request_user_id', 'id');
    }

    public function targetUser()
    {
      return $this->belongsTo(\App\Models\User::class, 'target_user_id', 'id');
    }

    public function user()
    {
      return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
