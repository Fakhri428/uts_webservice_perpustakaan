<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700">Welcome, {{ auth()->user()->name }}. Browse books, borrow, and return your own loans.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('user.books') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <div class="font-semibold text-lg">Browse Books</div>
                    <div class="text-sm text-gray-500">Lihat koleksi buku perpustakaan.</div>
                </a>
                <a href="{{ route('user.loans') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <div class="font-semibold text-lg">My Loans</div>
                    <div class="text-sm text-gray-500">Pinjam dan kembalikan buku.</div>
                </a>
                <a href="{{ route('user.ai') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <div class="font-semibold text-lg">AI Assistant</div>
                    <div class="text-sm text-gray-500">Minta rekomendasi, ringkasan, dan tanya chatbot.</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
