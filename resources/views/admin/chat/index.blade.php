{{--
<div class="container mt-4 row">
    <div class="col-md-3 border-end">
        <form method="GET" action="{{ route('admin.chat.index') }}" class="mb-3">
            <input type="text" name="search" placeholder="Search drivers..." class="form-control" />
        </form>

        @foreach($drivers as $driver)
            <a href="{{ route('admin.chat.index', ['driver_id' => $driver->id]) }}" class="d-block mb-2">
                {{ $driver->first_name }} {{ $driver->last_name }}
            </a>
        @endforeach
    </div>

    <div class="col-md-9">
        @if($currentDriver)
            <h5>Chat with {{ $currentDriver->first_name }}</h5>
            <div class="border p-3 mb-3" style="height: 300px; overflow-y: scroll;">
                @foreach($currentDriver->messages as $msg)
                    <div class="{{ $msg->is_from_admin ? 'text-end' : 'text-start' }}">
                        <p class="d-inline-block px-3 py-2 rounded {{ $msg->is_from_admin ? 'bg-primary text-white' : 'bg-light' }}">
                            {{ $msg->message }}
                        </p>
                    </div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('admin.chat.send') }}">
                @csrf
                <input type="hidden" name="driver_id" value="{{ $currentDriver->id }}">
                <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Type your message...">
                    <button class="btn btn-primary">Send</button>
                </div>
            </form>
        @else
            <p>Select a driver to begin chatting.</p>
        @endif
    </div>
