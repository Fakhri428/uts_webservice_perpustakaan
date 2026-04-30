<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700">Welcome, {{ auth()->user()->name }}. Use these admin tools to manage the library.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.books') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <div class="font-semibold text-lg">Manage Books</div>
                    <div class="text-sm text-gray-500">Tambah, hapus, dan update stok.</div>
                </a>
                <a href="{{ route('admin.categories') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <div class="font-semibold text-lg">Manage Categories</div>
                    <div class="text-sm text-gray-500">Kelola master data kategori buku.</div>
                </a>
                <a href="{{ route('admin.loans') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <div class="font-semibold text-lg">Monitor Loans</div>
                    <div class="text-sm text-gray-500">Lihat semua peminjaman dan kembalikan buku.</div>
                </a>
                <a href="{{ route('admin.ai') }}" class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <div class="font-semibold text-lg">AI Tools</div>
                    <div class="text-sm text-gray-500">Rekomendasi, ringkasan, dan chatbot.</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
