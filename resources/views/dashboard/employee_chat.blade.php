@extends('layouts.app')

@section('content')
<div class="py-8 max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
        <svg class="w-7 h-7 text-green-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4-4.03 7-9 7-1.18 0-2.31-.13-3.36-.38-.37-.09-.77-.08-1.12.07l-2.13.85a1 1 0 01-1.32-1.32l.85-2.13c.15-.35.16-.75.07-1.12A7.96 7.96 0 013 12c0-4 4.03-7 9-7s9 3 9 7z" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Chat Management
    </h1>
    <div class="bg-white rounded-xl shadow p-8">
        <div class="flex gap-10">
            <!-- User List -->
            <div class="w-80 border-r pr-6">
                <div class="font-semibold mb-2">Users</div>
                <ul id="user-list" class="space-y-2"></ul>
            </div>
            <!-- Chat Box -->
            <div class="flex-1 min-w-[400px]">
                <div id="chat-header" class="font-semibold mb-2 text-green-700 text-lg"></div>
                <div id="chat-messages" class="h-80 overflow-y-auto bg-gray-50 rounded p-3 mb-3 text-base border border-gray-200"></div>
                <form id="chat-form" class="flex gap-2" style="display:none;">
                    <input type="text" id="chat-input" class="border border-green-300 rounded px-3 py-2 w-full focus:outline-none text-base" placeholder="Type your message...">
                    <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 font-semibold">Send</button>
                </form>
                <div id="chat-status" class="text-xs text-gray-400 mt-1"></div>
            </div>
        </div>
    </div>
    <script>
    let selectedUserId = null;
    let selectedUserName = '';
    function fetchUserList() {
        fetch("{{ url('/chat/users') }}")
            .then(r => r.json())
            .then(users => {
                let html = users.map(u => `<li><button onclick='selectUser(${u.id}, \"${u.name}\")' class='w-full text-left px-2 py-1 rounded hover:bg-green-100 ${selectedUserId==u.id?'bg-green-200':''}'>${u.name}</button></li>`).join('');
                document.getElementById('user-list').innerHTML = html;
            });
    }
    function fetchChat() {
        if (!selectedUserId) return;
        fetch(`{{ url('/chat/fetch') }}?with_user_id=${selectedUserId}`)
            .then(r => r.json())
            .then(msgs => {
                let html = msgs.map(m => `<div><b>${m.sender_id == {{ auth()->id() }} ? 'You' : selectedUserName}:</b> ${m.message}</div>`).join('');
                document.getElementById('chat-messages').innerHTML = html;
                let box = document.getElementById('chat-messages');
                box.scrollTop = box.scrollHeight;
            });
    }
    function selectUser(id, name) {
        selectedUserId = id;
        selectedUserName = name;
        document.getElementById('chat-header').innerText = 'Chat with ' + name;
        document.getElementById('chat-form').style.display = '';
        fetchChat();
        fetchUserList();
    }
    fetchUserList();
    setInterval(fetchUserList, 5000);
    setInterval(fetchChat, 3000);
    document.getElementById('chat-form').onsubmit = function(e) {
        e.preventDefault();
        let msg = document.getElementById('chat-input').value;
        if (!msg.trim() || !selectedUserId) return;
        fetch("{{ url('/chat/send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: msg, to_user_id: selectedUserId })
        }).then(r => r.json()).then(() => {
            document.getElementById('chat-input').value = '';
            fetchChat();
        });
    };
    </script>
</div>
@endsection
