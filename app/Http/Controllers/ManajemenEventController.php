<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ManajemenEventController extends Controller
{
    public function manajemenevent(Request $request)
{
    $query = Event::query();

    // Jika ada pencarian nama event
    if ($request->has('search') && $request->search != '') {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $events = $query->latest()->get();

    return view('admin.manajemenevent', compact('events'));
}

    /**
     * Menampilkan form tambah event.
     */
    public function create()
    {
        return view('admin.tambah_event'); // Ganti sesuai view form tambah jika ada
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:100',
        'event_type' => 'required|in:webinar,jobfair,workshop',
        'description' => 'required|string',
        'event_date' => 'required|date',
        'event_time' => 'required',
        'location' => 'required|string|max:100',
        'needs_registration' => 'required|boolean',
        'max_participants' => 'nullable|integer|min:1',
        'registration_link' => 'nullable|url',
        'flyer' => 'required|image|max:2048',
        'is_active' => 'nullable|boolean',
    ]);

    try {
        // Handle flyer upload
        if ($request->hasFile('flyer')) {
            $file = $request->file('flyer');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/flyers', $filename);
            $validated['flyer'] = $filename;
        }

        // Tambahkan ID user yang membuat event
        $validated['posted_by'] = auth()->id(); // atau 'user_id'

        // Checkbox 'is_active'
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Simpan ke database
        $event = Event::create($validated);

        Log::info('Event berhasil disimpan', ['event_id' => $event->id, 'posted_by' => auth()->id()]);

        return redirect()->route('admin.manajemenevent')->with('success', 'Event berhasil ditambahkan.');
    } catch (\Exception $e) {
        Log::error('Gagal menyimpan event: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan event.']);
    }
}


    // Anda bisa tambahkan fungsi store, edit, update, destroy jika diperlukan
    public function detailEvent($id)
{
    $event = Event::findOrFail($id);
    return view('admin.detail_event', compact('event'));
}

    public function editEvent($id)
{
    $event = Event::findOrFail($id);
    return view('admin.edit_event', compact('event'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:100',
        'event_type' => 'required|in:webinar,jobfair,workshop',
        'description' => 'required|string',
        'event_date' => 'required|date',
        'event_time' => 'required',
        'location' => 'required|string|max:100',
        'needs_registration' => 'required|boolean',
        'max_participants' => 'nullable|integer|min:1',
        'registration_link' => 'nullable|url',
        'flyer' => 'nullable|image|max:2048',
        'is_active' => 'nullable|boolean',
    ]);

    try {
        $event = Event::findOrFail($id);

        // Update data dasar
        $event->fill($validated);
        $event->is_active = $request->has('is_active') ? 1 : 0;

        // Handle flyer baru (jika diunggah)
        if ($request->hasFile('flyer')) {
            $file = $request->file('flyer');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/flyers', $filename);
            $event->flyer = $filename;
        }

        $event->save();

        Log::info('Event berhasil diperbarui', ['event_id' => $event->id]);

        return redirect()->route('admin.manajemenevent')->with('success', 'Event berhasil diperbarui.');
    } catch (\Exception $e) {
        Log::error('Gagal memperbarui event: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui event.']);
    }
   
}
public function destroy($id)
{
    $event = Event::findOrFail($id);
    $event->delete();

    return redirect()->route('admin.manajemenevent')->with('success', 'Event berhasil dihapus.');
}
}
