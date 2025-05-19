<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Message;
use App\Events\ClientMessageSent;

class AdminClientChatController extends Controller
{
    public function index(Request $request){
        $client = Client::select('id', 'first_name', 'last_name')->get();

        $currentClient = $request->client_id ?
            client::with('message')->find($request->client_id)
            :null;

        return view('admin.client_chat.index', compact('client', 'currentClient'));

    }

    public function chatWithClient($clientId){
        $client = Client::select('id', 'first_name', 'last_name')->get();
        $currentClient = Client::with('message')->findOrFial($clientId);

        return view ('admin.client_chat.index', compact('client','currentClient'));
    }

    public function sendMessage(Request $request){
        Message::create([
            'client_id'=>$request->client_id,
            'admin_id'=>1,
            'message'=>$request->message,
            'is_from_admin'=>true,
        ]);

        return back();
    }

    public function sendClientMessage(Request $request)
    {
        // Save the message first
        $message = \App\Models\Message::create([
            'client_id' => $request->client_id,
            'admin_id' => auth()->id(),  // Assuming admin is logged
            'message' => $request->message,
            'is_from_admin' => true,
        ]);

        // Dispatch Event to broadcast
        broadcast(new ClientMessageSent($message, $request->client_id))->toOthers();

        return response()->json(['status' => 'Message sent']);
    }




}
