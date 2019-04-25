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

        if ($like == false) {
             $liked = $this->match->firstOrCreate([
                'request_user_id' => $formData['request_user_id'],
                'target_user_id'  => $formData['target_user_id'],
                'matched_flag'    => false
            ])->save();

             return $message = 'いいねしました';

        } else {

            $same_liked = $this->match
            ->where([
                'request_user_id' => $formData['request_user_id'],
                'target_user_id'  => $formData['target_user_id'],
            ])
            ->exists();

            if ($same_liked == true) {
                return $message = 'すでにいいねしたユーザーにはいいねできません';

            } else {
                $liked = $this->match
                ->where([
                    'request_user_id' => $formData['target_user_id'],
                    'target_user_id'  => $formData['request_user_id'],
                ])
                ->first();

                $liked = $liked->update(['matched_flag' => true]);

                $chat = Chat::create(['match_id' => $liked->id]);

                return $message = 'マッチしました';
            }

        }

    }

    public function matchedUsers($currentUserId)
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
        foreach ($collection as $key => $value) {
            $a = collect();
            $user = User::where('id', $value['user_id'])->first();
            $user->load('profile');

            $a->put('user', $user);
            $a->put('match_id', $value['id']);

            $filterMatchedUsers->push($a);
        }

        return $filterMatchedUsers;
    }
}