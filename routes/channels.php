<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat-client.{clientId}', function ($user, $clientId) {
    // Allow only the client himself or the admin to listen
    return true; // ⚡ In real system you should check if authenticated user is allowed
});
