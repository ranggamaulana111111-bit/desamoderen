<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('user')
            ->latest()
            ->paginate(20);

        $eventsCalendar = Event::select('id', 'judul', 'tanggal', 'jenis', 'status')->get();

        $eventsCalendarJson = $eventsCalendar->map(fn ($e) => [
            'title' => $e->judul,
            'start' => $e->tanggal->format('Y-m-d'),
            'url' => route('admin.events.show', $e),
            'color' => $e->jenis === 'musrenbangdes' ? '#ef4444' : ($e->jenis === 'rapat' ? '#f59e0b' : '#3b82f6'),
        ])->toJson();

        return view('admin.events.index', compact('events', 'eventsCalendarJson'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:musrenbangdes,rapat,kegiatan,sosialisasi',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'tempat' => 'nullable|string|max:200',
            'rt_target' => 'nullable|string|max:3',
            'rw_target' => 'nullable|string|max:3',
            'status' => 'required|in:akan_datang,berlangsung,selesai',
        ]);

        $validated['user_id'] = auth()->id();

        $event = Event::create($validated);

        $this->batchInsertPeserta($event, $request);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat dan undangan telah dikirim');
    }

    public function show(Event $event)
    {
        $event->load(['user', 'peserta.user']);

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:musrenbangdes,rapat,kegiatan,sosialisasi',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'tempat' => 'nullable|string|max:200',
            'rt_target' => 'nullable|string|max:3',
            'rw_target' => 'nullable|string|max:3',
            'status' => 'required|in:akan_datang,berlangsung,selesai',
        ]);

        $event->update($validated);

        $this->batchInsertPeserta($event, $request);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus');
    }

    private function batchInsertPeserta(Event $event, Request $request): void
    {
        $query = User::role('Warga');
        if ($request->filled('rt_target')) {
            $query->where('rt', $request->rt_target);
        }
        if ($request->filled('rw_target')) {
            $query->where('rw', $request->rw_target);
        }
        $pesertaIds = $query->pluck('id');

        if ($pesertaIds->isEmpty()) {
            return;
        }

        $existingIds = DB::table('event_peserta')
            ->where('event_id', $event->id)
            ->pluck('user_id')
            ->toArray();

        $now = now();

        $newRecords = $pesertaIds
            ->reject(fn ($id) => in_array($id, $existingIds))
            ->map(fn ($id) => [
                'event_id' => $event->id,
                'user_id' => $id,
                'konfirmasi' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ])
            ->values()
            ->toArray();

        if (! empty($newRecords)) {
            DB::table('event_peserta')->insert($newRecords);
        }
    }
}
