@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-4">Kelola: {{ $kamar->name }}</h1>

    @if(session('status'))
        <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 rounded">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.kamar.update', $kamar->id) }}">
        @csrf
        @method('PUT')
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <label class="block text-sm text-gray-600 mb-2">Stok Default</label>
            <input type="number" name="stock" value="{{ $kamar->stock }}" class="border p-2 rounded w-32" min="0">
        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="font-semibold mb-3">Override Per Tanggal</h3>
            <p class="text-sm text-gray-500 mb-4">Tambahkan override untuk tanggal tertentu (nilai available akan dipakai untuk tanggal tersebut).</p>

            <div id="overrides_list">
                @foreach($overrides as $ov)
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" name="delete_override[]" value="{{ $ov->id }}"> Hapus
                    <div class="ml-2">{{ $ov->date }} — tersedia: {{ $ov->available }}</div>
                </div>
                @endforeach
            </div>

            <hr class="my-4">
            <div id="new_overrides">
                <div class="flex gap-2 items-center mb-2">
                    <input type="date" name="override_date[]" class="border p-2 rounded">
                    <input type="number" name="override_available[]" class="border p-2 rounded w-24" placeholder="available">
                </div>
            </div>
            <button type="button" id="add_override" class="mt-2 inline-block text-emerald-600">+ Tambah override</button>
        </div>

        <div class="flex gap-3">
            <button class="bg-emerald-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('admin.kamar.index') }}" class="px-4 py-2 rounded border">Kembali</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('add_override').addEventListener('click', function(){
        const container = document.getElementById('new_overrides');
        const div = document.createElement('div');
        div.className = 'flex gap-2 items-center mb-2';
        div.innerHTML = `<input type="date" name="override_date[]" class="border p-2 rounded"> <input type="number" name="override_available[]" class="border p-2 rounded w-24" placeholder="available"> <button type="button" class="text-red-500 remove">Hapus</button>`;
        container.appendChild(div);
        div.querySelector('.remove').addEventListener('click', ()=>div.remove());
    });
</script>

@endsection
