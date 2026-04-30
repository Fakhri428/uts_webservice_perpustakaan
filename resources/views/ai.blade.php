<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Library AI</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="/dashboard" class="text-sm text-blue-600">Back</a>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h3 class="text-lg font-medium">Recommend</h3>
                        <div class="mt-2 flex gap-2">
                            <input id="rec-query" placeholder="Enter title or category" class="border rounded px-2 py-1 flex-1">
                            <button id="rec-btn" class="bg-indigo-600 text-white px-3 rounded">Ask</button>
                        </div>
                        <pre id="rec-result" class="mt-2 bg-gray-50 p-3 rounded"></pre>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium">Summarize</h3>
                        <textarea id="sum-text" class="border rounded p-2 w-full mt-2" placeholder="Paste book description"></textarea>
                        <div class="mt-2"><button id="sum-btn" class="bg-indigo-600 text-white px-3 rounded">Summarize</button></div>
                        <pre id="sum-result" class="mt-2 bg-gray-50 p-3 rounded"></pre>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium">Chat</h3>
                        <div class="mt-2 flex gap-2">
                            <input id="chat-msg" placeholder="Ask something about books" class="border rounded px-2 py-1 flex-1">
                            <button id="chat-btn" class="bg-indigo-600 text-white px-3 rounded">Send</button>
                        </div>
                        <pre id="chat-result" class="mt-2 bg-gray-50 p-3 rounded"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.getElementById('rec-btn').addEventListener('click', async ()=>{
        const q = document.getElementById('rec-query').value;
        const r = await fetch('/api/ai/recommend', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ query: q }) });
        const j = await r.json();
        document.getElementById('rec-result').textContent = JSON.stringify(j.raw || j, null, 2);
    });

    document.getElementById('sum-btn').addEventListener('click', async ()=>{
        const t = document.getElementById('sum-text').value;
        const r = await fetch('/api/ai/summarize', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ text: t }) });
        const j = await r.json();
        document.getElementById('sum-result').textContent = j.content || JSON.stringify(j.raw||j, null,2);
    });

    document.getElementById('chat-btn').addEventListener('click', async ()=>{
        const m = document.getElementById('chat-msg').value;
        const r = await fetch('/api/ai/chat', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ message: m }) });
        const j = await r.json();
        document.getElementById('chat-result').textContent = j.content || JSON.stringify(j.raw||j, null,2);
    });
    </script>
    @endpush
</x-app-layout>
