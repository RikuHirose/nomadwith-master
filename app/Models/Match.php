<?php

namespace App;

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

    // Relations
    public function user()
    {
      return $this->belongsTo(\App\Models\User::class, 'request_user_id', 'id');
    }

    public function user()
    {
      return $this->belongsTo(\App\Models\User::class, 'target_user_id', 'id');
    }
}
