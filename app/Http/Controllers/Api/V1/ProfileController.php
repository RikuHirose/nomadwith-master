<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\ProfileRequest;
use App\Mail\CotactMail;

use App\Models\Profile;
use App\Repositories\ProfileRepositoryInterface;

class ProfileController extends Controller
{

    /** @var ProfileRepositoryInterface */
    protected $profileRepository;

    public function __construct(
        profileRepositoryInterface $profileRepository
    ) {
        $this->profileRepository = $profileRepository;
    }

    public function index()
    {
      $profiles = $this->profileRepository->getAllProfile();
      $profiles->load('user');

      return response()->json(['profiles' => $profiles]);
    }

    public function show(Profile $profile)
    {
      $profile->load('user');
      return response()->json(['profile' => $profile]);
    }

    public function update(Profile $profile, ProfileRequest $request)
    {
      if ($request->hasFile('image')) {
        if ($request->file('image')->isValid()) {
          $profile = $this->profileRepository->updateProfileImage($profile, $request->file('image'));
        }
      } else {
        $profile->fill($request->all())->save();
      }

      $profile->load('user');

      return response()->json(['profile' => $profile]);
    }

    public function search(ProfileRequest $request)
    {
      $data = $request->all();

      $profiles = $this->profileRepository->searchProfiles($data);
      $profiles->load('user');

      return response()->json(['profiles' => $profiles]);
    }

    public function contact(ProfileRequest $request, Profile $profile)
    {
      $profile->load('user');
      $to_email = $profile->user->email;
       Mail::to($to_email)
            ->send(new \App\Mail\ContactMail($request->all(), $to_email));

        return response()->json(['profile' => $profile]);
    }

}
