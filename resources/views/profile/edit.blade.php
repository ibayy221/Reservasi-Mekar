@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold mb-4">Edit Profil</h2>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 rounded mb-4">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">NIK / KTP</label>
                    <input type="text" name="nik_ktp" value="{{ old('nik_ktp', $user->nik_ktp) }}" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">No. Telepon / WhatsApp</label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Password (kosongkan untuk tidak mengubah)</label>
                    <input type="password" name="password" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm">
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded font-semibold">Simpan Perubahan</button>
                <a href="/" class="text-sm text-gray-500">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
