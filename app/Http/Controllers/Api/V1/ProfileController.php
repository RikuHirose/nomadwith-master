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

      // $profile->fill($request->all())->update();
      $profile->fill($request->all())->save();
      $profile->load('user');

      return response()->json(['profile' => $profile]);
    }

    public function search(ProfileRequest $request)
    {
      $data = $request->all();
      $profiles = $this->profileRepository->searchProfiles($data);

      // if(!is_null($data['data'][0]['profile_name'])) {
      //   $profile_name = $data['data'][0]['profile_name'];

      //   // $profiles->load(['user' => function($query, $profile_name) {
      //   //   $query->where('name', 'like', "%{$profile_name}%");
      //   // }])->get();
      //   $profiles->load(['user' => function ($query) use ($profile_name) {
      //       $query->where('name', 'like', '%{$profile_name}%');
      //   }]);

      // }
         $profiles->load('user');


        return response()->json(['profiles' => $profiles]);
    }

    public function contact(ProfileRequest $request, Profile $profile)
    {

       // Mail::to($request->email)
       Mail::to('rikuparkour9+2@gmail.com')
            ->send(new \App\Mail\ContactMail($request->all()));

        return response()->json(['profile' => $profile]);
    }
}
