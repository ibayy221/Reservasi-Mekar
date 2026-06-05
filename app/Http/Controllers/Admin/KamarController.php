<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\KamarAvailability;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::orderBy('name')->get();
        return view('admin.kamar.index', compact('kamars'));
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        $overrides = KamarAvailability::where('kamar_id', $kamar->id)->orderBy('date')->get();
        return view('admin.kamar.edit', compact('kamar', 'overrides'));
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);

        $data = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $kamar->stock = $data['stock'];
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
