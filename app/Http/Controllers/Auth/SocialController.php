<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Socialite;
use App\Models\User;
use App\Models\Profile;

class SocialController extends Controller
{
        /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function viewLogin()
    {
        return view('auth.login');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
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

        //すでに登録済みかチェック
        $socialProvider = User::where('facebook_id',$facebookUser->getId())->first();

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