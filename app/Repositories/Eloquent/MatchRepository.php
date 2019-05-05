<?php

namespace App\Repositories\Eloquent;
use App\Repositories\MatchRepositoryInterface;
use App\Models\Match;
use App\Models\User;
use App\Models\Chat;
use App\Models\ChatUser;

class MatchRepository implements MatchRepositoryInterface
{
    protected $match;

    /**
    * @param object $match
    */
    public function __construct(Match $match)
    {
        $this->match = $match;
    }

    /**
     * 名前で1レコードを取得
     *
     * @var $name
     * @return object
     */
    public function getFirstRecordByName($name)
    {
        return $this->match->where('name', '=', $name)->first();
    }

    public function like($formData)
    {

        $like = $this->match
        ->where([
            'request_user_id' => $formData['request_user_id'],
            'target_user_id' => $formData['target_user_id'],
        ])
        ->orWhere([
            'request_user_id' => $formData['target_user_id'],
            'target_user_id'  => $formData['request_user_id'],
        ])
        ->exists();

        if ($this->checkDuplicateUserId($formData)) {
            return '自分にはいいねできません';

        }

        if ($like === false) {

             $liked = $this->match->firstOrCreate([
                    'request_user_id' => $formData['request_user_id'],
                    'target_user_id'  => $formData['target_user_id'],
                    'matched_flag'    => false
                ])->save();

            return $message = 'いいねしました';

        } else {

            if ($this->checkDuplicateLike($formData) === true) {
                return $message = 'すでにいいねしたユーザーにはいいねできません';
            }

            if ($this->checkDuplicateMatch($formData) === true) {
                return $message = 'すでにマッチしたユーザーにはいいねできません';
            }

            $liked = $this->match
                ->where([
                    'request_user_id' => $formData['target_user_id'],
                    'target_user_id'  => $formData['request_user_id'],
                ])
                ->first();
            $liked->update(['matched_flag' => true]);

            $chat = Chat::create(['match_id' => $liked->id]);

            ChatUser::create(['chat_id' => $chat->id, 'user_id' => $liked->target_user_id]);
            ChatUser::create(['chat_id' => $chat->id, 'user_id' => $liked->request_user_id]);

            return $message = 'マッチしました';

        }

    }

    protected function checkDuplicateUserId($formData){
        if ($formData['request_user_id'] === $formData['target_user_id']) {
            return true;
        }
    }

    protected function checkDuplicateLike($formData){
        $duplicateLiked = $this->match
            ->where([
                'request_user_id' => $formData['request_user_id'],
                'target_user_id'  => $formData['target_user_id'],
            ])
            ->exists();

        return $duplicateLiked;
    }

    protected function checkDuplicateMatch($formData){
        $duplicateMatch = $this->match
        ->where(function ($query) use ($formData)
        {
            $query->where('request_user_id', $formData['request_user_id'])
                  ->where('target_user_id', $formData['target_user_id'])
                  ->where('matched_flag', true);
        })
        ->orWhere(function ($query) use ($formData)
        {
            $query->where('request_user_id', $formData['target_user_id'])
                  ->where('target_user_id', $formData['request_user_id'])
                  ->where('matched_flag', true);
        })
        ->exists();

        return $duplicateMatch;
    }

    protected function searchMatchdUsers($currentUserId){
        $matchedUsers = $this->match
        ->where(function ($query) use ($currentUserId)
        {
            $query->where('request_user_id', $currentUserId)
                ->where('matched_flag', true);
        })
        ->orWhere(function ($query) use ($currentUserId)
        {
            $query->where('target_user_id', $currentUserId)
                ->where('matched_flag', true);
        })
        ->exists();

        return $matchedUsers;
    }

    protected function getMatchdUsers($currentUserId){
        $matchedUsers = $this->match
        ->where(function ($query) use ($currentUserId)
        {
            $query->where('request_user_id', $currentUserId)
                ->where('matched_flag', true);
        })
        ->orWhere(function ($query) use ($currentUserId)
        {
            $query->where('target_user_id', $currentUserId)
                ->where('matched_flag', true);
        })
        ->get();

        return $matchedUsers;
    }

    public function matchedUsersDesc($currentUserId)
    {

        if ($this->searchMatchdUsers($currentUserId) === false) {
            return  ['fail' => 'マッチしたユーザーがいません'];
        }
        // current userではないuserのみを取得したい
        $collection = collect();
        $matchedUsers = $this->getMatchdUsers($currentUserId);

        foreach ($matchedUsers as $key => $value) {

            if ($value->request_user_id !== $currentUserId) {

                $filtered = collect([
                    'id' => $value->id,
                    'user_id' => $value->request_user_id,
                ]);
                $collection->push($filtered);

            } elseif ($value->target_user_id !== $currentUserId) {

                $filtered = collect([
                    'id' => $value->id,
                    'user_id' => $value->target_user_id,
                ]);
                $collection->push($filtered);
            }
        }

        $filterMatchedUsers = collect();
        foreach (array_reverse($collection->toArray()) as $key => $value) {
            $a = collect();
            $user = User::where('id', $value['user_id'])->latest()->first();
            $user->load('profile');

            $a->put('user', $user);
            $a->put('match_id', $value['id']);

            $filterMatchedUsers->push($a);
        }

        return $filterMatchedUsers;
    }
}