<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
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
        Log::info('masuk');
        
        try {
            $socialUser = Socialite::driver('google')->stateless()->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))->user();
        } catch (\Exception $e) {
            Log::error('Error during Google authentication: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Failed to authenticate with Google.');
        }
    
        // Convert the social user object to an array or JSON for logging
        Log::info('Social User: ' . json_encode($socialUser));
    
        // Find or create the user in the database
        $existing = User::where('email', $socialUser->getEmail())->first();
        if ($existing) {
            $existing->google_id = $socialUser->getId();
            $existing->avatar = $socialUser->getAvatar();
            $existing->save();
            return redirect()->away('http://localhost:3000/auth/callback?remember_token=' . $existing->remember_token);
        } else {
            // create a new user
            $newUser = new User;
             // Assuming username is the same as email without domain
            $newUser->username = explode('@', $socialUser->getEmail())[0];
            $newUser->email = $socialUser->getEmail();
            $newUser->google_id = $socialUser->getId();
            $newUser->avatar = $socialUser->getAvatar();
            $newUser->email_verified_at = now();
            $newUser->remember_token = Str::uuid()->toString().Str::random(64);
            $newUser->role = 'user'; // Default role
            $newUser->is_banned = false; // Default value
            $newUser->save();
            return redirect()->away('http://localhost:3000/auth/callback?remember_token=' . $newUser->remember_token);
        }

    }
}