<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the OAuth Provider.
     */
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from the OAuth Provider.
     */
    public function handleProviderCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to authenticate user.'], 500);
        }

        // Find or create the user in the database
        $existing = User::where('email', $socialUser->email)->first();
        if ($existing) {
            return response()->json(['token' => $existing->createToken('Personal Access Token')->accessToken], 200);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $socialUser->name;
            $newUser->email           = $socialUser->email;
            $newUser->google_id       = $socialUser->id;
            $newUser->avatar          = $socialUser->avatar;
            $newUser->avatar_original = $socialUser->avatar_original;
            $newUser->save();
        }

        return response()->json(['token' => $newUser->createToken('Personal Access Token')->accessToken], 200);
    }
}