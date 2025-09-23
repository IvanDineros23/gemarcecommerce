@extends('layouts.app')

@section('content')
<div class="py-12 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
        <svg class="w-7 h-7 text-green-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4-4.03 7-9 7-1.18 0-2.31-.13-3.36-.38-.37-.09-.77-.08-1.12.07l-2.13.85a1 1 0 01-1.32-1.32l.85-2.13c.15-.35.16-.75.07-1.12A7.96 7.96 0 013 12c0-4 4.03-7 9-7s9 3 9 7z" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Chat with Employee
    </h1>
    <div class="bg-white rounded-xl shadow p-6">
        <div class="relative">
            <div id="chat-messages" class="h-80 overflow-y-auto bg-gray-50 rounded p-4 mb-4 text-base border border-gray-200"></div>
            <div id="chat-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 text-lg px-4 text-center pointer-events-none transition-opacity duration-500" style="background:rgba(255,255,255,0.85); z-index:2;">
                <div class="font-semibold text-green-700 mb-2 text-xl">Welcome to Gemarc Enterprises Inc.</div>
                <div>What would you like to inquire about?<br>Want to get a quote quickly?</div>
            </div>
        </div>
        <form id="chat-form" class="flex gap-2 mb-2">
            <input type="text" id="chat-input" class="border border-green-300 rounded px-3 py-2 w-full focus:outline-none" placeholder="Type your message...">
            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 font-semibold">Send</button>
        </form>
        <button id="clear-chat" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded font-semibold mb-2">Clear Chat</button>
        <div id="chat-status" class="text-xs text-gray-400 mt-1"></div>
    </div>
    <script>
    // Placeholder fade logic
    function updateChatPlaceholder() {
        const chatBox = document.getElementById('chat-messages');
        const placeholder = document.getElementById('chat-placeholder');
        const input = document.getElementById('chat-input');
        // Hide placeholder if there are messages or if user is typing
        let hasMessages = chatBox && chatBox.innerText.trim().length > 0;
        let isTyping = input && input.value.trim().length > 0;
        if (hasMessages || isTyping) {
            placeholder.style.opacity = 0;
            placeholder.style.pointerEvents = 'none';
        } else {
            placeholder.style.opacity = 1;
            placeholder.style.pointerEvents = 'none';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateChatPlaceholder();
        document.getElementById('chat-input').addEventListener('input', updateChatPlaceholder);
    });
    // Get the first employee's user ID for demo (server-side rendered)
    const EMPLOYEE_ID = @php
        $emp = \App\Models\User::where('role','employee')->first();
        echo $emp ? $emp->id : 1;
    @endphp;
    function fetchChat() {
        fetch("{{ url('/chat/fetch') }}")
            .then(r => r.json())
            .then(msgs => {
                let html = msgs.map(m => `<div><b>${m.sender_id == {{ auth()->id() }} ? 'You' : 'Employee'}:</b> ${m.message}</div>`).join('');
                document.getElementById('chat-messages').innerHTML = html;
                let box = document.getElementById('chat-messages');
                box.scrollTop = box.scrollHeight;
                updateChatPlaceholder();
            });
    }
    fetchChat();
    setInterval(fetchChat, 3000);
    document.getElementById('chat-form').onsubmit = function(e) {
        e.preventDefault();
        let msg = document.getElementById('chat-input').value;
        if (!msg.trim()) return;
        fetch("{{ url('/chat/send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: msg, to_user_id: EMPLOYEE_ID })
        }).then(r => r.json()).then(() => {
            document.getElementById('chat-input').value = '';
            fetchChat();
        });
    };
    document.getElementById('clear-chat').onclick = function() {
        if(confirm('Clear all chat messages?')) {
            fetch("{{ url('/chat/clear') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ to_user_id: EMPLOYEE_ID })
            }).then(r => r.json()).then(() => {
                fetchChat();
            });
        }
    };
    </script>
</div>
@endsection
