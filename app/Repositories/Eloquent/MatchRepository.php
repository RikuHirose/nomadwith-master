<?php

namespace App\Repositories\Eloquent;
use App\Repositories\MatchRepositoryInterface;
use App\Models\Match;

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
        // $like = $this->match->firstOrCreate([
        //     'request_user_id' => $formData['request_user_id'],
        //     'target_user_id' => $formData['target_user_id'],
        // ]);

        // // wasRecentlyCreated を用いることで、今回のリクエストで作成されたことを判定できる
        // if ($like->wasRecentlyCreated) {
        //     $like->save();
        // } else {
        //     dd($like->first());
        // }

        // user_id = 1がuser_id = 2に対してlikeをした場合
        // createorfirstする

        // request_user_id: 1
        // target_user_id: 2
        // matched_flag: false

        // user_id = 2がuser_id = 1に対してlikeをした場合
        // createorfirstする

        // request_user_id: 1
        // target_user_id: 2
        // matched_flag: true

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

                return $message = 'マッチしました';
            }

        }

    }
}