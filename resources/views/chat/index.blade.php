@extends('layouts.app')
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="alert-success" class="hidden text-green-600 mb-4"></div>
                    @if (session()->has('success'))
                        <div id="alert-flash" class="text-green-600 mb-4">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <form id="chat-form">
                        @csrf
                        <div class="mt-4">
                            <label for="user_id"
                                class="block font-medium text-sm text-gray-700">{{ __('User') }}</label>
                            <select id="user_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
                                required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="message"
                                class="block font-medium text-sm text-gray-700">{{ __('Message') }}</label>
                            <textarea id="message" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">
                                {{ __('Send') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Pusher JS Library -->
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        var pusher = new Pusher('21578e52d25b53b8c91f', {
            cluster: 'mt1',
            forceTLS: true,
            authEndpoint: '/broadcasting/auth', // default, but make sure auth routes are registered
        });

        var channel = pusher.subscribe('message-sent');
        channel.bind('App\\Events\\MessageSentEvent', function(data) {
            console.log(JSON.stringify(data));
        });

        // Handle the form submission
        // This will send the message to the server via AJAX
        // and display a success message without reloading the page
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const userId = document.getElementById('user_id').value;
            const message = document.getElementById('message').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('{{ route('chat.send') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        message: message
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network error');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('message').value = '';
                    const alertDiv = document.getElementById('alert-success');
                    alertDiv.textContent = data.message || 'Message sent successfully.';
                    alertDiv.classList.remove('hidden');
                    // Hide any old server-side flash message
                    const flashDiv = document.getElementById('alert-flash');
                    if (flashDiv) flashDiv.classList.add('hidden');
                    console.log('Message sent:', data);
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
        });
    </script>
@endpush
