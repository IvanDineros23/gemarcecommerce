@extends('layouts.app')

@section('content')
<div class="py-8 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
        <svg class="w-7 h-7 text-green-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4-4.03 7-9 7-1.18 0-2.31-.13-3.36-.38-.37-.09-.77-.08-1.12.07l-2.13.85a1 1 0 01-1.32-1.32l.85-2.13c.15-.35.16-.75.07-1.12A7.96 7.96 0 013 12c0-4 4.03-7 9-7s9 3 9 7z" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Chat with Employee
    </h1>
    <div class="bg-white rounded-xl shadow p-6">
        <div id="chat-messages" class="h-48 overflow-y-auto bg-gray-50 rounded p-2 mb-2 text-sm border border-gray-200"></div>
        <form id="chat-form" class="flex gap-2">
            <input type="text" id="chat-input" class="border border-green-300 rounded px-3 py-2 w-full focus:outline-none" placeholder="Type your message...">
            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 font-semibold">Send</button>
        </form>
        <div id="chat-status" class="text-xs text-gray-400 mt-1"></div>
    </div>
    <script>
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
    </script>
</div>
@endsection
