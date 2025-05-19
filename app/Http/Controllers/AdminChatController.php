<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\Message;

class AdminChatController extends Controller
{
    public function chatWithDriver($driverId)
    {
        $drivers = Driver::select('id', 'first_name', 'last_name')->get();

        $currentDriver = Driver::with('messages')->findOrFail($driverId);

        return view('admin.chat.index', compact('drivers', 'currentDriver'));
    }


    public function index(Request $request)
    {
        $drivers = Driver::select('id', 'first_name', 'last_name')->get();

        $currentDriver = $request->driver_id
            ? Driver::with('messages')->find($request->driver_id)
            : null;

        return view('admin.chat.index', compact('drivers', 'currentDriver'));
    }

    public function sendMessage(Request $request)
    {
        Message::create([
            'driver_id' => $request->driver_id,
            'admin_id' => 1,
            'message' => $request->message,
            'is_from_admin' => true,
        ]);

        return back();
    }

    public function fetchDriverMessages($driverId)
    {
        $messages = \App\Models\Message::where('driver_id', $driverId)
            ->orderBy('created_at')
            ->get(['id', 'message', 'is_from_admin', 'created_at']);

        return response()->json($messages);
    }




}
