<?php

namespace App\Repositories\Eloquent;
use App\Repositories\ChatRepositoryInterface;
use App\Models\Match;
use App\Models\User;
use App\Models\Chat;

class ChatRepository implements ChatRepositoryInterface
{
    protected $chat;

    /**
    * @param object $chat
    */
    public function __construct(chat $chat)
    {
        $this->chat = $chat;
    }

}