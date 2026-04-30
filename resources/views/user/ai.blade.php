<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">AI Assistant</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('user.dashboard') }}" class="text-sm text-blue-600">Back to dashboard</a>
                </div>

                <div class="grid gap-6">
                    <div>
                        <h3 class="text-lg font-medium">Recommend Books</h3>
                        <div class="mt-2 flex gap-2">
                            <input id="rec-query" class="border rounded px-3 py-2 flex-1" placeholder="judul atau kategori">
                            <button id="rec-btn" class="bg-indigo-600 text-white px-4 py-2 rounded">Ask</button>
                        </div>
                        <pre id="rec-result" class="mt-2 bg-gray-50 p-3 rounded"></pre>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium">Summarize</h3>
                        <textarea id="sum-text" class="border rounded p-3 w-full mt-2" rows="5" placeholder="deskripsi buku"></textarea>
                        <button id="sum-btn" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Summarize</button>
                        <pre id="sum-result" class="mt-2 bg-gray-50 p-3 rounded"></pre>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium">Chatbot</h3>
                        <div class="mt-2 flex gap-2">
                            <input id="chat-msg" class="border rounded px-3 py-2 flex-1" placeholder="Buku apa yang cocok untuk belajar AI?">
                            <button id="chat-btn" class="bg-indigo-600 text-white px-4 py-2 rounded">Send</button>
                        </div>
                        <pre id="chat-result" class="mt-2 bg-gray-50 p-3 rounded"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    const csrf = @json(csrf_token());

    async function callAi(url, payload, targetId) {
        const target = document.getElementById(targetId);
        target.textContent = 'Loading...';

        try {
            const r = await fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            });

            const j = await r.json().catch(() => ({}));

            if (!r.ok || j.success === false) {
                target.textContent = j.error || `Request failed (${r.status})`;
                return;
            }

            target.textContent = j.content || JSON.stringify(j.raw || j, null, 2);
        } catch (error) {
            target.textContent = error.message;
        }
    }

    document.getElementById('rec-btn').addEventListener('click', () => {
        callAi('/api/ai/recommend', { query: document.getElementById('rec-query').value }, 'rec-result');
    });

    document.getElementById('sum-btn').addEventListener('click', () => {
        callAi('/api/ai/summarize', { text: document.getElementById('sum-text').value }, 'sum-result');
    });

    document.getElementById('chat-btn').addEventListener('click', () => {
        callAi('/api/ai/chat', { message: document.getElementById('chat-msg').value }, 'chat-result');
    });
    </script>
    @endpush
</x-app-layout>
