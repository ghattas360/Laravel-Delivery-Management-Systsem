<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Driver;
use App\Models\Client;

class AdminEmailController extends Controller
{


    public function index($email = null)
    {
        return view('admin.email.index', compact('email'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:client,driver',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::raw($request->message, function ($mail) use ($request) {
            $mail->to($request->email)
                ->subject('Message from Admin');
        });

        return back()->with('success', 'Email sent successfully!');
    }
}