</div>
--}}
{{--<afkaf>vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv</afkaf>--}}
    {{--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Chat with Drivers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f9; }
        .chat-list a { cursor: pointer; }
        .chat-contact-info small { font-size: 0.8rem; color: #888; }
        .chat-message-text p { background: #f1f1f1; padding: 8px 12px; border-radius: 12px; }
        .chat-message-right .chat-message-text p { background: #0d6efd; color: #fff; }
    </style>
</head>
<body>

<div class="container-xxl py-4">
    <div class="card overflow-hidden">
        <div class="row g-0">

            <!-- Sidebar Left -->
            <div class="col-3 border-end">
                <div class="p-4">
                    <div class="text-center mb-4">
                        <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/1.png" class="rounded-circle mb-2" width="80" height="80">
                        <h5>Admin</h5>
                        <span class="text-muted">Administrator</span>
                    </div>

                    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search drivers..." onkeyup="filterDrivers()">
                    <div style="height: 500px; overflow-y: auto;">

                    <ul class="list-unstyled chat-contact-list" id="driverList">
                        @foreach($drivers as $driver)
                            <li class="mb-2">
                                <a href="{{ route('admin.chat.withDriver', $driver->id) }}" class="d-flex align-items-center {{ isset($currentDriver) && $currentDriver->id == $driver->id ? 'fw-bold text-primary' : '' }}">
                                    <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/13.png" class="rounded-circle me-2" width="40" height="40">
                                    <span>{{ $driver->first_name }} {{ $driver->last_name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>


                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-9">
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                    @if($currentDriver)
                        <div class="d-flex align-items-center">
                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/4.png" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h6 class="mb-0">{{ $currentDriver->first_name }} {{ $currentDriver->last_name }}</h6>
                                <small class="text-muted">Driver</small>
                            </div>
                        </div>
                    @else
                        <h6 class="text-muted">Select a driver to start chatting</h6>
                    @endif
                </div>

                <div id="chat-history" class="chat-history p-4 overflow-auto" style="height: 500px;"></div>

 --}}{{--           @if(isset($currentDriver))
                        @forelse($currentDriver->messages as $message)
                            <div class="mb-3 {{ $message->is_from_admin ? 'text-end' : 'text-start' }}">
                                <div class="d-inline-block p-2 rounded" style="max-width: 75%; background-color: {{ $message->is_from_admin ? '#d1e7dd' : '#f8d7da' }};">
                                    <p class="mb-1">{{ $message->message }}</p>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($message->created_at)->format('h:i A') }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted mt-5">No messages yet</div>
                        @endforelse
                    @endif--}}{{--
                </div>


                @if(isset($currentDriver))
                    <div class="p-3 border-top">
                        <form action="{{ route('admin.chat.send') }}" method="POST" class="d-flex">
                            @csrf
                            <input type="hidden" name="driver_id" id="driver-id" value="{{ $currentDriver->id }}">
                            <input type="text" name="message" class="form-control me-2" placeholder="Type your message...">
                            <button type="submit" class="btn btn-primary" id="message-input">Send</button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    function filterDrivers() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const driverList = document.getElementById('driverList').getElementsByTagName('li');

        for (let i = 0; i < driverList.length; i++) {
            const name = driverList[i].innerText.toLowerCase();
            driverList[i].style.display = name.includes(input) ? '' : 'none';
        }
    }

    document.getElementById('message-input').addEventListener('keypress', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {  // enter without shift
            e.preventDefault();  // prevent adding a newline
            document.getElementById('send-message-button').click(); // trigger send
        }
    });


</script>

<script>
    let driverId = {{ $currentDriver->id }};

    function fetchMessages() {
        fetch(`/admin/chat/driver-messages/${driverId}`)
            .then(response => response.json())
            .then(messages => {
                const chatHistory = document.getElementById('chat-history');
                chatHistory.innerHTML = '';

                messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `mb-3 ${message.is_from_admin ? 'text-end' : 'text-start'}`;

                    messageDiv.innerHTML = `
                        <div class="d-inline-block p-2 rounded" style="max-width: 75%; background-color: ${message.is_from_admin ? '#d1e7dd' : '#f8d7da'};">
                            <p class="mb-1">${message.message}</p>
                            <small class="text-muted">${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</small>
                        </div>
                    `;

                    chatHistory.appendChild(messageDiv);
                });

                chatHistory.scrollTop = chatHistory.scrollHeight;
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    setInterval(fetchMessages, 1000);

    window.onload = fetchMessages;
</script>



</body>
</html>
--}}
@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f9; }
        .chat-list a { cursor: pointer; }
        .chat-contact-info small { font-size: 0.8rem; color: #888; }
        .chat-message-text p { background: #f1f1f1; padding: 8px 12px; border-radius: 12px; }
        .chat-message-right .chat-message-text p { background: #0d6efd; color: #fff; }
    </style>
@endsection

@section('content')
    <div class="container-xxl py-4">
        <div class="card overflow-hidden">
            <div class="row g-0">

                <!-- Sidebar Left -->
                <div class="col-3 border-end">
                    <div class="p-4">
                        <div class="text-center mb-4">
                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/1.png" class="rounded-circle mb-2" width="80" height="80">
                            <h5>Admin</h5>
                            <span class="text-muted">Administrator</span>
                        </div>

                        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search drivers..." onkeyup="filterDrivers()">
                        <div style="height: 500px; overflow-y: auto;">
                            <ul class="list-unstyled chat-contact-list" id="driverList">
                                @foreach($drivers as $driver)
                                    <li class="mb-2">
                                        <a href="{{ route('admin.chat.withDriver', $driver->id) }}" class="d-flex align-items-center {{ isset($currentDriver) && $currentDriver->id == $driver->id ? 'fw-bold text-primary' : '' }}">
                                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/13.png" class="rounded-circle me-2" width="40" height="40">
                                            <span>{{ $driver->first_name }} {{ $driver->last_name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="col-9">
                    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                        @if($currentDriver)
                            <div class="d-flex align-items-center">
                                <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/4.png" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h6 class="mb-0">{{ $currentDriver->first_name }} {{ $currentDriver->last_name }}</h6>
                                    <small class="text-muted">Driver</small>
                                </div>
                            </div>
                        @else
                            <h6 class="text-muted">Select a driver to start chatting</h6>
                        @endif
                    </div>

                    <div id="chat-history" class="chat-history p-4 overflow-auto" style="height: 500px;">
                        {{-- Messages will be dynamically loaded here --}}
                    </div>

                    @if(isset($currentDriver))
                        <div class="p-3 border-top">
                            <form action="{{ route('admin.chat.send') }}" method="POST" class="d-flex">
                                @csrf
                                <input type="hidden" name="driver_id" id="driver-id" value="{{ $currentDriver->id }}">
                                <input type="text" name="message" class="form-control me-2" placeholder="Type your message...">
                                <button type="submit" class="btn btn-primary" id="message-input">Send</button>
                            </form>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function filterDrivers() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const driverList = document.getElementById('driverList').getElementsByTagName('li');

            for (let i = 0; i < driverList.length; i++) {
                const name = driverList[i].innerText.toLowerCase();
                driverList[i].style.display = name.includes(input) ? '' : 'none';
            }
        }

        document.getElementById('message-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('send-message-button').click();
            }
        });

        let driverId = {{ $currentDriver->id ?? 'null' }};
        function fetchMessages() {
            fetch(`/admin/chat/driver-messages/${driverId}`)
                .then(response => response.json())
                .then(messages => {
                    const chatHistory = document.getElementById('chat-history');
                    chatHistory.innerHTML = '';

                    messages.forEach(message => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `mb-3 ${message.is_from_admin ? 'text-end' : 'text-start'}`;
                        messageDiv.innerHTML = `
                        <div class="d-inline-block p-2 rounded" style="max-width: 75%; background-color: ${message.is_from_admin ? '#d1e7dd' : '#f8d7da'};">
                            <p class="mb-1">${message.message}</p>
                            <small class="text-muted">${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</small>
                        </div>
                    `;
                        chatHistory.appendChild(messageDiv);
                    });

                    chatHistory.scrollTop = chatHistory.scrollHeight;
                })
                .catch(error => console.error('Error fetching messages:', error));
        }

        if (driverId) {
            setInterval(fetchMessages, 1000);
            window.onload = fetchMessages;
        }
    </script>
@endsection
