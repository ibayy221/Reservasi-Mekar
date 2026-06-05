@extends('layouts.app')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12 bg-gray-50">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <!-- Header Form -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-dark tracking-tight">Selamat Datang Kembali</h2>
            <p class="text-xs text-gray-500 mt-1">Silakan masuk ke akun Anda untuk melanjutkan reservasi.</p>
        </div>

        <!-- Form Input -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            @if (session('status'))
                <div class="p-3 rounded-md bg-emerald-50 text-emerald-700 text-sm">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="p-3 rounded-md bg-red-50 text-red-700 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" 
                    class="w-full bg-gray-50 border border-gray-200 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-medium transition duration-150">
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Kata Sandi</label>
                    <a href="#" class="text-xs text-emerald-600 hover:underline">Lupa Password?</a>
                </div>
                <input type="password" name="password" required placeholder="••••••••" 
                    class="w-full bg-gray-50 border border-gray-200 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-medium transition duration-150">
            </div>

            <div class="flex items-center gap-3">
                <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-emerald-600">
                <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
            </div>

            <!-- Tombol Masuk -->
            <button type="submit" 
                class="w-full bg-emerald-500 hover:bg-emerald-600 text-white p-3 rounded-xl font-bold shadow-lg shadow-emerald-500/20 transition duration-200 text-sm">
                Masuk ke Akun
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('auth.google') }}" class="w-full inline-flex items-center justify-center gap-3 bg-white border border-gray-200 text-gray-700 p-3 rounded-xl font-semibold hover:shadow-md transition duration-150">
                <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5">
                Masuk dengan Google
            </a>
        </div>

        <!-- Footer Form -->
        <p class="text-center text-xs text-gray-500 mt-8">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-emerald-600 font-semibold hover:underline">Daftar Sekarang</a>
        </p>
    </div>
</div>
@endsection