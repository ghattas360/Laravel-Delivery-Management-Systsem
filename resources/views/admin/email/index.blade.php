@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <h3 class="mb-4">📧 Send Email</h3>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.email.send') }}">
            @csrf
            @if(!$email)
                <div class="mb-3">
                    <label for="type" class="form-label">Recipient Type (optional)</label>
                    <select class="form-select" name="type" id="type" onchange="filterEmails()">
                        <option value="">All</option>
                        <option value="client">Clients</option>
                        <option value="driver">Drivers</option>
                    </select>
                </div>
            @endif


            <div class="mb-3">
                <label for="email" class="form-label">Recipient Email</label>
                <input type="email" class="form-control" name="email" id="email" list="emailList" required value="{{ $email ?? '' }}">
                <datalist id="emailList"></datalist>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" name="message" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
            </div>

            <button class="btn btn-primary">Send Email</button>
        </form>
    </div>

    <script>
        const datalist = document.getElementById('emailList');
        const typeSelect = document.getElementById('type');
        @if(!$email)
            window.onload = filterEmails;
        @endif
        async function filterEmails() {
            const type = typeSelect.value;
            const response = await fetch(`/admin/email-emails?type=${type}`);
            const emails = await response.json();

            datalist.innerHTML = '';
            emails.forEach(email => {
                const option = document.createElement('option');
                option.value = email;
                datalist.appendChild(option);
            });
        }

        window.onload = filterEmails;
    </script>

    <script>
        $(document).ready(function () {
            $('#message').summernote({
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['fontsize', 'color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'emoji']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });
    </script>


@endsection
