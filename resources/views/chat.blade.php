
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BankShield - Live Support</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

<div class="max-w-7xl mx-auto p-4 md:p-6">

    <!-- Header -->
    <header class="bg-blue-950 text-white p-5 rounded-t-xl">
        <h1 class="text-2xl font-bold">BankShield Support</h1>
        <p class="text-blue-200 text-sm mt-1">
            Live Customer Assistance
        </p>
    </header>

    <main class="bg-white shadow-lg rounded-b-xl overflow-hidden">

        <div class="grid grid-cols-1 md:grid-cols-3 min-h-[650px]">

            <!-- Left Sidebar -->
            <aside class="border-r border-gray-200 p-5">

                <h2 class="text-lg font-bold mb-4">
                    My Conversations
                </h2>

                <button
                    id="newChatButton"
                    class="w-full bg-blue-700 text-white p-3 rounded-lg hover:bg-blue-800 mb-5"
                >
                    + New Conversation
                </button>

                <!-- New Conversation Form -->
                <form id="newChatForm" class="hidden space-y-3 mb-5">

                    <input
                        type="text"
                        id="subject"
                        maxlength="255"
                        required
                        placeholder="Subject"
                        class="w-full border rounded-lg p-3"
                    >

                    <textarea
                        id="initialMessage"
                        maxlength="5000"
                        required
                        rows="3"
                        placeholder="Describe your issue..."
                        class="w-full border rounded-lg p-3"
                    ></textarea>

                    <button
                        type="submit"
                        id="createButton"
                        class="w-full bg-green-600 text-white p-3 rounded-lg hover:bg-green-700"
                    >
                        Start Chat
                    </button>

                </form>

                <!-- Conversation List -->
                <div id="conversationList" class="space-y-3">
                    <p class="text-gray-500 text-sm">
                        Loading conversations...
                    </p>
                </div>

            </aside>

            <!-- Right Chat Area -->
            <section class="md:col-span-2 flex flex-col">

                <!-- Chat Header -->
                <div class="border-b p-5 flex justify-between items-center">

                    <div>
                        <h2 id="chatSubject" class="font-bold text-lg">
                            Welcome to BankShield Support
                        </h2>

                        <p id="chatStatus" class="text-sm text-gray-500">
                            Select a conversation to begin.
                        </p>
                    </div>

                    <button
                        id="resolveButton"
                        class="hidden bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"
                    >
                        Resolve
                    </button>

                </div>

                <!-- Messages -->
                <div
                    id="messages"
                    class="flex-1 p-5 space-y-4 overflow-y-auto bg-slate-50 min-h-[400px]"
                >
                    <div class="text-center text-gray-500 mt-20">
                        Select a conversation or start a new one.
                    </div>
                </div>

                <!-- Message Input -->
                <form id="messageForm" class="hidden border-t p-4">

                    <div class="flex gap-3">

                        <input
                            type="text"
                            id="messageInput"
                            maxlength="5000"
                            required
                            placeholder="Write your message..."
                            class="flex-1 border rounded-lg p-3 focus:outline-blue-600"
                        >

                        <button
                            type="submit"
                            id="sendButton"
                            class="bg-blue-700 text-white px-6 rounded-lg hover:bg-blue-800"
                        >
                            Send
                        </button>

                    </div>

                </form>

            </section>

        </div>

    </main>

    <p id="notification" class="mt-4 text-sm"></p>

</div>

