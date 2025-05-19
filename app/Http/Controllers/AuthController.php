<?php

namespace App\Http\Controllers;

use App\Mail\WaitDriverRequestApprove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Client;
use App\Models\Driver;
use App\Mail\OtpVerificationMail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show registration form
    public function showRegisterForm()
    {
        return view('SignUp');
    }

    // Show login form
    public function showLoginForm()
    {
        return view('Login');
    }

    // Show registration form
    public function showRegisterDriverForm()
    {
        return view('SignUpDriver');
    }

    public function showOTPForm()
    {
        return view('VerifyOtp');
    }

    // Handle client registration (from Blade)
    public function registerClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:100',
            'phone' => 'required|regex:/^\d{2}-\d{3}-\d{3}$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $fullName = trim(($request->first_name ?? '') . ' ' . ($request->last_name ?? ''));


        $existingUser = User::where('name', $fullName)->first();
        if ($existingUser) {
            return back()->withErrors(['name' => 'This full name already exists.'])->withInput();
        }
        $otp = rand(100000, 999999);

        $user = User::create([
            'name' => trim(($request->first_name ?? '') . ' ' . ($request->last_name ?? '')),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
            'otp_code' => $otp,
        ]);

        Client::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'phone' => $request->phone,
            'user_name' => trim(($request->first_name ?? '') . ' ' . ($request->last_name ?? '')),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Mail::to($user->email)->send(new OTPVerificationMail($otp));

        return redirect()->route('otp.form')->with('success', 'Registered successfully. Check email for OTP.');

    }


    // 🔒 Leave this method unchanged
    public function registerDriver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required',
            'username' => 'required|unique:drivers,username',
            'plate_number' => 'required|unique:drivers,plate_number',
            'pricing_model' => 'required',
            'driving_license' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'national_id' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Save uploaded files
        $drivingLicenseFile = $request->file('driving_license');
        $drivingLicenseName = time() . '_driving_license.' . $drivingLicenseFile->getClientOriginalExtension();
        $drivingLicensePath = $drivingLicenseFile->store("ImageFolder", 'public');

        $nationalIdFile = $request->file('national_id');
        $nationalIdName = time() . '_national_id.' . $nationalIdFile->getClientOriginalExtension();
        $nationalIdPath = $nationalIdFile->store("ImageFolder", 'public');

        // Create user with OTP
        $otp = rand(100000, 999999);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'driver',
            'otp_code' => $otp,
        ]);

        // Create driver
        Driver::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'first_name' => $request->name,
            'last_name' => '',
            'phone' => $request->phone,
            'email' => $request->email,
            'driving_license' => $drivingLicenseName,
            'path1' => "storage/" . $drivingLicensePath,
            'national_id' => $nationalIdName,
            'path2' => "storage/" . $nationalIdPath,
            'plate_number' => $request->plate_number,
            'pricing_model' => $request->pricing_model,
            'user_id' => $user->id,
        ]);

        Mail::to($user->email)->send(new OTPVerificationMail($otp));
        Mail::to($user->email)->send(new WaitDriverRequestApprove());
        return redirect()->route('otp.form')->with('success', 'Registered successfully. Check email for OTP.');
    }

    // Verify OTP (from form)
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
        return redirect()->route('login')->with('success', 'Account verified. You may now log in.');

    }

    public function login(Request $request)
    {
        // Validate email and password input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // IMPORTANT for session fixation protection
            $user = Auth::user();

            // Check if user has a valid role
            if (!in_array($user->role, ['admin', 'client', 'driver'])) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Invalid role']);
            }

            // Redirect based on role
            return match ($user->role) {
                'admin' => redirect()->route('admin.deliveries.index'),//admin-dashboard
                'client' => redirect()->route('client-dashboard'),
                'driver' => redirect()->route('driver-dashboard'),
            };
        }

        // If login failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
}
