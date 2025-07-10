<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

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
            // 'needs_registration' => 'required|boolean',
            'max_participants' => 'nullable|integer|min:1',
            'registration_link' => 'nullable|url',
            'flyer' => 'required|image',
            'is_active' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            // Upload flyer ke storage/app/public/flyers
            $flyerPath = $request->file('flyer')->store('flyers', 'public');

            // Simpan data event
            $event = Event::create([
                'title' => $validated['title'],
                'event_type' => $validated['event_type'],
                'description' => $validated['description'],
                'event_date' => $validated['event_date'],
                'event_time' => $validated['event_time'],
                'location' => $validated['location'],
                // 'needs_registration' => $validated['needs_registration'],
                'max_participants' => $validated['max_participants'] ?? null,
                'registration_link' => $validated['registration_link'] ?? null,
                'flyer' => $flyerPath,
                'is_active' => $validated['is_active'] ?? false,
                'posted_by' => auth()->id(), // pastikan user login
            ]);

            DB::commit();

            return redirect()->route('admin.manajemenevent')->with('success', 'Event berhasil ditambahkan.');
        } catch (Throwable $e) {
            DB::rollBack();

            // Hapus flyer jika sudah terupload tapi DB gagal
            if (!empty($flyerPath)) {
                Storage::disk('public')->delete($flyerPath);
            }
            Log::error('Gagal menyimpan event', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'input' => $request->all(),
            ]);
            return back()->withErrors(['error' => 'Gagal menyimpan event: ' . $e->getMessage()]);
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
