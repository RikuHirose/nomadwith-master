<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Socialite;
use App\Models\User;
use App\Models\Profile;
use App\Models\SocialProvider;
use App\Repositories\SocialProviderRepositoryInterface;

class SocialController extends Controller
{
    /** @var SocialProviderRepositoryInterface */
    protected $socialProviderRepository;

    public function __construct(
        SocialProviderRepositoryInterface $socialProviderRepository
    ) {
        $this->socialProviderRepository = $socialProviderRepository;
    }

        /**
     * Redirect the user to the FaceBook authentication page.
     *
     * @return Response
     */
    public function viewLogin()
    {
        return view('auth.login');
    }

    /**
     * Redirect the user to the FaceBook authentication page.
     *
     * @return Response
     */
    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from FaceBook.
     *
     * @return Response
     */
    public function handleFacebookProviderCallback()
    {
        try{
            $facebookUser = Socialite::driver('facebook')->user();

        } catch(Exception $e){
            return redirect("/");
        }

        //privider_idとemailですでに登録済みかチェック
        $socialProvider = $this->socialProviderRepository->findSocialProvider($facebookUser->getId(), $facebookUser->getEmail());
        // $socialProvider = SocialProvider::where('provider_id',$facebookUser->getId())->first();
        dd($socialProvider);

        if(!$socialProvider) {

            $user = User::firstOrCreate(
                ['email' => $facebookUser->getEmail(), 'facebook_id' => $facebookUser->getId()]
            );

            $profile = Profile::firstOrCreate(
                ['user_id' => $user->id,'name' => $facebookUser->getName(),'img_url' => $facebookUser->avatar_original]
            );

        } else {
            // $user = User::firstOrCreate(
            //     ['email' => $user->getEmail(), 'name' => $user->getName(), 'facebook_id' => $user->getId()]
            // );
            $user = User::where(
                ['email' => $facebookUser->getEmail(), 'facebook_id' => $facebookUser->getId()]
            )->first();
        }

        auth()->login($user);

      return redirect('/');
    }

}