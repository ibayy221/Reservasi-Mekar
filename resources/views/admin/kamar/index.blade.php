@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Kelola Kamar</h1>

    <div class="bg-white rounded-lg shadow p-4">
        <table class="w-full table-auto">
            <thead>
                <tr class="text-left text-sm text-gray-500">
                    <th class="py-2">Nama</th>
                    <th class="py-2">Stok Default</th>
                    <th class="py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kamars as $k)
                <tr class="border-t">
                    <td class="py-3">{{ $k->name }}</td>
                    <td class="py-3">{{ $k->stock }}</td>
                    <td class="py-3"><a href="{{ route('admin.kamar.edit', $k->id) }}" class="text-emerald-600">Kelola</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
