<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Mail\OtpVerificationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Exception;
use Log;

class SocialAuthController extends Controller
{

    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();
    }

    // Handles the Google callback after the user logs in
    public function handleGoogleCallback(Request $request)
    {
        // This will be triggered after the user selects a Google account
        $googleUser = Socialite::driver('google')->stateless()->user();

        $otp = rand(100000, 999999);
        // Check if the user already exists in the database
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(16)),  // Generate a random password since Google login doesn't provide one
                'email_verified_at' => now(),  // Mark the email as verified
                'role' => 'client',  // You can set other roles as needed
                'otp_code' => $otp,
            ]
        );

        $client = Client::firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'user_name' => explode('@', $googleUser->getEmail())[0], // Generate username from email
                'password' => bcrypt(Str::random(16)), // Generate a random password for the client
                'created_on' => now(),
                'updated_on' => now(),
            ]
        );

        Mail::to($user->email)->send(new OTPVerificationMail($otp));
        return redirect()->route('otp.formSocial')->with('success', 'Registered successfully. Check email for OTP.');


    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->scopes(['user:email'])->redirect();
    }
    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->stateless()->user();
            // Ensure we have an email
            if (!$githubUser->email) {
                throw new Exception("No email returned from GitHub. Please ensure your GitHub account has a public email.");
            }

            // Check if the user exists by GitHub ID first
            $findUser = User::where('github_id', $githubUser->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect()->route('login')->with('success', 'Account verified. You may now log in.');
            } else {

                $otp = rand(100000, 999999);
                $newUser = User::updateOrCreate(
                    ['email' => $githubUser->email],
                    [
                        'name' => $githubUser->name ?? $githubUser->nickname,
                        'github_id' => $githubUser->id,
                        'password' => Hash::make('123456dummy'),
                        'role' => 'client',
                        'otp_code' => $otp,
                    ]
                );

                Auth::login($newUser);
                $client = Client::firstOrCreate(
                    ['user_id' => $newUser->id],
                    [
                        'first_name' => $githubUser->getName(),
                        'email' => $githubUser->getEmail(),
                        'user_name' => explode('@', $githubUser->getEmail())[0], // Generate username from email
                        'password' => bcrypt(Str::random(16)), // Generate a random password for the client
                        'created_on' => now(),
                        'updated_on' => now(),
                    ]
                );

                Mail::to($newUser->email)->send(new OTPVerificationMail($otp));
                return redirect()->route('otp.formSocial')->with('success', 'Registered successfully. Check email for OTP.');
            }
        } catch (Exception $e) {
            // Log error or handle it appropriately
            dd($e->getMessage());
        }
    }
    public function showOTPForm()
    {
        return view('VerifyOtpSocial');
    }
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['otp_code' => 'Invalid OTP'])->withInput();
        }

        $user->otp_code = null;
        $user->email_verified_at = now();
        $user->save();

        // Redirect to set password form, passing email as query
        return redirect()->route('password.set.form', ['email' => $user->email])
            ->with('success', 'OTP verified. Please set your password.');
    }
    public function showSetPasswordForm(Request $request)
    {
        return view('set-password', ['email' => $request->email]);
    }

    public function submitSetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password set successfully. You can now log in.');
    }

}

