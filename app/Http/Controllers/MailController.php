<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationEmail;

class MailController extends Controller
{
    /**
     * Send a verification email.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $welcomeMessage = "Welcome to our platform! Please verify your email.";

        Mail::to($email)->send(new SendVerificationEmail($welcomeMessage));

        return response()->json(['message' => 'Verification email sent successfully']);
    }
}