<script>
    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    const conversationList = document.getElementById('conversationList');
    const messagesBox = document.getElementById('messages');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const notification = document.getElementById('notification');

    let activeConversationId = null;
    let activeConversationStatus = null;
    let pollingTimer = null;

    // API request helper
    async function api(url, method = 'GET', body = null) {

        const options = {
            method: method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        };

        if (body !== null) {
            options.body = JSON.stringify(body);
        }

        const response = await fetch(url, options);

        if (response.status === 401) {
            window.location.href = '/login';
            throw new Error('Please log in again.');
        }

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Something went wrong.');
        }

        return data;
    }

    function showNotification(message, success = true) {
        notification.textContent = message;
        notification.className = success
            ? 'mt-4 text-sm text-green-700'
            : 'mt-4 text-sm text-red-600';
    }

    // Load conversations
    async function loadConversations() {

        try {

            const conversations = await api('/chat');

            conversationList.replaceChildren();

            if (conversations.length === 0) {
                const empty = document.createElement('p');
                empty.className = 'text-gray-500 text-sm';
                empty.textContent = 'No conversations yet.';
                conversationList.appendChild(empty);
                return;
            }

            conversations.forEach(conversation => {

                const button = document.createElement('button');

                button.className =
                    'w-full text-left p-3 border rounded-lg hover:bg-blue-50';

                if (conversation.id === activeConversationId) {
                    button.classList.add('bg-blue-50', 'border-blue-500');
                }

                const subject = document.createElement('p');
                subject.className = 'font-semibold';
                subject.textContent = conversation.subject;

                const status = document.createElement('p');
                status.className = 'text-xs text-gray-500 mt-1';
                status.textContent = conversation.status;

                button.append(subject, status);

                button.addEventListener('click', () => {
                    openConversation(conversation.id);
                });

                conversationList.appendChild(button);
            });

        } catch (error) {
            showNotification(error.message, false);
        }
    }

    // Open a conversation
    async function openConversation(id) {

        try {

            const conversation = await api(`/chat/${id}`);

            activeConversationId = id;
            activeConversationStatus = conversation.status;

            document.getElementById('chatSubject').textContent =
                conversation.subject;

            document.getElementById('chatStatus').textContent =
                'Status: ' + conversation.status;

            messageForm.classList.remove('hidden');

            document.getElementById('resolveButton').classList.toggle(
                'hidden',
                conversation.status === 'resolved'
            );

            messageInput.disabled = conversation.status === 'resolved';

            await loadMessages();

            await loadConversations();

            startPolling();

        } catch (error) {
            showNotification(error.message, false);
        }
    }

    // Load messages
    async function loadMessages() {

        if (!activeConversationId) return;

        try {

            const data = await api(
                `/chat/${activeConversationId}/messages`
            );

            messagesBox.replaceChildren();

            if (data.length === 0) {
                const empty = document.createElement('p');
                empty.className = 'text-center text-gray-500 mt-20';
                empty.textContent = 'No messages yet.';
                messagesBox.appendChild(empty);
                return;
            }

            data.forEach(message => {

                const wrapper = document.createElement('div');

                const isMine = message.sender_id ===
                    {{ (int) auth()->id() }};

                wrapper.className = isMine
                    ? 'flex justify-end'
                    : 'flex justify-start';

                const bubble = document.createElement('div');

                bubble.className = isMine
                    ? 'bg-blue-700 text-white p-3 rounded-xl max-w-[80%]'
                    : 'bg-white border p-3 rounded-xl max-w-[80%]';

                const sender = document.createElement('p');
                sender.className = 'text-xs opacity-70 mb-1';
                sender.textContent = message.sender?.name || 'User';

                const body = document.createElement('p');
                body.className = 'break-words whitespace-pre-wrap';
                body.textContent = message.body;

                const time = document.createElement('p');
                time.className = 'text-xs opacity-60 mt-2';
                time.textContent = new Date(
                    message.created_at
                ).toLocaleString();

                bubble.append(sender, body, time);
                wrapper.appendChild(bubble);

                messagesBox.appendChild(wrapper);

            });

            messagesBox.scrollTop = messagesBox.scrollHeight;

        } catch (error) {
            showNotification(error.message, false);
        }
    }

    // Send message
    messageForm.addEventListener('submit', async function(e) {

        e.preventDefault();

        if (!activeConversationId) return;

        const body = messageInput.value.trim();

        if (!body) return;

        const button = document.getElementById('sendButton');

        button.disabled = true;

        try {

            await api(
                `/chat/${activeConversationId}/messages`,
                'POST',
                { body: body }
            );

            messageInput.value = '';

            await loadMessages();
            await loadConversations();

        } catch (error) {
            showNotification(error.message, false);
        }

        button.disabled = false;

    });

    // Show new conversation form
    document.getElementById('newChatButton')
        .addEventListener('click', function() {

            document.getElementById('newChatForm')
                .classList.toggle('hidden');

        });

    // Create conversation and send initial message
    document.getElementById('newChatForm')
        .addEventListener('submit', async function(e) {

            e.preventDefault();

            const button = document.getElementById('createButton');

            button.disabled = true;

            try {

                const subject = document.getElementById('subject').value.trim();
                const body = document.getElementById('initialMessage').value.trim();

                if (!subject || !body) {
                    throw new Error('Please enter both subject and message.');
                }

                const data = await api('/chat', 'POST', {
                    subject: subject
                });

                const id = data.conversation.id;

                await api(`/chat/${id}/messages`, 'POST', {
                    body: body
                });

                document.getElementById('newChatForm').reset();
                document.getElementById('newChatForm').classList.add('hidden');

                showNotification('Conversation created successfully!');

                await loadConversations();
                await openConversation(id);

            } catch (error) {
                showNotification(error.message, false);
            }

            button.disabled = false;

        });

    // Resolve conversation
    document.getElementById('resolveButton')
        .addEventListener('click', async function() {

            if (!activeConversationId) return;

            if (!confirm('Are you sure you want to resolve this conversation?')) {
                return;
            }

            try {

                await api(
                    `/chat/${activeConversationId}/resolve`,
                    'POST'
                );

                showNotification('Conversation resolved successfully.');

                await openConversation(activeConversationId);

            } catch (error) {
                showNotification(error.message, false);
            }

        });

    // Automatic message refresh
    function startPolling() {

        if (pollingTimer) {
            clearInterval(pollingTimer);
        }

        pollingTimer = setInterval(async () => {

            if (activeConversationId) {
                await loadMessages();
            }

        }, 3000);

    }

    // Initial page load
    loadConversations();

</script>

</body>
</html>
