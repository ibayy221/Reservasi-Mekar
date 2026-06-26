<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\KamarAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::orderBy('name')->get();
        return view('admin.kamar.index', compact('kamars'));
    }

    public function create()
    {
        return view('admin.kamar.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'capacity' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = Str::slug($data['name']);
        $baseSlug = $slug ?: 'kamar';
        $slug = $baseSlug;
        $counter = 2;
        while (Kamar::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $kamar = new Kamar();
        $kamar->name = $data['name'];
        $kamar->slug = $slug;
        $kamar->price = $data['price'];
        $kamar->capacity = $data['capacity'];
        $kamar->stock = $data['stock'];
        $kamar->description = $data['description'] ?? null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $kamar->slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('rooms', $filename, 'public');
            $kamar->image = 'storage/' . $path;
        }

        $kamar->save();

        return redirect()->route('admin.kamar.index')->with('status', 'Kamar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        $overrides = KamarAvailability::where('kamar_id', $kamar->id)->orderBy('date')->get();
        return view('admin.kamar.edit', compact('kamar', 'overrides'));
    }

    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();

        return redirect()->route('admin.kamar.index')->with('status', 'Kamar berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'capacity' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $kamar->name = $data['name'];
        $kamar->price = $data['price'];
        $kamar->capacity = $data['capacity'];
        $kamar->description = $data['description'] ?? null;
        $kamar->stock = $data['stock'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $kamar->slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('rooms', $filename, 'public');
            $kamar->image = 'storage/' . $path;
        }

        $kamar->save();

        // handle overrides additions
        if ($request->has('override_date') && $request->has('override_available')) {
            $dates = $request->input('override_date');
            $availables = $request->input('override_available');
            foreach ($dates as $i => $d) {
                $a = isset($availables[$i]) ? intval($availables[$i]) : null;
                if (!$d || $a === null) continue;
                KamarAvailability::updateOrCreate(
                    ['kamar_id' => $kamar->id, 'date' => $d],
                    ['available' => $a]
                );
            }
        }

        // handle deletions
        if ($request->has('delete_override')) {
            $toDelete = $request->input('delete_override');
            KamarAvailability::whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('admin.kamar.edit', $kamar->id)->with('status', 'Perubahan disimpan.');
    }
}
