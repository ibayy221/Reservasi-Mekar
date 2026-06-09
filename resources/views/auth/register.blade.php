@extends('layouts.app')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12 bg-gray-50">
    <div class="max-w-lg w-full bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <!-- Header Form -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-dark tracking-tight">Buat Akun Baru</h2>
            <p class="text-xs text-gray-500 mt-1">Daftarkan diri Anda untuk kemudahan dan kecepatan transaksi kamar.</p>
        </div>

        <!-- Form Input -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required placeholder="Masukkan nama lengkap sesuai KTP" 
                    class="w-full bg-gray-50 border border-gray-200 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm font-medium transition duration-150">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">NIK KTP</label>
                    <input type="text" name="nik_ktp" required placeholder="16 Digit NIK" 
                        class="w-full bg-gray-50 border border-gray-200 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm font-medium transition duration-150">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">No. Handphone</label>
                    <input type="text" name="no_hp" required placeholder="Contoh: 0812345678" 
                        class="w-full bg-gray-50 border border-gray-200 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm font-medium transition duration-150">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Alamat Email</label>
                <input type="email" name="email" required placeholder="nama@email.com" 
                    class="w-full bg-gray-50 border border-gray-200 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm font-medium transition duration-150">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Kata Sandi</label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter" 
                    class="w-full bg-gray-50 border border-gray-200 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm font-medium transition duration-150">
            </div>

            <!-- Tombol Daftar -->
            <button type="submit" 
                class="w-full bg-purple-500 hover:bg-purple-600 text-white p-3 rounded-xl font-bold shadow-lg shadow-purple-500/20 transition duration-200 text-sm mt-2">
                Daftar Akun
            </button>
        </form>

        <!-- Footer Form -->
        <p class="text-center text-xs text-gray-500 mt-6">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection