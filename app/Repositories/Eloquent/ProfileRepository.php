<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ProfileRepositoryInterface;
use App\Models\Profile;
use Storage;

class ProfileRepository implements ProfileRepositoryInterface
{
    protected $profile;

    /**
    * @param object $profile
    */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function getAllProfile()
    {
      return $this->profile->all();
    }

    public function searchProfiles($data)
    {
        $profiles =  $this->profile;

        if(!is_null($data['data'][0]['smoke_flag'])) {
            $smoke_flag  = $data['data'][0]['smoke_flag'];

            $profiles = $profiles->when($smoke_flag, function ($query) use ($smoke_flag) {
                return $query->where('smoke_flag', $smoke_flag);
            });
        }

        if(!is_null($data['data'][0]['nomad_flag'])) {
            $nomad_flag  = $data['data'][0]['nomad_flag'];

            $profiles = $profiles->when($nomad_flag, function ($query) use ($nomad_flag) {
                return $query->where('nomad_flag', $nomad_flag);
            });
        }

        if(!is_null($data['data'][0]['profile_name'])) {
            $profile_name  = $data['data'][0]['profile_name'];
            // 最適解ではない??
            $profiles = $profiles->whereHas('user', function($query) use ($profile_name) {
                return $query->where('name', 'like', "%{$profile_name}%");
            });
        }


        $profiles = $profiles->get();

        return $profiles;
    }

    public function updateProfileImage($profile, $imageFile)
    {
        $profileId = $profile->id;
        $path = Storage::disk('s3')->putFile('pklinks', $imageFile, 'public');
        $url = Storage::disk('s3')->url($path);

        $profile = $profile->fill(['img_url' => $url])->save();

        $profile = $this->profile->where('id', $profileId)->first();

        return $profile;
    }

}