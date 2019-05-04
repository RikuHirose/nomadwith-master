<?php

namespace App\Repositories\Eloquent;
use App\Repositories\MatchRepositoryInterface;
use App\Models\Match;
use App\Models\User;
use App\Models\Chat;

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

            $liked = $this->match
                ->where([
                    'request_user_id' => $formData['target_user_id'],
                    'target_user_id'  => $formData['request_user_id'],
                ])
                ->first();

            $liked->update(['matched_flag' => true]);

            $chat = Chat::create(['match_id' => $liked->id]);

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

    public function matchedUsersDesc($currentUserId)
    {
        $matchedUsers = $this->match
        ->where([
            'request_user_id' => $currentUserId,
            'matched_flag'    => true
        ])
        ->orWhere([
            'target_user_id'  => $currentUserId,
            'matched_flag'    => true
        ])
        ->get();

        // current userではないuserのみを取得したい
        $collection = collect();
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