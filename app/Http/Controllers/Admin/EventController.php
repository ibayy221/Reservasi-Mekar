<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::orderBy('order')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => ['nullable', 'file', 'image', 'max:5120'],
            'badge' => 'required|string|max:50',
            'badge_color' => 'nullable|string|max:50',
            'features_text' => 'nullable|string',
            'link' => ['nullable', 'string', 'regex:/^(\/.*|https?:\/\/.*)$/'],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'order' => 'required|integer',
        ]);

        // Handle image upload
        $imagePath = $validated['image_path'] ?? null;
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $imagePath = $file->store('events', 'public');
        }

        // Convert features_text to array
        $features = [];
        if (!empty($validated['features_text'])) {
            $features = array_filter(array_map('trim', explode("\n", $validated['features_text'])));
        }

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_path' => $imagePath,
            'badge' => $validated['badge'],
            'badge_color' => $validated['badge_color'] ?? '#6d36a1',
            'features' => $features,
            'link' => $validated['link'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'order' => $validated['order'],
            'slug' => Str::slug($validated['title']),
        ];
        
        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => ['nullable', 'file', 'image', 'max:5120'],
            'badge' => 'required|string|max:50',
            'badge_color' => 'nullable|string|max:50',
            'features_text' => 'nullable|string',
            'link' => ['nullable', 'string', 'regex:/^(\/.*|https?:\/\/.*)$/'],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'order' => 'required|integer',
        ]);

        // Handle image upload / replacement
        $imagePath = $validated['image_path'] ?? null;
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $newPath = $file->store('events', 'public');
            // delete old
            if (!empty($event->image_path) && Storage::disk('public')->exists($event->image_path)) {
                Storage::disk('public')->delete($event->image_path);
            }
            $imagePath = $newPath;
        } else {
            // keep existing if provided
            $imagePath = $request->input('existing_image', $event->image_path);
        }

        // Convert features_text to array
        $features = [];
        if (!empty($validated['features_text'])) {
            $features = array_filter(array_map('trim', explode("\n", $validated['features_text'])));
        }

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_path' => $imagePath,
            'badge' => $validated['badge'],
            'badge_color' => $validated['badge_color'] ?? ($event->badge_color ?? '#6d36a1'),
            'features' => $features,
            'link' => $validated['link'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'order' => $validated['order'],
            'slug' => Str::slug($validated['title']),
        ];
        
        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus');
    }
}
