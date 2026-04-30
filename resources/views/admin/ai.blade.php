<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - AI Tools</h2>
    </x-slot>

    <style>
        .ai-shell { display: grid; grid-template-columns: 300px minmax(0, 1fr); gap: 24px; }
        .ai-side, .ai-main { background: #fff; border: 1px solid #e5e7eb; border-radius: 20px; box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04); }
        .ai-side { padding: 20px; }
        .ai-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 14px; margin-bottom: 12px; }
        .ai-card strong { display: block; color: #0f172a; margin-bottom: 4px; }
        .ai-card span { color: #64748b; font-size: 13px; }
        .ai-main { padding: 24px; }
        .ai-grid { display: grid; gap: 18px; }
        .ai-box h3 { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
        .ai-row { display: flex; gap: 10px; flex-wrap: wrap; }
        .ai-input, .ai-textarea { width: 100%; border: 1px solid #e2e8f0; border-radius: 12px; padding: 11px 12px; font-size: 14px; }
        .ai-input { flex: 1; }
        .ai-btn { background: #2563eb; color: #fff; border: 0; border-radius: 12px; padding: 10px 14px; font-size: 14px; font-weight: 700; cursor: pointer; }
        .ai-output { margin-top: 10px; min-height: 56px; white-space: pre-wrap; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; color: #0f172a; }
        @media (max-width: 960px) { .ai-shell { grid-template-columns: 1fr; } }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="ai-shell">
                <aside class="ai-side">
                    <div class="ai-card">
                        <strong>Catalog AI</strong>
                        <span>Rekomendasi, ringkasan, dan chat untuk admin.</span>
                    </div>
                    <div class="ai-card">
                        <strong>Scope</strong>
                        <span>Memakai data catalog dan akses session admin.</span>
                    </div>
                    <div class="ai-card">
                        <strong>Tips</strong>
                        <span>Isi kata kunci buku, kategori, atau teks deskripsi.</span>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600">Back to dashboard</a>
                </aside>

                <div class="ai-main">
                    <div class="ai-grid">
                        <div class="ai-box">
                            <h3>Recommend Books</h3>
                            <div class="ai-row">
                                <input id="rec-query" class="ai-input" placeholder="judul atau kategori">
                                <button id="rec-btn" class="ai-btn">Ask</button>
                            </div>
                            <div id="rec-result" class="ai-output"></div>
                        </div>

                        <div class="ai-box">
                            <h3>Summarize</h3>
                            <textarea id="sum-text" class="ai-textarea" rows="5" placeholder="deskripsi buku"></textarea>
                            <button id="sum-btn" class="ai-btn" style="margin-top:10px;">Summarize</button>
                            <div id="sum-result" class="ai-output"></div>
                        </div>

                        <div class="ai-box">
                            <h3>Chatbot</h3>
                            <div class="ai-row">
                                <input id="chat-msg" class="ai-input" placeholder="Buku apa yang cocok untuk belajar AI?">
                                <button id="chat-btn" class="ai-btn">Send</button>
                            </div>
                            <div id="chat-result" class="ai-output"></div>
                        </div>
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
